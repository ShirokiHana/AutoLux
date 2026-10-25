<?php use lib\FnArray;

    if ( empty( $attr[ 'data' ] ) ) { ?>
        <p>No supplier</p>
        <?php return;
    }

    $addToCartSelectors = array_keys( FnArray::removeKey( $attr[ 'data' ][ 0 ], 'part_id' ) ); ?>

    <form action="<?= $attr[ 'target' ] ?>" method="POST">
        <label for="">
            Add Item to Cart:
            <?php load( 'order/add/buildFilters.php', 'buildFilters', [ $attr[ 'data' ] ] ); ?>
        </label>
        <label>
            Quantity:
            <input type="number" name="quantity" min="0" step="1" value="0">
        </label>
        <input type="submit" value="Add">
        <input type="hidden" name="__method" value="PUT">
    </form>
    <script>
        const addToCartSelectors = <?= json_encode( $addToCartSelectors ) ?>.map( element => document.querySelector( `#${element}` ) );

        addToCartSelectors.forEach( element => element.addEventListener( 'change', ( eventObj ) => {
            query( { [ eventObj.target.id ]: eventObj.target.value } )

            // console.log( 'Params: ', [ ...params.entries() ].flat().map( element => element.replaceAll( ' ', '+' ) ) );
        }, false ) );
    </script>

<!--http://localhost:3000/order?part_name=Cabin+Filter+R2420&brand=Bosch&part_type=Filter -->