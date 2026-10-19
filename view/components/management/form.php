<?php

use core\SessionHelper;

function managementForm( array $request ) : void {

        $errors = SessionHelper::getFlash( 'errors' );
        $old = SessionHelper::getFlash( 'old' );
        $e = fn( string $key ) : string => isset( $errors[ $key ] )
            ? '<small class="error">' . htmlspecialchars( $errors[ $key ] ) . '</small>'
            : '';

        // TODO: Pass $request ✅
        $limit = ( int ) $request[ 'view-limit' ];
        $filter = $request[ 'inventory-filter' ] ?? 'brand';
        $range = ( int ) ( $request[ 'inventory-filter-range' ] ?? 300 );
        $search = htmlspecialchars( $old[ 'input-search' ] ?? $request[ 'input-search' ] ?? '' );

        $brandSelected = $filter === 'brand' ? 'selected' : '';
        $typeSelected = $filter === 'part_type' ? 'selected' : '';

        $filterError = $e( 'inventory-filter' );
        $searchError = $e( 'input-search' );
        $rangeError = $e( 'inventory-filter-range' );

        echo <<<HTML
            <form action="/inventory" id="inventory-form" method="GET">
                <label> Filter
                    <select name="inventory-filter" id="inventory-filter">
                        <option value="brand" $brandSelected>Brand</option>
                        <option value="part_type" $typeSelected>Type</option>
                    </select>
                </label>
                $filterError
                <br>
                <label>
                    Input:
                    <input type="text" name="input-search" id="" placeholder="..." value="$search">
                </label>
                $searchError
                <br>
                <!-- TODO: Make range dynamic. ✅ -->
                <input type="range"
                       min="20" max="300" step="20" value="$range"
                       name="inventory-filter-range" id="inventory-filter-range">
                <label id="inventory-filter-label" for="inventory-filter-range"></label><span>€</span>
                $rangeError
                <input type="hidden" name="view-limit" value="$limit">
                <br>
                <input type="submit" value="Search">
            </form>
            <br>
            <script>
                const label = document.querySelector('#inventory-filter-label');
                const range = document.querySelector('#inventory-filter-range');
                label.textContent = range.value;
        
                range.addEventListener( 'input', () => {
                    label.textContent = range.value;
                }, false );
            </script>
        HTML;

    }