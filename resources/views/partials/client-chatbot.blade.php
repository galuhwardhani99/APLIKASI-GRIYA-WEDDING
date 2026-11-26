<style>
    /* Floating Chatbot Griya Rias Elly Jr. */
    .gr-chat-launcher-wrap {
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 1050;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Custom Tooltip di Sebelah Kiri Tombol */
    .gr-chat-tooltip {
        position: relative;
        background: #241A16;
        color: #FDFBF7;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 999px;
        white-space: nowrap;
        box-shadow: 0 8px 20px rgba(36, 26, 22, 0.22);
        border: 1px solid rgba(197, 143, 67, 0.35);
        opacity: 0;
        transform: translateX(10px);
        pointer-events: none;
        transition: opacity 0.25s ease, transform 0.25s ease;
    }
    .gr-chat-tooltip::after {
        content: "";
        position: absolute;
        right: -5px;
        top: 50%;
        transform: translateY(-50%) rotate(45deg);
        width: 10px;
        height: 10px;
        background: #241A16;
        border-right: 1px solid rgba(197, 143, 67, 0.35);
        border-top: 1px solid rgba(197, 143, 67, 0.35);
    }
    .gr-chat-launcher-wrap:hover .gr-chat-tooltip {
        opacity: 1;
        transform: translateX(0);
    }

    .gr-chat-launcher {
        position: relative;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: none;
        background: linear-gradient(135deg, #C58F43 0%, #A87632 100%);
        color: #FFFFFF;
        font-size: 1.35rem;
        cursor: pointer;
        box-shadow: 0 10px 25px rgba(168, 118, 50, 0.38);
        display: grid;
        place-items: center;
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease;
    }
    .gr-chat-launcher::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 2px solid #C58F43;
        animation: grPulseRing 2.6s infinite ease-out;
        pointer-events: none;
    }
    @keyframes grPulseRing {
        0% { transform: scale(1); opacity: 0.65; }
        75% { transform: scale(1.38); opacity: 0; }
        100% { transform: scale(1.38); opacity: 0; }
    }

    .gr-chat-launcher i {
        transition: transform 0.25s ease;
    }
    .gr-chat-launcher:hover {
        transform: translateY(-3px) scale(1.06);
        box-shadow: 0 14px 30px rgba(168, 118, 50, 0.48);
    }
    .gr-chat-launcher:hover i {
        transform: rotate(-10deg) scale(1.08);
    }
    .gr-chat-launcher:active {
        transform: scale(0.95);
    }

    .gr-chat-window {
        position: fixed;
        right: 24px;
        bottom: 92px;
        z-index: 1050;
        width: min(355px, calc(100vw - 32px));
        height: 470px;
        background: #FDFBF7;
        border: 1px solid #D8CEC0;
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(36, 26, 22, 0.22);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        font-family: 'Plus Jakarta Sans', sans-serif;
        animation: grChatFadeIn 0.22s ease-out;
    }
    .gr-chat-window[hidden] {
        display: none;
    }
    @keyframes grChatFadeIn {
        from { opacity: 0; transform: translateY(12px) scale(0.97); }
        to { opacity: 1; transform: none; }
    }

    .gr-chat-header {
        flex-shrink: 0;
        background: linear-gradient(135deg, #C58F43 0%, #A87632 100%);
        color: #FFFFFF;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .gr-chat-header-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .gr-chat-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #FDFBF7;
        border: 1.5px solid rgba(255, 255, 255, 0.75);
        display: grid;
        place-items: center;
        flex-shrink: 0;
        color: #A87632;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.02em;
        box-shadow: 0 2px 6px rgba(36, 26, 22, 0.15);
    }
    .gr-chat-title {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }
    .gr-chat-sub {
        font-size: 0.72rem;
        opacity: 0.9;
    }
    .gr-chat-close {
        background: transparent;
        border: none;
        color: #FFFFFF;
        font-size: 1.1rem;
        cursor: pointer;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        transition: background 0.15s;
    }
    .gr-chat-close:hover {
        background: rgba(255, 255, 255, 0.18);
    }

    /* Area Percakapan dengan Scrollbar Selalu Aktif & Rapi */
    .gr-chat-body {
        flex: 1;
        min-height: 0;
        padding: 14px;
        overflow-y: scroll;
        scroll-behavior: smooth;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background-color: #FAF6F0;
        background-image: radial-gradient(#E6DDD0 1px, transparent 1px);
        background-size: 16px 16px;
        scrollbar-width: thin;
        scrollbar-color: #C58F43 #EFE8DE;
    }
    .gr-chat-body::-webkit-scrollbar {
        width: 6px;
    }
    .gr-chat-body::-webkit-scrollbar-track {
        background: #EFE8DE;
        border-radius: 999px;
    }
    .gr-chat-body::-webkit-scrollbar-thumb {
        background: #C58F43;
        border-radius: 999px;
    }
    .gr-chat-body::-webkit-scrollbar-thumb:hover {
        background: #A87632;
    }

    .gr-msg {
        flex-shrink: 0;
        max-width: 85%;
        padding: 11px 14px;
        border-radius: 16px;
        font-size: 0.83rem;
        line-height: 1.48;
        white-space: pre-line;
        word-wrap: break-word;
    }
    .gr-msg-bot {
        align-self: flex-start;
        background: #FFFFFF;
        color: #241A16;
        border: 1px solid #EFE8DE;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 6px rgba(36, 26, 22, 0.04);
    }
    .gr-msg-user {
        align-self: flex-end;
        background: #C58F43;
        color: #FFFFFF;
        border-bottom-right-radius: 4px;
        box-shadow: 0 2px 6px rgba(197, 143, 67, 0.25);
    }

    /* Kartu Selamat Datang Menyatu dengan Daftar Topik & Panah */
    .gr-welcome-card {
        flex-shrink: 0;
        align-self: flex-start;
        width: 92%;
        background: #FFFFFF;
        border: 1px solid #EFE8DE;
        border-radius: 16px;
        border-bottom-left-radius: 4px;
        box-shadow: 0 3px 10px rgba(36, 26, 22, 0.05);
        overflow: hidden;
    }
    .gr-welcome-text {
        padding: 13px 15px 11px;
        font-size: 0.83rem;
        line-height: 1.5;
        color: #241A16;
    }
    .gr-topic-list {
        display: flex;
        flex-direction: column;
        border-top: 1px solid #F2ECE4;
    }
    .gr-topic-item {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 1px solid #F5EFE7;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        text-align: left;
        font-family: inherit;
        font-size: 0.81rem;
        font-weight: 600;
        color: #9E6B24;
        cursor: pointer;
        transition: background-color 0.16s ease, color 0.16s ease, padding-left 0.16s ease;
    }
    .gr-topic-item:last-child {
        border-bottom: none;
    }
    .gr-topic-item i {
        font-size: 0.72rem;
        color: #C58F43;
        flex-shrink: 0;
        transition: transform 0.16s ease;
    }
    .gr-topic-item:hover {
        background-color: #FBF5EC;
        color: #7C5116;
        padding-left: 18px;
    }
    .gr-topic-item:hover i {
        transform: translateX(3px);
    }
    .gr-welcome-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 7px 15px 9px;
        background: #FCF9F4;
        border-top: 1px solid #F2ECE4;
        font-size: 0.69rem;
        color: #8C8279;
    }

    .gr-chat-footer {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        background: #FFFFFF;
        border-top: 1px solid #EFE8DE;
    }
    .gr-chat-input {
        flex: 1;
        border: 1px solid #E2D9CC;
        border-radius: 999px;
        padding: 9px 14px;
        font-size: 0.83rem;
        font-family: inherit;
        color: #241A16;
        background: #FDFBF7;
        outline: none;
    }
    .gr-chat-input:focus {
        border-color: #C58F43;
    }
    .gr-chat-send {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: #C58F43;
        color: #FFFFFF;
        cursor: pointer;
        display: grid;
        place-items: center;
        font-size: 0.85rem;
        transition: background 0.2s;
    }
    .gr-chat-send:hover:not(:disabled) {
        background: #A87632;
    }
    .gr-chat-send:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

{{-- Tombol Floating Kanan Bawah + Custom Tooltip --}}
<div class="gr-chat-launcher-wrap">
    <span class="gr-chat-tooltip">Tanya Asisten WO &amp; EO ✨</span>
    <button type="button" class="gr-chat-launcher" id="grChatLauncher" aria-label="Buka ChatBot">
        <i class="fa-solid fa-comments" id="grChatLauncherIcon"></i>
    </button>
</div>

{{-- Jendela ChatBox Floating --}}
<div class="gr-chat-window" id="grChatWindow" hidden>
    <div class="gr-chat-header">
        <div class="gr-chat-header-info">
            <div class="gr-chat-avatar">EJ</div>
            <div>
                <h4 class="gr-chat-title">Asisten Griya Rias</h4>
                <span class="gr-chat-sub">Tanya seputar WO, EO &amp; Rias</span>
            </div>
        </div>
        <button type="button" class="gr-chat-close" id="grChatClose" aria-label="Tutup">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="gr-chat-body" id="grChatBody">
        {{-- Kartu Selamat Datang Menyatu dengan Menu Pertanyaan + Panah --}}
        <div class="gr-welcome-card">
            <div class="gr-welcome-text">
                Selamat datang di <strong>Griya Rias Elly Jr.</strong> ✨<br>
                Ada yang bisa dibantu? Pilih topik di bawah atau ketik pertanyaan seputar layanan kami:
            </div>
            <div class="gr-topic-list" id="grQuickChips">
                <button type="button" class="gr-topic-item" data-q="Daftar paket rias dan harganya">
                    <span>Daftar paket rias dan harganya</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <button type="button" class="gr-topic-item" data-q="Bagaimana aturan jam rias dan jadwal acara?">
                    <span>Aturan durasi rias &amp; jadwal acara</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <button type="button" class="gr-topic-item" data-q="Cek tanggal dan slot jadwal yang tersedia">
                    <span>Cek ketersediaan tanggal &amp; slot jadwal</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <button type="button" class="gr-topic-item" data-q="Bagaimana cara reservasi dan pembayaran?">
                    <span>Cara reservasi &amp; pembayaran online</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            <div class="gr-welcome-meta">
                <span>Asisten Virtual Griya Rias</span>
                <span>24/7</span>
            </div>
        </div>
    </div>

    <form class="gr-chat-footer" id="grChatForm">
        <input type="text" class="gr-chat-input" id="grChatInput" placeholder="Ketik pertanyaan WO / EO..." autocomplete="off" required>
        <button type="submit" class="gr-chat-send" id="grChatSend" aria-label="Kirim">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const launcher = document.getElementById('grChatLauncher');
    const launcherIcon = document.getElementById('grChatLauncherIcon');
    const win = document.getElementById('grChatWindow');
    const closeBtn = document.getElementById('grChatClose');
    const form = document.getElementById('grChatForm');
    const input = document.getElementById('grChatInput');
    const sendBtn = document.getElementById('grChatSend');
    const body = document.getElementById('grChatBody');

    function toggleChat(forceState) {
        const isHidden = typeof forceState === 'boolean' ? !forceState : !win.hidden;
        win.hidden = isHidden;
        launcherIcon.className = isHidden ? 'fa-solid fa-comments' : 'fa-solid fa-xmark';
        if (!isHidden) {
            input.focus();
            body.scrollTop = body.scrollHeight;
        }
    }

    launcher.addEventListener('click', () => toggleChat());
    closeBtn.addEventListener('click', () => toggleChat(false));

    function appendMessage(text, sender) {
        const div = document.createElement('div');
        div.className = 'gr-msg ' + (sender === 'user' ? 'gr-msg-user' : 'gr-msg-bot');
        div.textContent = text;
        body.appendChild(div);
        body.scrollTop = body.scrollHeight;
        return div;
    }

    async function sendMessage(text) {
        const cleanText = text.trim();
        if (!cleanText) return;

        appendMessage(cleanText, 'user');
        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;

        const typingEl = appendMessage('Sedang mengetik...', 'bot');

        try {
            const response = await fetch('{{ route("client.chatbot.ask") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: cleanText })
            });

            const data = await response.json();

            if (!response.ok) {
                typingEl.textContent = 'Error (' + response.status + '): ' + (data.message || 'Gagal memproses permintaan.');
            } else {
                typingEl.textContent = data.reply || 'Maaf saya tidak dilatih untuk itu, coba keyword lain';
            }
        } catch (err) {
            typingEl.textContent = 'Maaf, terjadi gangguan koneksi. Silakan coba lagi.';
        } finally {
            input.disabled = false;
            sendBtn.disabled = false;
            input.focus();
            body.scrollTop = body.scrollHeight;
        }
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        sendMessage(input.value);
    });

    document.querySelectorAll('#grQuickChips .gr-topic-item').forEach(item => {
        item.addEventListener('click', () => sendMessage(item.dataset.q));
    });
});
</script>