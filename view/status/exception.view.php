<?php require_once basePath( 'view/components/header.php' ) ?>

    <style>
        .kangel-error-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2.5rem 1.5rem;
            box-sizing: border-box;
        }

        .kangel-error-card {
            position: relative;
            width: 100%;
            max-width: 480px;
            padding: 3rem 2.25rem 2.5rem;
            border-radius: 32px;
            background: linear-gradient(
                    135deg,
                    rgba(255, 255, 255, 0.72) 0%,
                    rgba(255, 220, 238, 0.45) 45%,
                    rgba(182, 232, 255, 0.45) 100%
            );
            backdrop-filter: blur(22px) saturate(190%);
            -webkit-backdrop-filter: blur(22px) saturate(190%);
            border: 1.5px solid rgba(255, 255, 255, 0.85);
            box-shadow:
                    0 24px 48px -12px rgba(255, 112, 166, 0.3),
                    0 12px 32px -8px rgba(112, 214, 255, 0.35),
                    inset 0 2px 4px rgba(255, 255, 255, 0.95),
                    inset 0 -2px 6px rgba(255, 142, 188, 0.2);
            text-align: center;
            overflow: hidden;
            box-sizing: border-box;
        }

        /* Liquid Specular Reflection */
        .kangel-error-card::before {
            content: "";
            position: absolute;
            top: -60%;
            left: -40%;
            width: 180%;
            height: 180%;
            background: radial-gradient(
                    circle at 35% 25%,
                    rgba(255, 255, 255, 0.6) 0%,
                    rgba(255, 255, 255, 0.08) 45%,
                    transparent 65%
            );
            pointer-events: none;
            transform: rotate(18deg);
        }

        .kangel-error-tag {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #ff5596;
            background: rgba(255, 255, 255, 0.65);
            padding: 4px 14px;
            border-radius: 9999px;
            border: 1px solid rgba(255, 112, 166, 0.3);
            margin-bottom: 0.75rem;
        }

        .kangel-error-code {
            margin: 0;
            font-size: 5.5rem;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #ff4785 0%, #a259ff 50%, #48bfe3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 4px 14px rgba(255, 112, 166, 0.35));
        }

        .kangel-error-msg {
            margin: 1.25rem 0 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #4a385f;
            line-height: 1.5;
            position: relative;
            z-index: 1;
            word-break: break-word;
        }

        .kangel-home-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 2rem;
            border-radius: 9999px;
            border: 1.5px solid rgba(255, 255, 255, 0.85);
            background: linear-gradient(135deg, #ff70a6 0%, #ff8fb1 45%, #70d6ff 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            letter-spacing: 0.04em;
            position: relative;
            z-index: 1;
            box-shadow:
                    0 8px 24px rgba(255, 112, 166, 0.4),
                    0 4px 12px rgba(112, 214, 255, 0.35),
                    inset 0 1px 2px rgba(255, 255, 255, 0.8);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kangel-home-btn:hover {
            transform: translateY(-2px);
            box-shadow:
                    0 12px 30px rgba(255, 112, 166, 0.55),
                    0 6px 18px rgba(112, 214, 255, 0.45),
                    inset 0 1px 3px rgba(255, 255, 255, 0.95);
        }
    </style>

    <div class="kangel-error-container">
        <section class="kangel-error-card">
            <span class="kangel-error-tag">† SYSTEM OVERDOSE †</span>
            <h1 class="kangel-error-code"><?= htmlspecialchars( (string) $attr['code'] ) ?>!</h1>
            <p class="kangel-error-msg"><?= htmlspecialchars( (string) $attr['exception'] ) ?></p>
            <a href="/" class="kangel-home-btn">Return Home ♡</a>
        </section>
    </div>

<?php require_once basePath( 'view/components/footer.php' ) ?>