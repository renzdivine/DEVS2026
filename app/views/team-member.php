<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$pageTitle = $pageTitle ?? (($member['member_name'] ?? 'Team member') . ' - DEVS');
$pageDescription = $pageDescription ?? (($member['member_role'] ?? '') . ' at DEVS.');
$pagePath = $pagePath ?? ('/team/' . ($member['member_slug'] ?? ''));
$pageCss = 'team-member.css';
?>
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css<?php echo asset_v('/css/style.css'); ?>">
    <?php if (!empty($pageCss)): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/<?php echo e($pageCss); ?><?php echo asset_v('/css/' . $pageCss); ?>">
    <?php endif; ?>
<?php include __DIR__ . "/partials/head.php"; ?>
<?php include __DIR__ . "/partials/nav.php"; ?>
<main id="main" class="main-content">
    <section class="member-profile">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>/about#team" class="back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
                Back to Team
            </a>
            <div class="member-hero" data-reveal>
                <div class="member-photo-large">
                    <?php if (!empty($member['member_photo'])): ?>
                        <img src="<?php echo BASE_URL . e($member['member_photo']); ?>" alt="<?php echo e($member['member_name']); ?>">
                    <?php else: ?>
                        <span class="image-placeholder large" aria-hidden="true"><?php echo e(strtoupper(substr($member['member_name'], 0, 2))); ?></span>
                    <?php endif; ?>
                </div>
                <div class="member-info">
                    <h1><?php echo e($member['member_name']); ?></h1>
                    <p class="member-role"><?php echo e($member['member_role']); ?></p>
                    <p class="member-short-bio"><?php echo e(!empty($member['member_short_bio']) ? $member['member_short_bio'] : ($member['member_full_bio'] ?? '')); ?></p>
                    <?php if (!empty($member['member_skills'])): ?>
                    <div class="member-skills">
                        <?php foreach (explode(',', $member['member_skills']) as $skill): ?>
                            <?php $skill = trim($skill); if ($skill === '') continue; ?>
                            <span class="tech-tag"><?php echo e($skill); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="member-social">
                        <?php if (!empty($member['member_github'])): ?>
                            <a href="<?php echo e($member['member_github']); ?>" class="btn btn-sm btn-secondary" target="_blank" rel="noopener noreferrer">GitHub</a>
                        <?php endif; ?>
                        <?php if (!empty($member['member_linkedin'])): ?>
                            <a href="<?php echo e($member['member_linkedin']); ?>" class="btn btn-sm btn-secondary" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                        <?php endif; ?>
                        <?php if (!empty($member['member_facebook'])): ?>
                            <a href="<?php echo e($member['member_facebook']); ?>" class="btn btn-sm btn-secondary" target="_blank" rel="noopener noreferrer">Facebook</a>
                        <?php endif; ?>
                        <?php if (!empty($member['member_instagram'])): ?>
                            <a href="<?php echo e($member['member_instagram']); ?>" class="btn btn-sm btn-secondary" target="_blank" rel="noopener noreferrer">Instagram</a>
                        <?php endif; ?>
                        <?php if (!empty($member['member_email'])): ?>
                            <a href="mailto:<?php echo e($member['member_email']); ?>" class="btn btn-sm btn-secondary">Email</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (!empty($member['member_full_bio']) && trim($member['member_full_bio']) !== trim($member['member_short_bio'] ?? '')): ?>
            <section class="member-bio" data-reveal>
                <h2>About</h2>
                <p><?php echo e($member['member_full_bio']); ?></p>
            </section>
            <?php endif; ?>

            <?php if (!empty($memberProjects)): ?>
            <section class="member-projects" data-reveal>
                <h2>Projects</h2>
                <div class="projects-grid">
                    <?php foreach ($memberProjects as $project): ?>
                    <article class="project-card" data-category="<?php echo e($project['project_category']); ?>">
                        <div class="project-image">
                            <?php if (!empty($project['project_featured_image'])): ?>
                                <img src="<?php echo BASE_URL . e($project['project_featured_image']); ?>" alt="<?php echo e($project['project_name']); ?>" loading="lazy">
                            <?php else: ?>
                                <div class="image-placeholder" aria-hidden="true">DEVS</div>
                            <?php endif; ?>
                        </div>
                        <div class="project-info">
                            <div class="project-meta">
                                <span class="project-category"><?php echo e($project['project_category']); ?></span>
                            </div>
                            <h3><?php echo e($project['project_name']); ?></h3>
                            <p><?php echo e(trunc_text($project['project_description'], 110)); ?></p>
                            <a href="<?php echo BASE_URL; ?>/projects/<?php echo e($project['project_slug']); ?>" class="link-arrow">
                                View project
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include __DIR__ . "/partials/footer.php"; ?>
    <script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
