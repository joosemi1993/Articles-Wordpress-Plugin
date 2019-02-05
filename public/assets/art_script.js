/**
 * @package JosemiArticlesPlugin
**/

jQuery(document).keypress(function(e) {
    var charCode = e.which;
    if (charCode) {
        var lowerCharStr = String.fromCharCode(charCode).toLowerCase();
        // Detect the keywork
        if (lowerCharStr == "j") {
            // If j redirect to previous viewer
            jQuery( "button.flickity-button.flickity-prev-next-button.previous" ).trigger( "click" );
        } else if (lowerCharStr == "k") {
            // If k redirect to next viewer
            jQuery( "button.flickity-button.flickity-prev-next-button.next" ).trigger( "click" );
        }
    }
});

