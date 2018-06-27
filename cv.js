 $(function() {

/*
        $('.js-scrollTo').on('click', function() { // Au clic sur un élément
            var page = $(this).attr('href'); // Page cible
            var speed = 750; // Durée de l'animation (en ms)
            $('html, body').animate({ scrollTop: $(page).offset().top }, speed); // Go
            return false;
        });

*/




/* Every time the window is scrolled ... */
        $(window).scroll(function() {

/* Check the location of each desired element */
        $('.hideme').each(function(i) {

                var bottom_of_object = $(this).position().top + $(this).outerHeight();
                var bottom_of_window = $(window).scrollTop() + $(window).height();

/* If the object is completely visible in the window, fade it it */
                if (bottom_of_window > bottom_of_object) {

                    $(this).animate({ 'opacity': '1' }, 1500);

                }

            });

        });


    });
