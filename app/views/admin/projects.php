<div class="table-container">
    <div class="table-title">Projects</div>
    <table>
        <thead>
            <tr><th>Name</th><th>Category</th><th>Status</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php if (empty($projects)): ?>
                <tr><td colspan="5" class="cell-muted">No projects yet.</td></tr>
            <?php else: foreach ($projects as $project): ?>
            <tr>
                <td><?php echo e($project['project_name']); ?></td>
                <td><?php echo e($project['project_category']); ?></td>
                <td><span class="status-badge <?php echo $project['project_status'] ? 'status-active' : 'status-inactive'; ?>"><?php echo $project['project_status'] ? 'Active' : 'Inactive'; ?></span></td>
                <td class="cell-muted"><?php echo e(date('M j, Y', strtotime($project['project_created_at']))); ?></td>
                <td>
                    <div class="table-actions">
                        <a href="<?php echo BASE_URL; ?>/admin?sub=projects&action=adminEditProject&id=<?php echo (int)$project['project_id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                        <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminDeleteProject" onsubmit="return confirm('Delete this project?');">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo (int)$project['project_id']; ?>">
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
    <a href="<?php echo BASE_URL; ?>/admin?sub=projects&action=adminAddProject" class="btn btn-primary">Add project</a>
</div>

<?php if (!empty($addOpen) || !empty($editId)): ?>
<?php $isEdit = !empty($editId); $row = $editing ?? []; ?>
<div class="modal-overlay">
    <div class="modal">
        <div class="modal-head">
            <h2><?php echo $isEdit ? 'Edit project' : 'Add project'; ?></h2>
            <a href="<?php echo BASE_URL; ?>/admin?sub=projects" class="close-modal" aria-label="Close">&times;</a>
        </div>
        <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminSaveProject" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="project_id" value="<?php echo (int)$editId; ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="project_name">Project name *</label>
                    <input type="text" id="project_name" name="project_name" required value="<?php echo e($row['project_name'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="project_slug">Slug</label>
                    <input type="text" id="project_slug" name="project_slug" placeholder="auto-generated if empty" value="<?php echo e($row['project_slug'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="project_category">Category</label>
                    <select id="project_category" name="project_category">
                        <?php foreach (['Web', 'Mobile', 'System', 'Other'] as $cat): ?>
                            <option value="<?php echo e($cat); ?>" <?php echo ($row['project_category'] ?? 'Web') === $cat ? 'selected' : ''; ?>><?php echo e($cat); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="project_status">Status</label>
                    <select id="project_status" name="project_status">
                        <option value="1" <?php echo (int)($row['project_status'] ?? 1) === 1 ? 'selected' : ''; ?>>Active</option>
                        <option value="0" <?php echo (isset($row['project_status']) && (int)$row['project_status'] === 0) ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="project_description">Short description *</label>
                <textarea id="project_description" name="project_description" rows="3" required><?php echo e($row['project_description'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="project_long_description">Long description</label>
                <textarea id="project_long_description" name="project_long_description" rows="5"><?php echo e($row['project_long_description'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="project_dev_story">Dev story</label>
                <textarea id="project_dev_story" name="project_dev_story" rows="5" placeholder="How the project was actually built…"><?php echo e($row['project_dev_story'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="project_features">Features (one per line)</label>
                <textarea id="project_features" name="project_features" rows="4"><?php echo e($row['project_features'] ?? ''); ?></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="project_github_url">GitHub URL</label>
                    <input type="url" id="project_github_url" name="project_github_url" value="<?php echo e($row['project_github_url'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="project_live_url">Live URL</label>
                    <input type="url" id="project_live_url" name="project_live_url" value="<?php echo e($row['project_live_url'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="featured_image">Featured image</label>
                <?php if (!empty($row['project_featured_image'])): ?>
                    <div class="current-image-preview">
                        <img src="<?php echo BASE_URL . e($row['project_featured_image']); ?>" alt="Current featured image" style="max-height:120px;max-width:100%;border-radius:6px;margin-bottom:8px;display:block;">
                        <label class="checkbox-item" style="font-size:0.85rem;">
                            <input type="checkbox" name="remove_featured_image" value="1"> Remove current featured image
                        </label>
                    </div>
                <?php endif; ?>
                <input type="file" id="featured_image" name="featured_image" accept="image/jpeg,image/png,image/webp,image/gif">
                <img id="featured_image_preview" src="" alt="Preview" style="display:none;max-height:120px;max-width:100%;border-radius:6px;margin-top:8px;">
                <span class="file-note">JPG, PNG, WEBP or GIF - max 3MB.<?php echo !empty($row['project_featured_image']) ? ' Upload a new one to replace it.' : ''; ?></span>
            </div>
            <div class="form-group">
                <label>Screenshots</label>
                <?php if (!empty($editScreenshots)): ?>
                    <div class="screenshots-preview" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:12px;">
                        <?php foreach ($editScreenshots as $shot): ?>
                            <div style="position:relative;display:inline-block;">
                                <img src="<?php echo BASE_URL . e($shot['image_path']); ?>" alt="Screenshot" style="height:80px;width:120px;object-fit:cover;border-radius:6px;display:block;">
                                <label style="display:flex;align-items:center;gap:4px;font-size:0.75rem;margin-top:4px;">
                                    <input type="checkbox" name="delete_screenshots[]" value="<?php echo (int)$shot['image_id']; ?>"> Delete
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <input type="file" id="screenshots" name="screenshots[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple>
                <div id="screenshots_preview" style="display:flex;flex-wrap:wrap;gap:10px;margin-top:8px;"></div>
                <span class="file-note">Select one or more images (max 3MB each). Added to existing screenshots.</span>
            </div>
            <fieldset>
                <legend>Technologies</legend>
                <div class="checkbox-grid">
                    <?php foreach ($skills as $skill): ?>
                        <label class="checkbox-item">
                            <input type="checkbox" name="project_skills[]" value="<?php echo (int)$skill['skill_id']; ?>"
                                <?php echo in_array((int)$skill['skill_id'], $editSkillIds, true) ? 'checked' : ''; ?>>
                            <?php echo e($skill['skill_name']); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </fieldset>
            <fieldset>
                <legend>Team</legend>
                <div class="checkbox-grid">
                    <?php foreach ($teamMembers as $member): ?>
                        <label class="checkbox-item">
                            <input type="checkbox" name="project_members[]" value="<?php echo (int)$member['member_id']; ?>"
                                <?php echo in_array((int)$member['member_id'], $editMemberIds, true) ? 'checked' : ''; ?>>
                            <?php echo e($member['member_name']); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </fieldset>
            <div class="modal-actions">
                <a href="<?php echo BASE_URL; ?>/admin?sub=projects" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Save changes' : 'Add project'; ?></button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
// Featured image live preview
document.getElementById('featured_image')?.addEventListener('change', function () {
    const preview = document.getElementById('featured_image_preview');
    if (!preview) return;
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
});

// Screenshots live preview
document.getElementById('screenshots')?.addEventListener('change', function () {
    const container = document.getElementById('screenshots_preview');
    if (!container) return;
    container.innerHTML = '';
    Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const wrap = document.createElement('div');
            wrap.style.cssText = 'display:inline-block;';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'New screenshot preview';
            img.style.cssText = 'height:80px;width:120px;object-fit:cover;border-radius:6px;display:block;';
            const label = document.createElement('p');
            label.textContent = file.name;
            label.style.cssText = 'font-size:0.7rem;margin:4px 0 0;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;';
            wrap.appendChild(img);
            wrap.appendChild(label);
            container.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });
});
</script>
