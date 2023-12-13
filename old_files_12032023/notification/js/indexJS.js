$(document).ready(function(){
  /* Call the new notifications to the page */
    displayLoadingElement('infoDisplay');
    var newLocal = 'none';
    useBackbone('recNot=1',newLocal)
});

$('.nav-link').click(function(event){
    $('.nav-link').removeClass('active');
    $(this).addClass('active');

});

/**** trigger function to mark notification as viewed and redirect to the appropriate page ****/
 
  $('#infoDisplay').on('click','.useBackBone',function(event){
      event.preventDefault();
      if($(this).hasClass('viewNotification')){
        var notificationID = $(this).attr('notID');
        var newLocal = $(this).attr('href');
        var getVar = 'notificationID='+notificationID+'&viewed=1';
        useBackbone(getVar,newLocal);
      }else if( $(this).hasClass('viewAllNotification') ){
        var getVar = 'notificationID=all&viewed=1';
        newLocal = 'none';
        console.log(getVar);
        useBackbone(getVar,newLocal);
      }
  });
/* END - trigger function to mark notification as viewed and redirect to the appropriate page */

/**** Call to the notificationBackbone.php page based on the tab selected ****/
  $('.useBackBone1').click(function(event){
    event.preventDefault();
    displayLoadingElement('infoDisplay');
    var action = $(this).attr('id');
    var getVar = action +'=1';
    var newLocal = 'none';
    useBackbone(getVar,newLocal)
  });

/* END - Call to the notificationBackbone.php page based on the tab selected */

