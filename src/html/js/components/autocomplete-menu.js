import $ from 'jquery';

let globalTimeout = null;

let currentXhr;

$( '#list' ).on( 'keyup', function() {
    
    currentXhr && currentXhr.readyState != 4 && currentXhr.abort(); // clear previous request

    let value = $( this ).val();
    
    if ( value.length > 1 ) {
        
        if ( globalTimeout != null ) {
            clearTimeout( globalTimeout );
        }
        globalTimeout = setTimeout( function() {
            globalTimeout = null;
            
            //ajax code
            currentXhr = $.ajax( {
                url: window.js_school_wp.ajaxUrlSubsite1,
                data: {
                    action: 'js_school_wp_load_autocomplete',
                    keyword: value,
                    blog_id: $( '#blog-info' ).data( 'blogid' ),
                },
                beforeSend: function() {
                    $( '#autocomplete-menu' ).show();
                    $( '#loadingAnimation' ).removeClass( 'd-none' );
                    $( '#loadingAnimation' ).addClass( 'd-block' );
                },
                success: function( data ) {
                    // console.log( data.data );
                    $( '#autocomplete-menu > .list-group > .list-group-item' ).not( '#loadingAnimation' ).remove();
                    $( '#autocomplete-menu > .list-group' ).append( data.html );
                    $( '#loadingAnimation' ).removeClass( 'd-block' );
                    $( '#loadingAnimation' ).addClass( 'd-none' );
                },
                complete: function() {
                    // ajax request completed
                }
            } );

        }, 300 );  
    }
    else {
        $( '#autocomplete-menu' ).hide();
        $( '#autocomplete-menu > .list-group > .list-group-item' ).not( '#loadingAnimation' ).remove();
        $( '#loadingAnimation' ).removeClass( 'd-block' );
        $( '#loadingAnimation' ).addClass( 'd-none' );
    }

} );

window.selectOrganization = function( val ) {
    $( '#list' ).val( val );
    $( '#autocomplete-menu' ).hide();
}
