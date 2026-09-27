<?php
$statusOptions   = $statusOptions   ?? ['New', 'Contacted', 'In Discussion', 'Accepted', 'Completed', 'Archived'];
$contacts        = $contacts        ?? [];
$activeEmail     = $activeEmail     ?? '';
$activeThread    = $activeThread    ?? [];
$activeInquiry   = $activeInquiry   ?? null;
$activeInquiries = $activeInquiries ?? [];
?>
<style>
.messenger-wrap{display:flex;height:calc(100vh - 140px);min-height:480px;border:1px solid var(--border);border-radius:10px;overflow:hidden;background:var(--bg);}
.msg-sidebar{width:280px;min-width:200px;border-right:1px solid var(--border);display:flex;flex-direction:column;overflow:hidden;}
.msg-sidebar-head{padding:14px 16px;font-size:.78rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--text-muted);border-bottom:1px solid var(--border);}
.msg-contact-list{flex:1;overflow-y:auto;}
.msg-contact-item{display:flex;align-items:center;gap:11px;padding:13px 15px;border-bottom:1px solid var(--border);text-decoration:none;color:var(--text);transition:background .12s;}
.msg-contact-item:hover{background:var(--bg-secondary);}
.msg-contact-item.active{background:color-mix(in srgb,var(--accent) 12%,transparent);}
.msg-avatar{width:38px;height:38px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.95rem;flex-shrink:0;}
.msg-ci{flex:1;min-width:0;}
.msg-ci-name{font-weight:600;font-size:.88rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.msg-ci-preview{font-size:.76rem;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-top:2px;}
.msg-ci-meta{display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0;}
.msg-ci-date{font-size:.7rem;color:var(--text-muted);}
.msg-unread{background:var(--accent);color:#fff;border-radius:999px;font-size:.68rem;font-weight:700;padding:1px 7px;}
.msg-empty-side{padding:28px 14px;text-align:center;color:var(--text-muted);font-size:.83rem;}
.msg-main{flex:1;display:flex;flex-direction:column;overflow:hidden;}
.msg-main-head{padding:13px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-shrink:0;}
.msg-main-name{font-weight:700;font-size:.95rem;}
.msg-main-sub{font-size:.77rem;color:var(--text-muted);margin-top:2px;}
.msg-thread{flex:1;overflow-y:auto;padding:18px;display:flex;flex-direction:column;gap:10px;}
.msg-bwrap{display:flex;flex-direction:column;max-width:68%;}
.msg-bwrap.client{align-self:flex-start;}
.msg-bwrap.admin{align-self:flex-end;}
.msg-bubble{padding:9px 13px;border-radius:14px;font-size:.87rem;line-height:1.55;white-space:pre-wrap;word-break:break-word;}
.msg-bwrap.client .msg-bubble{background:var(--bg-secondary);border-bottom-left-radius:4px;color:var(--text);}
.msg-bwrap.admin  .msg-bubble{background:var(--accent);color:#fff;border-bottom-right-radius:4px;}
.msg-blabel{font-size:.7rem;color:var(--text-muted);margin-bottom:3px;}
.msg-bwrap.admin .msg-blabel{text-align:right;}
.msg-btime{font-size:.69rem;color:var(--text-muted);margin-top:3px;}
.msg-bwrap.admin .msg-btime{text-align:right;}
.msg-meta-card{background:var(--bg-secondary);border:1px solid var(--border);border-radius:8px;padding:10px 14px;font-size:.8rem;color:var(--text-muted);align-self:center;text-align:center;max-width:80%;}
.msg-meta-card strong{color:var(--text);display:block;margin-bottom:4px;}
.msg-no-thread{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-muted);font-size:.87rem;gap:6px;}
.msg-reply-box{border-top:1px solid var(--border);padding:12px 16px;flex-shrink:0;}
.msg-flash-ok{background:#d4edda;color:#155724;padding:7px 12px;border-radius:6px;font-size:.8rem;margin-bottom:8px;}
.msg-flash-err{background:#f8d7da;color:#721c24;padding:7px 12px;border-radius:6px;font-size:.8rem;margin-bottom:8px;}
.msg-reply-row{display:flex;gap:9px;align-items:flex-end;}
.msg-textarea{flex:1;resize:none;border:1px solid var(--border);border-radius:8px;padding:9px 12px;font-size:.87rem;font-family:inherit;background:var(--bg-secondary);color:var(--text);min-height:58px;max-height:140px;}
.msg-textarea:focus{outline:none;border-color:var(--accent);}
.msg-send{background:var(--accent);color:#fff;border:none;border-radius:8px;padding:0 18px;font-size:.87rem;font-weight:600;cursor:pointer;height:42px;white-space:nowrap;transition:opacity .13s;}
.msg-send:hover{opacity:.85;}
.msg-empty-main{flex:1;display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:.88rem;}

/* ── Messenger back button (mobile only) ── */
.msg-back-btn{display:none;align-items:center;gap:6px;background:none;border:none;cursor:pointer;font-size:.82rem;font-weight:600;color:var(--accent);padding:0;margin-bottom:2px;text-decoration:none;}
.msg-back-btn svg{flex-shrink:0;}

@media (max-width: 680px) {
    /* Stack: show either list OR conversation, not both */
    .messenger-wrap {
        height: calc(100vh - 110px);
        min-height: 0;
        border-radius: 8px;
    }

    /* Sidebar fills full width by default */
    .msg-sidebar {
        width: 100%;
        min-width: 0;
        border-right: none;
        flex-shrink: 0;
    }

    /* Main panel hidden by default on mobile */
    .msg-main {
        display: none;
        width: 100%;
        flex: none;
    }

    /* When a conversation is active: hide sidebar, show main */
    .messenger-wrap.has-active .msg-sidebar {
        display: none;
    }

    .messenger-wrap.has-active .msg-main {
        display: flex;
    }

    /* Back button visible on mobile */
    .msg-back-btn {
        display: flex;
    }

    /* Bubbles can be wider on narrow screens */
    .msg-bwrap {
        max-width: 85%;
    }

    /* Reply row stacks on very small screens */
    .msg-reply-row {
        gap: 7px;
    }

    .msg-send {
        padding: 0 13px;
        font-size: .82rem;
    }
}
</style>

<div class="messenger-wrap<?php echo $activeInquiry ? ' has-active' : ''; ?>">

    <!-- ══ Sidebar ══ -->
    <aside class="msg-sidebar">
        <div class="msg-sidebar-head">Conversations</div>
        <div class="msg-contact-list">
            <?php if (empty($contacts)): ?>
                <p class="msg-empty-side">No inquiries yet.</p>
            <?php else: foreach ($contacts as $c):
                $initials = strtoupper(substr(trim($c['inquiry_name']), 0, 1) ?: '?');
                $isActive = ($c['inquiry_email'] === $activeEmail);
                $unread   = (int)($c['unread_count'] ?? 0);
                $preview  = mb_strimwidth(trim($c['inquiry_description'] ?? ''), 0, 42, '…');
                $date     = date('M j', strtotime($c['inquiry_created_at']));
            ?>
            <a href="<?php echo BASE_URL; ?>/admin?sub=inquiries&email=<?php echo urlencode($c['inquiry_email']); ?>"
               class="msg-contact-item <?php echo $isActive ? 'active' : ''; ?>">
                <div class="msg-avatar"><?php echo e($initials); ?></div>
                <div class="msg-ci">
                    <div class="msg-ci-name"><?php echo e($c['inquiry_name']); ?></div>
                    <div class="msg-ci-preview"><?php echo e($preview); ?></div>
                </div>
                <div class="msg-ci-meta">
                    <span class="msg-ci-date"><?php echo $date; ?></span>
                    <?php if ($unread > 0): ?>
                        <span class="msg-unread"><?php echo $unread; ?></span>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; endif; ?>
        </div>
    </aside>

    <!-- ══ Main panel ══ -->
    <div class="msg-main">
        <?php if ($activeInquiry): ?>

        <!-- Header -->
        <div class="msg-main-head">
            <div>
                <!-- Back button - mobile only -->
                <a href="<?php echo BASE_URL; ?>/admin?sub=inquiries" class="msg-back-btn" aria-label="Back to conversations">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                    Conversations
                </a>
                <div class="msg-main-name"><?php echo e($activeInquiry['inquiry_name']); ?></div>
                <div class="msg-main-sub">
                    <?php echo e($activeInquiry['inquiry_email']); ?>
                    <?php if (!empty($activeInquiry['inquiry_phone'])): ?>&nbsp;·&nbsp;<?php echo e($activeInquiry['inquiry_phone']); ?><?php endif; ?>
                    <?php if (!empty($activeInquiry['inquiry_project_type'])): ?>&nbsp;·&nbsp;<?php echo e($activeInquiry['inquiry_project_type']); ?><?php endif; ?>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminUpdateInquiryStatus"
                      style="display:flex;gap:8px;align-items:center;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="inquiry_id" value="<?php echo (int)$activeInquiry['inquiry_id']; ?>">
                    <input type="hidden" name="view_email" value="<?php echo e($activeEmail); ?>">
                    <label class="visually-hidden" for="conv_status">Status</label>
                    <select class="admin-inline-select" id="conv_status" name="inquiry_status"
                            onchange="this.form.submit()">
                        <?php foreach ($statusOptions as $opt): ?>
                            <option value="<?php echo e($opt); ?>"
                                <?php echo $activeInquiry['inquiry_status'] === $opt ? 'selected' : ''; ?>>
                                <?php echo e($opt); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>

        <!-- Thread -->
        <div class="msg-thread" id="msgThread">

            <?php
            // Show project detail card if any inquiry has meta
            foreach ($activeInquiries as $inq):
                $hasMeta = !empty($inq['inquiry_project_type'])
                        || !empty($inq['inquiry_budget_range'])
                        || !empty($inq['inquiry_company']);
                if ($hasMeta): ?>
            <div class="msg-meta-card">
                <strong>Project details</strong>
                <?php if (!empty($inq['inquiry_project_type'])): ?>Type: <?php echo e($inq['inquiry_project_type']); ?><br><?php endif; ?>
                <?php if (!empty($inq['inquiry_budget_range'])): ?>Budget: <?php echo e($inq['inquiry_budget_range']); ?><br><?php endif; ?>
                <?php if (!empty($inq['inquiry_company'])): ?>Company: <?php echo e($inq['inquiry_company']); ?><?php endif; ?>
            </div>
            <?php endif; endforeach; ?>

            <?php if (empty($activeThread)): ?>
                <div class="msg-no-thread">
                    <span>No messages stored yet.</span>
                    <span style="font-size:.76rem;">New messages from this client will appear here.</span>
                </div>
            <?php else: foreach ($activeThread as $msg):
                $dir  = $msg['direction'];
                $time = date('M j, g:i a', strtotime($msg['replied_at']));
            ?>
            <div class="msg-bwrap <?php echo e($dir); ?>">
                <div class="msg-blabel">
                    <?php echo $dir === 'client' ? e($activeInquiry['inquiry_name']) : 'You (DEVS)'; ?>
                </div>
                <div class="msg-bubble"><?php echo e($msg['reply_message']); ?></div>
                <div class="msg-btime"><?php echo $time; ?></div>
            </div>
            <?php endforeach; endif; ?>

        </div>

        <!-- Reply box -->
        <div class="msg-reply-box">
            <?php if (!empty($_SESSION['reply_success'])): ?>
                <div class="msg-flash-ok"><?php echo e($_SESSION['reply_success']); unset($_SESSION['reply_success']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['reply_error'])): ?>
                <div class="msg-flash-err"><?php echo e($_SESSION['reply_error']); unset($_SESSION['reply_error']); ?></div>
            <?php endif; ?>
            <form method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminReplyInquiry" id="replyForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="inquiry_id"    value="<?php echo (int)$activeInquiry['inquiry_id']; ?>">
                <input type="hidden" name="client_email"  value="<?php echo e($activeInquiry['inquiry_email']); ?>">
                <input type="hidden" name="client_name"   value="<?php echo e($activeInquiry['inquiry_name']); ?>">
                <input type="hidden" name="reply_subject" value="Re: Your inquiry to DEVS">
                <div class="msg-reply-row">
                    <textarea class="msg-textarea" name="reply_message" id="replyMsg"
                              placeholder="Type a reply…" rows="2" required></textarea>
                    <button type="submit" class="msg-send">Send</button>
                </div>
            </form>
        </div>

        <?php else: ?>
            <div class="msg-empty-main">
                <?php if (empty($contacts)): ?>
                    No inquiries yet.
                <?php else: ?>
                    Select a conversation to view messages.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
// Auto-scroll thread to bottom on load
(function () {
    var t = document.getElementById('msgThread');
    if (t) t.scrollTop = t.scrollHeight;
})();

// Ctrl+Enter submits the reply form
document.getElementById('replyMsg')?.addEventListener('keydown', function (e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('replyForm')?.submit();
    }
});
</script>
