<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$pageTitle = $pageTitle ?? (($project['project_name'] ?? 'Project') . ' - DEVS');
$pageDescription = $pageDescription ?? ($project['project_description'] ?? '');
$pagePath = $pagePath ?? ('/projects/' . ($project['project_slug'] ?? ''));
$pageCss = 'project-detail.css';
$pageImage = !empty($project['project_featured_image']) ? $project['project_featured_image'] : '';
?>
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css<?php echo asset_v('/css/style.css'); ?>">
    <?php if (!empty($pageCss)): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/<?php echo e($pageCss); ?><?php echo asset_v('/css/' . $pageCss); ?>">
    <?php endif; ?>
<?php include __DIR__ . "/partials/head.php"; ?>
<?php include __DIR__ . "/partials/nav.php"; ?>
<main id="main" class="main-content">
    <article class="project-detail">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>/projects" class="back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
                Back to Projects
            </a>
            <div data-reveal>
                <h1><?php echo e($project['project_name']); ?></h1>
                <span class="project-category"><?php echo e($project['project_category']); ?></span>
            </div>

            <?php if (!empty($project['project_featured_image'])): ?>
            <div class="screenshot-item" style="margin-bottom: clamp(1.75rem, 3vw, 2.5rem);" data-reveal>
                <img src="<?php echo BASE_URL . e($project['project_featured_image']); ?>" alt="<?php echo e($project['project_name']); ?> cover">
            </div>
            <?php endif; ?>

            <div class="project-overview" data-reveal>
                <p><?php echo e($project['project_long_description'] ?: $project['project_description']); ?></p>
            </div>

            <?php if (!empty($project['project_dev_story'])): ?>
            <section data-reveal>
                <h2>Dev story</h2>
                <div class="dev-story">
                    <p><?php echo e($project['project_dev_story']); ?></p>
                </div>
            </section>
            <?php endif; ?>

            <?php
            $featureLines = array_filter(array_map('trim', explode("\n", (string)($project['project_features'] ?? ''))));
            if (!empty($featureLines)):
            ?>
            <section class="project-features" data-reveal>
                <h2>Features</h2>
                <ul>
                    <?php foreach ($featureLines as $feature): ?>
                        <li><?php echo e($feature); ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <?php endif; ?>

            <?php if (!empty($skills)): ?>
            <section data-reveal>
                <h2>Technologies</h2>
                <div class="tech-tags">
                    <?php foreach ($skills as $skill): ?>
                        <span class="tech-tag"><?php echo e($skill['skill_name']); ?></span>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if (!empty($members)): ?>
            <section class="project-team" data-reveal>
                <h2>Team</h2>
                <div class="team-grid">
                    <?php foreach ($members as $member): ?>
                    <a class="team-card small" href="<?php echo BASE_URL; ?>/team/<?php echo e($member['member_slug']); ?>">
                        <div class="team-photo">
                            <?php if (!empty($member['member_photo'])): ?>
                                <img src="<?php echo BASE_URL . e($member['member_photo']); ?>" alt="<?php echo e($member['member_name']); ?>" loading="lazy">
                            <?php else: ?>
                                <span class="photo-placeholder small" aria-hidden="true"><?php echo e(strtoupper(substr($member['member_name'], 0, 2))); ?></span>
                            <?php endif; ?>
                        </div>
                        <p><?php echo e($member['member_name']); ?></p>
                        <span><?php echo e($member['member_role']); ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if (!empty($images)): ?>
            <section data-reveal>
                <h2>Screenshots</h2>
                <div class="screenshots-grid">
                    <?php foreach ($images as $img): ?>
                        <figure class="screenshot-item">
                            <img src="<?php echo BASE_URL . e($img['image_path']); ?>" alt="<?php echo e($project['project_name']); ?> screenshot" loading="lazy">
                        </figure>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <section class="project-links">
                <?php if (!empty($project['project_live_url'])): ?>
                    <a href="<?php echo e($project['project_live_url']); ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Live Demo</a>
                <?php endif; ?>
                <?php if (!empty($project['project_github_url'])): ?>
                    <a href="<?php echo e($project['project_github_url']); ?>" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">GitHub</a>
                <?php endif; ?>
                <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-secondary">Start a similar project</a>
            </section>
        </div>
    </article>
</main>
<?php include __DIR__ . "/partials/footer.php"; ?>
    <script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
