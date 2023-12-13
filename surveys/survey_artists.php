<?php
  
  /* Include header page */
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/surveys/survey_header.php');

      /*** Evaluate User data and Insert into the database ***/
        if($_POST['email']){

          /* Loop thru post array and test each element value */
            foreach($_POST as $index0 => $value0){
              if($value0 != ''){

                /* Validate form where necessary */
                  if($index0 == 'zipCode'){
                    if(strlen(intval($value0)) != 5){
                      echo 'Zip Code Validation Error!!';
                      exit;
                    }
                  }

                /* Create new array to eliminate empty elements */
                  $post[$index0] = $value0;
              }
              else{
                echo 'Validation Error!!!';
                exit;
              }
            }
          /* END - Loop thru post array and test each element value */

          /* Insert into the Database */
            foreach($post as $index1 => $value1){
              $field[] = $index1;
              $value[] = $value1;
            }

            $table = 'artist_surveys';
            $surveyID = $obj->insert($field,$value,$table);
          /* END - Insert into the Database */
        }
        else{
          /* Re-direct user to the qualification questions page */
            echo '<script>window.location="' . URL . 'surveys/index.php"</script>';
        }
      /* END - Evaluate User data and Insert into the database */
    ?>
   
      <div class="row p-2 ">
        <div class="col bg-white mx-auto p-3 a-prof-shadow rounded" style="max-width:600px">

          <!-- if initial data is inserted successfully, display next set of questions -->
            <?php if($surveyID && $surveyID > 0){?>
              <div class="text-right mb-2">
                <span class="font-weight-bold" style="font-size:12px">Page 1 of 3</span>
              </div>
              <form class="form-signin text-left" id="form-1" name="form-signin" method="post" action="<?php echo URL;?>surveys/survey_artists2.php">
                <input type="hidden" name="id" value="<?php echo $surveyID;?>">
                <ol>
                  <li>
                    <p class="mb-1">Gender? <span class="text-muted">(select one)</span></p>
                    <div class="col-10 col-md-7">
                      <select class="custom-select form-control-sm mb-0" name="sGender" value="">
                        <option value="">Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                    </div>
                  </li>
                  <li>
                    <p class="mb-1">Birth date?</p>
                    <div class="col-10 col-md-7">
                      <div class="input-group date dateTime-input mb-0" id="datetimepicker1">
                          <input type="text" class="form-control form-control-sm clearDefault" name="dDOB" placeholder="Birth Date" value="<?php echo $userData['dDOB'];?>"/> 
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>  
                    </div>
                  </li>
                  <li>
                    <?php $getAllStates = $obj->fetchRowAll('states', 'country_id = 231');?>
                    <p class="mb-1">State?</p>
                    <div class="col-10 col-md-7">
                      <select class="custom-select form-control-sm mb-0" name="sStateName">
                        <option value="">State</option>
                        <?php 
                          foreach($getAllStates as $state){
                            if($userData['sStateName'] == $state['id']){
                              echo '<option selected value="' . $state['id'] . '" >' . $state['name'] . '</option>';
                            }
                            else{
                              echo '<option value="' . $state['id'] . '" >' . $state['name'] . '</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </li>
                  <li>
                    <p class="mb-1">Zip Code?</p>
                    <div class="col-10 col-md-7">
                      <input type="text" class="form-control form-control-sm clearDefault" name="zipCode" placeholder="Zip Code" value=""/> 
                    </div>
                  </li>

                  <li>
                    <p class="mb-1">Ethnicity?</p>
                    <div class="col-10 col-md-7">
                      <select class="custom-select form-control-sm mb-0" name="ethnicity">
                        <option value="">Ethnicity</option>
                        <option value="asian">Asian</option>
                        <option value="black">Black and/or African American</option>
                        <option value="nativeAmerican">Native American or Alaska Native</option>
                        <option value="pacIslander">Native Hawaiian or Other Pacific Islander</option>
                        <option value="white">White</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                  </li>
                </ol>
                

                <span id="loadlogin"></span> 
                <?php 
                  $year = date_create();
                  $currentYear = $year; 
                  $currentYear = date_format($currentYear, 'Y');
                  date_sub($year,date_interval_create_from_date_string("1 years"));
                  $lastYear = date_format($year, 'Y');
                ?>
                <div class="text-right pr-5">
                  <button type="submit" class="btn btn-md btn-gs">Next</button>
                </div>
                <p class="mt-2 mb-3 text-muted">&copy; 2016-<?php echo $currentYear;?></p>
              </form>
          <?php }else{
              echo '<div class="container">Error Inserting Data</div>';
            }
          ?>
        <!-- /If initial data is inserted successfully, display next set of questions -->
        </div>
      </div>      
    </div>

  <script src="<?php echo URL;?>js/moment-with-locales.js"></script> 
  <script src="<?php echo URL;?>js/bootstrap-datetimepicker.js"></script>
  <script src="<?php echo URL;?>js/jquery.validate.js"></script>
  <script src="<?php echo URL;?>js/additional-methods.js"></script>
  <script>
    /* Date and Time Picker plugin JS */
      $(function () {
        var dat = $("input[name=todaysDate]").val();
        $("#datetimepicker1").datetimepicker({
          format: "YYYY-MM-DD",
          defaultDate: false,
          minDate: dat,
          //minDate: moment(),
          maxDate: moment().add(1,'year'),
          //useCurrent: true, 
          allowInputToggle: true
         });
      });
    /* END - Date and Time Picker plugin JS */
    </script>
    <script>
      /* Front End Form Validation */
        var signUpForm = $("#form-1");

        signUpForm.validate({
          /* Error message placement */
            errorPlacement: function(error, element) {
                error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
                element.parent("div").after(error);
            },

          /* Submit the form */
            submitHandler: function(form) {
              form.submit();
            },

          /* Set validation rules for the form */
            rules:{
              sGender: {
                required: true,
              },
              dDOB: {
                required: true,
              },
              sStateName: {
                required: true,
              },
              zipCode: {
                required: true,
                minlength: 5,
                maxlength: 5,
                digits: true
              },
              ethnicity: {
                required: true,
              }
            },
            messages: {
              sGender: {
                required: 'Please select a gender',
              },
              dDOB: {
                required: 'Please enter your birth date',
              },
              sStateName: {
                required: 'Please select your state',
              },
              zipCode: {
                required: 'Please enter your 5 digit zip code',
                minlength: 'Please enter your 5-digit zip code',
                maxlength: 'Please enter your 5-digit zip code',
                digits: 'Please enter numeric values only'
              },
              ethnicity: {
                required: 'Please enter your ethnicity',
              }
            }
        });

    </script>
  </body>
</html>
