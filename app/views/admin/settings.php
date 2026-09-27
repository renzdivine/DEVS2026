<?php $settings = $settings ?? []; ?>
<div class="admin-panel">
    <h3>Site settings</h3>
    <p>These values power the public footer and contact page. Leave a field empty to hide it.</p>
    <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminSaveSettings">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="github_url">GitHub URL</label>
            <input type="url" id="github_url" name="github_url" placeholder="https://github.com/your-org" value="<?php echo e($settings['github_url'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="linkedin_url">LinkedIn URL</label>
            <input type="url" id="linkedin_url" name="linkedin_url" placeholder="https://www.linkedin.com/company/…" value="<?php echo e($settings['linkedin_url'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="site_email">Contact email</label>
            <input type="email" id="site_email" name="site_email" placeholder="hello@example.com" value="<?php echo e($settings['site_email'] ?? ''); ?>">
            <span class="file-note">Also used to receive inquiry notifications.</span>
        </div>
        <div class="form-group">
            <label for="site_phone">Phone number</label>
            <input type="text" id="site_phone" name="site_phone" placeholder="+63 912 345 6789" value="<?php echo e($settings['site_phone'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="site_address">Address</label>
            <input type="text" id="site_address" name="site_address" placeholder="City, Province, Country" value="<?php echo e($settings['site_address'] ?? ''); ?>">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save settings</button>
        </div>
    </form>
</div>
