<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$scriptDir = rtrim($scriptDir, '/');
if (!defined('BASE_URL')) {
    define('BASE_URL', $scriptDir === '' || $scriptDir === '/' ? '' : $scriptDir);
}

// APP_ROOT: auto-detects local (XAMPP) vs production (InfinityFree)
// Local:      index.php is at public/index.php — app/ and config/ are one level up
// Production: index.php is at htdocs/index.php — app/ and config/ are in the same folder
if (!defined('APP_ROOT')) {
    if (file_exists(__DIR__ . '/../config/Database.php')) {
        // Local XAMPP — public/ subfolder structure
        define('APP_ROOT', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);
    } else {
        // Production — flat htdocs/ structure
        define('APP_ROOT', __DIR__ . DIRECTORY_SEPARATOR);
    }
}

require_once APP_ROOT . "config/Database.php";
require_once APP_ROOT . "app/helpers.php";
require_once APP_ROOT . "app/controllers/HomeController.php";
require_once APP_ROOT . "app/controllers/AdminController.php";
require_once APP_ROOT . "app/controllers/ApiControllers.php";

$action = $_GET['action'] ?? '';
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = (string)parse_url($requestUri, PHP_URL_PATH);
$path = trim($path, '/');

// Strip the base URL prefix (e.g. "DEVS/public") so clean URLs dispatch correctly.
$basePrefix = trim(BASE_URL, '/');
if ($basePrefix !== '') {
    if ($path === $basePrefix) {
        $path = '';
    } elseif (strpos($path, $basePrefix . '/') === 0) {
        $path = substr($path, strlen($basePrefix) + 1);
    }
}
if (strpos($path, 'index.php') === 0) {
    $path = trim(substr($path, strlen('index.php')), '/');
}
$path = trim($path, '/');
$pathParts = $path === '' ? [''] : explode('/', $path);

$homeController = new HomeController();
$teamController = new TeamController();
$projectController = new ProjectController();
$adminController = new AdminController();

function render_404() {
    http_response_code(404);
    include APP_ROOT . "app/views/404.php";
    exit;
}

// Admin pages: /admin with optional ?sub=
if ($pathParts[0] === 'admin') {
    // Google OAuth routes — no session required
    if (isset($pathParts[1]) && $pathParts[1] === 'google-login') {
        $adminController->googleLogin();
        exit;
    }
    if (isset($pathParts[1]) && $pathParts[1] === 'google-callback') {
        $adminController->googleCallback();
        exit;
    }

    if ($action !== '') {
        handleApiAction();
        exit;
    }
    if (!isset($_SESSION['admin_id'])) {
        $adminController->login();
        exit;
    }

    $sub = $_GET['sub'] ?? '';
    switch ($sub) {
        case '':
        case 'dashboard':
            $adminController->dashboard();
            break;
        case 'team':
            $adminController->manageTeam();
            break;
        case 'services':
            $adminController->manageServices();
            break;
        case 'technologies':
            $adminController->manageTechnologies();
            break;
        case 'projects':
            $adminController->manageProjects();
            break;
        case 'inquiries':
            $adminController->manageInquiries();
            break;
        case 'availability':
            $adminController->availability();
            break;
        case 'settings':
            $adminController->settings();
            break;
        default:
            $adminController->dashboard();
            break;
    }
    exit;
}

// Mutation / API actions (admin saves, deletes, logout, etc.)
if ($action !== '') {
    handleApiAction();
    exit;
}

// Public routes dispatched on the clean path
switch (true) {
    case $path === '':
    case $path === 'home':
        $homeController->home();
        break;
    case $path === 'about':
        $homeController->about();
        break;
    case $path === 'services':
        $homeController->services();
        break;
    case $path === 'projects':
        $homeController->projects();
        break;
    case $pathParts[0] === 'projects' && isset($pathParts[1]) && $pathParts[1] !== '':
        $projectController->detail($pathParts[1]);
        break;
    case $path === 'team':
        header('Location: ' . BASE_URL . '/about#team', true, 301);
        exit;
        break;
    case $pathParts[0] === 'team' && isset($pathParts[1]) && $pathParts[1] !== '':
        $teamController->member($pathParts[1]);
        break;
    case $path === 'contact':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inquiry = new InquiryApiController();
            $inquiry->submit();
        } else {
            $homeController->contact();
        }
        break;
    default:
        render_404();
        break;
}

function handleApiAction() {
    global $adminController, $teamController, $projectController;
    $action = $_GET['action'];
    $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

    // All mutations must be POST with a valid CSRF token.
    $mutations = [
        'adminLogin', 'adminLogout', 'adminDeleteTeam', 'adminDeleteProject',
        'adminDeleteService', 'adminDeleteTech', 'adminSaveProject', 'adminSaveTeam',
        'adminSaveService', 'adminSaveTech', 'adminUpdateInquiryStatus',
        'adminAvailabilityUpdate', 'adminSaveSettings', 'adminReplyInquiry',
    ];
    if (in_array($action, $mutations, true)) {
        if (!$isPost || !csrf_verify()) {
            http_response_code(419);
            $_SESSION['error'] = 'Security check failed. Please try again.';
            header('Location: ' . BASE_URL . '/admin');
            exit;
        }
    }

    switch ($action) {
        case 'adminLogin':
            $adminController->login();
            break;
        case 'adminLogout':
            session_destroy();
            header('Location: ' . BASE_URL . '/admin');
            exit;
        case 'adminDeleteTeam':
            $api = new TeamApiController();
            $api->delete();
            break;
        case 'adminDeleteProject':
            $api = new ProjectApiController();
            $api->delete();
            break;
        case 'adminDeleteService':
            $api = new ServiceApiController();
            $api->delete();
            break;
        case 'adminDeleteTech':
            $api = new TechnologyApiController();
            $api->delete();
            break;
        case 'adminSaveProject':
            $api = new ProjectApiController();
            if (isset($_POST['project_id']) && $_POST['project_id']) {
                $api->edit();
            } else {
                $api->add();
            }
            break;
        case 'adminSaveTeam':
            $api = new TeamApiController();
            if (isset($_POST['member_id']) && $_POST['member_id']) {
                $api->edit();
            } else {
                $api->add();
            }
            break;
        case 'adminSaveService':
            $api = new ServiceApiController();
            if (isset($_POST['service_id']) && $_POST['service_id']) {
                $api->edit();
            } else {
                $api->add();
            }
            break;
        case 'adminSaveTech':
            $api = new TechnologyApiController();
            if (isset($_POST['skill_id']) && $_POST['skill_id']) {
                $api->edit();
            } else {
                $api->add();
            }
            break;
        case 'adminUpdateInquiryStatus':
            $api = new InquiryApiController();
            $api->updateStatus();
            break;
        case 'adminReplyInquiry':
            $api = new ReplyInquiryApiController();
            $api->send();
            break;
        case 'adminAvailabilityUpdate':
            $api = new AvailabilityApiController();
            $api->update();
            break;
        case 'adminSaveSettings':
            $api = new SettingsApiController();
            $api->save();
            break;
        case 'adminEditTeam':
        case 'adminAddTeam':
            $adminController->manageTeam();
            break;
        case 'adminAddProject':
        case 'adminEditProject':
            $adminController->manageProjects();
            break;
        case 'adminAddService':
        case 'adminEditService':
            $adminController->manageServices();
            break;
        case 'adminAddTech':
        case 'adminEditTech':
            $adminController->manageTechnologies();
            break;
        case 'chatbot':
            $api = new ChatbotApiController();
            $api->respond();
            break;
        default:
            header('Location: ' . BASE_URL . '/');
            exit;
    }
}
