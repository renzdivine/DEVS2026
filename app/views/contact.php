<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$pageTitle = $pageTitle ?? 'Contact - DEVS';
$pageDescription = $pageDescription ?? 'Have a project idea or system you need built? Tell DEVS what you are looking for.';
$pagePath = $pagePath ?? '/contact';
$pageCss = 'contact.css';
$success = $success ?? '';
$error = $error ?? '';
$availLabel = availability_label($avail['availability_status'] ?? 'Available');
$siteEmail = setting('site_email');
$sitePhone = setting('site_phone');
$siteAddress = setting('site_address');
?>
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css<?php echo asset_v('/css/style.css'); ?>">
    <?php if (!empty($pageCss)): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/<?php echo e($pageCss); ?><?php echo asset_v('/css/' . $pageCss); ?>">
    <?php endif; ?>
<?php include __DIR__ . "/partials/head.php"; ?>
<?php include __DIR__ . "/partials/nav.php"; ?>
<main id="main" class="main-content contact-page">

    <!-- Top Hero Section -->
    <section class="contact-hero-banner" data-reveal>
        <div class="container">
            <h1 class="contact-hero-title">LET'S TALK ABOUT<br>YOUR PROJECT</h1>
        </div>
    </section>

    <hr class="contact-section-divider">

    <!-- Middle Contact & Message Form Section -->
    <section class="contact-main-section" data-reveal>
        <div class="container">
            <div class="contact-grid">
                <!-- Left Column: Contact Channels -->
                <div class="contact-left-col">
                    <div class="contact-badge">
                        <span class="badge-square">▪</span> CONTACT
                    </div>
                    <h2 class="contact-col-heading">GET IN<br>TOUCH</h2>

                    <div class="contact-channels">
                        <?php if ($siteEmail): ?>
                        <div class="channel-row">
                            <span class="channel-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </span>
                            <a href="mailto:<?php echo e($siteEmail); ?>" class="channel-link">
                                <?php echo e($siteEmail); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if ($sitePhone): ?>
                        <div class="channel-row">
                            <span class="channel-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </span>
                            <a href="tel:<?php echo preg_replace('/[^\d+]/', '', $sitePhone); ?>" class="channel-link">
                                <?php echo e($sitePhone); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if ($siteAddress): ?>
                        <div class="channel-row">
                            <span class="channel-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </span>
                            <span class="channel-text">
                                <?php echo e($siteAddress); ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($availLabel)): ?>
                    <div class="contact-availability tone-<?php echo e($availLabel['tone']); ?>">
                        <span><?php echo e($availLabel['text']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column: Form Card -->
                <div class="contact-right-col">
                    <div class="contact-card">
                        <h3 class="card-title">Send Message</h3>

                        <?php if ($success !== ''): ?>
                            <div class="success-message" role="status" id="successMsg"><?php echo e($success); ?></div>
                            <script>
                                setTimeout(function () {
                                    var el = document.getElementById('successMsg');
                                    if (el) {
                                        el.style.transition = 'opacity .6s ease';
                                        el.style.opacity = '0';
                                        setTimeout(function () { el.style.display = 'none'; }, 600);
                                    }
                                }, 5000);
                            </script>
                        <?php endif; ?>
                        <?php if ($error !== ''): ?>
                            <div class="error-message" role="alert"><?php echo e($error); ?></div>
                        <?php endif; ?>

                        <form action="<?php echo BASE_URL; ?>/contact" method="POST" class="contact-form" id="projectForm" novalidate>
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <label for="inquiry_name">Name</label>
                                <input type="text" id="inquiry_name" name="inquiry_name" required autocomplete="name" placeholder="Your Name">
                            </div>

                            <div class="form-group">
                                <label for="inquiry_email">Email</label>
                                <input type="email" id="inquiry_email" name="inquiry_email" required autocomplete="email" placeholder="you@example.com">
                            </div>

                            <div class="form-group">
                                <label for="inquiry_description">Message</label>
                                <textarea id="inquiry_description" name="inquiry_description" rows="5" required placeholder="Type Your Message"></textarea>
                            </div>

                            <!-- Optional Expandable Details Drawer -->
                            <div class="optional-details-wrap">
                                <button type="button" class="optional-toggle-btn" id="toggleExtraDetails" aria-expanded="false" aria-controls="extraDetailsDrawer">
                                    <span class="toggle-icon">+</span>
                                    <span>Additional project details (optional)</span>
                                </button>
                                <div class="optional-drawer" id="extraDetailsDrawer" hidden>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="inquiry_project_type">Project Type</label>
                                            <select id="inquiry_project_type" name="inquiry_project_type">
                                                <option value="">Select project type</option>
                                                <option value="Website">Website</option>
                                                <option value="Web Application">Web Application</option>
                                                <option value="Mobile Application">Mobile Application</option>
                                                <option value="Custom System">Custom System</option>
                                                <option value="Database">Database</option>
                                                <option value="API">API</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inquiry_budget">Budget Range</label>
                                            <select id="inquiry_budget" name="inquiry_budget" onchange="handleBudgetChange(this)">
                                                <option value="">Select budget range</option>
                                                <option value="Under ₱10,000">Under ₱10,000</option>
                                                <option value="₱10,000 - ₱50,000">₱10,000 - ₱50,000</option>
                                                <option value="₱50,000 - ₱150,000">₱50,000 - ₱150,000</option>
                                                <option value="₱150,000+">₱150,000+</option>
                                                <option value="Not sure">Not sure yet</option>
                                                <option value="custom">Type my own budget…</option>
                                            </select>
                                            <input type="text" id="inquiry_budget_custom" name="inquiry_budget_custom"
                                                   placeholder="e.g. ₱25,000"
                                                   style="display:none;margin-top:8px;">
                                            <script>
                                            function handleBudgetChange(sel) {
                                                var custom = document.getElementById('inquiry_budget_custom');
                                                if (sel.value === 'custom') {
                                                    custom.style.display = 'block';
                                                    custom.required = true;
                                                } else {
                                                    custom.style.display = 'none';
                                                    custom.required = false;
                                                    custom.value = '';
                                                }
                                            }
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="inquiry_phone">Phone</label>
                                            <input type="text" id="inquiry_phone" name="inquiry_phone" autocomplete="tel" placeholder="Optional phone">
                                        </div>
                                        <div class="form-group">
                                            <label for="inquiry_company">Company / Organization</label>
                                            <input type="text" id="inquiry_company" name="inquiry_company" autocomplete="organization" placeholder="Optional company">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary submit-card-btn">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="contact-section-divider">

    <!-- Bottom FAQ Section: Quick Answers -->
    <section class="contact-faq-section" data-reveal>
        <div class="container">
            <div class="contact-grid">
                <!-- Left Column: FAQ Heading -->
                <div class="contact-left-col">
                    <div class="contact-badge">
                        <span class="badge-square">▪</span> FAQ
                    </div>
                    <h2 class="contact-col-heading">QUICK<br>ANSWERS</h2>
                </div>

                <!-- Right Column: Accordion -->
                <div class="contact-right-col">
                    <div class="faq-accordion" id="faqAccordion">
                        <!-- Item 1 (Open by default, matching image) -->
                        <div class="faq-item is-open">
                            <button type="button" class="faq-trigger" aria-expanded="true" aria-controls="faq-answer-1">
                                <span class="faq-question">How do I start a project with you ?</span>
                                <span class="faq-indicator" aria-hidden="true">&minus;</span>
                            </button>
                            <div class="faq-panel" id="faq-answer-1">
                                <p class="faq-answer">
                                    First, you can reach out to me through the contact form or email. We'll schedule an initial meeting to discuss your needs and plan the project together.
                                </p>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="faq-item">
                            <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-answer-2">
                                <span class="faq-question">What is the cost of your services ?</span>
                                <span class="faq-indicator" aria-hidden="true">+</span>
                            </button>
                            <div class="faq-panel" id="faq-answer-2" hidden>
                                <p class="faq-answer">
                                    Every project is unique and depends on the scope, feature set, timeline, and architectural complexity. We provide upfront, transparent project estimates and flexible milestone-based plans so there are never unexpected costs.
                                </p>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="faq-item">
                            <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-answer-3">
                                <span class="faq-question">How much time is typically needed to finish a project ?</span>
                                <span class="faq-indicator" aria-hidden="true">+</span>
                            </button>
                            <div class="faq-panel" id="faq-answer-3" hidden>
                                <p class="faq-answer">
                                    Timelines depend on complexity. A modern marketing website usually takes 2 to 4 weeks, while custom full-stack web platforms or mobile apps typically require 6 to 12 weeks. We agree on explicit milestones at project kickoff.
                                </p>
                            </div>
                        </div>

                        <!-- Item 4 -->
                        <div class="faq-item">
                            <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-answer-4">
                                <span class="faq-question">What sets you apart from your competitors?</span>
                                <span class="faq-indicator" aria-hidden="true">+</span>
                            </button>
                            <div class="faq-panel" id="faq-answer-4" hidden>
                                <p class="faq-answer">
                                    You work directly with the developers and designers creating your product, not non-technical project managers. We craft bespoke, lightweight, high-performance code with meticulous visual polish and long-term durability.
                                </p>
                            </div>
                        </div>

                        <!-- Item 5 -->
                        <div class="faq-item">
                            <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-answer-5">
                                <span class="faq-question">How can I contact you to initiate a project ?</span>
                                <span class="faq-indicator" aria-hidden="true">+</span>
                            </button>
                            <div class="faq-panel" id="faq-answer-5" hidden>
                                <p class="faq-answer">
                                    You can submit a message using the form above, send an email directly to our inbox, or give us a phone call. We promptly review all inquiries and respond within 24 hours with sensible next steps.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<?php include __DIR__ . "/partials/footer.php"; ?>
<script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
</body>
</html>
