<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $error = $error ?? ''; ?>
    <title>Admin Login - DEVS</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="<?php echo BASE_URL; ?>/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/admin.css">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-header">
            <div class="login-brand">DEVS<span class="text-terracotta">.</span></div>
            <p class="login-sub">Admin Workspace</p>
        </div>

        <?php if ($error !== ''): ?>
            <div class="flash error login-flash"><?php echo e($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>/admin" autocomplete="off" class="login-form">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="admin" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-editorial-primary btn-block">Sign In &rarr;</button>
            </div>
        </form>

        <div class="login-divider">
            <span>or</span>
        </div>

        <a href="<?php echo BASE_URL; ?>/admin/google-login" class="btn-google">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20" height="20" aria-hidden="true">
                <path fill="#EA4335" d="M24 9.5c3.14 0 5.95 1.08 8.17 2.86l6.09-6.09C34.46 3.09 29.5 1 24 1 14.82 1 7.07 6.48 3.64 14.22l7.08 5.5C12.5 13.36 17.77 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.5 24.5c0-1.64-.15-3.22-.42-4.75H24v9h12.68c-.55 2.99-2.2 5.52-4.68 7.22l7.19 5.59C43.27 37.77 46.5 31.6 46.5 24.5z"/>
                <path fill="#FBBC05" d="M10.72 28.28A14.6 14.6 0 0 1 9.5 24c0-1.49.26-2.93.72-4.28l-7.08-5.5A23.94 23.94 0 0 0 0 24c0 3.86.92 7.51 2.55 10.73l8.17-6.45z"/>
                <path fill="#34A853" d="M24 47c5.5 0 10.12-1.82 13.5-4.94l-7.19-5.59C28.6 38.13 26.42 39 24 39c-6.23 0-11.5-3.86-13.28-9.22l-8.17 6.45C6.07 43.52 14.41 47 24 47z"/>
            </svg>
            Continue with Google
        </a>

        <div class="login-footer">
            <a href="<?php echo BASE_URL; ?>/">&larr; Back to DEVS site</a>
        </div>
    </div>
    <script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
