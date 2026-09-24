<form>
    <label for="">
        Add Item to Cart:
        <?php load( 'order/add/buildFilters.php', 'buildFilters', [ $data, $options ] ); ?>
    </label>
    <input type="submit" value="Add">
    <button>Info V</button>
</form>
<script>
    const selectors = <?= json_encode( $options ) ?>.map( element => document.querySelector( `#${element}` ) );

    selectors.forEach( element => element.addEventListener( 'change', ( eventObj ) => {
        const params = new URLSearchParams( window.location.search );
        params.set( eventObj.target.id, eventObj.target.value );
        window.location.search = params.toString();
        // sharable buying link, it's not a bug, it's a feature!

        // console.log( 'Params: ', [ ...params.entries() ].flat().map( element => element.replaceAll( ' ', '+' ) ) );
    }, false ) );
</script>

<!--http://localhost:3000/order?part_name=Cabin+Filter+R2420&brand=Bosch&part_type=Filter -->