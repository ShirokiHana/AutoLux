<style>
    .kangel-footer {
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.9rem 2rem;
        margin-top: auto;
        border-radius: 28px 28px 0 0;
        background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.75) 0%,
                rgba(255, 214, 237, 0.5) 45%,
                rgba(189, 236, 255, 0.55) 100%
        );
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border-top: 1.5px solid rgba(255, 255, 255, 0.85);
        box-shadow:
                0 -12px 30px -8px rgba(255, 112, 166, 0.28),
                0 -6px 18px -4px rgba(112, 214, 255, 0.25),
                inset 0 1px 2px rgba(255, 255, 255, 0.85);
        font-family: 'Quicksand', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .kangel-footer-brand {
        font-weight: 700;
        font-size: 0.88rem;
        color: #4a385f;
        letter-spacing: 0.05em;
    }

    .kangel-footer-icons {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .kangel-footer-icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 9999px;
        border: 1.5px solid rgba(255, 255, 255, 0.85);
        background: rgba(255, 255, 255, 0.5);
        color: #4a385f;
        text-decoration: none;
        font-family: monospace;
        font-weight: 700;
        font-size: 0.95rem;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 12px rgba(255, 112, 166, 0.2);
        transition: all 0.25s ease;
    }

    .kangel-footer-icon-btn svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
    }

    .kangel-footer-icon-btn:hover {
        color: #ff3377;
        background: rgba(255, 255, 255, 0.9);
        border-color: rgba(255, 142, 188, 0.65);
        transform: translateY(-2px);
        box-shadow:
                0 8px 18px rgba(255, 112, 166, 0.4),
                0 3px 10px rgba(112, 214, 255, 0.35);
    }
</style>

<footer class="kangel-footer">
    <span class="kangel-footer-brand">† AutoLux • BLESS †</span>

    <div class="kangel-footer-icons">
        <!-- Source Code Link -->
        <a href="https://github.com/ShirokiHana/AutoLux" target="_blank" rel="noopener noreferrer" class="kangel-footer-icon-btn" title="View Source">
            &lt;/&gt;
        </a>
        <!-- GitHub Link -->
        <a href="https://github.com/ShirokiHana" target="_blank" rel="noopener noreferrer" class="kangel-footer-icon-btn" title="GitHub">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
            </svg>
        </a>
    </div>
</footer>

</body>
</html>