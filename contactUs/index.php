<?php 
  /* Contact Us Page */
  
  $backGround = 'bg2';
  $page = 'Contact Us';

  /* Require the Header */
    require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
  /* Create DB connection to Query Database for Artist info */
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

  /* Process the contact us submission */
    if($_POST){

      $err = 0;
      /********************* Validate the user input *********************/
        foreach($_POST as $index => $criteria){
          $criteria = trim($criteria);
          if($index == 'sFullName' || $index == 'sStateName' || $index == 'sCityName'){
            $alphaTest = str_replace(" ","",$criteria); 
            if(!ctype_alpha($alphaTest)){
              if($index == 'sFullName'){
                $errorMess = '<div class="container text-danger text-center pt-2"><h5>Please Enter a Valid Name!!!</h5></div>'; 
                $err += 1;
                break; 
              }
              elseif($index == 'sStateName'){
                $errorMess = '<div class="container text-danger text-center pt-2"><h5>Please Enter a Valid State!!!</h5></div>';
                $err += 1; 
                break;
              }
              elseif($index == 'sCityName'){
                $errorMess = '<div class="container text-danger text-center pt-2"><h5>Please Enter a Valid City!!!</h5></div>'; 
                $err += 1;
                break;
              }
            }
          }
          elseif($index == 'iLoginID' && $criteria == ''){
            $criteria = 'Visitor';
          }
          elseif($index == 'ConactUs_message' && $criteria == ''){
            $errorMess = '<div class="container text-danger text-center pt-2"><h5>Please Enter a write us a message!!!</h5></div>'; 
            $err += 1;
            break;
          }
          $_POST[$index] = $criteria;
        }
      /******************* END - Validate the user input ******************/

      /* Submit Contact Us form to the database */ 
        if($err == 0){
          /* Create date/time stamp submission */
            $today = date_create();
            $today = date_format($today, "Y-m-d H:i:s"); 
            $_POST['submitDate'] = $today; 
          /* END - Create date/time stamp submission */

          foreach($_POST as $index1 => $val){
            $field[] = $index1; 
            $value[] = $val; 
          }
          $table = 'contact_us';
          $submitted = $obj->insert($field,$value,$table);

          if($submitted > 0){
            $succMess = '<div class="container text-center text-gs pt-2"><h5>Message Submitted!!!</h5></div>';
          }
        }
      /* END - Submit Contact Us form to the database */ 
    }
  /* END - Process the contact us submission */

  /* Conditional to determine if user is a member or visitor */
  if($currentUserID > 0 ){
    if($currentUserType == 'admin'){
      $userInfo2 = $obj->fetchRow('loginmaster', 'iLoginID='.$currentUserID);
    }
    else{
      $userInfo2 = $obj->fetchRow('loginmaster', 'iLoginID='.$currentUserID);
    }
    $memberState = $obj->fetchRow('states', 'id='.$userInfo['sStateName']);
    $visitor = 'd-none'; 
  }
  else{
    $member = 'd-none'; 
  }
?>

<style>
  p {
    color: rgba(149,73,173,1);
  }
</style>

