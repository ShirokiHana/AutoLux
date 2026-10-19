<style>
    .kangel-navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 1.75rem;
        border-radius: 0 0 28px 28px;
        background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.75) 0%,
                rgba(255, 214, 237, 0.5) 45%,
                rgba(189, 236, 255, 0.55) 100%
        );
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border-bottom: 1.5px solid rgba(255, 255, 255, 0.85);
        box-shadow:
                0 14px 34px -10px rgba(255, 112, 166, 0.35),
                0 8px 22px -6px rgba(112, 214, 255, 0.3),
                inset 0 -1px 2px rgba(255, 255, 255, 0.7);
        font-family: 'Quicksand', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .kangel-nav-list {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        list-style: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .kangel-nav-links {
        display: flex;
        flex: 1;
        justify-content: space-evenly;
        align-items: center;
        gap: 0.5rem;
    }

    .kangel-nav-link {
        color: #4a385f;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.03em;
        padding: 0.55rem 1.25rem;
        border-radius: 9999px;
        border: 1px solid transparent;
        background: rgba(255, 255, 255, 0.25);
        transition: all 0.25s ease;
        display: inline-block;
    }

    .kangel-nav-link:hover {
        color: #ff3377;
        background: rgba(255, 255, 255, 0.8);
        border-color: rgba(255, 142, 188, 0.6);
        transform: translateY(-2px);
        box-shadow:
                0 6px 16px rgba(255, 112, 166, 0.3),
                0 2px 8px rgba(112, 214, 255, 0.3);
    }
</style>

<nav class="kangel-navbar">
    <ul class="kangel-nav-list">
        <li>
            <?php view( 'components/goBackButton.php' ) ?>
        </li>
        <div class="kangel-nav-links">
            <li><a class="kangel-nav-link" href="/">Home ♡</a></li>
            <li><a class="kangel-nav-link" href="/inventory">Management ✨</a></li>
            <li><a class="kangel-nav-link" href="/order">Order ✧</a></li>
            <li><a class="kangel-nav-link" href="/management/order">Restock ☁</a></li>
            <li><a class="kangel-nav-link" href="/admin">Admin ☁</a></li>
            <li><a class="kangel-nav-link" href="/admin/clients">Clients ♡</a></li>
            <li><a class="kangel-nav-link" href="/admin/suppliers">Suppliers ✧</a></li>
        </div>
    </ul>
</nav>