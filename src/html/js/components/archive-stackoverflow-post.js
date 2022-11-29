import $ from 'jquery';

$( function() {
    const popoverTriggerList = document.querySelectorAll( '[data-bs-toggle="popover"]' );
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover( 
        popoverTriggerEl, {
            container: 'body',
            content: 'Content',
            placement: 'bottom',
            title: 'Title',
            trigger: 'hover focus'
        }
    ) );
} );
