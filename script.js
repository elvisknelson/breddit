$(document).ready(function(){
   
    $(window).scroll(function() {

        if($(window).scrollTop() + $(window).height() > $(document).height() - 50) 
        {
            $(document).ready(function() {

                // If cookie is set, scroll to the position saved in the cookie.
                if ( $.cookie("scroll") !== null ) {
                    $(document).scrollTop( $.cookie("scroll") );
                }
            
                // When a button is clicked...
                $('#vote').on("click", function() {
            
                    // Set a cookie that holds the scroll position.
                    $.cookie("scroll", $(document).scrollTop() );
            
                });
            
            });
        }
    });

});