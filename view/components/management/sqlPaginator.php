<?php

use lib\FnArray;

function buildPagination(int $step, string $uri ) : void {
    if ( $step < 1 )
        return;
    $url = htmlspecialchars( $uri . buildQuery( [ 'page' => $step ] ) );
    echo "<a href='$url'>$step</a> ";
    buildPagination( $step - 1, $uri );
}

function sqlPaginator( int $page, int $maxPage, string $uri, int $limit ) : void { ?>
        <form action="" method="GET">
            <a href=
               "<?= htmlspecialchars( $uri . buildQuery( [ 'page' => max( 1, $page - 1 ) ] ) ) ?>"
            ><</a>

            <?php buildPagination( $maxPage, $uri ); ?>

            <a href=
               "<?= htmlspecialchars( $uri . buildQuery( [ 'page' => min( $maxPage, $page + 1 ) ] ) ) ?>"
            >></a>

            <label for="">
                Display:
                <select data-param="view-limit">

                    <?php FnArray::map( array_unique( [ 12, 24, 36, $limit ] ), function( $value ) use ( $limit ) { ?>
                        <option value="<?= $value ?>" <?= $value === $limit
                            ? 'selected'
                            : '' ?> ><?= $value ?></option>
                    <?php } ) ?>

                </select>
            </label>
        </form>
    <?php } ?>