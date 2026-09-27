<?php
$pageTitle = $pageTitle ?? 'DEVS - Web & Mobile Development Team';
$pageDescription = $pageDescription ?? 'DEVS is a team of web and mobile developers building custom digital solutions for businesses, organizations, and individuals.';
$pagePath = $pagePath ?? '/';
$pageImage = $pageImage ?? '';
$canonical = page_url($pagePath);
$ogImage = $pageImage ? page_url($pageImage) : page_url('/img/og-default.png');

if (empty($pageCss)) {
    if ($pagePath === '/' || $pagePath === '') {
        $pageCss = 'home.css';
    } elseif ($pagePath === '/about') {
        $pageCss = 'about.css';
    } elseif ($pagePath === '/services') {
        $pageCss = 'services.css';
    } elseif ($pagePath === '/projects') {
        $pageCss = 'projects.css';
    } elseif (strpos($pagePath, '/projects') === 0) {
        $pageCss = 'project-detail.css';
    } elseif ($pagePath === '/team') {
        $pageCss = 'team.css';
    } elseif (strpos($pagePath, '/team') === 0) {
        $pageCss = 'team-member.css';
    } elseif ($pagePath === '/contact') {
        $pageCss = 'contact.css';
    } elseif ($pagePath === '/404') {
        $pageCss = '404.css';
    }
}
?>
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <link rel="canonical" href="<?php echo e($canonical); ?>">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="DEVS">
    <meta property="og:title" content="<?php echo e($pageTitle); ?>">
    <meta property="og:description" content="<?php echo e($pageDescription); ?>">
    <meta property="og:url" content="<?php echo e($canonical); ?>">
    <meta property="og:image" content="<?php echo e($ogImage); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($pageTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($pageDescription); ?>">
    <meta name="twitter:image" content="<?php echo e($ogImage); ?>">
    <meta name="theme-color" content="#c86142">
    <link rel="icon" href="<?php echo BASE_URL; ?>/favicon.svg" type="image/svg+xml">
    <script>
        (function () {
            try {
                var t = localStorage.getItem('theme');
                if (t === 'dark' || t === 'light') {
                    document.documentElement.setAttribute('data-theme', t);
                } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                }
            } catch (e) {}
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Caveat:wght@500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap">
    <!-- GSAP + ScrollTrigger (scroll choreography) -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <!-- Motion (Framer Motion for vanilla JS: spring micro-interactions) -->
    <script src="https://cdn.jsdelivr.net/npm/motion@11.11.13/dist/motion.js"></script>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
