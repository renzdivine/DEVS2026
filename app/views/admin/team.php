<div class="table-container">
    <div class="table-title">Team members</div>
    <table>
        <thead>
            <tr><th>Photo</th><th>Name</th><th>Role</th><th>Skills</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php if (empty($members)): ?>
                <tr><td colspan="6" class="cell-muted">No team members yet.</td></tr>
            <?php else: foreach ($members as $member): ?>
            <tr>
                <td>
                    <?php if ($member['member_photo']): ?>
                        <img class="avatar-thumb" src="<?php echo BASE_URL . e($member['member_photo']); ?>" alt="">
                    <?php else: ?>
                        <span class="avatar-thumb"><?php echo e(strtoupper(substr($member['member_name'], 0, 2))); ?></span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($member['member_name']); ?></td>
                <td><?php echo e($member['member_role']); ?></td>
                <td class="cell-muted"><?php echo e($member['member_skills']); ?></td>
                <td><span class="status-badge <?php echo $member['member_status'] ? 'status-active' : 'status-inactive'; ?>"><?php echo $member['member_status'] ? 'Active' : 'Inactive'; ?></span></td>
                <td>
                    <div class="table-actions">
                        <a href="<?php echo BASE_URL; ?>/admin?sub=team&action=adminEditTeam&id=<?php echo (int)$member['member_id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                        <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminDeleteTeam" onsubmit="return confirm('Delete this team member?');">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo (int)$member['member_id']; ?>">
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
    <a href="<?php echo BASE_URL; ?>/admin?sub=team&action=adminAddTeam" class="btn btn-primary">Add member</a>
</div>

<?php if (!empty($addOpen) || !empty($editId)): ?>
<?php $isEdit = !empty($editId); $row = $editing ?? []; ?>
<div class="modal-overlay">
    <div class="modal">
        <div class="modal-head">
            <h2><?php echo $isEdit ? 'Edit team member' : 'Add team member'; ?></h2>
            <a href="<?php echo BASE_URL; ?>/admin?sub=team" class="close-modal" aria-label="Close">&times;</a>
        </div>
        <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminSaveTeam" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="member_id" value="<?php echo (int)$editId; ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="member_name">Name *</label>
                    <input type="text" id="member_name" name="member_name" required value="<?php echo e($row['member_name'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="member_slug">Slug</label>
                    <input type="text" id="member_slug" name="member_slug" placeholder="auto-generated if empty" value="<?php echo e($row['member_slug'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="member_role">Role</label>
                    <input type="text" id="member_role" name="member_role" value="<?php echo e($row['member_role'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="member_email">Email</label>
                    <input type="email" id="member_email" name="member_email" value="<?php echo e($row['member_email'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="member_photo">Photo</label>
                <input type="file" id="member_photo" name="member_photo" accept="image/jpeg,image/png,image/webp,image/gif">
                <span class="file-note">JPG, PNG, WEBP or GIF - max 3MB. Leave empty to keep the current photo.</span>
            </div>
            <div class="form-group">
                <label for="member_short_bio">Bio</label>
                <textarea id="member_short_bio" name="member_short_bio" rows="4"><?php echo e(!empty($row['member_short_bio']) ? $row['member_short_bio'] : ($row['member_full_bio'] ?? '')); ?></textarea>
            </div>
            <fieldset>
                <legend>Skills</legend>
                <div class="checkbox-grid">
                    <?php foreach ($allSkills as $skill): ?>
                        <label class="checkbox-item">
                            <input type="checkbox" name="member_skills[]" value="<?php echo (int)$skill['skill_id']; ?>"
                                <?php echo in_array((int)$skill['skill_id'], $editSkillIds, true) ? 'checked' : ''; ?>>
                            <?php echo e($skill['skill_name']); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </fieldset>
            <div class="form-row">
                <div class="form-group">
                    <label for="member_github">GitHub</label>
                    <input type="url" id="member_github" name="member_github" value="<?php echo e($row['member_github'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="member_linkedin">LinkedIn</label>
                    <input type="url" id="member_linkedin" name="member_linkedin" value="<?php echo e($row['member_linkedin'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="member_facebook">Facebook</label>
                    <input type="url" id="member_facebook" name="member_facebook" value="<?php echo e($row['member_facebook'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="member_instagram">Instagram</label>
                    <input type="url" id="member_instagram" name="member_instagram" value="<?php echo e($row['member_instagram'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="member_status">Status</label>
                    <select id="member_status" name="member_status">
                        <option value="1" <?php echo (int)($row['member_status'] ?? 1) === 1 ? 'selected' : ''; ?>>Active</option>
                        <option value="0" <?php echo (isset($row['member_status']) && (int)$row['member_status'] === 0) ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="display_order">Display order</label>
                    <input type="number" id="display_order" name="display_order" value="<?php echo (int)($row['display_order'] ?? 0); ?>">
                </div>
            </div>
            <div class="modal-actions">
                <a href="<?php echo BASE_URL; ?>/admin?sub=team" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Save changes' : 'Add member'; ?></button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
