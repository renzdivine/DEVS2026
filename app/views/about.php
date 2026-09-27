<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$pageTitle = $pageTitle ?? 'About & Team - DEVS';
$pageDescription = $pageDescription ?? 'Meet the DEVS team of developers, and discover our philosophy, expertise, and digital solutions.';
$pagePath = $pagePath ?? '/about';
$pageCss = 'about.css';
?>
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css<?php echo asset_v('/css/style.css'); ?>">
    <?php if (!empty($pageCss)): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/<?php echo e($pageCss); ?><?php echo asset_v('/css/' . $pageCss); ?>">
    <?php endif; ?>
<?php include __DIR__ . "/partials/head.php"; ?>
<?php include __DIR__ . "/partials/nav.php"; ?>
<main id="main" class="main-content">

    <!-- Hero Section -->
    <section class="about-page-hero">
        <div class="container" data-reveal>
            <span class="eyebrow">About &amp; Team</span>
            <h1>Young developers. Real solutions.</h1>
            <p class="section-subtitle">A multidisciplinary team turning ideas into reliable, high-performance systems.</p>
        </div>
    </section>

    <!-- Who We Are & Core Pillars -->
    <section class="about-statement">
        <div class="container">
            <div class="about-details" data-reveal>
                <span class="eyebrow">Who we are</span>
                <h2>We build software people actually use</h2>
                <p>DEVS is a team of developers focused on practical, modern, and reliable digital work. We help individuals, businesses, organizations, and students who need a custom system, website, web application, or mobile application built.</p>
                <p>We do not just write code. We map how you work, design around that workflow, and ship something your team can keep running without us in the room.</p>
            </div>
            <div class="about-grid">
                <div class="about-cell" data-reveal>
                    <h3>What we do</h3>
                    <p>Web and mobile development, custom database-driven systems, and APIs - from first sketch to production.</p>
                </div>
                <div class="about-cell" data-reveal>
                    <h3>How we work</h3>
                    <p>Short feedback loops, clear scopes, and working increments. You see progress while the project is still moving.</p>
                </div>
                <div class="about-cell" data-reveal>
                    <h3>Who we serve</h3>
                    <p>Businesses, organizations, schools, and individuals who need reliable software built around real requirements.</p>
                </div>
                <div class="about-cell" data-reveal>
                    <h3>What we value</h3>
                    <p>Clarity over jargon, maintainable code over quick hacks, and interfaces that do not get in the way.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Merged Team Showcase -->
    <section class="about-team-section" id="team">
        <div class="container">
            <div class="team-header-slanted text-center" data-reveal>
                <h2 class="team-heading-slanted">OUR TEAM</h2>
                <p class="team-subtitle-slanted">A dedicated team turning ideas into reliable, high-performance systems.</p>
            </div>

            <?php if (empty($team)): ?>
                <p class="section-subtitle text-center">Team profiles are being updated. Check back soon.</p>
            <?php else: ?>
            <div class="team-grid-slanted">
                <?php foreach ($team as $member): ?>
                <a class="team-card-slanted" href="<?php echo BASE_URL; ?>/team/<?php echo e($member['member_slug']); ?>" data-reveal>
                    <div class="slanted-photo-frame">
                        <span class="slanted-corner-accent" aria-hidden="true"></span>
                        <div class="slanted-photo-inner">
                            <?php if (!empty($member['member_photo'])): ?>
                                <img src="<?php echo BASE_URL . e($member['member_photo']); ?>" alt="<?php echo e($member['member_name']); ?>" loading="lazy">
                            <?php else: ?>
                                <span class="photo-placeholder" aria-hidden="true"><?php echo e(strtoupper(substr($member['member_name'], 0, 2))); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="slanted-info-badge">
                        <div class="slanted-info-inner">
                            <h3 class="slanted-member-name"><?php echo e($member['member_name']); ?></h3>
                            <p class="slanted-member-role"><?php echo e($member['member_role']); ?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Technologies & Stack (Matching Reference Layout) -->
    <?php if (!empty($skills)): ?>
    <section class="skills-showcase-section" id="skills">
        <div class="container">
            <div class="skills-header" data-reveal>
                <div class="skills-pill">Skills</div>
                <h2 class="skills-subtitle">The skills, tools and technologies we excel at:</h2>
            </div>

            <div class="skills-icon-grid" data-reveal>
                <?php foreach ($skills as $skill): ?>
                <div class="skill-item" title="<?php echo e($skill['skill_description'] ?? $skill['skill_name']); ?>">
                    <div class="skill-icon-wrap">
                        <?php echo render_tech_icon($skill['skill_name'], 54); ?>
                    </div>
                    <span class="skill-label"><?php echo e($skill['skill_name']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2>Work with the team</h2>
                <p>Have an idea for a system? Tell us what you are building and who it is for.</p>
                <div class="cta-buttons">
                    <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-primary">Start a Project</a>
                    <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">See our work</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . "/partials/footer.php"; ?>
<script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
