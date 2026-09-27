    </div>
</main>
<script src="<?php echo BASE_URL; ?>/js/main.js<?php echo asset_v('/js/main.js'); ?>" defer></script>
<script>
(function () {
    var toggle   = document.getElementById('sidebarToggle');
    var sidebar  = document.getElementById('adminSidebar');
    var backdrop = document.getElementById('sidebarBackdrop');
    if (!toggle || !sidebar || !backdrop) return;

    function openSidebar() {
        sidebar.classList.add('is-open');
        backdrop.classList.add('is-open');
        toggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        backdrop.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', function () {
        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });

    backdrop.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeSidebar();
    });
})();
</script>
</body>
</html>
