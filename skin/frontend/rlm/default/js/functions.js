jQuery = jQuery.noConflict();

jQuery('document').ready(function() {
    jQuery('.slider').cycle({fx: 'scrollLeft'});
});