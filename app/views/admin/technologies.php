<div class="table-container">
    <div class="table-title">Technologies</div>
    <table>
        <thead>
            <tr><th>Name</th><th>Category</th><th>Description</th><th>Icon</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php if (empty($skills)): ?>
                <tr><td colspan="5" class="cell-muted">No technologies yet.</td></tr>
            <?php else: foreach ($skills as $skill): ?>
            <tr>
                <td><?php echo e($skill['skill_name']); ?></td>
                <td><?php echo e($skill['skill_category']); ?></td>
                <td class="cell-muted"><?php echo e($skill['skill_description']); ?></td>
                <td class="cell-muted"><?php echo e($skill['skill_icon']); ?></td>
                <td>
                    <div class="table-actions">
                        <a href="<?php echo BASE_URL; ?>/admin?sub=technologies&action=adminEditTech&id=<?php echo (int)$skill['skill_id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                        <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminDeleteTech" onsubmit="return confirm('Delete this technology?');">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo (int)$skill['skill_id']; ?>">
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
    <a href="<?php echo BASE_URL; ?>/admin?sub=technologies&action=adminAddTech" class="btn btn-primary">Add technology</a>
</div>

<?php if (!empty($addOpen) || !empty($editId)): ?>
<?php $isEdit = !empty($editId); $row = $editing ?? []; ?>
<div class="modal-overlay">
    <div class="modal">
        <div class="modal-head">
            <h2><?php echo $isEdit ? 'Edit technology' : 'Add technology'; ?></h2>
            <a href="<?php echo BASE_URL; ?>/admin?sub=technologies" class="close-modal" aria-label="Close">&times;</a>
        </div>
        <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminSaveTech">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="skill_id" value="<?php echo (int)$editId; ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="skill_name">Name *</label>
                    <input type="text" id="skill_name" name="skill_name" required value="<?php echo e($row['skill_name'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="skill_category">Category</label>
                    <select id="skill_category" name="skill_category">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo e($cat); ?>" <?php echo ($row['skill_category'] ?? 'Frontend') === $cat ? 'selected' : ''; ?>><?php echo e($cat); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="skill_description">Description</label>
                <input type="text" id="skill_description" name="skill_description" value="<?php echo e($row['skill_description'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="skill_icon">Icon label</label>
                <input type="text" id="skill_icon" name="skill_icon" placeholder="e.g. PHP" value="<?php echo e($row['skill_icon'] ?? ''); ?>">
            </div>
            <div class="modal-actions">
                <a href="<?php echo BASE_URL; ?>/admin?sub=technologies" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Save changes' : 'Add technology'; ?></button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
