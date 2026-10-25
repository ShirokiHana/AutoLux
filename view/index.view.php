<?php view( 'components/header.php' ) ?>

    <h1>AutoLux</h1>

    <section>
        <h2>Store — PHP / MySQL</h2>
        <nav>
            <ul>
                <li><a href="/order">New order</a></li>
                <li><a href="/order/cart">Cart</a></li>
                <li><a href="/inventory">Inventory</a></li>
                <li><a href="/admin">Orders administration</a></li>
                <li><a href="/admin/clients">Clients</a></li>
            </ul>
        </nav>
    </section>

    <section>
        <h2>Warehouse — Node service</h2>
        <nav>
            <ul>
                <li><a href="/admin/suppliers">Suppliers</a></li>
                <li><a href="/management/order">Restock order</a></li>
            </ul>
        </nav>
    </section>

<?php view( 'components/footer.php' ) ?>