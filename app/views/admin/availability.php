<div class="admin-panel">
    <h3>Availability status</h3>
    <p>This status is shown on the homepage hero and the contact page.</p>
    <p>
        Current:
        <span class="status-badge <?php echo (($avail['availability_status'] ?? '') === 'Available') ? 'status-active' : 'status-contacted'; ?>">
            <?php echo e($avail['availability_status'] ?? 'Available'); ?>
        </span>
    </p>
    <form class="admin-inline-form" method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminAvailabilityUpdate" style="margin-top:16px;">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="avail_id" value="<?php echo (int)($avail['availability_id'] ?? 0); ?>">
        <input type="hidden" name="back" value="availability">
        <label class="visually-hidden" for="availability_status">New status</label>
        <select id="availability_status" name="availability_status">
            <?php foreach (['Available', 'Limited Availability', 'Currently Busy'] as $option): ?>
                <option value="<?php echo e($option); ?>" <?php echo ($avail['availability_status'] ?? '') === $option ? 'selected' : ''; ?>><?php echo e($option); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Update status</button>
    </form>
</div>