<div class="container mt-5 px-5">
  <div class="row px-5">
    <?php 
      if($errorMess !== ''){
        echo $errorMess;
      }
      if($submitted > 0){
        echo $succMess;
      }
    ?>
    <div class="col px-5 mt-2">
      <h4 class="h4 text-center text-gs" style="margin-bottom: 20px;">Contact Us</h4>

        <form class="form-horizontal" action="contactUs.php" method="POST" id="myform" autocomplete="no">
          <div class="container px-5 py-3">
            <div class="row px-5">
              <input type="hidden" name="iLoginID" value="<?php echo $currentUserID;?>">
              <input type="hidden" name="pic" value="<?php echo $userInfo['sProfileName'];?>">
              <input type="hidden" name="sUsertype" value="<?php if($currentUserType == 'artist' || $currentUserType == 'group'){echo 'artist';}elseif($currentUserType == 'church'){echo 'church';}elseif($currentUserType == 'user'){echo 'user';}else{echo 'Visitor';}?>">
              <table class="table px-5" style="max-width: 500px; margin: 0 auto 0 auto">
                <tr>
                  <td style="width: 150px">Full Name<span class="text-danger <?php echo $visitor;?>"> *</span></td>
                  <td>
                    <p class="<?php echo $member;?>"><?php echo $userInfo['sFirstName'] . ' ' . $userInfo['sLastName'];?></p>
                    <input type="text" class="form-control  <?php echo $visitor;?>" id="sFullName" name="sFullName" value="<?php if($userInfo){ echo $userInfo['sFirstName'] . ' ' . $userInfo['sLastName'];}elseif($_POST && $err > 0 ){echo $_POST['sFullName'];}?>" placeholder="Enter Your FullName" required>
                  </td>
                </tr>
                <tr>
                  <td>Email<span class="text-danger <?php echo $visitor;?>"> *</span></td>
                  <td>
                    <p class="<?php echo $member;?>"><?php echo $userInfo2['sEmailID'];?></p>
                    <input type="text" class="form-control  <?php echo $visitor;?>" id="email" name="sEmail" value="<?php if($userInfo){ echo $userInfo2['sEmailID'];}elseif($_POST && $err > 0 ){echo $_POST['sEmail'];}?>" placeholder="Enter Your Email" required>
                  </td>
                </tr>
                <tr>
                  <td>State<span class="text-danger <?php echo $visitor;?>"> *</span></td>
                  <td>
                    <p class="<?php echo $member;?>"><?php echo $memberState['name'];?></p>
                    <!-- State -->
                       <?php 
                        /* Fetch States */
                        $cond = 'country_id = 231'; 
                        $stateArray = $obj->fetchRowAll('states', $cond);
                      /* END - Fetch States */
                      ?>
                      <select class="custom-select dropdown py-0 <?php echo $visitor;?>"  name="sStateName" id="sStateName" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);" required>
                        <option value="">State</option>
                        <?php 
                          foreach($stateArray as $evID => $state) {
                            if($userInfo){
                              if($state['name'] == $memberState['name']){
                                $selected = 'selected';
                                echo '<option ' . $selected . ' value="' .$state['name'] . '" >' . $state['name'] . '</option>'; 
                              }
                              else{
                                echo '<p>Error</p>'; 
                              }
                            }
                            elseif($_POST && $err > 0 ){
                              if($state['name'] == $_POST["sStateName"]){
                                $selected = 'selected';
                                echo '<option ' . $selected . ' value="' .$state['name'] . '" >' . $state['name'] . '</option>'; 
                              }
                              else{
                                echo '<option value="' .$state['name'] . '" >' . $state['name'] . '</option>'; 
                              }
                            } 
                            else{
                              echo '<option value="' .$state['name'] . '" >' . $state['name'] . '</option>'; 
                            }
                          }
                        ?>
                      </select>
                    <!-- /State -->
                  </td>
                </tr>
                <tr>
                  <td>Zip Code<span class="text-danger <?php echo $visitor;?>"> *</span></td>
                  <td>
                    <p class="<?php echo $member;?>"><?php echo $userInfo['iZipcode'];?></p>
                    <input type="hidden" name="sCityName" id="sCityName" value="">
                    <input type="text" class="form-control  <?php echo $visitor;?>" id="iZipcode" name="iZipcode" value="<?php if($userInfo){ echo $userInfo['iZipcode'];}elseif($_POST && $err > 0){echo $_POST['iZipcode'];}?>" placeholder="Enter Your Zip Code" required>
                  </td>
                </tr>
                <tr>
                  <td>Your Message<span class="text-danger"> *</span></td>
                  <td>
                    <textarea class="form-control mb-2" name="ConactUs_message" placeholder="Write us a message..." wrap="" rows="5" aria-label="With textarea" required><?php if($_POST && $err > 0 ){echo $_POST['ConactUs_message'];}?></textarea>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td class="text-right"><button type="submit" id="contactSubmit" class="btn btn-gs">Submit</button></td>
                </tr>
               
              </table>
            </div>
          </div>    
        </form>

    </div>
  </div>  
</div>

<?php 
  /* Include the footer */ 
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>
<script src="<?php echo URL;?>js/jquery.validate.js"></script>
<script src="<?php echo URL;?>js/additional-methods.js"></script>
<script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
<script>
  /* Front End Form Validation */
    var signUpForm = $("#myform");

    signUpForm.validate({
      /* Submit the form */
          submitHandler: function(form) {
            /****** execute Javascript to contact google geocoding api ******/
              $.support.cors = true;
                $.ajaxSetup({ cache: false });
                var city = '';
                var hascity = 0;
                var hassub = 0;
                var state = '';
                var nbhd = '';
                var subloc = '';
                var userState = $('#sStateName').val();
                var userZip = $('#iZipcode').val();

                if(userZip.length == 5){
                  var date = new Date();
                  $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + userZip + '&key=AIzaSyCRtBdKK4NmLTuE8dsel7zlyq-iLbs6APQ&type=json&_=' + date.getTime(), function(response){
                    //find the city and state
                    var address_components = response.results[0].address_components;
                    $.each(address_components, function(index, component){
                       var types = component.types;
                       $.each(types, function(index, type){
                        if(type == 'locality') {
                          city = component.long_name;
                          hascity = 1;

                        }
                        if(type == 'administrative_area_level_1') {
                          state = component.long_name;
                        }
                        if(type == 'neighborhood') {
                          nbhd = component.long_name;
                          hasnbhd = 1;
                        }
                        if(type == 'sublocality') {
                          subloc = component.long_name;
                          hassub = 1;
                        }
                       });
                    });

                    if(state == userState){
                      if(hascity == 1){
                        $('#sCityName').val(city);
                      }
                      else if(hasnbhd == 1){
                        $('#sCityName').val(nbhd);
                      }
                    }
                    else{
                      $('#sCityName').val('');
                    }

                    /* Submit Contact Us Form */
                      form.submit();
                  });
                }
              /****** END - execute Javascript to contact google geocoding api ******/
        },
      /* END - Submit the form */

      /* Set validation rules for the form */
        rules:{
          sFullName: {
            required: true,
          },
          sEmail: {
            required: true,
            email: true
          },
          sStateName: {
            required: true,
          },
          iZipcode: {
            required: true,
            minlength: 5,
            maxlength: 5,
            digits: true
          },
          ConactUs_message: {
            required: true,
          }
        },
        messages: {
          sFullName: {
            required: 'Please Enter Your Name',
          },
          sEmail: {
            required: 'Please enter your email address',
            email: 'Please enter a valid email address'
          },
          sStateName: {
            required: 'Please select your state',
          },
          iZipcode: {
            required: 'Please enter your zip code',
             minlength: 'Please enter your 5-digit zip code',
             maxlength: 'Please enter your 5-digit zip code',
             digits: 'Please enter numeric values only'
          },
          ConactUs_message: {
            required: 'Please give us your feedback',
          },
        }

    });
  /* END - Front End Form Validation */  
</script>