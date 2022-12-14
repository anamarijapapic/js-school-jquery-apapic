import $ from 'jquery';

$( '.js-autocomplete' ).each( function() {

    function showAutocompleteMenu() {
        autocompleteMenu.show();
        showLoadingAnimation();
    }
    
    function populateAutocompleteMenu( data ) {
        listGroup.find( '.list-group-item' ).not( loader ).remove();
        listGroup.append( data );
        hideLoadingAnimation();
    }
    
    function hideAutocompleteMenu() {
        autocompleteMenu.hide();
        listGroup.find( '.list-group-item' ).not( loader ).remove();
        hideLoadingAnimation();
    }
    
    function showLoadingAnimation() {
        loader.removeClass( 'd-none' );
        loader.addClass( 'd-block' );
    }
    
    function hideLoadingAnimation() {
        loader.removeClass( 'd-block' );
        loader.addClass( 'd-none' );
    }

    const autocompleteInputField = $( this ).find( '.js-autocomplete-input-field' );
    const autocompleteMenu = $( this ).find( '.js-autocomplete-menu' );
    const loader = $( this ).find( '.js-loading-animation' );
    const listGroup =  $( this ).find( '.js-autocomplete-menu > .list-group' );

    let currentXhr;

    autocompleteInputField.on( 'keyup', _.debounce( function() {

        currentXhr && currentXhr.abort(); // clear previous request
    
        let value = $( this ).val();
        
        if ( value.length > 1 ) {
            //ajax code
            currentXhr = $.ajax( {
                url: window.js_school_wp.ajaxUrlSubsite1,
                data: {
                    action: 'js_school_wp_load_autocomplete',
                    keyword: value,
                    blog_id: window.js_school_wp.blog_id,
                },
                beforeSend: function() {
                    showAutocompleteMenu();
                },
                success: function( data ) {
                    // console.log( data.data );
                    populateAutocompleteMenu( data.html );
                },
                error: function( ) {
                    hideAutocompleteMenu();
                },
                complete: function() {
                    // ajax request completed
                    currentXhr = undefined;
                }
            } );  
        }
        else {
            hideAutocompleteMenu();
        }

    }, 300 ) );

    listGroup.on( 'click', '.list-group-item:not(.js-loading-animation)', function( event ) {

        autocompleteInputField.val( $( this ).text() );
        hideAutocompleteMenu();

    } );

});
