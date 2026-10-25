<?php require_once basePath( 'view/components/header.php' ) ?>

    <style>
        .charcoal-error-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2.5rem 1.5rem;
            box-sizing: border-box;
        }

        .charcoal-error-card {
            position: relative;
            width: 100%;
            max-width: 480px;
            padding: 3rem 2.25rem 2.5rem;
            border: 1px solid rgba(242, 182, 208, 0.18);
            border-radius: 32px;
            background: linear-gradient(
                    135deg,
                    rgba(48, 43, 50, 0.92),
                    rgba(27, 25, 30, 0.96) 60%,
                    rgba(42, 32, 40, 0.92)
            );
            backdrop-filter: blur(22px) saturate(140%);
            -webkit-backdrop-filter: blur(22px) saturate(140%);
            box-shadow:
                    0 24px 48px -12px rgba(0, 0, 0, 0.35),
                    0 0 24px rgba(242, 182, 208, 0.06),
                    inset 0 1px 0 rgba(255, 255, 255, 0.08),
                    inset 0 -1px 0 rgba(242, 182, 208, 0.05);
            text-align: center;
            overflow: hidden;
            box-sizing: border-box;
        }

        /* Liquid specular reflection */
        .charcoal-error-card::before {
            content: "";
            position: absolute;
            top: -60%;
            left: -40%;
            width: 180%;
            height: 180%;
            background: radial-gradient(
                    circle at 35% 25%,
                    rgba(255, 255, 255, 0.08) 0%,
                    rgba(255, 255, 255, 0.02) 45%,
                    transparent 65%
            );
            pointer-events: none;
            transform: rotate(18deg);
        }

        .charcoal-error-tag {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #f2b6d0;
            background: rgba(242, 182, 208, 0.08);
            padding: 4px 14px;
            border-radius: 9999px;
            border: 1px solid rgba(242, 182, 208, 0.3);
            margin-bottom: 0.75rem;
        }

        .charcoal-error-code {
            margin: 0;
            font-size: 5.5rem;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #f2b6d0 0%, #ff85ad 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 4px 14px rgba(242, 182, 208, 0.25));
        }

        .charcoal-error-msg {
            margin: 1.25rem 0 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #eee7ed;
            line-height: 1.5;
            position: relative;
            z-index: 1;
            word-break: break-word;
        }

        .charcoal-home-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 2rem;
            border: 1px solid rgba(242, 182, 208, 0.35);
            border-radius: 9999px;
            background: rgba(242, 182, 208, 0.1);
            color: #f2b6d0;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            letter-spacing: 0.04em;
            position: relative;
            z-index: 1;
            box-shadow:
                    0 8px 24px rgba(0, 0, 0, 0.25),
                    0 0 14px rgba(242, 182, 208, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.08);
            transition:
                    color 0.2s ease,
                    background-color 0.2s ease,
                    border-color 0.2s ease,
                    box-shadow 0.2s ease,
                    transform 0.2s ease;
        }

        .charcoal-home-btn:hover {
            background-color: rgba(242, 182, 208, 0.18);
            border-color: rgba(242, 182, 208, 0.55);
            transform: translateY(-2px);
            box-shadow:
                    0 12px 30px rgba(0, 0, 0, 0.3),
                    0 0 18px rgba(242, 182, 208, 0.18),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .charcoal-home-btn:focus-visible {
            outline: 2px solid #f2b6d0;
            outline-offset: 4px;
        }

        @media (prefers-reduced-motion: reduce) {
            .charcoal-home-btn {
                transition: none;
                transform: none;
            }
        }
    </style>

    <div class="charcoal-error-container">
        <section class="charcoal-error-card">
            <span class="charcoal-error-tag">† SYSTEM OVERLOAD †</span>
            <h1 class="charcoal-error-code"><?= htmlspecialchars( (string) $attr['code'] ) ?>!</h1>
            <p class="charcoal-error-msg"><?= htmlspecialchars( (string) $attr['exception'] ) ?></p>
            <a href="/" class="charcoal-home-btn">Return Home</a>
        </section>
    </div>

<?php require_once basePath( 'view/components/footer.php' ) ?>