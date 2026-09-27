
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$pageTitle = $pageTitle ?? 'DEVS - Web & Mobile Development Team';
$pageDescription = $pageDescription ?? 'DEVS is a team of web and mobile developers creating custom websites, applications, and information systems based on our clients\' needs.';
$pagePath = $pagePath ?? '/';
$pageCss = 'home.css';
$availLabel = availability_label($avail['availability_status'] ?? 'Available');
$activeServices = array_values(array_filter($services ?? [], fn($s) => !isset($s['service_status']) || (int)$s['service_status'] === 1));

// Featured projects - pulled from database (set in HomeController)
$editorialProjects = [];
$nums = ['01', '02', '03', '04'];
foreach (array_values($featuredProjects ?? []) as $i => $proj) {
    $editorialProjects[] = [
        'num'      => $nums[$i] ?? str_pad($i + 1, 2, '0', STR_PAD_LEFT),
        'title'    => $proj['project_name'],
        'category' => $proj['project_category'],
        'image'    => $proj['project_featured_image'] ?? '',
        'slug'     => $proj['project_slug'],
    ];
}
?>
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css<?php echo asset_v('/css/style.css'); ?>">
    <?php if (!empty($pageCss)): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/<?php echo e($pageCss); ?><?php echo asset_v('/css/' . $pageCss); ?>">
    <?php endif; ?>
<?php include __DIR__ . "/partials/head.php"; ?>
<?php include __DIR__ . "/partials/nav.php"; ?>

