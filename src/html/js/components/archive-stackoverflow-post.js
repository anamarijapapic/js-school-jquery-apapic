import $ from 'jquery';

$( function() {
    $( '[data-bs-toggle="popover"]' ).on( 'mouseenter', function ( event ) {
        var el = $( this );

        var tag_name = el.text().trim();

        // disable this event after first binding 
        el.off( event );

        $.ajax( {
            url: window.ajaxurl, 
            data: {
                action: 'js_school_wp_load_stackoverflow_tag_data',
                tag_name: tag_name,
            },
            dataType: 'json',
            success: function( data ) {

                el.popover( {
                    container: 'body',
                    content: ' ',
                    html: true,
                    placement: 'bottom',
                    trigger: 'hover',
                } );

                bootstrap.Popover.getOrCreateInstance( el ).setContent( {
                    '.popover-header': data.popover_header,
                    '.popover-body': data.popover_body,
                } );

                el.popover( 'show' );

            },
            error: function( error ) { 
                // console.log( error ) 
            },
        } );
    });
} );
