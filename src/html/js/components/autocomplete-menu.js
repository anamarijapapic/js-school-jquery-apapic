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

                //ajax code
                $.ajax({
                    url: window.ajaxurl,
                    data: {
                        action: 'js_school_wp_load_autocomplete',
                        keyword: value,
                    },
                    beforeSend: function() {
                        $( '#loadingAnimation' ).removeClass( 'd-none' );
                        $( '#loadingAnimation' ).addClass( 'd-block' );
                    },
                    success: function( data ) {
                        $( '#autocomplete-menu > .list-group' ).not( '#loadingAnimation' ).empty();
                        $( '#autocomplete-menu > .list-group' ).append( data.data );
                    },
                    complete: function() {
                        $( '#loadingAnimation' ).removeClass( 'd-block' );
                        $( '#loadingAnimation' ).addClass( 'd-none' );
                    }
                });

            }, 300 );  
        }
        else {
            $( '#autocomplete-menu' ).show();
            $( '#loadingAnimation' ).removeClass( 'd-block' );
            $( '#loadingAnimation' ).addClass( 'd-none' );
        }

	} );
} );

window.selectOrganization = function( val ) {
    $( '#list' ).val( val );
    $( '#autocomplete-menu' ).hide();
}
