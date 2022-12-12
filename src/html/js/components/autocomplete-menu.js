import $ from 'jquery';

$( function() {

    var globalTimeout = null;

    var currentXhr;

    $( "#list" ).on( 'keyup', function() {
        
        currentXhr && currentXhr.readyState != 4 && currentXhr.abort(); // clear previous request

        var value = $( this ).val();
        
        if ( value.length > 1 ) {
            
            if ( globalTimeout != null ) {
                clearTimeout( globalTimeout );
            }
            globalTimeout = setTimeout( function() {
                globalTimeout = null;
                
                //ajax code
                currentXhr = $.ajax({
                    url: window.js_school_wp.ajaxUrl,
                    data: {
                        action: 'js_school_wp_load_autocomplete',
                        keyword: value,
                    },
                    beforeSend: function() {
                        $( '#autocomplete-menu' ).show();
                        $( '#loadingAnimation' ).removeClass( 'd-none' );
                        $( '#loadingAnimation' ).addClass( 'd-block' );
                    },
                    success: function( data ) {
                        $( '#autocomplete-menu > .list-group > .list-group-item' ).not( '#loadingAnimation' ).remove();
                        $( '#autocomplete-menu > .list-group' ).append( data.data );
                        $( '#loadingAnimation' ).removeClass( 'd-block' );
                        $( '#loadingAnimation' ).addClass( 'd-none' );
                    },
                    complete: function() {
                        // ajax request completed
                    }
                });

            }, 300 );  
        }
        else {
            $( '#autocomplete-menu' ).hide();
            $( '#autocomplete-menu > .list-group > .list-group-item' ).not( '#loadingAnimation' ).remove();
            $( '#loadingAnimation' ).removeClass( 'd-block' );
            $( '#loadingAnimation' ).addClass( 'd-none' );
        }

	} );
} );

window.selectOrganization = function( val ) {
    $( '#list' ).val( val );
    $( '#autocomplete-menu' ).hide();
}
