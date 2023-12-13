<?php 
  include(realpath($_SERVER["DOCUMENT_ROOT"]) . "/include/header.php");

  if(isset($_POST) && count($_POST) > 0){
    echo'<pre>';
    var_dump($_POST);

    $time = $_POST['timepicker'];
    $time = date_create($time);
    $time1 = date(d); 
    $time1 = date_create($time1);
    var_dump($time1);
    //echo $time; 
  }
?>
<!-- <body> -->
<form action="#" method="post">
  <input type="text" name="timepicker" class="timepicker" placeholder="Enter Time"/>
  <input type="submit" name="submit">
</form>
 <!--  <script type="text/javascript" src="../timePlug/jquery-1.11.3.min.js"></script> -->
 <link href="<?php echo URL;?>timePlug/stylesheets/wickedpicker.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="../timePlug/src/wickedpicker.js"></script>
<!-- </body> -->


	<a href="" id="test">Test output</a>


<script>
  console.log('test');
  $('#test').click(function(event){
      event.preventDefault(); 
      var timeOut = $('input[name=timepicker]').val(); 
      console.log(timeOut);
  });
  	var options = { 
      //now: "17:00", //hh:mm 24 hour format only, defaults to current time 
      twentyFour: false, //Display 24 hour format, defaults to false 
      upArrow: 'wickedpicker__controls__control-up', //The up arrow class selector to use, for custom CSS 
      downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS 
      close: 'wickedpicker__close', //The close class selector to use, for custom CSS 
      hoverState: 'hover-state', //The hover state class to use, for custom CSS 
      title: 'Time', //The Wickedpicker's title, 
      showSeconds: false, //Whether or not to show seconds, 
      secondsInterval: 1, //Change interval for seconds, defaults to 1  , 
      minutesInterval: 5, //Change interval for minutes, defaults to 1 
      beforeShow: null, //A function to be called before the Wickedpicker is shown 
      show: null, //A function to be called when the Wickedpicker is shown 
      clearable: false, //Make the picker's input clearable (has clickable "x") 
    }; 
    $('.timepicker').wickedpicker(options);
</script>