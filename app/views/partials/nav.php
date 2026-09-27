<?php
$currentPath = $pagePath ?? '/';
$navLinks = [
    '/' => 'Home',
    '/projects' => 'Work',
    '/services' => 'Services',
    '/about' => 'About',
    '/contact' => 'Contact',
];

function nav_is_active($href, $current) {
    if ($href === '/') {
        return $current === '/' || $current === '';
    }
    return $current === $href || strpos($current, $href . '/') === 0;
}
?>
<header class="site-header">
    <nav class="navbar" aria-label="Main navigation">
        <div class="nav-container">
            <!-- Brand Logo -->
            <a href="<?php echo BASE_URL; ?>/" class="nav-brand" aria-label="DEVS home">
                <span class="brand-title">DEVS TEAM</span>
            </a>

            <!-- Desktop Navigation Links -->
            <ul class="nav-links" id="navLinks">
                <?php foreach ($navLinks as $href => $label): ?>
                <li>
                    <a href="<?php echo BASE_URL . ($href === '/' ? '/' : $href); ?>"
                       class="<?php echo nav_is_active($href, $currentPath) ? 'active' : ''; ?>"
                       <?php echo nav_is_active($href, $currentPath) ? 'aria-current="page"' : ''; ?>>
                        <?php echo $label; ?>
                    </a>
                </li>
                <?php endforeach; ?>
                <li class="nav-cta-mobile">
                    <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-editorial-primary btn-block">Start a Project</a>
                </li>
            </ul>

            <!-- Right Controls: Theme, CTA & Mobile Toggle -->
            <div class="nav-right">
                <button id="themeToggle" class="theme-toggle" type="button" aria-label="Switch color theme" title="Toggle dark/light theme">
                    <svg class="icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                    </svg>
                    <svg class="icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                </button>

                <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-editorial-primary btn-sm nav-cta">Start a Project</a>

                <button class="mobile-menu-toggle" id="mobileMenuToggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="navLinks">
                    <span class="bar"></span><span class="bar"></span><span class="bar"></span>
                </button>
            </div>
        </div>
    </nav>
</header>
