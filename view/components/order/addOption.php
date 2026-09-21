<?php

use lib\FnArray;

function addOption( array $data, string $option, string $selected ) : void { ?>
    <label for="">
        <select name="<?= $option ?>" id="<?= $option ?>">
            <?php FnArray::map( $data, function( $element ) use ( $selected ) { ?>
                <option value="<?= $element ?>" <?= $element === $selected ? 'selected' : '' ?>><?= $element ?></option>
            <?php } ); ?>
        </select>
    </label>
<?php } ?>