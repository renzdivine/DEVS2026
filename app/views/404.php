<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$pageTitle = $pageTitle ?? 'Page Not Found - DEVS';
$pageDescription = $pageDescription ?? 'The page you are looking for does not exist.';
$pagePath = $pagePath ?? '/404';
$pageCss = '404.css';
?>
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css<?php echo asset_v('/css/style.css'); ?>">
    <?php if (!empty($pageCss)): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/<?php echo e($pageCss); ?><?php echo asset_v('/css/' . $pageCss); ?>">
    <?php endif; ?>
<?php include __DIR__ . "/partials/head.php"; ?>
<?php include __DIR__ . "/partials/nav.php"; ?>
<main id="main" class="main-content">
    <section class="error-page">
        <div class="container">
            <div class="error-code" aria-hidden="true">404</div>
            <h1>Page not found</h1>
            <p>The page you are looking for was moved, renamed, or never existed.</p>
            <div class="cta-buttons">
                <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">Go Home</a>
                <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">View Our Work</a>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . "/partials/footer.php"; ?>
    <script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
