<?php
$pageTitle = $pageTitle ?? 'Dashboard';
$currentSub = $_GET['sub'] ?? '';
if ($currentSub === '') {
    $currentSub = 'dashboard';
}
$adminUsername = $_SESSION['admin_username'] ?? 'Admin';

/* Grouped navigation - each group has a label and items */
$adminNavGroups = [
    'Overview' => [
        'dashboard' => ['label' => 'Dashboard', 'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>'],
    ],
    'Content' => [
        'projects'     => ['label' => 'Projects',     'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>'],
        'team'         => ['label' => 'Team',         'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'],
        'services'     => ['label' => 'Services',     'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>'],
        'technologies' => ['label' => 'Technologies', 'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>'],
    ],
    'Activity' => [
        'inquiries'    => ['label' => 'Inquiries',    'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>'],
        'availability' => ['label' => 'Availability', 'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'],
    ],
    'System' => [
        'settings' => ['label' => 'Settings', 'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>'],
    ],
];

/* Format last login nicely */
$lastLogin = date('j M Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?> - Admin</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="<?php echo BASE_URL; ?>/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/admin.css">
</head>
<body class="admin-body">

<!-- Mobile sidebar backdrop -->
<div class="admin-sidebar-backdrop" id="sidebarBackdrop"></div>

<aside class="admin-sidebar" id="adminSidebar" aria-label="Admin sidebar">

    <!-- User identity block -->
    <div class="sidebar-identity">
        <div class="sidebar-avatar" aria-hidden="true">
            <?php echo strtoupper(substr($adminUsername, 0, 1)); ?>
        </div>
        <div class="sidebar-identity-info">
            <span class="sidebar-name">
                <?php echo e(ucfirst($adminUsername)); ?>
            </span>
            <span class="sidebar-last-login">Last login <?php echo $lastLogin; ?></span>
        </div>
    </div>

    <!-- Grouped navigation -->
    <nav class="admin-sidebar-nav" aria-label="Admin Navigation">
        <?php foreach ($adminNavGroups as $groupLabel => $items): ?>
            <div class="nav-group">
                <span class="nav-group-label"><?php echo e($groupLabel); ?></span>
                <?php foreach ($items as $sub => $item): ?>
                    <a href="<?php echo BASE_URL; ?>/admin?sub=<?php echo e($sub); ?>"
                       class="nav-item<?php echo $currentSub === $sub ? ' active' : ''; ?>"
                       <?php echo $currentSub === $sub ? 'aria-current="page"' : ''; ?>>
                        <span class="nav-icon" aria-hidden="true"><?php echo $item['icon']; ?></span>
                        <span class="nav-text"><?php echo e($item['label']); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </nav>

    <!-- Bottom actions -->
    <div class="sidebar-footer">
        <a href="<?php echo BASE_URL; ?>/" target="_blank" rel="noopener" class="sidebar-view-site">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            <span>View Live Site</span>
        </a>
        <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminLogout">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-logout" aria-label="Log out">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>

</aside>

<main class="admin-main">
    <div class="admin-topbar">
        <div class="topbar-left">
            <!-- Hamburger - mobile only -->
            <button class="admin-menu-toggle" id="sidebarToggle" aria-label="Open menu" aria-expanded="false" aria-controls="adminSidebar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <h1 class="admin-page-title"><?php echo e($pageTitle); ?></h1>
        </div>
        <div class="topbar-right">
            <label class="visually-hidden" for="adminSearch">Search</label>
            <div class="search-input-wrap">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input class="admin-search" id="adminSearch" type="search" placeholder="Search…" autocomplete="off">
            </div>
            <div class="admin-user-badge">
                <span class="user-avatar-dot" aria-hidden="true"></span>
                <span class="admin-user"><?php echo e($adminUsername); ?></span>
            </div>
        </div>
    </div>
    <div class="admin-content">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="flash success">
                <span><?php echo e($_SESSION['success']); unset($_SESSION['success']); ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="flash error">
                <span><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></span>
            </div>
        <?php endif; ?>
