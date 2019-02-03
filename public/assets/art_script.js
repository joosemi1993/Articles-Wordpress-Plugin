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
            if( jQuery('.art-nav-previous a').length ) {
			    var a_href = jQuery('.art-navigation').find('.art-nav-previous a').attr('href');
			    window.location.href = a_href;
			}
        } else if (lowerCharStr == "k") {
            // If k redirect to next viewer
            if( jQuery('.art-nav-next a').length ) {
			    var a_href = jQuery('.art-navigation').find('.art-nav-next a').attr('href');
			    window.location.href = a_href;
			}
        }
    }
});