<div class="editorial-page-wrapper">
    <!-- Desktop Side Rails -->
    <aside class="side-rail side-rail-left" aria-hidden="true">
        <span class="rail-text">WEB DEVELOPMENT <span class="rail-divider"></span> MOBILE APPLICATIONS</span>
    </aside>
    <aside class="side-rail side-rail-right" aria-hidden="true">
        <span class="rail-text">CUSTOM SYSTEMS <span class="rail-divider"></span> DATABASE ARCHITECTURE</span>
    </aside>

    <main id="main" class="main-content editorial-main">
        <!-- ==================== HERO SECTION ==================== -->
        <section class="editorial-hero" aria-label="Introduction">
            <div class="hero-top-banner">
                <div class="hero-title-parallax">
                    <h1 class="giant-portfolio-title">DEVS</h1>
                </div>
            </div>

            <div class="hero-two-col">
                <!-- Left Column: Exact Brand Identity & Value Proposition -->
                <div class="hero-left-column">
                    <span class="hero-greeting">WEB &amp; MOBILE DEVELOPMENT TEAM</span>
                    <h2 class="hero-headline-title">WE BUILD DIGITAL SOLUTIONS.</h2>
                    <p class="hero-lead-bio">
                        DEVS is a team of web and mobile developers creating custom websites, applications, and information systems based on our clients' needs.
                    </p>

                    <div class="hero-cta-group">
                        <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-editorial-primary">Start a Project</a>
                        <a href="#selected-projects" class="btn btn-editorial-outline">Explore Our Work</a>
                    </div>

                    <p class="team-status-text">Available for custom website, app &amp; system projects</p>
                </div>

                <!-- Right Column: Developer Team Stage (Visualizing Software Development Team) -->
                <div class="hero-right-column">
                    <div class="hero-art-stage hero-team-stage">
                        <!-- Terracotta Geometric Sun Disk -->
                        <div class="hero-sun-disk" aria-hidden="true"></div>

                        <!-- Developer Terminal & System Architecture Window -->
                        <div class="hero-dev-window">
                            <div class="dev-window-header">
                                <div class="window-controls">
                                    <span class="dot-ctrl red"></span>
                                    <span class="dot-ctrl yellow"></span>
                                    <span class="dot-ctrl green"></span>
                                </div>
                                <span class="window-tab-title">devs / team.build()</span>
                            </div>

                            <div class="dev-window-code">
                                <p class="code-row"><span class="c-comment">// DEVS: Web &amp; Mobile Development Team</span></p>
                                <p class="code-row"><span class="c-keyword">const</span> <span class="c-obj">devs</span> = {</p>
                                <p class="code-row c-indent"><span class="c-prop">team</span>: [<span class="c-str">'Full-Stack'</span>, <span class="c-str">'Mobile'</span>, <span class="c-str">'Frontend'</span>],</p>
                                <p class="code-row c-indent"><span class="c-prop">stack</span>: [<span class="c-str">'PHP'</span>, <span class="c-str">'MySQL'</span>, <span class="c-str">'React'</span>, <span class="c-str">'Android'</span>],</p>
                                <p class="code-row c-indent"><span class="c-prop">build</span>: <span class="c-str">'Websites, Apps &amp; Custom Systems'</span>,</p>
                                <p class="code-row c-indent"><span class="c-prop">deploy</span>: <span class="c-bool">true</span></p>
                                <p class="code-row">};</p>
                                <p class="code-row"><span class="c-keyword">await</span> devs.<span class="c-fn">shipSolutions</span>(clientNeeds);</p>
                            </div>

                            <!-- Team System Capability Badges -->
                            <div class="dev-window-tags">
                                <span class="dev-tag">Web Apps</span>
                                <span class="dev-tag">Mobile Systems</span>
                                <span class="dev-tag">Custom Databases</span>
                            </div>
                        </div>

                        <!-- Static Team Stamp Badge (typographic, no ambient spin) -->
                        <div class="stamp-badge-wrap" aria-label="DEVS Team. Web and Mobile Development. Custom Systems.">
                            <svg class="stamp-svg" viewBox="0 0 200 200" width="140" height="140">
                                <path id="badgeCircle" d="M 100, 100 m -72, 0 a 72,72 0 1,1 144,0 a 72,72 0 1,1 -144,0" fill="none" />
                                <text class="stamp-text">
                                    <textPath href="#badgeCircle" startOffset="0%">
                                        &bull; DEVS TEAM &bull; WEB &amp; MOBILE DEVELOPMENT &bull; SYSTEMS
                                    </textPath>
                                </text>
                            </svg>
                            <div class="stamp-inner-dot">
                                <span class="stamp-star">&lt;/&gt;</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>        <!-- ==================== MISSION & VISION ==================== -->
        <section class="editorial-section mv-section band" aria-labelledby="mv-heading">
            <div class="container">
                <!-- Asymmetric two-column: big headline left / sculpted manifestos right -->
                <div class="mv-grid">
                    <!-- Headline -->
                    <div class="mv-col-headline" data-reveal>
                        <h2 id="mv-heading" class="editorial-headline mv-headline">
                            <span class="headline-dark">MISSION</span> <span class="headline-accent text-terracotta">&amp; VISION</span>
                        </h2>
                    </div>

                    <!-- Mission & Vision — minimal two-column -->
                    <div class="mv-col-cards">
                        <!-- Mission -->
                        <article class="mv-bezel-card mv-bezel-card--mission" data-reveal>
                            <div class="mv-bezel-shell">
                                <div class="mv-bezel-inner">
                                    <h3 class="mv-card-title">MISSION</h3>
                                    <p class="mv-card-thesis">We build practical digital systems that help businesses simplify their operations, reduce manual work, and manage their everyday processes more effectively.</p>
                                </div>
                            </div>
                        </article>

                        <!-- Vision -->
                        <article class="mv-bezel-card mv-bezel-card--vision" data-reveal>
                            <div class="mv-bezel-shell">
                                <div class="mv-bezel-inner">
                                    <h3 class="mv-card-title">VISION</h3>
                                    <p class="mv-card-thesis">We aim to become a trusted technology partner for businesses and organizations looking to improve the way they work through digital solutions.</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

                <!-- Studio Commitments Strip (Impeccable Architectural Rhythm) -->
                <div class="mv-commitments-bar" data-reveal>
                    <div class="mv-commitment-item">
                        <span class="commitment-index">01</span>
                        <div class="commitment-body">
                            <h4 class="commitment-title">Pragmatic Tech Stack</h4>
                            <p class="commitment-text">We select technologies based on stability, ease of maintenance, and speed, never fleeting trends.</p>
                        </div>
                    </div>
                    <div class="mv-commitment-item">
                        <span class="commitment-index">02</span>
                        <div class="commitment-body">
                            <h4 class="commitment-title">Direct Engineer Contact</h4>
                            <p class="commitment-text">You collaborate directly with the engineers shipping your features. Zero account-manager telephone games.</p>
                        </div>
                    </div>
                    <div class="mv-commitment-item">
                        <span class="commitment-index">03</span>
                        <div class="commitment-body">
                            <h4 class="commitment-title">Complete Code Ownership</h4>
                            <p class="commitment-text">You own 100% of your source code, schemas, and configurations. No vendor lock-in or licensing surprises.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== CLIENT PROBLEMS WE SOLVE ==================== -->
        <section class="editorial-section cp-section" aria-labelledby="cp-heading">
            <div class="container">
                <div class="editorial-section-header" data-reveal>
                    <div class="header-left">
                        <div class="cp-section-kicker">
                            <span>OPERATIONAL FRICTIONS RESOLVED</span>
                        </div>
                        <h2 id="cp-heading" class="editorial-headline cp-headline">
                            <span class="headline-dark">PROBLEMS</span>
                            <span class="headline-accent text-terracotta">WE SOLVE</span>
                        </h2>
                    </div>
                    <div class="header-right">
                        <p class="section-description section-description--right">
                            We build software that turns messy manual processes into clean, organized digital workflows.
                        </p>
                    </div>
                </div>

                <!-- Interactive Category Filter Bar -->
                <div class="cp-filter-wrap" data-reveal>
                    <div class="cp-filter-bar" role="tablist" aria-label="Problem categories">
                        <button type="button" class="cp-filter-btn is-active" data-filter="all" role="tab" aria-selected="true">
                            <span>ALL CHALLENGES</span>
                        </button>
                        <button type="button" class="cp-filter-btn" data-filter="ops" role="tab" aria-selected="false">
                            <span>OPERATIONS &amp; WORKFLOW</span>
                        </button>
                        <button type="button" class="cp-filter-btn" data-filter="platforms" role="tab" aria-selected="false">
                            <span>PLATFORMS &amp; MOBILE</span>
                        </button>
                        <button type="button" class="cp-filter-btn" data-filter="data" role="tab" aria-selected="false">
                            <span>DATA &amp; SYSTEMS</span>
                        </button>
                    </div>
                </div>

                <!-- Asymmetrical Interlocking Bento Grid -->
                <div class="cp-bento-grid">
                    <!-- Problem 1: Hero Anchor (Spans 2 cols on Desktop) -->
                    <article class="cp-bento-card cp-bento-card--hero" data-category="ops" data-reveal data-spotlight>
                        <div class="cp-card-shell">
                            <div class="cp-card-inner">
                                <div class="cp-card-top">
                                    <div class="cp-identity">
                                        <span class="cp-code-tag">OPS // BOTTLENECK 01</span>
                                        <span class="cp-num text-terracotta">01</span>
                                    </div>
                                    <div class="cp-icon-wrap" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                    </div>
                                </div>

                                <h3 class="cp-problem-title">Manual Business Processes</h3>
                                
                                <div class="cp-tension-grid">
                                    <div class="cp-tension cp-tension--friction">
                                        <span class="tension-badge">THE PROBLEM</span>
                                        <p class="tension-desc">Repetitive paperwork, spreadsheets, and manual tasks slow your team down and make everyday operations harder to manage.</p>
                                    </div>
                                    <div class="cp-tension cp-tension--resolution">
                                        <span class="tension-badge">WHAT WE DO</span>
                                        <p class="tension-desc">We replace repetitive paperwork, spreadsheets, and manual tasks with organized digital workflows.</p>
                                    </div>
                                </div>

                                <!-- Interactive Pipeline Preview Widget -->
                                <div class="cp-pipeline-widget" aria-hidden="true">
                                    <div class="pipe-step pipe-step--raw">
                                        <span class="pipe-code">INPUT</span>
                                        <span class="pipe-label">Scattered Spreadsheets</span>
                                    </div>
                                    <div class="pipe-connector">
                                        <span class="pipe-line"></span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                    </div>
                                    <div class="pipe-step pipe-step--core">
                                        <span class="pipe-code">ENGINE</span>
                                        <span class="pipe-label">Automated System Logic</span>
                                    </div>
                                    <div class="pipe-connector">
                                        <span class="pipe-line"></span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                    </div>
                                    <div class="pipe-step pipe-step--out">
                                        <span class="pipe-code">OUTCOME</span>
                                        <span class="pipe-label">Instant Operational Clarity</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </article>

                    <!-- Problem 2: Mobile Presence -->
                    <article class="cp-bento-card" data-category="platforms" data-reveal data-spotlight>
                        <div class="cp-card-shell">
                            <div class="cp-card-inner">
                                <div class="cp-card-top">
                                    <div class="cp-identity">
                                        <span class="cp-code-tag">MOBILITY // 02</span>
                                        <span class="cp-num text-terracotta">02</span>
                                    </div>
                                    <div class="cp-icon-wrap" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                                    </div>
                                </div>

                                <h3 class="cp-problem-title">Limited Mobile Access</h3>

                                <div class="cp-tension cp-tension--friction">
                                    <span class="tension-badge">THE PROBLEM</span>
                                    <p class="tension-desc">Users and staff can't access important services or tools from their phones, slowing down work that happens outside the office.</p>
                                </div>
                                <div class="cp-tension cp-tension--resolution">
                                    <span class="tension-badge">WHAT WE DO</span>
                                    <p class="tension-desc">We create responsive and mobile solutions that let users access important services wherever they are.</p>
                                </div>


                            </div>
                        </div>
                    </article>

                    <!-- Problem 3: Outdated Website -->
                    <article class="cp-bento-card" data-category="platforms" data-reveal data-spotlight>
                        <div class="cp-card-shell">
                            <div class="cp-card-inner">
                                <div class="cp-card-top">
                                    <div class="cp-identity">
                                        <span class="cp-code-tag">FRONTEND // 03</span>
                                        <span class="cp-num text-terracotta">03</span>
                                    </div>
                                    <div class="cp-icon-wrap" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                    </div>
                                </div>

                                <h3 class="cp-problem-title">Inefficient Tracking</h3>

                                <div class="cp-tension cp-tension--friction">
                                    <span class="tension-badge">THE PROBLEM</span>
                                    <p class="tension-desc">Important data is tracked manually through logs, spreadsheets, or paper records, making it hard to monitor and report accurately.</p>
                                </div>
                                <div class="cp-tension cp-tension--resolution">
                                    <span class="tension-badge">WHAT WE DO</span>
                                    <p class="tension-desc">We turn manual tracking into structured records, dashboards, and reports that are easier to monitor.</p>
                                </div>


                            </div>
                        </div>
                    </article>

                    <!-- Problem 4: Scattered Data -->
                    <article class="cp-bento-card" data-category="data" data-reveal data-spotlight>
                        <div class="cp-card-shell">
                            <div class="cp-card-inner">
                                <div class="cp-card-top">
                                    <div class="cp-identity">
                                        <span class="cp-code-tag">DATABASE // 04</span>
                                        <span class="cp-num text-terracotta">04</span>
                                    </div>
                                    <div class="cp-icon-wrap" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                                    </div>
                                </div>

                                <h3 class="cp-problem-title">Disorganized Information</h3>

                                <div class="cp-tension cp-tension--friction">
                                    <span class="tension-badge">THE PROBLEM</span>
                                    <p class="tension-desc">Records and information are scattered across folders, inboxes, and different tools, making them difficult to find and use when needed.</p>
                                </div>
                                <div class="cp-tension cp-tension--resolution">
                                    <span class="tension-badge">WHAT WE DO</span>
                                    <p class="tension-desc">We centralize scattered records and information into one system that is easier to access and manage.</p>
                                </div>


                            </div>
                        </div>
                    </article>

                    <!-- Problem 5: Siloed Systems -->
                    <article class="cp-bento-card" data-category="data" data-reveal data-spotlight>
                        <div class="cp-card-shell">
                            <div class="cp-card-inner">
                                <div class="cp-card-top">
                                    <div class="cp-identity">
                                        <span class="cp-code-tag">SYSTEMS // 05</span>
                                        <span class="cp-num text-terracotta">05</span>
                                    </div>
                                    <div class="cp-icon-wrap" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                                    </div>
                                </div>

                                <h3 class="cp-problem-title">Lack of Custom Software</h3>

                                <div class="cp-tension cp-tension--friction">
                                    <span class="tension-badge">THE PROBLEM</span>
                                    <p class="tension-desc">Generic tools don't fit how your business actually works, forcing your team to adjust their process around software instead of the other way around.</p>
                                </div>
                                <div class="cp-tension cp-tension--resolution">
                                    <span class="tension-badge">WHAT WE DO</span>
                                    <p class="tension-desc">We build systems around the specific processes and requirements of each business.</p>
                                </div>


                            </div>
                        </div>
                    </article>

                    <!-- Problem 6: Strategic Anchor (Spans 3 cols on Desktop) -->
                    <article class="cp-bento-card cp-bento-card--anchor" data-category="ops" data-reveal data-spotlight>
                        <div class="cp-card-shell">
                            <div class="cp-card-inner">
                                <div class="cp-card-top">
                                    <div class="cp-identity">
                                        <span class="cp-code-tag">CREW // STRATEGY 06</span>
                                        <span class="cp-num text-terracotta">06</span>
                                    </div>
                                    <div class="cp-icon-wrap" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    </div>
                                </div>

                                <h3 class="cp-problem-title">Ideas Without a Working System</h3>
                                
                                <div class="cp-tension-grid">
                                    <div class="cp-tension cp-tension--friction">
                                        <span class="tension-badge">THE PROBLEM</span>
                                        <p class="tension-desc">You have a clear idea for a product or system but no technical team to bring it to life. The concept stays on paper while the opportunity moves on.</p>
                                    </div>
                                    <div class="cp-tension cp-tension--resolution">
                                        <span class="tension-badge">WHAT WE DO</span>
                                        <p class="tension-desc">We transform business ideas into functional digital products that people can actually use.</p>
                                    </div>
                                </div>

                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- ==================== WHAT WE BUILD (SELECTED PROJECTS) ==================== -->
        <section class="editorial-section" id="selected-projects" aria-labelledby="projects-heading">
            <div class="editorial-section-header" data-reveal>
                <div class="header-left">
                    <h2 id="projects-heading" class="editorial-headline">
                        <span class="headline-dark">WHAT WE</span>
                        <span class="headline-accent text-terracotta">BUILD</span>
                    </h2>
                </div>
                <div class="header-center">
                    <p class="section-description">
                        A curated selection of custom websites, applications, and information systems built by our team.
                    </p>
                </div>
                <div class="header-right">
                    <a href="<?php echo BASE_URL; ?>/projects" class="editorial-arrow-link">
                        <span>EXPLORE OUR WORK</span>
                        <svg class="arrow-svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
            </div>

            <div class="projects-editorial-grid">
                <?php if (empty($editorialProjects)): ?>
                <p class="section-description">Projects coming soon. <a href="<?php echo BASE_URL; ?>/contact">Start one with us.</a></p>
                <?php else: ?>
                <?php foreach ($editorialProjects as $p): ?>
                <article class="editorial-project-card" data-reveal>
                    <a href="<?php echo BASE_URL; ?>/projects/<?php echo e($p['slug']); ?>" class="card-media-link" aria-label="<?php echo e($p['title']); ?> - <?php echo e($p['category']); ?>">
                        <div class="media-container">
                            <?php if (!empty($p['image'])): ?>
                            <img src="<?php echo BASE_URL . e($p['image']); ?>" alt="<?php echo e($p['title']); ?>" loading="lazy" class="project-img" width="600" height="600">
                            <?php else: ?>
                            <div class="image-placeholder" aria-hidden="true">DEVS</div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <div class="card-editorial-meta">
                        <span class="meta-number text-terracotta"><?php echo e($p['num']); ?></span>
                        <div class="meta-text">
                            <h3 class="meta-title">
                                <a href="<?php echo BASE_URL; ?>/projects/<?php echo e($p['slug']); ?>"><?php echo e($p['title']); ?></a>
                            </h3>
                            <p class="meta-category"><?php echo e($p['category']); ?></p>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- ==================== OUR EXPERTISE ==================== -->
        <section class="editorial-section editorial-skills-section" aria-labelledby="skills-heading">
            <div class="skills-editorial-grid">
                <!-- Column 1: Progress Bars for Team Capabilities -->
                <div class="skills-col skills-col-bars" data-reveal>
                    <h2 id="skills-heading" class="editorial-headline mb-header">
                        <span class="headline-dark">OUR</span>
                        <span class="headline-accent text-terracotta">EXPERTISE</span>
                    </h2>

                    <div class="skill-capability-list">
                        <div class="skill-capability-item">
                            <span class="capability-index text-terracotta">01</span>
                            <div class="capability-body">
                                <span class="meter-label">WEB APPLICATION DEVELOPMENT</span>
                                <p class="capability-note">Custom sites and web apps built on PHP, MySQL, and modern JavaScript.</p>
                            </div>
                        </div>

                        <div class="skill-capability-item">
                            <span class="capability-index text-terracotta">02</span>
                            <div class="capability-body">
                                <span class="meter-label">MOBILE APPLICATION DEVELOPMENT</span>
                                <p class="capability-note">Native Android builds and mobile-first interfaces for existing systems.</p>
                            </div>
                        </div>

                        <div class="skill-capability-item">
                            <span class="capability-index text-terracotta">03</span>
                            <div class="capability-body">
                                <span class="meter-label">CUSTOM INFORMATION SYSTEMS</span>
                                <p class="capability-note">Role-based portals, dashboards, and record management for real workflows.</p>
                            </div>
                        </div>

                        <div class="skill-capability-item">
                            <span class="capability-index text-terracotta">04</span>
                            <div class="capability-body">
                                <span class="meter-label">DATABASE ARCHITECTURE &amp; SQL</span>
                                <p class="capability-note">Normalized schemas, migrations, and queries that stay fast as data grows.</p>
                            </div>
                        </div>

                        <div class="skill-capability-item">
                            <span class="capability-index text-terracotta">05</span>
                            <div class="capability-body">
                                <span class="meter-label">API &amp; BACKEND SERVICES</span>
                                <p class="capability-note">REST endpoints that connect mobile apps, websites, and third-party tools.</p>
                            </div>
                        </div>

                        <div class="skill-capability-item">
                            <span class="capability-index text-terracotta">06</span>
                            <div class="capability-body">
                                <span class="meter-label">UI / UX &amp; SYSTEM DESIGN</span>
                                <p class="capability-note">Wireframes and interface design shaped around the people who use the system.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Team Manifesto Quote -->
                <div class="skills-col skills-col-quote" data-reveal>
                    <div class="quote-sign text-terracotta" aria-hidden="true">&ldquo;</div>
                    <blockquote class="editorial-manifesto-quote">
                        We build systems that fit how your organization actually operates, not the other way around.
                    </blockquote>
                </div>

                <!-- Column 3: 4 Core Value Pillars -->
                <div class="skills-col skills-col-pillars" data-reveal>
                    <div class="pillar-row">
                        <div class="pillar-badge" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        </div>
                        <div class="pillar-body">
                            <h3 class="pillar-title">USER-CENTERED DESIGN</h3>
                            <p class="pillar-desc">Focus on creating seamless and meaningful user experiences.</p>
                        </div>
                    </div>

                    <div class="pillar-row">
                        <div class="pillar-badge" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                        </div>
                        <div class="pillar-body">
                            <h3 class="pillar-title">CLEAN &amp; MODERN CODE</h3>
                            <p class="pillar-desc">High-quality, scalable, and performant development.</p>
                        </div>
                    </div>

                    <div class="pillar-row">
                        <div class="pillar-badge" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                        </div>
                        <div class="pillar-body">
                            <h3 class="pillar-title">FULLY RESPONSIVE</h3>
                            <p class="pillar-desc">Websites and applications that work perfectly on any device.</p>
                        </div>
                    </div>

                    <div class="pillar-row">
                        <div class="pillar-badge" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        </div>
                        <div class="pillar-body">
                            <h3 class="pillar-title">PERFORMANCE DRIVEN</h3>
                            <p class="pillar-desc">Speed, SEO, and database integrity built into every release.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== HOW WE OPERATE (WORK WITH DEVS) ==================== -->
        <section class="editorial-section" aria-labelledby="operate-heading">
            <div class="editorial-section-header" data-reveal>
                <div class="header-left">
                    <h2 id="operate-heading" class="editorial-headline">
                        <span class="headline-dark">HOW WE</span>
                        <span class="headline-accent text-terracotta">OPERATE</span>
                    </h2>
                </div>
                <div class="header-right">
                    <p class="section-description section-description--right">
                        Our principles for delivering reliable, maintainable software and systems on schedule.
                    </p>
                </div>
            </div>

            <div class="operate-editorial-grid">
                <article class="editorial-operate-card" data-reveal>
                    <span class="operate-index text-terracotta">01</span>
                    <h3 class="operate-title">Clear Communication</h3>
                    <p class="operate-desc">
                        We explain technology in terms you understand, and we flag risks early instead of waiting for launch day.
                    </p>
                </article>

                <article class="editorial-operate-card" data-reveal>
                    <span class="operate-index text-terracotta">02</span>
                    <h3 class="operate-title">Practical Delivery</h3>
                    <p class="operate-desc">
                        We scope in working increments, so you see and test usable software while the project is actively moving.
                    </p>
                </article>

                <article class="editorial-operate-card" data-reveal>
                    <span class="operate-index text-terracotta">03</span>
                    <h3 class="operate-title">Built to Last</h3>
                    <p class="operate-desc">
                        Clean databases, maintainable codebases, and interfaces your organization can actually run day to day.
                    </p>
                </article>
            </div>
        </section>

        <!-- ==================== PROCESS STAGES ==================== -->
        <section class="editorial-section ps-section band" aria-labelledby="ps-heading">
            <div class="container">
                <div class="ps-header" data-reveal>
                    <h2 id="ps-heading" class="editorial-headline ps-headline">
                        <span class="headline-dark">HOW WE</span>
                        <span class="headline-accent text-terracotta">WORK</span>
                    </h2>
                    <p class="ps-header-sub">
                        A clear, repeatable process so you always know where your project stands.
                    </p>
                </div>

                <!-- Horizontal stage track -->
                <div class="ps-track" role="list">
                    <div class="ps-stage" role="listitem" data-reveal>
                        <div class="ps-stage-num" aria-hidden="true">01</div>
                        <div class="ps-stage-connector" aria-hidden="true"></div>
                        <div class="ps-stage-body">
                            <div class="ps-stage-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </div>
                            <h3 class="ps-stage-title">Discovery &amp; Brief</h3>
                            <p class="ps-stage-desc">We listen to your goals, pain points, and constraints. Then we ask the hard questions your previous vendor skipped.</p>
                            <ul class="ps-stage-list">
                                <li>Goals &amp; audience</li>
                                <li>Scope &amp; budget</li>
                                <li>Technical audit</li>
                            </ul>
                        </div>
                    </div>

                    <div class="ps-stage" role="listitem" data-reveal>
                        <div class="ps-stage-num" aria-hidden="true">02</div>
                        <div class="ps-stage-connector" aria-hidden="true"></div>
                        <div class="ps-stage-body">
                            <div class="ps-stage-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                            </div>
                            <h3 class="ps-stage-title">Plan &amp; Design</h3>
                            <p class="ps-stage-desc">Wireframes, database schemas, and system architecture, agreed before a single line of code is written.</p>
                            <ul class="ps-stage-list">
                                <li>UI wireframes</li>
                                <li>DB schema</li>
                                <li>Tech stack decision</li>
                            </ul>
                        </div>
                    </div>

                    <div class="ps-stage" role="listitem" data-reveal>
                        <div class="ps-stage-num" aria-hidden="true">03</div>
                        <div class="ps-stage-connector" aria-hidden="true"></div>
                        <div class="ps-stage-body">
                            <div class="ps-stage-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                            </div>
                            <h3 class="ps-stage-title">Build &amp; Iterate</h3>
                            <p class="ps-stage-desc">We ship working increments. You see real progress every sprint, not a reveal at the end of three months.</p>
                            <ul class="ps-stage-list">
                                <li>Sprint cycles</li>
                                <li>Live previews</li>
                                <li>Feedback loops</li>
                            </ul>
                        </div>
                    </div>

                    <div class="ps-stage" role="listitem" data-reveal>
                        <div class="ps-stage-num" aria-hidden="true">04</div>
                        <div class="ps-stage-connector" aria-hidden="true"></div>
                        <div class="ps-stage-body">
                            <div class="ps-stage-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            </div>
                            <h3 class="ps-stage-title">Test &amp; Review</h3>
                            <p class="ps-stage-desc">QA across devices and browsers. UAT with your team. We do not call it done until it actually works under your real conditions.</p>
                            <ul class="ps-stage-list">
                                <li>Cross-device QA</li>
                                <li>UAT session</li>
                                <li>Performance check</li>
                            </ul>
                        </div>
                    </div>

                    <div class="ps-stage" role="listitem" data-reveal>
                        <div class="ps-stage-num" aria-hidden="true">05</div>
                        <div class="ps-stage-connector ps-stage-connector--last" aria-hidden="true"></div>
                        <div class="ps-stage-body">
                            <div class="ps-stage-icon ps-stage-icon--accent" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            </div>
                            <h3 class="ps-stage-title">Launch &amp; Support</h3>
                            <p class="ps-stage-desc">Deployment, domain setup, staff training, and post-launch support. You own the project, and we make sure you can run it.</p>
                            <ul class="ps-stage-list">
                                <li>Deployment</li>
                                <li>Staff handover</li>
                                <li>Ongoing support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
</div>

<?php include __DIR__ . "/partials/footer.php"; ?>
    <script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
