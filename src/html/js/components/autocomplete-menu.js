import $ from 'jquery';

$( function() {
    var globalTimeout = null;  

    $( "#list" ).on( 'keyup', function() {

        var value = $( this ).val();

        if ( value.length > 1 ) {
            if ( globalTimeout != null ) {
                clearTimeout( globalTimeout );
            }
            globalTimeout = setTimeout( function() {
                globalTimeout = null;  
            
                $( '#loadingAnimation' ).removeClass( 'd-none' );
                $( '#loadingAnimation' ).addClass( 'd-block' );

                //ajax code

            }, 300 );  
        }
        else {
            $( '#loadingAnimation' ).removeClass( 'd-block' );
            $( '#loadingAnimation' ).addClass( 'd-none' );
        }

	} );
} );
