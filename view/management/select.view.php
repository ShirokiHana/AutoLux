<?php

    require_once basePath( 'view/components/header.php' ) ?>

        <?php foreach ( $errors as $message ): ?>
            <p style="color:#b00020"><?= htmlspecialchars( $message ) ?></p>
        <?php endforeach; ?>
        <?= $html ?>

    <?php require_once basePath( 'view/components/footer.php' ) ?>