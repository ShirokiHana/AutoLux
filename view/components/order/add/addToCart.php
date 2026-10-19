<?php use lib\FnArray;
$addToCartSelectors = array_keys( FnArray::removeKey( $data[ 0 ], 'part_id' ) ); ?>
<form action="/order/cart" method="POST">
    <label for="">
        Add Item to Cart:
        <?php load( 'order/add/buildFilters.php', 'buildFilters', [ $data ] ); ?>
    </label>
    <input type="submit" value="Add">
    <input type="hidden" name="__method" value="PUT">
</form>
<script>
    const addToCartSelectors = <?= json_encode( $addToCartSelectors ) ?>.map( element => document.querySelector( `#${element}` ) );

    addToCartSelectors.forEach( element => element.addEventListener( 'change', ( eventObj ) => {
        query( { [ eventObj.target.id ]: eventObj.target.value } )
        // sharable buying link, it's not a bug, it's a feature!

        // console.log( 'Params: ', [ ...params.entries() ].flat().map( element => element.replaceAll( ' ', '+' ) ) );
    }, false ) );
</script>

<!--http://localhost:3000/order?part_name=Cabin+Filter+R2420&brand=Bosch&part_type=Filter -->