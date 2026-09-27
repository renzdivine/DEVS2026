<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$pageTitle = $pageTitle ?? 'Projects - DEVS';
$pageDescription = $pageDescription ?? 'A selection of web, mobile, and custom system projects built by DEVS.';
$pagePath = $pagePath ?? '/projects';
$pageCss = 'projects.css';
?>
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css<?php echo asset_v('/css/style.css'); ?>">
    <?php if (!empty($pageCss)): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/<?php echo e($pageCss); ?><?php echo asset_v('/css/' . $pageCss); ?>">
    <?php endif; ?>
<?php include __DIR__ . "/partials/head.php"; ?>
<?php include __DIR__ . "/partials/nav.php"; ?>
<main id="main" class="main-content">

    <!-- ── Hero ─────────────────────────────────────── -->
    <section class="projects-hero">
        <div class="container projects-hero-inner">
            <div class="projects-hero-left" data-reveal>
                <h1>Projects</h1>
            </div>
            <div class="projects-hero-right" data-reveal>
                <p>Websites, mobile apps, and custom systems built for real clients. Every project below shipped to production.</p>
            </div>
        </div>
    </section>

    <!-- ── Filters + Grid ────────────────────────────── -->
    <section class="projects-body">
        <div class="container">

            <!-- Filter bar -->
            <div class="proj-filter-bar" role="group" aria-label="Filter projects">
                <button class="proj-filter active" type="button" data-filter="all">All</button>
                <button class="proj-filter" type="button" data-filter="Web">Web design</button>
                <button class="proj-filter" type="button" data-filter="Mobile">Mobile</button>
                <button class="proj-filter" type="button" data-filter="System">Development</button>
                <button class="proj-filter" type="button" data-filter="Other">Other</button>
            </div>

            <div class="proj-filter-rule"></div>

            <!-- Grid -->
            <?php if (empty($projects)): ?>
                <p class="section-subtitle" style="padding-top:3rem;">No projects to show yet. <a href="<?php echo BASE_URL; ?>/contact">Start one with us.</a></p>
            <?php else: ?>
            <div class="projects-flat-grid">
                <?php foreach ($projects as $project): ?>
                <article class="proj-card" data-category="<?php echo e($project['project_category']); ?>" data-reveal>
                    <a href="<?php echo BASE_URL; ?>/projects/<?php echo e($project['project_slug']); ?>" class="proj-card-link" aria-label="View <?php echo e($project['project_name']); ?>">
                        <div class="proj-img-wrap">
                            <?php if (!empty($project['project_featured_image'])): ?>
                                <img src="<?php echo BASE_URL . e($project['project_featured_image']); ?>"
                                     alt="<?php echo e($project['project_name']); ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="proj-img-placeholder" aria-hidden="true">DEVS</div>
                            <?php endif; ?>
                            <span class="proj-arrow" aria-hidden="true">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7"/><path d="M7 7h10v10"/></svg>
                            </span>
                        </div>
                    </a>
                    <div class="proj-info">
                        <h3 class="proj-title">
                            <a href="<?php echo BASE_URL; ?>/projects/<?php echo e($project['project_slug']); ?>">
                                <?php echo e($project['project_name']); ?>
                            </a>
                        </h3>
                        <p class="proj-desc"><?php echo e(trunc_text($project['project_description'], 100)); ?></p>
                        <div class="proj-tags">
                            <span class="proj-tag"><?php echo e($project['project_category']); ?></span>
                            <?php if (!empty($project['technologies'])): ?>
                                <?php foreach (array_slice(array_map('trim', explode(',', $project['technologies'])), 0, 2) as $tech): ?>
                                    <?php if ($tech): ?><span class="proj-tag"><?php echo e($tech); ?></span><?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- ── CTA ───────────────────────────────────────── -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2>Want something like these?</h2>
                <p>Tell us about your project and we will map the fastest sensible path to a working version.</p>
                <div class="cta-buttons">
                    <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-primary">Start a Project</a>
                    <a href="<?php echo BASE_URL; ?>/services" class="btn btn-secondary">What we build</a>
                </div>
            </div>
        </div>
    </section>

</main>
<?php include __DIR__ . "/partials/footer.php"; ?>
    <script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
