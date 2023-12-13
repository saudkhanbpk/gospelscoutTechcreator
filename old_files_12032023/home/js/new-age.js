(function($) {
  "use strict"; // Start of use strict

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);

      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 48)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 54
  });

  // Collapse Navbar
  var navbarCollapse = function() {
    if ($("#mainNav").offset().top > 50) {
      $("#mainNav").addClass("navbar-shrink");

      if( screen.width >= 992){
         // Change barbmo page title to orange color and swap out logo
        $('#company-name').removeClass('company-name');
        $('#company-name').addClass('company-name2');
        $('#company-logo').attr('src','https://www.gospelscout.com/img/gospelscout_logo.png');
        $('#notBell').removeClass('notBell');
        $('#notBell').addClass('notBell2');
        $('#not-numb').removeClass('not-numb');
        $('#not-numb').addClass('not-numb2');
        $('#menu-icon').attr('src','https://www.gospelscout.com/img/right-menu.svg');
        $('#menu-icon').attr('src','https://www.gospelscout.com/img/right-menu-2.svg');
        // $('#notBell').attr('style','background-image: url("https://www.gospelscout.com/img/notification2.svg");display:inline-block;height:22px; width:22px');
      }
    } else {
      $("#mainNav").removeClass("navbar-shrink");
      
      // Change barbmo page title to white color and swap out logo
        $('#company-name').removeClass('company-name2');
        $('#company-name').addClass('company-name');
        $('#company-logo').attr('src','https://www.gospelscout.com/img/logo_bright_2.png');
        $('#notBell').removeClass('notBell2');
        $('#notBell').addClass('notBell');
        $('#not-numb').removeClass('not-numb2');
        $('#not-numb').addClass('not-numb');
        $('#menu-icon').attr('src','https://www.gospelscout.com/img/right-menu-2.svg');
        $('#menu-icon').attr('src','https://www.gospelscout.com/img/right-menu.svg');
        // $('#notBell').attr('style','background-image: url("https://www.gospelscout.com/img/notification.svg");display:inline-block;height:22px; width:22px')
    }
  };
  // Collapse now if page is not at top
  navbarCollapse();
  // Collapse the navbar when page is scrolled
  $(window).scroll(navbarCollapse);

  // Contact form 
  $('#contact-form-submit').click(function(e){
    e.preventDefault(); 

    var form = document.forms.namedItem('contact_form');
    var contact_form = new FormData(form);
    var url = 'https://www.gospelscout.com/home/phpBackend/connectToDb.php';

    // Send email to email page w/ ajax request 
      var contact_xhr = new XMLHttpRequest(); 
      contact_xhr.onload = function(){
        if(contact_xhr.status == 200){
          var response = contact_xhr.responseText.trim(); 
          var parsedResponse = JSON.parse(response);
         // console.log(response);

          if(parsedResponse.success){
            $('#email-status').html('<p class="text-success">Email Has Been Submitted!!!</p>');
			if( $('input[name=sUsertype]').val() == 'Visitor'){
              $('input[name=fName]').val('');
              $('input[name=lName]').val('');
              $('input[name=email]').val('');
            }
            $('#text-area').val('');
          }else{
            $('#email-status').html('<p class="text-danger">Submission Error :-(</p>')
          }

        }
      }
      contact_xhr.open('post',url);
      contact_xhr.send(contact_form); 
  });

})(jQuery); // End of use strict
