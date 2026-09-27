<div class="table-container">
    <div class="table-title">Services</div>
    <table>
        <thead>
            <tr><th>Name</th><th>Description</th><th>Technologies</th><th>Order</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php if (empty($services)): ?>
                <tr><td colspan="6" class="cell-muted">No services yet.</td></tr>
            <?php else: foreach ($services as $service): ?>
            <tr>
                <td><?php echo e($service['service_name']); ?></td>
                <td class="cell-muted"><?php echo e(trunc_text($service['service_description'], 80)); ?></td>
                <td class="cell-muted"><?php echo e($service['service_technologies']); ?></td>
                <td><?php echo (int)$service['display_order']; ?></td>
                <td><span class="status-badge <?php echo $service['service_status'] ? 'status-active' : 'status-inactive'; ?>"><?php echo $service['service_status'] ? 'Active' : 'Inactive'; ?></span></td>
                <td>
                    <div class="table-actions">
                        <a href="<?php echo BASE_URL; ?>/admin?sub=services&action=adminEditService&id=<?php echo (int)$service['service_id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                        <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminDeleteService" onsubmit="return confirm('Delete this service?');">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo (int)$service['service_id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<div class="form-actions">
    <a href="<?php echo BASE_URL; ?>/admin?sub=services&action=adminAddService" class="btn btn-primary">Add service</a>
</div>

<?php if (!empty($addOpen) || !empty($editId)): ?>
<?php $isEdit = !empty($editId); $row = $editing ?? []; ?>
<div class="modal-overlay">
    <div class="modal">
        <div class="modal-head">
            <h2><?php echo $isEdit ? 'Edit service' : 'Add service'; ?></h2>
            <a href="<?php echo BASE_URL; ?>/admin?sub=services" class="close-modal" aria-label="Close">&times;</a>
        </div>
        <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminSaveService">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="service_id" value="<?php echo (int)$editId; ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="service_name">Name *</label>
                    <input type="text" id="service_name" name="service_name" required value="<?php echo e($row['service_name'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="service_icon">Icon label</label>
                    <input type="text" id="service_icon" name="service_icon" placeholder="e.g. &lt;/&gt;" value="<?php echo e($row['service_icon'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="service_description">Description *</label>
                <textarea id="service_description" name="service_description" rows="4" required><?php echo e($row['service_description'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="service_technologies">Technologies (comma separated)</label>
                <input type="text" id="service_technologies" name="service_technologies" placeholder="HTML, CSS, JavaScript" value="<?php echo e($row['service_technologies'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="service_status">Status</label>
                <select id="service_status" name="service_status">
                    <option value="1" <?php echo (int)($row['service_status'] ?? 1) === 1 ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?php echo (isset($row['service_status']) && (int)$row['service_status'] === 0) ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <input type="hidden" name="display_order" value="<?php echo (int)($row['display_order'] ?? 0); ?>">
            <div class="modal-actions">
                <a href="<?php echo BASE_URL; ?>/admin?sub=services" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Save changes' : 'Add service'; ?></button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
