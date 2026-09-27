<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$pageTitle = $pageTitle ?? 'Services - DEVS';
$pageDescription = $pageDescription ?? 'Web development, mobile development, custom systems, databases, and APIs built around your requirements.';
$pagePath = $pagePath ?? '/services';
$pageCss = 'services.css';
$activeServices = array_values(array_filter($services ?? [], fn($s) => !isset($s['service_status']) || (int)$s['service_status'] === 1));
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
    <section class="services-hero">
        <div class="container services-hero-inner">
            <div class="services-hero-left" data-reveal>
                <span class="eyebrow">How we can help you</span>
                <h1>Services<br>We Offer</h1>
            </div>
            <div class="services-hero-right" data-reveal>
                <p class="services-hero-body">Full-stack web and mobile solutions - from fast-moving MVPs to robust production systems - shaped around how your team actually works.</p>
                <p class="services-hero-body">We map requirements before writing code, deliver in working increments, and hand over clean documented software your team can own.</p>
                <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-primary services-hero-cta">Let's Talk &rarr;</a>
            </div>
        </div>
    </section>

    <!-- ── Services numbered list ────────────────────── -->
    <section class="services-list-section">
        <div class="container">
            <?php if (empty($activeServices)): ?>
                <p class="section-subtitle">Services are being updated. Please <a href="<?php echo BASE_URL; ?>/contact">contact us</a> to discuss your project.</p>
            <?php else: ?>
            <div class="services-numbered-grid">
                <?php foreach ($activeServices as $i => $service): ?>
                <article class="svc-item" data-reveal>
                    <div class="svc-rule"></div>
                    <span class="svc-index"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
                    <h3 class="svc-name"><?php echo e($service['service_name']); ?></h3>
                    <?php if (!empty($service['service_description'])): ?>
                    <p class="svc-desc"><?php echo e($service['service_description']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($service['service_technologies'])): ?>
                    <p class="svc-tech-list">
                        <?php
                        $techs = array_filter(array_map('trim', explode(',', $service['service_technologies'])));
                        echo e(implode(', ', $techs));
                        ?>
                    </p>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ── How we work - zigzag process ─────────────── -->
    <section class="process-section band">
        <div class="container">
            <div class="process-head" data-reveal>
                <span class="eyebrow">How we work</span>
                <h2>From idea to working software</h2>
                <p class="section-subtitle">A proven process designed to turn requirements into clean, maintainable software - efficiently and without surprises.</p>
            </div>

            <div class="process-track">
                <div class="process-spine" aria-hidden="true"></div>

                <!-- Step 1 - icon left, text right -->
                <div class="process-step step-left" data-reveal>
                    <div class="process-icon-col">
                        <div class="process-icon-wrap">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        </div>
                        <span class="process-num">01</span>
                    </div>
                    <div class="process-connector" aria-hidden="true"></div>
                    <div class="process-text-col">
                        <h3>Scope &amp; Discovery</h3>
                        <p>We map your workflow, goals, and constraints before any code is written - so the build matches how you actually operate.</p>
                    </div>
                </div>

                <!-- Step 2 - text left, icon right -->
                <div class="process-step step-right" data-reveal>
                    <div class="process-text-col">
                        <h3>Architecture Blueprint</h3>
                        <p>We design the data model, tech stack, and system structure aligned with your KPIs and timeline.</p>
                    </div>
                    <div class="process-connector" aria-hidden="true"></div>
                    <div class="process-icon-col">
                        <div class="process-icon-wrap">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        </div>
                        <span class="process-num">02</span>
                    </div>
                </div>

                <!-- Step 3 - icon left, text right -->
                <div class="process-step step-left" data-reveal>
                    <div class="process-icon-col">
                        <div class="process-icon-wrap">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                        </div>
                        <span class="process-num">03</span>
                    </div>
                    <div class="process-connector" aria-hidden="true"></div>
                    <div class="process-text-col">
                        <h3>Build &amp; Integration</h3>
                        <p>We develop in working increments. You review real pieces along the way instead of waiting for one big reveal.</p>
                    </div>
                </div>

                <!-- Step 4 - text left, icon right -->
                <div class="process-step step-right" data-reveal>
                    <div class="process-text-col">
                        <h3>Testing &amp; Optimisation</h3>
                        <p>Performance testing, data validation, edge-case handling, and cross-device QA before anything ships.</p>
                    </div>
                    <div class="process-connector" aria-hidden="true"></div>
                    <div class="process-icon-col">
                        <div class="process-icon-wrap">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <span class="process-num">04</span>
                    </div>
                </div>

                <!-- Step 5 - icon left, text right -->
                <div class="process-step step-left" data-reveal>
                    <div class="process-icon-col">
                        <div class="process-icon-wrap">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                        <span class="process-num">05</span>
                    </div>
                    <div class="process-connector" aria-hidden="true"></div>
                    <div class="process-text-col">
                        <h3>Deploy &amp; Scale</h3>
                        <p>Launch, monitor, and continuously optimise. Documented structure and an interface your team can run without us.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── CTA ───────────────────────────────────────── -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2>Not sure what you need yet?</h2>
                <p>Describe the problem you are trying to solve. We will tell you what is worth building first.</p>
                <div class="cta-buttons">
                    <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-primary">Talk to us</a>
                    <a href="<?php echo BASE_URL; ?>/about#team" class="btn btn-secondary">Meet the team</a>
                </div>
            </div>
        </div>
    </section>

</main>
<?php include __DIR__ . "/partials/footer.php"; ?>
    <script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
