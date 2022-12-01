import $ from 'jquery';

var localCache = {
    data: {},
    remove: function ( tag_name ) {
        delete localCache.data[ tag_name ];
    },
    exist: function ( tag_name ) {
        return localCache.data.hasOwnProperty( tag_name ) && localCache.data[ tag_name ] !== null;
    },
    get: function ( tag_name ) {
        // console.log( 'Getting cache for tag: ' +  tag_name );
        return localCache.data[ tag_name ];
    },
    set: function ( tag_name, cachedData ) {
        localCache.remove( tag_name );
        localCache.data[ tag_name ] = cachedData;
    }
};

$( function() {
    $( '[data-bs-toggle="popover"]' ).on( 'mouseenter', function ( event ) {
        var el = $( this );
        
        // disable this event after first binding 
        // el.off( event );
        
        var tag_name = el.text().trim();

        $.ajax( {
            url: window.ajaxurl, 
            data: {
                action: 'js_school_wp_load_stackoverflow_tag_data',
                tag_name: tag_name,
            },
            dataType: 'json',
            cache: true,
            beforeSend: function () {
                if ( localCache.exist( tag_name ) ) {
                    // localCache.get( tag_name );
                    return false;
                }
                // reserve local cache data key so that no more ajax requests are made
                localCache.set( tag_name, undefined );
                return true;
            },
            success: function( data ) {

                var tags = $( '[data-tag="' + el.data( 'tag' ) + '"]' );

                tags.popover( {
                    container: 'body',
                    content: data.popover_body,
                    customClass: 'custom-popover',
                    html: true,
                    placement: 'bottom',
                    title: data.popover_header,
                    trigger: 'hover',
                } );

                el.popover( 'show' );

            },
            error: function( error ) { 
                // console.log( error ) 
            },
            complete: function ( jqXHR, textStatus ) {
                localCache.set( tag_name, jqXHR );
            },
        } );
    });
} );
