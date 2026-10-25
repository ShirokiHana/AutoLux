<style>
    .charcoal-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-block-start: 1em;
        padding: 0.9rem 2rem;
        border: 1px solid rgba(242, 182, 208, 0.18);
        border-radius: 24px 24px 0 0;
        background: linear-gradient(
                135deg,
                rgba(48, 43, 50, 0.88),
                rgba(27, 25, 30, 0.94) 60%,
                rgba(42, 32, 40, 0.88)
        );
        backdrop-filter: blur(20px) saturate(140%);
        -webkit-backdrop-filter: blur(20px) saturate(140%);
        box-shadow:
                0 8px 24px rgba(0, 0, 0, 0.25),
                0 0 20px rgba(242, 182, 208, 0.04),
                inset 0 1px 0 rgba(255, 255, 255, 0.08),
                inset 0 -1px 0 rgba(242, 182, 208, 0.04);
        font-family: inherit;
    }

    .charcoal-footer-brand {
        font-weight: 700;
        font-size: 0.88rem;
        color: #f2b6d0;
        letter-spacing: 0.05em;
    }

    .charcoal-footer-icons {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .charcoal-footer-icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: 1px solid rgba(242, 182, 208, 0.12);
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.035);
        color: #f2b6d0;
        text-decoration: none;
        font-family: monospace;
        font-weight: 700;
        font-size: 0.95rem;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
        transition:
                color 0.2s ease,
                background-color 0.2s ease,
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                transform 0.2s ease;
    }

    .charcoal-footer-icon-btn svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
    }

    .charcoal-footer-icon-btn:hover {
        color: #f2b6d0;
        background-color: rgba(242, 182, 208, 0.09);
        border-color: rgba(242, 182, 208, 0.4);
        transform: translateY(-2px);
        box-shadow:
                0 6px 16px rgba(0, 0, 0, 0.2),
                0 0 14px rgba(242, 182, 208, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }

    .charcoal-footer-icon-btn:focus-visible {
        outline: 2px solid #f2b6d0;
        outline-offset: 4px;
    }

    @media (prefers-reduced-motion: reduce) {
        .charcoal-footer-icon-btn {
            transition: none;
            transform: none;
        }
    }
</style>

<footer class="charcoal-footer">
    <span class="charcoal-footer-brand">† AutoLux †</span>

    <div class="charcoal-footer-icons">
        <!-- Source Code Link -->
        <a href="https://github.com/ShirokiHana/AutoLux" target="_blank" rel="noopener noreferrer" class="charcoal-footer-icon-btn" title="View
        Source">
            &lt;/&gt;
        </a>
        <!-- GitHub Link -->
        <a href="https://github.com/ShirokiHana" target="_blank" rel="noopener noreferrer" class="charcoal-footer-icon-btn" title="GitHub">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
            </svg>
        </a>
    </div>
</footer>

</body>
</html>