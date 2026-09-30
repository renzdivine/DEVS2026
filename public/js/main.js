(function () {
    'use strict';

    /* =====================================================
       ENGINE REGISTRATION
       GSAP + ScrollTrigger: scroll choreography only.
       Motion (Framer Motion vanilla): spring micro-interactions only.
       Both are gated behind prefers-reduced-motion.
       ===================================================== */
    var hasGSAP = typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined';
    if (hasGSAP) {
        gsap.registerPlugin(ScrollTrigger);
    }

    var hasMotion = typeof Motion !== 'undefined' && typeof Motion.animate === 'function';

    var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    var MOTION_SPRING = { type: 'spring', stiffness: 380, damping: 28 };

    /* =====================================================
       INIT ON DOM READY
       ===================================================== */
    document.addEventListener('DOMContentLoaded', function () {
        initTheme();
        initMobileMenu();
        initProjectFilters();
        initContactForm();
        initContactFaq();
        initOptionalDetailsToggle();
        initAdminSearch();
        initChatbot();

        if (!reduced && hasGSAP) {
            initPageEnter();
            initNavAnimation();
            initHeroAnimation();
            initScrollReveals();
            initMissionVision();
            initClientProblems();
            initProcessStages();
        } else {
            // Fallback: make everything visible immediately
            document.querySelectorAll('[data-reveal]').forEach(function (el) {
                el.classList.add('is-visible');
            });
        }

        if (!reduced && hasMotion) {
            initMotionMicroInteractions();
        }
    });

    /* =====================================================
       1. PAGE ENTER — curtain wipe + content fade
       ===================================================== */
    function initPageEnter() {
        // Create overlay curtain
        var curtain = document.createElement('div');
        curtain.id = 'page-curtain';
        curtain.setAttribute('aria-hidden', 'true');
        document.body.appendChild(curtain);

        var tl = gsap.timeline();

        tl.to(curtain, {
            scaleY: 0,
            transformOrigin: 'top center',
            duration: 0.85,
            ease: 'power4.inOut',
            delay: 0.05
        })
        .set(curtain, { display: 'none' });
    }

    /* =====================================================
       2. NAVBAR — slide down + fade on load
       ===================================================== */
    function initNavAnimation() {
        var header = document.querySelector('.site-header, .navbar');
        if (!header) return;

        gsap.from(header, {
            y: -80,
            opacity: 0,
            duration: 0.9,
            ease: 'power3.out',
            delay: 0.6
        });

        // Navbar shrink on scroll
        ScrollTrigger.create({
            start: 'top -60',
            onEnter: function () {
                gsap.to('.navbar, .site-header', {
                    '--nav-shrink': 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
                document.querySelector('.navbar') &&
                    document.querySelector('.navbar').classList.add('is-scrolled');
            },
            onLeaveBack: function () {
                document.querySelector('.navbar') &&
                    document.querySelector('.navbar').classList.remove('is-scrolled');
            }
        });
    }

    /* =====================================================
       3. HERO ANIMATIONS
       ===================================================== */
    function initHeroAnimation() {
        var isHome = document.querySelector('.editorial-hero');
        if (!isHome) return;

        var tl = gsap.timeline({ delay: 0.7 });

        // Giant title — clip reveal from bottom
        var title = document.querySelector('.giant-portfolio-title');
        if (title) {
            gsap.set(title, { yPercent: 110, opacity: 0 });
            tl.to(title, {
                yPercent: 0,
                opacity: 1,
                duration: 1.1,
                ease: 'power4.out'
            }, 0);
        }

        // Hero greeting label
        var greeting = document.querySelector('.hero-greeting');
        if (greeting) {
            gsap.set(greeting, { opacity: 0, y: 20, letterSpacing: '0.3em' });
            tl.to(greeting, {
                opacity: 1,
                y: 0,
                letterSpacing: '0.14em',
                duration: 0.8,
                ease: 'power3.out'
            }, 0.3);
        }

        // Hero headline — word-by-word split
        var headline = document.querySelector('.hero-headline-title');
        if (headline) {
            var words = splitWords(headline);
            gsap.set(words, { yPercent: 120, opacity: 0 });
            tl.to(words, {
                yPercent: 0,
                opacity: 1,
                duration: 0.75,
                ease: 'power3.out',
                stagger: 0.07
            }, 0.45);
        }

        // Hero bio paragraph
        var bio = document.querySelector('.hero-lead-bio');
        if (bio) {
            gsap.set(bio, { opacity: 0, y: 24 });
            tl.to(bio, {
                opacity: 1,
                y: 0,
                duration: 0.7,
                ease: 'power3.out'
            }, 0.75);
        }

        // CTA buttons
        var ctaItems = document.querySelectorAll('.hero-cta-group .btn, .hero-team-status');
        if (ctaItems.length) {
            gsap.set(ctaItems, { opacity: 0, y: 20 });
            tl.to(ctaItems, {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: 'power3.out',
                stagger: 0.1
            }, 0.9);
        }

        // Right column — dev window
        var rightCol = document.querySelector('.hero-right-column');
        if (rightCol) {
            gsap.set(rightCol, { opacity: 0, x: 60 });
            tl.to(rightCol, {
                opacity: 1,
                x: 0,
                duration: 1.0,
                ease: 'power3.out'
            }, 0.5);
        }

        // Parallax on the giant title on scroll (applied to wrapper to prevent resetting entrance animation)
        var titleParallax = document.querySelector('.hero-title-parallax');
        if (titleParallax) {
            gsap.to(titleParallax, {
                yPercent: -18,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.editorial-hero',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 1.2
                }
            });
        }
    }

    /* =====================================================
       4. SCROLL REVEALS — replaces old IntersectionObserver
       ===================================================== */
    function initScrollReveals() {
        // Generic [data-reveal] elements
        var reveals = document.querySelectorAll('[data-reveal]');
        reveals.forEach(function (el) {
            gsap.set(el, { opacity: 0, y: 48 });

            ScrollTrigger.create({
                trigger: el,
                start: 'top 88%',
                once: true,
                onEnter: function () {
                    gsap.to(el, {
                        opacity: 1,
                        y: 0,
                        duration: 0.85,
                        ease: 'power3.out'
                    });
                    el.classList.add('is-visible');
                }
            });
        });

        // Section headings — staggered word reveal
        document.querySelectorAll('.editorial-headline').forEach(function (el) {
            var words = splitWords(el);
            if (!words.length) return;
            gsap.set(words, { opacity: 0, y: 30 });
            ScrollTrigger.create({
                trigger: el,
                start: 'top 85%',
                once: true,
                onEnter: function () {
                    gsap.to(words, {
                        opacity: 1,
                        y: 0,
                        duration: 0.65,
                        ease: 'power3.out',
                        stagger: 0.06
                    });
                }
            });
        });

        // Operate / why cards — cascading stagger
        var operateCards = document.querySelectorAll('.editorial-operate-card');
        if (operateCards.length) {
            gsap.set(operateCards, { opacity: 0, y: 50 });
            ScrollTrigger.create({
                trigger: '.operate-editorial-grid',
                start: 'top 85%',
                once: true,
                onEnter: function () {
                    gsap.to(operateCards, {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        ease: 'power3.out',
                        stagger: 0.12
                    });
                }
            });
        }

        // Pillar rows — stagger from left
        var pillars = document.querySelectorAll('.pillar-row');
        if (pillars.length) {
            gsap.set(pillars, { opacity: 0, x: -30 });
            ScrollTrigger.create({
                trigger: '.skills-col-pillars',
                start: 'top 82%',
                once: true,
                onEnter: function () {
                    gsap.to(pillars, {
                        opacity: 1,
                        x: 0,
                        duration: 0.6,
                        ease: 'power3.out',
                        stagger: 0.1
                    });
                }
            });
        }

        // Editorial project cards — no animation, show immediately
        var projCards = document.querySelectorAll('.editorial-project-card');
        if (projCards.length) {
            gsap.set(projCards, { opacity: 1, scale: 1, y: 0 });
        }

        // Bottom CTA columns
        var ctaCols = document.querySelectorAll('.bottom-cta-col');
        if (ctaCols.length) {
            gsap.set(ctaCols, { opacity: 0, y: 40 });
            ScrollTrigger.create({
                trigger: '.bottom-cta-grid',
                start: 'top 85%',
                once: true,
                onEnter: function () {
                    gsap.to(ctaCols, {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        ease: 'power3.out',
                        stagger: 0.13
                    });
                }
            });
        }

        // Inner-page project cards — no animation, show immediately
        var innerCards = document.querySelectorAll('.project-card');
        if (innerCards.length) {
            gsap.set(innerCards, { opacity: 1, y: 0 });
        }

        // Team cards
        var teamCards = document.querySelectorAll('.team-card');
        if (teamCards.length) {
            gsap.set(teamCards, { opacity: 0, y: 36 });
            ScrollTrigger.batch(teamCards, {
                start: 'top 90%',
                once: true,
                onEnter: function (batch) {
                    gsap.to(batch, {
                        opacity: 1,
                        y: 0,
                        duration: 0.65,
                        ease: 'power3.out',
                        stagger: 0.09
                    });
                }
            });
        }

        // Service cards
        var serviceCards = document.querySelectorAll('.service-card');
        if (serviceCards.length) {
            gsap.set(serviceCards, { opacity: 0, y: 32 });
            ScrollTrigger.batch(serviceCards, {
                start: 'top 90%',
                once: true,
                onEnter: function (batch) {
                    gsap.to(batch, {
                        opacity: 1,
                        y: 0,
                        duration: 0.65,
                        ease: 'power3.out',
                        stagger: 0.1
                    });
                }
            });
        }

        // Quote block — elegant fade + scale
        var quote = document.querySelector('.editorial-manifesto-quote');
        var quoteSign = document.querySelector('.quote-sign');
        if (quote) {
            gsap.set([quoteSign, quote].filter(Boolean), { opacity: 0, y: 24 });
            ScrollTrigger.create({
                trigger: quote,
                start: 'top 85%',
                once: true,
                onEnter: function () {
                    gsap.to([quoteSign, quote].filter(Boolean), {
                        opacity: 1,
                        y: 0,
                        duration: 0.9,
                        ease: 'power3.out',
                        stagger: 0.15
                    });
                }
            });
        }

        // Footer links
        var footerLinks = document.querySelectorAll('.footer-links a, .editorial-subfooter-links a');
        if (footerLinks.length) {
            gsap.set(footerLinks, { opacity: 0, y: 16 });
            ScrollTrigger.create({
                trigger: 'footer',
                start: 'top 95%',
                once: true,
                onEnter: function () {
                    gsap.to(footerLinks, {
                        opacity: 1,
                        y: 0,
                        duration: 0.5,
                        ease: 'power2.out',
                        stagger: 0.05
                    });
                }
            });
        }
    }



    /* =====================================================
       10. MARQUEE SPEED ON SCROLL (side rails)
       ===================================================== */
    function initMarqueeOnScroll() {
        var rails = document.querySelectorAll('.rail-text');
        if (!rails.length) return;

        rails.forEach(function (rail, i) {
            var dir = i % 2 === 0 ? -1 : 1;
            gsap.to(rail, {
                xPercent: dir * 12,
                ease: 'none',
                scrollTrigger: {
                    trigger: 'body',
                    start: 'top top',
                    end: 'bottom bottom',
                    scrub: 2
                }
            });
        });
    }

    /* =====================================================
       UTILITIES
       ===================================================== */

    // Split element text into span words (non-destructive on markup)
    function splitWords(el) {
        // Skip elements with complex child markup to avoid breaking PHP-rendered HTML
        if (el.children.length > 0) {
            return Array.prototype.slice.call(el.children);
        }
        var text = el.textContent.trim();
        var words = text.split(/\s+/);
        el.innerHTML = words.map(function (w) {
            return '<span class="gsap-word" style="display:inline-block;overflow:hidden;padding-bottom:0.05em"><span style="display:inline-block">' + w + '</span></span>';
        }).join(' ');
        return Array.prototype.slice.call(el.querySelectorAll('.gsap-word > span'));
    }

    /* =====================================================
       MOTION MICRO-INTERACTIONS (Framer Motion / Motion vanilla)
       Spring-based responses to user actions. Never ambient,
       never looping. Runs once per interaction.
       ===================================================== */
    function initMotionMicroInteractions() {
        // Buttons and editorial arrow links: spring press feedback
        document.querySelectorAll('.btn, .editorial-arrow-link, .cp-filter-btn, .proj-filter').forEach(function (el) {
            el.addEventListener('pointerdown', function () {
                Motion.animate(el, { scale: 0.96 }, MOTION_SPRING);
            });
            el.addEventListener('pointerup', function () {
                Motion.animate(el, { scale: 1 }, MOTION_SPRING);
            });
            el.addEventListener('pointerleave', function () {
                Motion.animate(el, { scale: 1 }, MOTION_SPRING);
            });
        });

        // Cards: spring lift on hover, settles back on leave
        document.querySelectorAll(
            '.cp-bento-card, .editorial-operate-card, .team-card, .service-card, .proj-card, .mv-bezel-card'
        ).forEach(function (card) {
            card.addEventListener('pointerenter', function () {
                Motion.animate(card, { y: -4 }, MOTION_SPRING);
            });
            card.addEventListener('pointerleave', function () {
                Motion.animate(card, { y: 0 }, MOTION_SPRING);
            });
        });

        // Theme toggle: spring icon swap feedback
        var themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                Motion.animate(
                    themeToggle,
                    { rotate: [0, -180] },
                    { type: 'spring', stiffness: 260, damping: 22 }
                );
            });
        }

        // FAQ accordion: spring height open/close
        var accordion = document.getElementById('faqAccordion');
        if (accordion) {
            accordion.querySelectorAll('.faq-trigger').forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    var item = trigger.closest('.faq-item');
                    var panel = item && item.querySelector('.faq-panel');
                    if (panel && !panel.hidden) {
                        Motion.animate(panel, { opacity: [1, 0] }, { duration: 0.18 });
                    }
                });
            });
        }

        // Contact wizard steps: spring entrance on each step change
        var wizardSteps = document.querySelectorAll('.wizard-step');
        if (wizardSteps.length) {
            var observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (m) {
                    var step = m.target;
                    if (
                        m.attributeName === 'class' &&
                        step.classList.contains('is-active') &&
                        step instanceof HTMLElement
                    ) {
                        Motion.animate(
                            step,
                            { opacity: [0, 1], y: [18, 0] },
                            { type: 'spring', stiffness: 320, damping: 30 }
                        );
                    }
                });
            });
            wizardSteps.forEach(function (step) {
                observer.observe(step, { attributes: true, attributeFilter: ['class'] });
            });
        }

        // Form inputs: soft focus ring expansion
        document.querySelectorAll('.contact-form input, .contact-form select, .contact-form textarea').forEach(function (field) {
            field.addEventListener('focus', function () {
                Motion.animate(field, { scale: 1.008 }, MOTION_SPRING);
            });
            field.addEventListener('blur', function () {
                Motion.animate(field, { scale: 1 }, MOTION_SPRING);
            });
        });
    }

    /* =====================================================
       THEME TOGGLE
       ===================================================== */
    function initTheme() {
        var toggle = document.getElementById('themeToggle');
        if (!toggle) return;
        toggle.addEventListener('click', function () {
            var root = document.documentElement;
            var current = root.getAttribute('data-theme');
            if (!current) {
                current = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
            }
            var next = current === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            try { localStorage.setItem('theme', next); } catch (e) {}
        });
    }

    /* =====================================================
       MOBILE MENU — full-screen panel
       ===================================================== */
    function initMobileMenu() {
        var toggle = document.getElementById('mobileMenuToggle');
        var navLinks = document.getElementById('navLinks');
        if (!toggle || !navLinks) return;

        function setMenu(open) {
            navLinks.classList.toggle('show', open);
            toggle.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
            document.body.classList.toggle('nav-open', open);
        }

        toggle.addEventListener('click', function () {
            var open = !navLinks.classList.contains('show');
            setMenu(open);

            if (hasMotion && open && !reduced) {
                var items = navLinks.querySelectorAll('li');
                Motion.animate(
                    items,
                    { opacity: [0, 1], y: [22, 0] },
                    { type: 'spring', stiffness: 300, damping: 26, delay: Motion.stagger(0.055) }
                );
            }
        });

        navLinks.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () { setMenu(false); });
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setMenu(false);
        });

        // Reset if the viewport crosses back to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth > 920) setMenu(false);
        });
    }

    /* =====================================================
       PROJECT FILTERS
       ===================================================== */
    function initProjectFilters() {
        // support both old (.filter-btn / .project-card) and new (.proj-filter / .proj-card) class names
        var buttons = document.querySelectorAll('.filter-btn, .proj-filter');
        if (!buttons.length) return;

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                buttons.forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');

                var filter = btn.getAttribute('data-filter') || 'all';
                var cards = document.querySelectorAll('.project-card[data-category], .proj-card[data-category]');

                cards.forEach(function (card) {
                    var match = filter === 'all' || card.getAttribute('data-category') === filter;
                    if (match) {
                        card.style.display = '';
                        if (hasGSAP && !reduced) {
                            gsap.from(card, { opacity: 0, y: 20, duration: 0.4, ease: 'power2.out' });
                        }
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    /* =====================================================
       CONTACT WIZARD FORM
       ===================================================== */
    function initContactForm() {
        var form = document.getElementById('projectForm');
        if (!form) return;

        var modeBtns = Array.prototype.slice.call(form.querySelectorAll('.mode-btn'));
        var progress = document.getElementById('wizardProgress');
        var steps = Array.prototype.slice.call(form.querySelectorAll('.wizard-step'));
        var progressSteps = progress ? Array.prototype.slice.call(progress.querySelectorAll('.step')) : [];
        var prevBtn = document.getElementById('wizardPrev');
        var nextBtn = document.getElementById('wizardNext');
        var submitBtn = document.getElementById('wizardSubmit');
        var current = 1;

        if (!steps.length) {
            form.addEventListener('submit', function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    form.reportValidity();
                    return;
                }
                var btn = form.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    btn.textContent = 'Sending...';
                }
            });
            return;
        }

        function mode() { return form.getAttribute('data-mode') || 'wizard'; }

        function fillReview() {
            function val(name) {
                var el = form.querySelector('[name="' + name + '"]');
                return el ? String(el.value || '').trim() : '';
            }
            var typeEl = form.querySelector('input[name="inquiry_project_type"]:checked');
            var company = val('inquiry_company');
            var phone = val('inquiry_phone');
            var contactBits = [];
            if (company) contactBits.push(company);
            if (phone) contactBits.push(phone);
            var values = {
                reviewName: val('inquiry_name') || '—',
                reviewEmail: val('inquiry_email') || '—',
                reviewContact: contactBits.join(' · ') || '—',
                reviewType: typeEl ? typeEl.value : '—',
                reviewBudget: val('inquiry_budget') || 'Not specified',
                reviewPreferred: val('inquiry_preferred_contact') || 'Not specified',
                reviewDescription: val('inquiry_description') || '—'
            };
            Object.keys(values).forEach(function (id) {
                var el = document.getElementById(id);
                if (el) el.textContent = values[id];
            });
        }

        function goTo(n, focusHeading) {
            current = Math.min(Math.max(n, 1), steps.length);
            steps.forEach(function (step) {
                var i = parseInt(step.getAttribute('data-step'), 10);
                var isActive = i === current;
                step.classList.toggle('is-active', isActive);
                if (isActive && hasGSAP && !reduced) {
                    gsap.from(step, { opacity: 0, y: 16, duration: 0.4, ease: 'power2.out' });
                }
            });
            progressSteps.forEach(function (ps, idx) {
                var i = idx + 1;
                ps.classList.toggle('is-active', i === current);
                ps.classList.toggle('is-done', i < current);
            });
            if (prevBtn) prevBtn.hidden = current === 1;
            if (nextBtn) nextBtn.hidden = current === steps.length;
            if (submitBtn) submitBtn.hidden = current !== steps.length;
            if (current === steps.length) fillReview();
            if (focusHeading) {
                var heading = steps[current - 1].querySelector('h2');
                if (heading) {
                    heading.setAttribute('tabindex', '-1');
                    heading.focus({ preventScroll: true });
                }
            }
        }

        function validateStep(n) {
            var step = steps[n - 1];
            if (!step) return true;
            var fields = Array.prototype.slice.call(step.querySelectorAll('input, select, textarea'));
            var radioGroups = {};
            for (var i = 0; i < fields.length; i++) {
                var field = fields[i];
                if (field.type === 'radio') {
                    if (field.required && !radioGroups[field.name]) {
                        radioGroups[field.name] = true;
                        var group = Array.prototype.slice.call(
                            form.querySelectorAll('input[type="radio"][name="' + field.name + '"]')
                        );
                        if (!group.some(function (r) { return r.checked; })) {
                            field.focus(); field.reportValidity(); return false;
                        }
                    }
                    continue;
                }
                if (!field.checkValidity()) {
                    field.focus(); field.reportValidity(); return false;
                }
            }
            return true;
        }

        modeBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var next = btn.getAttribute('data-mode') || 'wizard';
                form.setAttribute('data-mode', next);
                modeBtns.forEach(function (b) {
                    b.classList.toggle('active', b.getAttribute('data-mode') === next);
                });
                if (next === 'wizard') goTo(1, false);
            });
        });

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                if (mode() !== 'wizard') return;
                if (!validateStep(current)) return;
                goTo(current + 1, true);
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () { goTo(current - 1, true); });
        }

        form.addEventListener('submit', function (e) {
            if (mode() === 'wizard') {
                for (var i = 1; i <= current; i++) {
                    if (!validateStep(i)) {
                        e.preventDefault(); goTo(i, true); return;
                    }
                }
            }
            if (!form.checkValidity()) {
                e.preventDefault(); form.reportValidity();
            }
        });

        goTo(1, false);
    }

    /* =====================================================
       CONTACT FAQ ACCORDION
       ===================================================== */
    function initContactFaq() {
        var accordion = document.getElementById('faqAccordion');
        if (!accordion) return;

        var items = Array.prototype.slice.call(accordion.querySelectorAll('.faq-item'));
        items.forEach(function (item) {
            var trigger = item.querySelector('.faq-trigger');
            var panel = item.querySelector('.faq-panel');
            var indicator = item.querySelector('.faq-indicator');
            if (!trigger || !panel) return;

            trigger.addEventListener('click', function () {
                var isOpen = item.classList.contains('is-open');

                items.forEach(function (otherItem) {
                    if (otherItem !== item && otherItem.classList.contains('is-open')) {
                        otherItem.classList.remove('is-open');
                        var otherTrigger = otherItem.querySelector('.faq-trigger');
                        var otherPanel = otherItem.querySelector('.faq-panel');
                        var otherIndicator = otherItem.querySelector('.faq-indicator');
                        if (otherTrigger) otherTrigger.setAttribute('aria-expanded', 'false');
                        if (otherPanel) otherPanel.hidden = true;
                        if (otherIndicator) otherIndicator.textContent = '+';
                    }
                });

                if (isOpen) {
                    item.classList.remove('is-open');
                    trigger.setAttribute('aria-expanded', 'false');
                    panel.hidden = true;
                    if (indicator) indicator.textContent = '+';
                } else {
                    item.classList.add('is-open');
                    trigger.setAttribute('aria-expanded', 'true');
                    panel.hidden = false;
                    if (indicator) indicator.textContent = '−';
                }
            });
        });
    }

    /* =====================================================
       OPTIONAL CONTACT DETAILS TOGGLE
       ===================================================== */
    function initOptionalDetailsToggle() {
        var toggle = document.getElementById('toggleExtraDetails');
        var drawer = document.getElementById('extraDetailsDrawer');
        if (!toggle || !drawer) return;

        toggle.addEventListener('click', function () {
            var isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!isExpanded));
            drawer.hidden = isExpanded;
            var icon = toggle.querySelector('.toggle-icon');
            if (icon) {
                icon.textContent = isExpanded ? '+' : '−';
            }
        });
    }

    /* =====================================================
       9. MISSION & VISION ANIMATIONS (IMPECCABLE CRAFT)
       ===================================================== */
    function initMissionVision() {
        var mvSection = document.querySelector('.mv-section');
        if (!mvSection) return;

        var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // Headline — clip reveal from bottom
        var mvHeadline = mvSection.querySelector('.mv-headline');
        if (mvHeadline) {
            var spans = Array.prototype.slice.call(mvHeadline.querySelectorAll('span'));
            if (!prefersReducedMotion) {
                gsap.set(spans, { yPercent: 110, opacity: 0 });
                ScrollTrigger.create({
                    trigger: mvHeadline,
                    start: 'top 86%',
                    once: true,
                    onEnter: function () {
                        gsap.to(spans, {
                            yPercent: 0,
                            opacity: 1,
                            duration: 0.9,
                            ease: 'power4.out',
                            stagger: 0.12
                        });
                    }
                });
            }
        }

        // Left column: kicker, lead text, action cluster
        var mvKicker = mvSection.querySelector('.mv-kicker');
        var mvLead = mvSection.querySelector('.mv-lead');
        var mvActionCluster = mvSection.querySelector('.mv-action-cluster');
        var leftElements = [mvKicker, mvLead, mvActionCluster].filter(Boolean);

        if (leftElements.length && !prefersReducedMotion) {
            gsap.set(leftElements, { opacity: 0, y: 30 });
            ScrollTrigger.create({
                trigger: mvLead || mvSection,
                start: 'top 84%',
                once: true,
                onEnter: function () {
                    gsap.to(leftElements, {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        ease: 'power3.out',
                        stagger: 0.12
                    });
                }
            });
        }

        // Right column: Double-Bezel cards entrance
        var mvCards = mvSection.querySelectorAll('.mv-bezel-card');
        if (mvCards.length && !prefersReducedMotion) {
            gsap.set(mvCards, { opacity: 0, y: 48, scale: 0.97 });
            ScrollTrigger.create({
                trigger: '.mv-col-cards',
                start: 'top 82%',
                once: true,
                onEnter: function () {
                    gsap.to(mvCards, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.85,
                        ease: 'power3.out',
                        stagger: 0.18
                    });
                }
            });
        }

        // Studio Commitments Bar entrance
        var commitments = mvSection.querySelectorAll('.mv-commitment-item');
        if (commitments.length && !prefersReducedMotion) {
            gsap.set(commitments, { opacity: 0, y: 24 });
            ScrollTrigger.create({
                trigger: '.mv-commitments-bar',
                start: 'top 88%',
                once: true,
                onEnter: function () {
                    gsap.to(commitments, {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        ease: 'power2.out',
                        stagger: 0.12
                    });
                }
            });
        }

        // Spotlight physics on double-bezel cards
        initSpotlightPhysics(mvCards);
    }

    /* =====================================================
       10. CLIENT PROBLEMS ANIMATIONS (UNSLOP BENTO)
       ===================================================== */
    function initClientProblems() {
        var cpSection = document.querySelector('.cp-section');
        if (!cpSection) return;

        var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var cards = cpSection.querySelectorAll('.cp-bento-card');
        if (!cards.length) return;

        // Bento cards entrance with staggered scale and rise
        if (!prefersReducedMotion) {
            gsap.set(cards, { opacity: 0, y: 52, scale: 0.96 });
            ScrollTrigger.create({
                trigger: '.cp-bento-grid',
                start: 'top 82%',
                once: true,
                onEnter: function () {
                    gsap.to(cards, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.8,
                        ease: 'power3.out',
                        stagger: {
                            each: 0.1,
                            from: 'start'
                        }
                    });
                }
            });
        }

        // Pipeline widget data pulse micro-animation
        var pipeWidget = cpSection.querySelector('.cp-pipeline-widget');
        if (pipeWidget && !prefersReducedMotion) {
            var pipeSteps = pipeWidget.querySelectorAll('.pipe-step');
            ScrollTrigger.create({
                trigger: pipeWidget,
                start: 'top 85%',
                once: true,
                onEnter: function () {
                    gsap.from(pipeSteps, {
                        opacity: 0.4,
                        scale: 0.94,
                        duration: 0.6,
                        stagger: 0.18,
                        ease: 'back.out(1.5)',
                        delay: 0.4
                    });
                }
            });
        }

        // Interactive Category Filter Bar
        var filterBtns = cpSection.querySelectorAll('.cp-filter-btn');
        filterBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var filter = btn.getAttribute('data-filter');

                // Update active state
                filterBtns.forEach(function (b) {
                    b.classList.remove('is-active');
                    b.setAttribute('aria-selected', 'false');
                });
                btn.classList.add('is-active');
                btn.setAttribute('aria-selected', 'true');

                // Animate cards according to filter
                cards.forEach(function (card) {
                    var cardCat = card.getAttribute('data-category');
                    var matches = (filter === 'all' || cardCat === filter);

                    if (matches) {
                        if (card.style.display === 'none') {
                            card.style.display = 'flex';
                            gsap.fromTo(card,
                                { opacity: 0, scale: 0.94, y: 15 },
                                { opacity: 1, scale: 1, y: 0, duration: 0.4, ease: 'power2.out' }
                            );
                        }
                    } else {
                        gsap.to(card, {
                            opacity: 0,
                            scale: 0.94,
                            y: -10,
                            duration: 0.25,
                            ease: 'power2.in',
                            onComplete: function () {
                                card.style.display = 'none';
                                ScrollTrigger.refresh();
                            }
                        });
                    }
                });

                setTimeout(function () {
                    ScrollTrigger.refresh();
                }, 300);
            });
        });

        // Spotlight physics on bento cards
        initSpotlightPhysics(cards);
    }

    /* Helper: Interactive Radial Spotlight Follower */
    function initSpotlightPhysics(elements) {
        if (!elements || !elements.length) return;

        elements.forEach(function (el) {
            el.addEventListener('pointermove', function (e) {
                var rect = el.getBoundingClientRect();
                var x = e.clientX - rect.left;
                var y = e.clientY - rect.top;
                el.style.setProperty('--mouse-x', x + 'px');
                el.style.setProperty('--mouse-y', y + 'px');
            });
        });
    }

    /* =====================================================
       11. PROCESS STAGES ANIMATIONS
       ===================================================== */
    function initProcessStages() {
        var psSection = document.querySelector('.ps-section');
        if (!psSection) return;

        // Header block
        var psHeader = psSection.querySelector('.ps-header');
        if (psHeader) {
            var psHeadlineSpans = Array.prototype.slice.call(psHeader.querySelectorAll('.editorial-headline span'));
            if (psHeadlineSpans.length) {
                gsap.set(psHeadlineSpans, { yPercent: 100, opacity: 0 });
                ScrollTrigger.create({
                    trigger: psHeader,
                    start: 'top 86%',
                    once: true,
                    onEnter: function () {
                        gsap.to(psHeadlineSpans, {
                            yPercent: 0,
                            opacity: 1,
                            duration: 0.85,
                            ease: 'power4.out',
                            stagger: 0.1
                        });
                    }
                });
            }
            var psSub = psHeader.querySelector('.ps-header-sub');
            if (psSub) {
                gsap.set(psSub, { opacity: 0, y: 20 });
                ScrollTrigger.create({
                    trigger: psSub,
                    start: 'top 88%',
                    once: true,
                    onEnter: function () {
                        gsap.to(psSub, { opacity: 1, y: 0, duration: 0.7, ease: 'power3.out', delay: 0.25 });
                    }
                });
            }
        }

        // Stage cards — staggered slide-up with sequential connector draw
        var stages = psSection.querySelectorAll('.ps-stage');
        if (!stages.length) return;

        gsap.set(stages, { opacity: 0, y: 64 });
        ScrollTrigger.create({
            trigger: '.ps-track',
            start: 'top 80%',
            once: true,
            onEnter: function () {
                gsap.to(stages, {
                    opacity: 1,
                    y: 0,
                    duration: 0.75,
                    ease: 'power3.out',
                    stagger: 0.14
                });
            }
        });

        // Connector lines — draw from left to right sequentially
        var connectors = psSection.querySelectorAll('.ps-stage-connector:not(.ps-stage-connector--last)');
        if (connectors.length) {
            gsap.set(connectors, { scaleX: 0, transformOrigin: 'left center' });
            ScrollTrigger.create({
                trigger: '.ps-track',
                start: 'top 78%',
                once: true,
                onEnter: function () {
                    gsap.to(connectors, {
                        scaleX: 1,
                        duration: 0.55,
                        ease: 'power2.inOut',
                        stagger: 0.14,
                        delay: 0.4
                    });
                }
            });
        }

        // Stage numbers — count-style pop-in
        var stageNums = psSection.querySelectorAll('.ps-stage-num');
        if (stageNums.length) {
            gsap.set(stageNums, { opacity: 0, scale: 0.6 });
            ScrollTrigger.create({
                trigger: '.ps-track',
                start: 'top 80%',
                once: true,
                onEnter: function () {
                    gsap.to(stageNums, {
                        opacity: 1,
                        scale: 1,
                        duration: 0.5,
                        ease: 'back.out(1.8)',
                        stagger: 0.13,
                        delay: 0.1
                    });
                }
            });
        }

        // Stage list items — stagger fade after stage lands
        var listItems = psSection.querySelectorAll('.ps-stage-list li');
        if (listItems.length) {
            gsap.set(listItems, { opacity: 0, x: -12 });
            ScrollTrigger.create({
                trigger: '.ps-track',
                start: 'top 76%',
                once: true,
                onEnter: function () {
                    gsap.to(listItems, {
                        opacity: 1,
                        x: 0,
                        duration: 0.45,
                        ease: 'power2.out',
                        stagger: 0.05,
                        delay: 0.7
                    });
                }
            });
        }
    }

    /* =====================================================
       ADMIN SEARCH
       ===================================================== */
    function initAdminSearch() {
        var input = document.getElementById('adminSearch');
        if (!input) return;
        input.addEventListener('input', function () {
            var query = this.value.toLowerCase().trim();
            document.querySelectorAll('.table-container tbody tr').forEach(function (row) {
                var match = !query || row.textContent.toLowerCase().indexOf(query) !== -1;
                row.style.display = match ? '' : 'none';
            });
        });
    }

    /* =====================================================
       CHATBOT WIDGET
       Opens/closes the panel, sends messages to the PHP
       endpoint (?action=chatbot) and renders AI replies.
       Conversation history is kept in memory and sent with
       every request so the AI maintains full context.
       ===================================================== */
    function initChatbot() {
        var launcher = document.getElementById('chatbotLauncher');
        var panel    = document.getElementById('chatbotPanel');
        var closeBtn = document.getElementById('chatbotClose');
        var messages = document.getElementById('chatbotMessages');
        var input    = document.getElementById('chatbotInput');
        var sendBtn  = document.getElementById('chatbotSend');

        if (!launcher || !panel || !messages || !input || !sendBtn) return;

        var isOpen    = false;
        var isWaiting = false;

        /*
         * Conversation history — array of {role, content} objects.
         * role is 'user' or 'assistant'. Sent with every request so
         * the OpenAI model has full context of the conversation.
         * Capped at 20 entries (10 turns) client-side; the server
         * also trims to the last 20 before forwarding to the API.
         */
        var history = [];

        /* Suggestion chips shown in the welcome message */
        var SUGGESTIONS = [
            'Who is on the team?',
            'What projects have you built?',
            'What services do you offer?',
            'Tell me about CHMSU-Alijis',
            'How do I hire you?'
        ];

        /* ---- Helpers ---- */
        function openPanel() {
            isOpen = true;
            panel.classList.add('is-visible');
            panel.setAttribute('aria-hidden', 'false');
            launcher.classList.add('is-open');
            launcher.setAttribute('aria-expanded', 'true');
            launcher.classList.add('chat-notif-hidden');
            input.focus();
        }

        function closePanel() {
            isOpen = false;
            panel.classList.remove('is-visible');
            panel.setAttribute('aria-hidden', 'true');
            launcher.classList.remove('is-open');
            launcher.setAttribute('aria-expanded', 'false');
            launcher.focus();
        }

        function scrollToBottom() {
            messages.scrollTop = messages.scrollHeight;
        }

        function appendMessage(role, text) {
            var wrap = document.createElement('div');
            wrap.className = 'chat-msg chat-msg--' + role;

            var bubble = document.createElement('div');
            bubble.className = 'chat-bubble';

            // Render markdown-style bold (**text**) and preserve newlines
            var escaped = text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');

            // Bold: **text**
            escaped = escaped.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
            // Newlines to <br>
            escaped = escaped.replace(/\n/g, '<br>');

            bubble.innerHTML = escaped;
            wrap.appendChild(bubble);
            messages.appendChild(wrap);
            scrollToBottom();
            return wrap;
        }

        function showTyping() {
            var wrap = document.createElement('div');
            wrap.className = 'chat-msg chat-msg--bot chat-typing';
            wrap.id = 'chatTyping';
            var bubble = document.createElement('div');
            bubble.className = 'chat-bubble';
            for (var i = 0; i < 3; i++) {
                var dot = document.createElement('span');
                dot.className = 'typing-dot';
                bubble.appendChild(dot);
            }
            wrap.appendChild(bubble);
            messages.appendChild(wrap);
            scrollToBottom();
        }

        function hideTyping() {
            var el = document.getElementById('chatTyping');
            if (el) el.remove();
        }

        function buildSuggestions(chips) {
            var row = document.createElement('div');
            row.className = 'chat-suggestions';
            chips.forEach(function (label) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'chat-suggestion-chip';
                btn.textContent = label;
                btn.addEventListener('click', function () {
                    messages.querySelectorAll('.chat-suggestions').forEach(function (r) { r.remove(); });
                    sendMessage(label);
                });
                row.appendChild(btn);
            });
            return row;
        }

        /* ---- Welcome message ---- */
        function injectWelcome() {
            if (messages.children.length > 0) return;
            appendMessage('bot', 'Hi! 👋 I\'m the DEVS Assistant — powered by AI.\n\nWe\'re a team of IT students from CHMSU-Alijis (Carlos Hilado Memorial State University). Ask me anything about our team, projects, services, or how to work with us.');
            messages.appendChild(buildSuggestions(SUGGESTIONS));
            scrollToBottom();
        }

        /* ---- Send a message ---- */
        function sendMessage(text) {
            text = text.trim();
            if (!text || isWaiting) return;

            // Render user bubble immediately
            appendMessage('user', text);
            input.value = '';
            autoResizeInput();

            // Snapshot history before adding new turn (what the server needs)
            var historySnapshot = history.slice();

            // Add to local history
            history.push({ role: 'user', content: text });
            // Keep last 20 messages
            if (history.length > 20) history = history.slice(history.length - 20);

            isWaiting = true;
            sendBtn.disabled = true;
            showTyping();

            var base = (typeof BASE_URL !== 'undefined' ? BASE_URL : '');
            var url  = base + '/?action=chatbot';

            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    message: text,
                    history: historySnapshot   // send history BEFORE this message
                })
            })
            .then(function (res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function (data) {
                hideTyping();
                var answer = (data && data.answer) ? data.answer : 'Sorry, I couldn\'t get a response right now. Please try again.';
                appendMessage('bot', answer);

                // Add assistant reply to history for next turn
                history.push({ role: 'assistant', content: answer });
                if (history.length > 20) history = history.slice(history.length - 20);
            })
            .catch(function () {
                hideTyping();
                // Remove the failed user message from history
                history.pop();
                appendMessage('bot', 'Something went wrong. Please check your connection and try again, or reach us at devzs2026@gmail.com.');
            })
            .finally(function () {
                isWaiting = false;
                sendBtn.disabled = false;
                input.focus();
            });
        }

        /* ---- Auto-resize textarea ---- */
        function autoResizeInput() {
            input.style.height = 'auto';
            input.style.height = Math.min(input.scrollHeight, 90) + 'px';
        }

        /* ---- Event listeners ---- */
        launcher.addEventListener('click', function () {
            if (isOpen) {
                closePanel();
            } else {
                openPanel();
                injectWelcome();
            }
        });

        closeBtn.addEventListener('click', closePanel);

        sendBtn.addEventListener('click', function () {
            sendMessage(input.value);
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage(input.value);
            }
        });

        input.addEventListener('input', autoResizeInput);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isOpen) closePanel();
        });
    }

})();
