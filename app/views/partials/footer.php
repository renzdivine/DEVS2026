<?php
    $githubUrl   = setting('github_url');
    $linkedinUrl = setting('linkedin_url');
    $siteEmail   = setting('site_email');
?>
<!-- Scrolling editorial ticker -->
<div class="marquee-band" aria-hidden="true">
    <div class="marquee-track">
        <div class="marquee-group">
            <span class="marquee-item">Websites</span>
            <span class="marquee-dot"></span>
            <span class="marquee-item">Mobile Apps</span>
            <span class="marquee-dot"></span>
            <span class="marquee-item">Custom Systems</span>
            <span class="marquee-dot"></span>
            <span class="marquee-item">Databases</span>
            <span class="marquee-dot"></span>
            <span class="marquee-item">APIs</span>
            <span class="marquee-dot"></span>
        </div>
        <div class="marquee-group">
            <span class="marquee-item">Websites</span>
            <span class="marquee-dot"></span>
            <span class="marquee-item">Mobile Apps</span>
            <span class="marquee-dot"></span>
            <span class="marquee-item">Custom Systems</span>
            <span class="marquee-dot"></span>
            <span class="marquee-item">Databases</span>
            <span class="marquee-dot"></span>
            <span class="marquee-item">APIs</span>
            <span class="marquee-dot"></span>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer-container">

        <!-- Zone 1: Brand -->
        <div class="footer-brand-zone">
            <a href="<?php echo BASE_URL; ?>/" class="nav-logo footer-logo" aria-label="DEVS home">
                <span class="logo-bracket" aria-hidden="true">&lt;</span><span class="logo-text">DEVS</span><span class="logo-bracket" aria-hidden="true">/&gt;</span>
            </a>
            <p class="footer-tagline">Web &amp; Mobile Development Team</p>
        </div>

        <!-- Zone 2: Service tags row -->
        <div class="footer-services-row">
            <span>Web Development</span>
            <span>Mobile Apps</span>
            <span>UI / UX Design</span>
            <span>API Integration</span>
        </div>

        <div class="footer-divider"></div>

        <!-- Zone 3: Nav links -->
        <nav class="footer-nav" aria-label="Footer navigation">
            <a href="<?php echo BASE_URL; ?>/">Home</a>
            <a href="<?php echo BASE_URL; ?>/about">About</a>
            <a href="<?php echo BASE_URL; ?>/services">Services</a>
            <a href="<?php echo BASE_URL; ?>/projects">Projects</a>
            <a href="<?php echo BASE_URL; ?>/contact">Contact us</a>
        </nav>

        <!-- Zone 4: Social icons -->
        <?php if ($githubUrl || $linkedinUrl || $siteEmail): ?>
        <div class="footer-socials">
            <?php if ($githubUrl): ?>
            <a href="<?php echo e($githubUrl); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-icon" aria-label="GitHub">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
            </a>
            <?php endif; ?>
            <?php if ($linkedinUrl): ?>
            <a href="<?php echo e($linkedinUrl); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-icon" aria-label="LinkedIn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
            </a>
            <?php endif; ?>
            <?php if ($siteEmail): ?>
            <a href="mailto:<?php echo e($siteEmail); ?>" class="footer-social-icon" aria-label="Email">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Zone 5: Bottom bar -->
        <div class="footer-bottom">
            <div class="footer-legal">
                <a href="<?php echo BASE_URL; ?>/about">About</a>
                <span class="footer-sep" aria-hidden="true">|</span>
                <a href="<?php echo BASE_URL; ?>/contact">Contact</a>
                <span class="footer-sep" aria-hidden="true">|</span>
                <a href="<?php echo BASE_URL; ?>/admin">Admin</a>
            </div>
            <p class="footer-copy">&copy; 2026 DEVS. All rights reserved.</p>
        </div>

    </div>
</footer>

<?php include __DIR__ . '/chatbot.php'; ?>
