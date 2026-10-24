<?php

    use core\CartHelper;
    use lib\FnArray;

    $cart = FnArray::map(
            $attr[ 'cart' ],
            fn( $part ) => [ ...$part, 'price' => CartHelper::fetchPartPrice( $part[ 'part_id' ] ) ]
    );

    $buildCartSelectors = FnArray::map( $attr[ 'cartOptions' ], fn( $element ) => 'sortParts' . formatStringLabel( $element ) )
?>

<table id="renderedTable" style="border: 1px solid;">
    <thead>
        <tr style="border: 1px solid;">
            <?php FnArray::map( $attr[ 'cartOptions' ], function( $element ) { ?>
                <th style="border: 1px solid; padding: .5em">
                    <span><?= formatStringLabel( $element ) ?></span>
                    <button
                            id="sortParts<?= formatStringLabel( $element ) ?>"
                            data-column="<?= formatStringLabel( $element ) ?>"
                    >&#8645;</button>
                </th>
            <?php } ) ?>
            <?php if ( isset( $attr[ 'extraOptions' ] ) ) { ?>
                <th style="border: 1px solid; padding: .5em">Actions</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
    <?php load( 'order/cart/renderCart.php', 'renderCart', [ $cart, $attr[ 'cartOptions' ], $attr[ 'extraOptions' ] ?? null ] ); ?>
    </tbody>
</table>
<script>
    const buildCartSelectors = <?= json_encode( $buildCartSelectors ) ?>.map( id => document.getElementById( id ) );
    const renderedTable = document.querySelector( '#renderedTable tbody' );

    const sortBy = ( column, direction ) => ( a, b ) =>
        a.cells[ column ].textContent.localeCompare(
            b.cells[ column ].textContent,
            undefined,
            { numeric: true, sensitivity: 'base' }
        ) * direction;

    buildCartSelectors.forEach( ( element, column ) => {
        let direction = 1;

        element.addEventListener( 'click', ( eventObj ) => {
            eventObj.preventDefault();
            const rows = [ ...renderedTable.rows ];

            rows.sort( sortBy( column, direction ) );
            direction *= -1;

            rows.forEach( row => renderedTable.appendChild( row ) );
        } );
    } );
</script>