<!-- =====================================================
     DEVS Chatbot Widget
     CSS is inlined below — no external file needed.
     JS in main.js → initChatbot()
     API endpoint: ?action=chatbot (POST JSON)
     ===================================================== -->
<style>
.chatbot-launcher{position:fixed;bottom:28px;right:28px;z-index:9990;width:56px;height:56px;border-radius:9999px;background:var(--terracotta,#C86142);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(200,97,66,.4);transition:background .22s,transform .22s,box-shadow .22s;outline-offset:3px}
.chatbot-launcher:hover{background:var(--terracotta-hover,#B25235);transform:scale(1.08);box-shadow:0 6px 28px rgba(200,97,66,.55)}
.chatbot-launcher:focus-visible{outline:2px solid var(--terracotta,#C86142)}
.chatbot-launcher .icon-chat,.chatbot-launcher .icon-close-chat{position:absolute;transition:opacity .18s,transform .18s}
.chatbot-launcher .icon-close-chat{opacity:0;transform:rotate(-90deg) scale(.7)}
.chatbot-launcher.is-open .icon-chat{opacity:0;transform:rotate(90deg) scale(.7)}
.chatbot-launcher.is-open .icon-close-chat{opacity:1;transform:rotate(0deg) scale(1)}
.chatbot-launcher .chat-notif-dot{position:absolute;top:6px;right:6px;width:10px;height:10px;background:#fff;border-radius:50%;border:2px solid var(--terracotta,#C86142);animation:chatPulse 2s ease-in-out infinite}
.chatbot-launcher.is-open .chat-notif-dot,.chatbot-launcher.chat-notif-hidden .chat-notif-dot{display:none}
@keyframes chatPulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.35);opacity:.6}}
.chatbot-panel{position:fixed;bottom:96px;right:28px;z-index:9989;width:360px;max-width:calc(100vw - 32px);height:520px;max-height:calc(100dvh - 120px);background:var(--bg-card,#fff);border:1px solid var(--border-strong,#CEC6B7);border-radius:8px;box-shadow:0 24px 60px rgba(21,20,19,.12);display:flex;flex-direction:column;overflow:hidden;opacity:0;transform:translateY(16px) scale(.97);pointer-events:none;transition:opacity .24s,transform .24s;transform-origin:bottom right}
.chatbot-panel.is-visible{opacity:1;transform:translateY(0) scale(1);pointer-events:all}
.chatbot-header{display:flex;align-items:center;gap:10px;padding:14px 16px;background:var(--bg-secondary,#EFE9DE);border-bottom:1px solid var(--border,#DFD9CE);flex-shrink:0}
.chatbot-avatar{width:36px;height:36px;border-radius:9999px;background:var(--terracotta,#C86142);color:#fff;display:flex;align-items:center;justify-content:center;font-family:var(--font-mono,'Space Grotesk',monospace);font-size:13px;font-weight:600;flex-shrink:0;letter-spacing:-.5px}
.chatbot-header-info{flex:1;min-width:0}
.chatbot-header-name{font-family:var(--font-mono,'Space Grotesk',monospace);font-size:13px;font-weight:600;color:var(--text-primary,#151413);line-height:1.2}
.chatbot-header-status{font-size:11px;color:var(--text-muted,#7A756D);display:flex;align-items:center;gap:5px;margin-top:2px}
.chatbot-status-dot{width:7px;height:7px;border-radius:50%;background:#22c55e;flex-shrink:0}
.chatbot-header-close{background:none;border:none;cursor:pointer;color:var(--text-muted,#7A756D);padding:4px;border-radius:2px;display:flex;align-items:center;justify-content:center;transition:color .18s,background .18s;flex-shrink:0}
.chatbot-header-close:hover{color:var(--text-primary,#151413);background:var(--bg-primary,#F7F3EB)}
.chatbot-messages{flex:1;overflow-y:auto;padding:16px 14px;display:flex;flex-direction:column;gap:12px;scroll-behavior:smooth}
.chatbot-messages::-webkit-scrollbar{width:4px}
.chatbot-messages::-webkit-scrollbar-track{background:transparent}
.chatbot-messages::-webkit-scrollbar-thumb{background:var(--border-strong,#CEC6B7);border-radius:2px}
.chat-msg{display:flex;gap:8px;align-items:flex-end;max-width:100%}
.chat-msg--bot{align-self:flex-start}
.chat-msg--user{align-self:flex-end;flex-direction:row-reverse;max-width:82%}
.chat-bubble{padding:10px 13px;border-radius:14px;font-size:13.5px;line-height:1.55;max-width:100%;min-width:0;word-break:break-word;overflow-wrap:anywhere;white-space:normal}
.chat-msg--bot .chat-bubble{background:var(--bg-secondary,#EFE9DE);color:var(--text-primary,#151413);border-bottom-left-radius:2px;border:1px solid var(--border,#DFD9CE);max-width:82%}
.chat-msg--user .chat-bubble{background:var(--terracotta,#C86142);color:#fff;border-bottom-right-radius:2px;width:100%}
.chat-typing .chat-bubble{display:flex;align-items:center;gap:4px;padding:12px 16px}
.typing-dot{width:6px;height:6px;border-radius:50%;background:var(--text-muted,#7A756D);animation:typingBounce 1.2s ease-in-out infinite}
.typing-dot:nth-child(2){animation-delay:.2s}
.typing-dot:nth-child(3){animation-delay:.4s}
@keyframes typingBounce{0%,60%,100%{transform:translateY(0)}30%{transform:translateY(-5px)}}
.chat-suggestions{display:flex;flex-wrap:wrap;gap:6px;padding:4px 0 2px}
.chat-suggestion-chip{background:var(--bg-primary,#F7F3EB);border:1px solid var(--border-strong,#CEC6B7);color:var(--text-secondary,#4A463F);font-family:var(--font-mono,'Space Grotesk',monospace);font-size:11.5px;padding:5px 10px;border-radius:9999px;cursor:pointer;transition:background .18s,border-color .18s,color .18s;white-space:nowrap}
.chat-suggestion-chip:hover{background:rgba(200,97,66,.12);border-color:var(--terracotta,#C86142);color:var(--terracotta,#C86142)}
.chatbot-input-row{padding:12px 14px;border-top:1px solid var(--border,#DFD9CE);display:flex;gap:8px;align-items:flex-end;background:var(--bg-card,#fff);flex-shrink:0}
.chatbot-input{flex:1;background:var(--bg-input,#fff);border:1px solid var(--border-strong,#CEC6B7);border-radius:20px;padding:9px 14px;font-family:var(--font-body,'Plus Jakarta Sans',sans-serif);font-size:13.5px;color:var(--text-primary,#151413);resize:none;outline:none;line-height:1.45;max-height:90px;overflow-y:auto;transition:border-color .18s}
.chatbot-input::placeholder{color:var(--text-muted,#7A756D)}
.chatbot-input:focus{border-color:var(--terracotta,#C86142)}
.chatbot-send-btn{width:36px;height:36px;border-radius:9999px;background:var(--terracotta,#C86142);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .18s,transform .18s}
.chatbot-send-btn:hover{background:var(--terracotta-hover,#B25235);transform:scale(1.08)}
.chatbot-send-btn:disabled{opacity:.45;cursor:not-allowed;transform:none}
.chatbot-footer-note{text-align:center;font-size:10.5px;color:var(--text-light,#A39D92);padding:6px 14px 10px;border-top:1px solid var(--border-subtle,#EBE5DB);letter-spacing:.02em;flex-shrink:0}
@media(max-width:480px){.chatbot-panel{right:12px;bottom:84px;width:calc(100vw - 24px);height:calc(100dvh - 110px);max-height:none}.chatbot-launcher{bottom:20px;right:16px}}
</style>

<!-- Launcher -->
<button
    class="chatbot-launcher"
    id="chatbotLauncher"
    aria-label="Open chat assistant"
    aria-expanded="false"
    aria-controls="chatbotPanel"
>
    <svg class="icon-chat" width="22" height="22" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         aria-hidden="true">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
    </svg>
    <svg class="icon-close-chat" width="20" height="20" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
         aria-hidden="true">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
    <span class="chat-notif-dot" aria-hidden="true"></span>
</button>

<!-- Panel -->
<div
    class="chatbot-panel"
    id="chatbotPanel"
    role="dialog"
    aria-modal="false"
    aria-label="DEVS Chat Assistant"
    aria-hidden="true"
>
    <div class="chatbot-header">
        <div class="chatbot-avatar" aria-hidden="true">&lt;/&gt;</div>
        <div class="chatbot-header-info">
            <div class="chatbot-header-name">DEVS Assistant</div>
            <div class="chatbot-header-status">
                <span class="chatbot-status-dot" aria-hidden="true"></span>
                Online — Ask me anything
            </div>
        </div>
        <button class="chatbot-header-close" id="chatbotClose" aria-label="Close chat" type="button">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                 aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <div class="chatbot-messages" id="chatbotMessages" role="log" aria-live="polite" aria-label="Chat messages">
    </div>

    <div class="chatbot-input-row">
        <textarea
            class="chatbot-input"
            id="chatbotInput"
            placeholder="Ask about our team, services…"
            rows="1"
            maxlength="400"
            aria-label="Type your message"
        ></textarea>
        <button class="chatbot-send-btn" id="chatbotSend" aria-label="Send message" type="button">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                 aria-hidden="true">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>

    <div class="chatbot-footer-note" aria-hidden="true">
        DEVS · CHMSU-Alijis IT Students · Ask about our team &amp; services
    </div>
</div>
