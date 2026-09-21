<h2>Shopping cart:</h2>
<table style="border: 1px solid;">
    <tr style="border: 1px solid;">
        <th style="border: 1px solid;">Type</th>
        <th style="border: 1px solid;">Brand</th>
        <th style="border: 1px solid;">Name</th>
    </tr>

    <?php load( 'order/renderCart.php', 'renderCart', [ $data, $options ] ); ?>
</table>