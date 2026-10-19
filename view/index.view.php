<?php view( 'components/header.php' ) ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap');

    .kangel-container {
        min-height: calc(100vh - 85px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem 1.5rem;
        box-sizing: border-box;
        background:
                radial-gradient(circle at 18% 22%, rgba(255, 142, 188, 0.45) 0%, transparent 45%),
                radial-gradient(circle at 82% 28%, rgba(112, 214, 255, 0.45) 0%, transparent 45%),
                radial-gradient(circle at 50% 80%, rgba(213, 187, 247, 0.4) 0%, transparent 50%),
                linear-gradient(135deg, #fff0f6 0%, #eef7ff 50%, #f7f0ff 100%);
        font-family: 'Quicksand', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* Liquid Glass Form */
    .kangel-glass-form {
        position: relative;
        width: 100%;
        max-width: 400px;
        padding: 2.75rem 2.25rem 2.5rem;
        border-radius: 32px;
        background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.72) 0%,
                rgba(255, 220, 238, 0.42) 40%,
                rgba(182, 232, 255, 0.45) 100%
        );
        backdrop-filter: blur(22px) saturate(190%);
        -webkit-backdrop-filter: blur(22px) saturate(190%);
        border: 1.5px solid rgba(255, 255, 255, 0.85);
        box-shadow:
                0 24px 48px -12px rgba(255, 112, 166, 0.28),
                0 12px 32px -8px rgba(112, 214, 255, 0.32),
                inset 0 2px 4px rgba(255, 255, 255, 0.95),
                inset 0 -2px 6px rgba(255, 142, 188, 0.2);
        box-sizing: border-box;
        overflow: hidden;
    }

    /* Liquid Specular Reflection */
    .kangel-glass-form::before {
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

    .kangel-tag {
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

    .kangel-glass-form h1 {
        margin: 0 0 1.75rem;
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        background: linear-gradient(135deg, #ff4785 0%, #a259ff 50%, #48bfe3 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 2px 8px rgba(255, 112, 166, 0.3));
    }

    .kangel-field {
        margin-bottom: 1.25rem;
        position: relative;
        z-index: 1;
    }

    .kangel-field label {
        display: block;
        font-size: 0.88rem;
        font-weight: 600;
        color: #4a385f;
        margin-bottom: 0.4rem;
        letter-spacing: 0.02em;
    }

    .kangel-field input[type="email"],
    .kangel-field input[type="password"] {
        width: 100%;
        padding: 0.85rem 1.15rem;
        border-radius: 16px;
        border: 1.5px solid rgba(255, 182, 218, 0.6);
        background: rgba(255, 255, 255, 0.6);
        color: #382947;
        font-family: inherit;
        font-size: 0.95rem;
        box-sizing: border-box;
        outline: none;
        transition: all 0.25s ease;
        backdrop-filter: blur(8px);
    }

    .kangel-field input:focus {
        background: rgba(255, 255, 255, 0.85);
        border-color: #ff70a6;
        box-shadow:
                0 0 0 4px rgba(255, 112, 166, 0.22),
                0 0 16px rgba(112, 214, 255, 0.45);
    }

    .kangel-error {
        margin: 0.4rem 0 0;
        font-size: 0.82rem;
        font-weight: 600;
        color: #d61e5c;
        background: rgba(255, 92, 141, 0.15);
        border: 1px solid rgba(255, 92, 141, 0.35);
        border-radius: 10px;
        padding: 6px 10px;
    }

    /* KAngel Glossy Liquid Button */
    .kangel-submit-btn {
        width: 100%;
        margin-top: 0.75rem;
        padding: 0.9rem 1.5rem;
        border-radius: 9999px;
        border: 1.5px solid rgba(255, 255, 255, 0.85);
        background: linear-gradient(135deg, #ff70a6 0%, #ff8fb1 45%, #70d6ff 100%);
        color: #ffffff;
        font-family: inherit;
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        cursor: pointer;
        position: relative;
        z-index: 1;
        box-shadow:
                0 8px 24px rgba(255, 112, 166, 0.45),
                0 4px 12px rgba(112, 214, 255, 0.4),
                inset 0 1px 2px rgba(255, 255, 255, 0.8);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .kangel-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow:
                0 12px 30px rgba(255, 112, 166, 0.6),
                0 6px 18px rgba(112, 214, 255, 0.5),
                inset 0 1px 3px rgba(255, 255, 255, 0.95);
    }

    .kangel-submit-btn:active {
        transform: translateY(1px);
    }
</style>

<div class="kangel-container">
    <form action="/login" method="POST" class="kangel-glass-form">
        <div style="text-align: center;">
            <span class="kangel-tag">† AUTOLUX †</span>
        </div>

        <h1>Hello! ♡</h1>

        <div class="kangel-field">
            <label for="login-email">E-mail</label>
            <input type="email" name="login-email" id="login-email" placeholder="angel@kawaii.net">
            <?php if ( isset( $errors['email'] ) ) : ?>
                <p class="kangel-error"><?= htmlspecialchars( $errors['email'] ) ?></p>
            <?php endif; ?>
        </div>

        <div class="kangel-field">
            <label for="login-password">Password</label>
            <input type="password" name="login-password" id="login-password" placeholder="••••••••">
            <?php if ( isset( $errors['password'] ) ) : ?>
                <p class="kangel-error"><?= htmlspecialchars( $errors['password'] ) ?></p>
            <?php endif; ?>
        </div>

        <input type="submit" value="Log in! ✨" class="kangel-submit-btn">
    </form>
</div>

<?php view( 'components/footer.php' ) ?>