"use strict";

function query( newState ) {
    const params = new URLSearchParams( location.search );
    for ( const [ key, value ] of Object.entries( newState ) )
        value === '' || value == null
            ? params.delete( key )
            : params.set( key, value );

    if ( !( 'page' in newState ) )
        params.delete( 'page' );

    location.search = params.toString();
}

document.addEventListener( 'change', ( eventObj ) => {
    const param = eventObj.target.dataset?.param;
    if ( param )
        query( { [ param ]: eventObj.target.value } );
}, false );