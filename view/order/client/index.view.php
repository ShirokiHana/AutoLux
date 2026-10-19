<?php use lib\FnArray;

require_once basePath( 'view/components/header.php' ) ?>

    <h1>Orders</h1>

    <ul style="display: flex; list-style-type: none">
        <?php FnArray::map( $attr[ 'letters' ], function( $element ) { ?>
            <li style="margin-inline: .25em"><a href="/order?index=<?= strtolower( $element ) ?>"><?= $element ?></a></li>
        <?php } ) ?>
    </ul>

    <?php if( !empty( $attr[ 'clients' ] ) ) { ?>
    <form action="/order/cart" method="POST">
        <label for="">
            <select name="client">
                <?php FnArray::map( $attr[ 'clients' ], function( $name ) { ?>
                    <option value="<?= $name[ 'client_id' ] ?>"><?= $name[ 'client_name' ] ?></option>
                <?php } ) ?>
            </select>
        </label>
        <input type="submit" value="Select this client">
    </form>
    <?php } else { ?>
        <p>No clients match!</p>
    <?php } ?>

    <a href="/order/new">Add new client!</a>

<?php require_once basePath( 'view/components/footer.php' ) ?>