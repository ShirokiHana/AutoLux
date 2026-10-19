<?php use lib\FnArray;

    // field => label, the form keeps the fields that sanitizeClient reads
    // for display
    $fields = [
        'new-client-name' => [ 'Name', 'client_name' ],
        'new-client-phone' => [ 'Phone #', 'phone' ],
        'new-client-email' => [ 'E-mail', 'email' ],
    ];

require_once basePath( 'view/components/header.php' ) ?>

    <h1>Edit client #<?= $client[ 'client_id' ] ?></h1>

    <form action="/admin/clients/<?= $client[ 'client_id' ] ?>" method="POST">
        <input type="hidden" name="__method" value="PATCH">

        <?php FnArray::map( array_keys( $fields ), function( $name ) use ( $fields, $client, $old, $errors ) {
            [ $label, $column ] = $fields[ $name ]; ?>
            <label>
                <?= $label ?>
                <input type="text" name="<?= $name ?>" value="<?= htmlspecialchars( $old[ $name ] ?? $client[ $column ] ) ?>">
                <?php if ( isset( $errors[ $name ] ) ) { ?>
                    <small class="error"><?= htmlspecialchars( $errors[ $name ] ) ?></small>
                <?php } ?>
            </label>
            <br>
        <?php } ) ?>

        <input type="submit" value="Save">
        <a href="/admin/clients">Cancel</a>
    </form>

<?php require_once basePath( 'view/components/footer.php' ) ?>