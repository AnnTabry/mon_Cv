 $(function() {

// _________fonction smooth scrolling__________________

     $('a[href^="#"]').on('click', function() {
         var the_id = $(this).attr("href");
         if (the_id === '#') {
             return;
         }
         $('html, body').animate({
             scrollTop: $(the_id).offset().top
         }, 'slow');
         return false;
     });


// ___________fonction fade slow_____________

     /* Every time the window is scrolled ... */
     $(window).scroll(function() {

         /* Check the location of each desired element */
         $('.hideme').each(function(i) {

             var bottom_of_object = $(this).position().top + $(this).outerHeight();
             var bottom_of_window = $(window).scrollTop() + $(window).height();

             /* If the object is completely visible in the window, fade it it */
             if (bottom_of_window > bottom_of_object) {

                 $(this).animate({ 'opacity': '1' }, 800);

             }
         });
     });


     //_________________ Formulaire ____________________

     $('#contact-form').submit(function(e) {
        e.preventDefault();
        $('.comments').empty();
        var postdata = $('#contact-form').serialize();
        
        $.ajax({
            type: 'POST',
            url: 'php/contact.php',
            data: postdata,
            dataType: 'json',
            success: function(json) {
                 
                if(json.isSuccess) 
                {
                    $('#contact-form').append("<p class='thank-you'>Votre message a bien été envoyé. Merci de m'avoir contacté :)</p>");
                    $('#contact-form')[0].reset();
                }
                else
                {
                    $('#firstname + .comments').html(json.firstnameError);
                    $('#name + .comments').html(json.nameError);
                    $('#email + .comments').html(json.emailError);
                    $('#phone + .comments').html(json.phoneError);
                    $('#message + .comments').html(json.messageError);
                }                
            }
        });
    });
 });
