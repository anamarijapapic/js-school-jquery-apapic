import $ from 'jquery';

$( function() {
    var allDisplayed = false;

    const $loadMoreWrapper = $( '.js-team-member-archive__load-more-wrapper' );
    const $loadMoreLoading = $( '.js-team-member-archive__load-more-loading' );

    $( '.variant1' ).on( 'click', function() {
        $( '.variant2' ).removeClass( 'active' );
        $( '.variant1' ).addClass( 'active' );

        if ( ! allDisplayed ) {
            $loadMoreWrapper.removeClass( 'd-block' );
            $loadMoreWrapper.addClass( 'd-none' );
        }
    } );

    $( '.variant2' ).on( 'click', function() {
        $( '.variant1' ).removeClass( 'active' );
        $( '.variant2' ).addClass( 'active' );

        if ( ! allDisplayed ) {
            $loadMoreWrapper.removeClass( 'd-none' );
            $loadMoreWrapper.addClass( 'd-block' );
        }
    } );

    const $archives = $( '.js-team-member-archive' );
    $archives.each( function () {

        const $archive = $( this );

        const $loadMoreBtn = $archive.find( '.js-team-member-archive__load-more' );
        const $row = $archive.find( '.js-team-member-archive__row' );
        let xhr;

        $loadMoreBtn.on( 'click', function ( e ) {
            e.preventDefault();

            $loadMoreWrapper.addClass( 'd-none' );
            $loadMoreLoading.removeClass( 'd-none' );
            $loadMoreLoading.addClass( 'd-flex' );

            if ( xhr ) {
                // ajax request already in progress
                return;
            }

            const currentPage = $archive.data( 'current-page' ) || 1;

            xhr = $.ajax( {
                url: window.ajaxurl, // window.js_school_wp.ajaxUrl
                data: {
                    action: 'js_school_wp_load_more_team_members',
                    js_school_wp_page: currentPage + 1,
                },
                dataType: 'json',
                success: function( data ) {
                    $archive.data( 'current-page', data.page );

                    $( data.data ).hide().appendTo( $row ).fadeIn();

                    $loadMoreWrapper.removeClass( 'd-none' );
                    $loadMoreLoading.removeClass( 'd-flex' );
                    $loadMoreLoading.addClass( 'd-none' );

                    if ( ( data.page ) < ( data.max_page ) ) {
                        // has more results
                    } else {
                        // no more results
                        allDisplayed = true;
                        $loadMoreWrapper.removeClass( 'd-block' );
                        $loadMoreWrapper.addClass( 'd-none' );
                    }
                },
                error: function() {
                    // console.log( 'error' );
                },
                complete: function () {
                    xhr = undefined;
                }
            } );
        } );
    } );
} );
