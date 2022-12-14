import $ from 'jquery';

const autocompleteInputField = $( '.js-autocomplete-input-field' );
const autocompleteMenu = $( '.js-autocomplete-menu' );
const loader = $( '.js-loading-animation' );
const listGroup =  $( '.js-autocomplete-menu > .list-group' );

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

let globalTimeout = null;

let currentXhr;

autocompleteInputField.on( 'keyup', function() {
    
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
                    blog_id: window.js_school_wp.blog_id,
                },
                beforeSend: function() {
                    showAutocompleteMenu();
                },
                success: function( data ) {
                    // console.log( data.data );
                    populateAutocompleteMenu( data.html );
                },
                complete: function() {
                    // ajax request completed
                }
            } );

        }, 300 );  
    }
    else {
        hideAutocompleteMenu();
    }

} );

window.selectOrganization = function( val ) {
    autocompleteInputField.val( val );
    hideAutocompleteMenu();
}
