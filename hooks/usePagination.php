<?php
    // TODO: Finish.

    function usePagination( int $currentPage, int $total, int $limit ) : array {
        $maxPage = max( 1, ( int ) ceil( $total / $limit ) );
        $page = min( $currentPage, $maxPage );
        $offset = ( $page - 1 ) * $limit;

        return [ $maxPage, $page, $offset ];
    }