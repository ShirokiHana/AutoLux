<style>
    .charcoal-navbar {
        position: sticky;
        top: 0;
        margin-block-end: 1em;
        border-radius: 0 0 24px 24px;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 1.75rem;
        border: 1px solid rgba(242, 182, 208, 0.18);
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
        margin-inline: -1em;
    }

    .charcoal-nav-list {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        list-style: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .charcoal-nav-links {
        display: flex;
        flex: 1;
        justify-content: space-evenly;
        align-items: center;
        gap: 0.5rem;
    }

    .charcoal-nav-link,
    .charcoal-return {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(242, 182, 208, 0.12);
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.035);
        color: #eee7ed;
        text-decoration: none;
        font-weight: 700;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
        transition:
                color 0.2s ease,
                background-color 0.2s ease,
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                transform 0.2s ease;
    }

    .charcoal-nav-link {
        padding: 0.55rem 1.25rem;
        font-size: 0.95rem;
        letter-spacing: 0.03em;
    }

    .charcoal-return {
        gap: 4px;
        padding: 0.5rem 1.1rem;
        color: #f2b6d0;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .charcoal-nav-link:hover,
    .charcoal-return:hover {
        color: #f2b6d0;
        background-color: rgba(242, 182, 208, 0.09);
        border-color: rgba(242, 182, 208, 0.4);
        transform: translateY(-2px);
        box-shadow:
                0 6px 16px rgba(0, 0, 0, 0.2),
                0 0 14px rgba(242, 182, 208, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }

    .charcoal-nav-link:focus-visible,
    .charcoal-return:focus-visible {
        outline: 2px solid #f2b6d0;
        outline-offset: 4px;
    }

    @media (prefers-reduced-motion: reduce) {
        .charcoal-nav-link,
        .charcoal-return {
            transition: none;
            transform: none;
        }
    }
</style>

<nav class="charcoal-navbar">
    <ul class="charcoal-nav-list">
        <li>
            <?php view( 'components/goBackButton.php' ) ?>
        </li>
        <div class="charcoal-nav-links">
            <li><a class="charcoal-nav-link" href="/">Home</a></li>
            <li><a class="charcoal-nav-link" href="/order">Order</a></li>
            <li><a class="charcoal-nav-link" href="/inventory">Management</a></li>
            <li><a class="charcoal-nav-link" href="/admin/clients">Clients</a></li>
            <li><a class="charcoal-nav-link" href="/admin">Admin</a></li>
            <li><a class="charcoal-nav-link" href="/management/order">Restock</a></li>
            <li><a class="charcoal-nav-link" href="/admin/suppliers">Suppliers</a></li>
        </div>
    </ul>
</nav>