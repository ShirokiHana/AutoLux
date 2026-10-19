<?php require_once basePath( 'view/components/header.php' ) ?>
<?php
    use core\SessionHelper;
    $errors = SessionHelper::getFlash( 'errors' );
    $old = SessionHelper::getFlash( 'old' );
?>

    <h1>New client</h1>
    <form action="/order/new" method="POST">
        <label for="">
            Name
            <input type="text" name="new-client-name" value="<?= htmlspecialchars( $old[ 'new-client-name' ] ?? '' ) ?>">
            <?php if ( isset( $errors[ 'new-client-name' ] ) ): ?>
                <small class="error"><?= htmlspecialchars( $errors[ 'new-client-name' ] ) ?></small>
            <?php endif; ?>
        </label>
        <br>
        <label for="">
            Phone #
            <input type="text" name="new-client-phone" id="" value="<?= htmlspecialchars( $old[ 'new-client-phone' ] ?? '' ) ?>">
            <?php if ( isset( $errors[ 'new-client-phone' ] ) ): ?>
                <small class="error"><?= htmlspecialchars( $errors[ 'new-client-phone' ] ) ?></small>
            <?php endif; ?>
        </label>
        <br>
        <label for="">
            E-mail
            <input type="text" name="new-client-email" id="" value="<?= htmlspecialchars( $old[ 'new-client-email' ] ?? '' ) ?>">
            <?php if ( isset( $errors[ 'new-client-email' ] ) ): ?>
                <small class="error"><?= htmlspecialchars( $errors[ 'new-client-email' ] ) ?></small>
            <?php endif; ?>
        </label>
        <br>
        <input type="submit" value="Add this client!">
    </form>

<?php require_once basePath( 'view/components/footer.php' ) ?>