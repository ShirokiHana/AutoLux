<?php
use core\SessionHelper; ?>
    <a href="<?= htmlspecialchars( SessionHelper::get( 'navigation' )[ 'back' ] ?? '/' ) ?>" class="charcoal-return">
        ← Return
    </a>