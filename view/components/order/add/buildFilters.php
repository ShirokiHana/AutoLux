<?php

use core\SessionHelper;
use lib\FnArray;

require_once basePath( 'view/components/order/add/addOption.php' );

function buildFilters( array $data, ?array $stages = null ) {
        // Base case, end recursion
        if ( empty( $data ) ) {
            return;
        }

        // Select recursion stage [ part_type => brand => part_name ]
        // Will be removed from stages array on each iteration to guarantee recursion end
        if ( $stages === null )
            $stages = $data[ 0 ]
                    |> array_keys( ... )
                    // Remove part_id
                    |> ( fn( $x ) => array_diff( $x, [ 'part_id' ] ) )
                    |> array_values( ... );

        if ( empty( $stages ) ) {
            $id = FnArray::extractValue( $data, 'part_id' );
            echo "<input type='hidden' name='part_id' value='$id'>";
            return;
        }

        // Mutation of array
        $currentStage = array_shift( $stages );

        // Remove duplicates for rendering and re-index array
        $uniqueDataValues = array_values( array_unique( FnArray::map( $data, fn( $element ) => $element[ $currentStage ] ) ) );
        // screen( $uniqueDataValues );

        $old = SessionHelper::getFlash( 'old' );
        $requested = $_GET[ $currentStage ] ?? $old[ $currentStage ] ?? null;

        // Fetch currently select <option>, otherwise default to first
        $isStateStale = !in_array( $requested, $uniqueDataValues );

        echo 'Stale state: ';
        echo  $isStateStale ? 'false' : 'true';

        $selectedOption = $isStateStale ? $uniqueDataValues[ 0 ] : $requested;
        // screen( $selected );

        // Filter out used array values
        $remainderData = FnArray::filter( $data, fn( $element ) => strcmp( $element[ $currentStage ], $selectedOption ) === 0 );

        // Build <select> and <option>s
        addOption( $uniqueDataValues, $currentStage, $selectedOption );
        // Send next step to recursion
        buildFilters( $remainderData, $stages );
    }