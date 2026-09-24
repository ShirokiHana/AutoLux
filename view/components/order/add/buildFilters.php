<?php

use lib\FnArray;

require_once basePath( 'view/components/order/add/addOption.php' );

function buildFilters( array $data, array $stages ) {
        // Base case, end recursion
        if ( empty( $data ) || empty( $stages ) ) {
            return;
        }

        // Select recursion stage [ part_type => brand => part_name ]
        // Will be removed from stages array on each iteration to guarantee recursion end
        $currentStage = $stages[ 0 ];

        // Remove duplicates for rendering and re-index array
        $uniqueDataValues = array_values( array_unique( FnArray::map( $data, fn( $element ) => $element[ $currentStage ] ) ) );
        //dd( $uniqueDataValues );

        // Fetch currently select <option>, otherwise default to first
        $isStateStale = in_array( $_GET[ $currentStage ] ?? null, $uniqueDataValues );
        echo 'Stale state: ';
        echo  $isStateStale ? 'false' : 'true';
        $selectedOption = $isStateStale ? $_GET[ $currentStage ] : $uniqueDataValues[ 0 ];
        //dd( $selected );

        // Build <select> and <option>s
        addOption( $uniqueDataValues, $currentStage, $selectedOption );

        // Filter out used array values
        $remainderStages = FnArray::slice( $stages, 1 );
        $remainderData = FnArray::filter( $data, fn( $element ) => strcmp( $element[ $currentStage ], $selectedOption ) === 0 );

        // Send next step to recursion
        buildFilters( $remainderData, $remainderStages );
    }