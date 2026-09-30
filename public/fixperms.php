<?php
/**
 * DEVS — One-time permission fixer
 * Upload to htdocs/, visit it once in your browser, then DELETE it.
 * Sets all files to 644 and all folders to 755.
 */

// Basic protection — change this to something only you know
$secret = 'devs2026fix';
if (($_GET['key'] ?? '') !== $secret) {
    http_response_code(403);
    die('Access denied. Add ?key=devs2026fix to the URL.');
}

$root    = __DIR__;
$fixed   = [];
$errors  = [];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
    $path = $item->getPathname();

    // Skip this script itself so it stays runnable
    if (realpath($path) === realpath(__FILE__)) continue;

    if ($item->isDir()) {
        if (@chmod($path, 0755)) {
            $fixed[] = '[DIR  755] ' . str_replace($root, '', $path);
        } else {
            $errors[] = '[FAIL dir] ' . str_replace($root, '', $path);
        }
    } else {
        if (@chmod($path, 0644)) {
            $fixed[] = '[FILE 644] ' . str_replace($root, '', $path);
        } else {
            $errors[] = '[FAIL file] ' . str_replace($root, '', $path);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DEVS Permission Fixer</title>
<style>
  body { font-family: monospace; background: #111; color: #eee; padding: 2rem; }
  h1 { color: #C86142; }
  .ok  { color: #22c55e; }
  .err { color: #ef4444; }
  .warn { color: #f59e0b; font-size: 1.1rem; margin-top: 2rem; padding: 1rem; border: 1px solid #f59e0b; border-radius: 4px; }
</style>
</head>
<body>
<h1>DEVS Permission Fixer</h1>
<p>Root: <?php echo htmlspecialchars($root); ?></p>
<p><strong class="ok">Fixed: <?php echo count($fixed); ?> items</strong> &nbsp;|&nbsp; <strong class="err">Failed: <?php echo count($errors); ?> items</strong></p>

<?php if ($errors): ?>
<h2 class="err">Errors</h2>
<pre><?php echo htmlspecialchars(implode("\n", $errors)); ?></pre>
<?php endif; ?>

<h2 class="ok">Fixed</h2>
<pre><?php echo htmlspecialchars(implode("\n", $fixed)); ?></pre>

<div class="warn">
  ⚠️ <strong>DELETE this file now!</strong><br>
  Remove <code>fixperms.php</code> from your server immediately after running it.
</div>
</body>
</html>
