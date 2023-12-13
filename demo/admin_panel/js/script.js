$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function ($) {
    $( "#birthday" ).datepicker({
      changeMonth:true,
     changeYear:true,
     yearRange:"-100:+0"
    });
  }

);