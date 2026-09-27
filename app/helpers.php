<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Read a value from config/.env (or a real environment variable).
 * Falls back to $default if the key is not found.
 */
function env_get(string $key, string $default = ''): string {
    $val = getenv($key);
    if ($val !== false) {
        return $val;
    }
    static $envCache = null;
    if ($envCache === null) {
        $envCache = [];
        $path = __DIR__ . '/../config/.env';
        if (is_readable($path)) {
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || $line[0] === '#') continue;
                $pos = strpos($line, '=');
                if ($pos === false) continue;
                $k = trim(substr($line, 0, $pos));
                $v = trim(substr($line, $pos + 1));
                if (strlen($v) >= 2 && ($v[0] === '"' || $v[0] === "'") && $v[0] === substr($v, -1)) {
                    $v = substr($v, 1, -1);
                }
                $envCache[$k] = $v;
            }
        }
    }
    return $envCache[$key] ?? $default;
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_verify() {
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(419);
        return false;
    }
    return true;
}

function csrf_require_or_fail($redirect = null) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify()) {
        http_response_code(419);
        $_SESSION['error'] = 'Security check failed. Please try again.';
        if ($redirect !== null) {
            header('Location: ' . $redirect);
            exit;
        }
        return false;
    }
    return true;
}

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function upload_image($file, $prefix) {
    if (empty($file) || !is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'path' => ''];
    }
    if ($file['size'] > 3 * 1024 * 1024) {
        return ['ok' => false, 'path' => '', 'error' => 'Image must be 3MB or smaller.'];
    }
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];
    $info = @getimagesize($file['tmp_name']);
    $mime = $info['mime'] ?? '';
    if (!isset($allowed[$mime])) {
        return ['ok' => false, 'path' => '', 'error' => 'Only JPG, PNG, WEBP, and GIF images are allowed.'];
    }
    $ext = $allowed[$mime];
    $filename = $prefix . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
    // Resolve uploads directory - works for flat (production) and nested (local) structures
    if (defined('APP_ROOT') && is_dir(APP_ROOT . 'uploads')) {
        $uploadBase = APP_ROOT . 'uploads'; // production: htdocs/uploads/
    } elseif (defined('APP_ROOT') && is_dir(APP_ROOT . 'public/uploads')) {
        $uploadBase = APP_ROOT . 'public/uploads'; // local: public/uploads/
    } else {
        $uploadBase = __DIR__ . '/../public/uploads'; // fallback
    }
    $dest = rtrim($uploadBase, '/\\') . '/' . $filename;
    if (!is_dir(dirname($dest))) {
        mkdir(dirname($dest), 0755, true);
    }
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['ok' => false, 'path' => '', 'error' => 'Could not save the uploaded image.'];
    }
    return ['ok' => true, 'path' => '/uploads/' . $filename];
}

function delete_upload($path) {
    if (empty($path)) return;
    if (defined('APP_ROOT') && is_dir(APP_ROOT . 'uploads')) {
        $uploadBase = realpath(APP_ROOT . 'uploads');
    } elseif (defined('APP_ROOT') && is_dir(APP_ROOT . 'public/uploads')) {
        $uploadBase = realpath(APP_ROOT . 'public/uploads');
    } else {
        $uploadBase = realpath(__DIR__ . '/../public/uploads');
    }
    $file = rtrim($uploadBase, '/\\') . '/' . ltrim(str_replace('/uploads/', '', $path), '/');
    if (strpos(realpath(dirname($file)) ?: '', $uploadBase) === 0 && is_file($file)) {
        @unlink($file);
    }
}

function setting($key, $default = '') {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        if (class_exists('Database')) {
            try {
                $db = (new Database())->connect();
                $stmt = $db->query('SELECT setting_key, setting_value FROM settings');
                if ($stmt) {
                    while ($row = $stmt->fetch_assoc()) {
                        $cache[$row['setting_key']] = $row['setting_value'];
                    }
                }
            } catch (Throwable $e) {
                // settings table may not exist yet
            }
        }
    }
    return $cache[$key] ?? $default;
}

function availability_label($status) {
    switch ($status) {
        case 'Limited Availability':
            return ['text' => 'Limited availability - book ahead', 'tone' => 'limited'];
        case 'Currently Busy':
            return ['text' => 'Currently busy - inquiries welcome', 'tone' => 'busy'];
        default:
            return ['text' => 'Available for new projects', 'tone' => 'available'];
    }
}

/**
 * Return a cache-busting query string (?v=mtime) for a public asset.
 * Works for both local (public/ subfolder) and production (flat htdocs) layouts.
 */
function asset_v(string $rel): string {
    $rel = '/' . ltrim($rel, '/');
    $candidates = [];
    if (defined('APP_ROOT')) {
        $candidates[] = APP_ROOT . 'public' . $rel;
        $candidates[] = APP_ROOT . ltrim($rel, '/');
    }
    $candidates[] = __DIR__ . '/../public' . $rel;
    foreach ($candidates as $file) {
        if (is_file($file)) {
            $mtime = @filemtime($file);
            if ($mtime) {
                return '?v=' . $mtime;
            }
        }
    }
    return '';
}

function page_url($path = '/') {
    return BASE_URL . ($path === '/' ? '/' : '/' . ltrim($path, '/'));
}

function trunc_text($text, $limit = 80) {
    $text = trim((string)$text);
    if (mb_strlen($text) <= $limit) {
        return $text;
    }
    return rtrim(mb_substr($text, 0, $limit), " \t.,;:") . '…';
}

function admin_status_class($status) {
    switch ($status) {
        case 'New': return 'status-new';
        case 'Contacted': return 'status-contacted';
        case 'In Discussion': return 'status-discussion';
        case 'Accepted': return 'status-accepted';
        case 'Completed': return 'status-completed';
        case 'Archived': return 'status-archived';
        default: return 'status-new';
    }
}

require_once __DIR__ . '/views/partials/tech_icons.php';

