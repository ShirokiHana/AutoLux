<?php use lib\FnArray;

require_once basePath( 'view/components/header.php' ) ?>

    <h1>Orders</h1>
    <form action="/order/cart" method="POST">
        <label for="">
            <select>
                <?php FnArray::map( $attr[ 'clients' ], function( $name ) { ?>
                    <option value=""><?= $name[ 'client_name' ] ?></option>
                <?php } ) ?>
            </select>
        </label>
        <input type="submit" value="Select this client">
    </form>
    <a href="/order/new">Add new client!</a>

<?php require_once basePath( 'view/components/footer.php' ) ?>