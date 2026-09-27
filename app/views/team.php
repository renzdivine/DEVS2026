<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$pageTitle = $pageTitle ?? 'Team - DEVS';
$pageDescription = $pageDescription ?? 'Meet the DEVS team of web and mobile developers.';
$pagePath = $pagePath ?? '/team';
$pageCss = 'team.css';
?>
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css<?php echo asset_v('/css/style.css'); ?>">
    <?php if (!empty($pageCss)): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/<?php echo e($pageCss); ?><?php echo asset_v('/css/' . $pageCss); ?>">
    <?php endif; ?>
<?php include __DIR__ . "/partials/head.php"; ?>
<?php include __DIR__ . "/partials/nav.php"; ?>
<main id="main" class="main-content">
    <section class="page-hero">
        <div class="container" data-reveal>
            <span class="eyebrow">Team</span>
            <h1>Meet the team</h1>
            <p class="section-subtitle">Young developers. Real solutions.</p>
        </div>
    </section>

    <section class="projects-page-body">
        <div class="container">
            <?php if (empty($members)): ?>
                <p class="section-subtitle">Team profiles are being updated. Check back soon.</p>
            <?php else: ?>
            <div class="team-grid-slanted">
                <?php foreach ($members as $member): ?>
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

    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2>Work with the team</h2>
                <p>Have a project in mind? Tell us what you are building and who it is for.</p>
                <div class="cta-buttons">
                    <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-primary">Start a Project</a>
                    <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">See what we have built</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . "/partials/footer.php"; ?>
    <script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
