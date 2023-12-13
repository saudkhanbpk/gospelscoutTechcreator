<?php
  
  /* Include header page */
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/surveys/survey_header.php');

      /*** Evaluate User data and Insert into the database ***/
        if($_POST){
          /* Define 'id' var - unset id element */
            $survey_ID = $_POST['id'];
            unset($_POST['id']);

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
            $cond = 'id = ' . $survey_ID;
            $surveyID = $obj->update($field,$value,$cond,$table);
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
            <?php if($surveyID){?>
              <div class="text-right mb-2">
                <!-- <h5>Preliminary Info</h5> -->
                <span class="font-weight-bold" style="font-size:12px">Page 2 of 3</span>
              </div>
              <form class="form-signin text-left" id="form-2" name="form-signin" method="post" action="<?php echo URL;?>surveys/survey_artists3.php">
                  <input type="hidden" name="id" value="<?php echo $survey_ID;?>">
                  <ol start="6">
                    <li><p class="mb-1">I have the following talent? <span class="text-muted">(select one)</span></p>
                      <div class="col-10 col-md-7 mb-0">
                        <select class="custom-select form-control-sm mb-2 talent" name="talent1">
                          <option value="">Talent</option>
                          <option value="dancer">Dancer</option>
                          <option value="musician/instrumentalist">Musician/Instrumentalist</option>
                          <option value="spoken word/lyricist">Spoken Word/Lyricist</option>
                          <option value="vocalist">Vocalist (Singers, Rappers, etc.) </option>
                        </select>
                        <span class="text-muted">Or</span>
                        <input type="text" class="form-control form-control-sm clearDefault talent" name="talent2" placeholder="List Talent Here (if not listed above)" value=""/> 
                      </div>
                    </li>
                    <li class="mt-1">
                      <p class="mb-1">I have been performing this talent for?</p>

                      <div class="col-10 col-md-7 mb-0">
                        <select class="custom-select form-control-sm mb-0" name="experience">
                          <option value="">Years of experience</option>
                          <option value="<2">Less than 2 years</option>
                          <option value="2-5">2 - 5 years</option>
                          <option value="6-10">6 - 10 years</option>
                          <option value=">10">Greater than 10 years</option>
                        </select>    
                      </div>
                    </li>
                    <li id="chkbxLI">
                      <p class="mb-1">As an artist, I struggle with? <span class="text-muted">(select all that Apply)</span></p>
                      <div class="col-10 col-md-7">
                        <div class="container rounded py-2 text-muted" style="border: 1px solid rgba(0,0,0,.2);"><!-- background-color:rgba(245,245,245,1) -->
                          <input name="challenges[]" type="checkbox" value="getting paid" aria-label="Getting paid">
                          <span class="ml-1">Getting paid</span><br> 
                          <input name="challenges[]" type="checkbox" value="finding gigs" aria-label="Consistently finding gigs">
                          <span class="ml-1">Consistently finding gigs</span><br>
                          <input name="challenges[]" type="checkbox" value="tracking gigs" aria-label="Keeping track of gigs">
                          <span class="ml-1">Keeping track of gigs</span><br>
                          <input name="challenges[]" type="checkbox" value="gig cancels" aria-label="Unexpected gig cancellations">
                          <span class="ml-1">Unexpected gig cancellations</span><br>
                          <input name="challenges[]" type="checkbox" value="fan updates" aria-label="Keeping fans updated on gigs ">
                          <span class="ml-1">Keeping fans updated on gigs </span><br> 
                          <input name="challenges[]" type="checkbox" value="artist collab" aria-label="Collaborating with other artists">
                          <span class="ml-1">Collaborating with other artists</span><br> 
                          <input name="challenges[]" type="checkbox" value="artist collab" aria-label="Collaborating with other artists">
                          <span class="ml-1">I have no challenges as an artist </span><br> 
                        </div>
                      </div>
                      <div class="container mt-1">
                        <span class="text-muted">Or (For additional info)</span>
                        <textarea class="form-control mt-2" style="font-size:15px; max-width:350px" id="challenges_other" name="challenges[]" placeholder="If not listed above, write a comma seperated list..." wrap="" rows="3" aria-label="With textarea"></textarea>
                      </div>
                    </li>

                    <li>
                      <p class="my-2">I want to gig at least: <span class="text-muted">(select one)</span></p>
                      <div class="col-10 col-md-7 mb-0">
                        <select class="custom-select form-control-sm mb-0" name="gigFreqWanted">
                          <option value="">Select One</option>
                          <option value="1-5">Less than once/month </option>
                          <option value="1-5">1 – 5 times/month </option>
                          <option value="6-10"> 6-10 times/month </option>
                          <option value=">10">Greater than 10 times/month </option>
                          <option value="0">I don’t want to gig </option>
                        </select>
                      </div>
                    </li>
                    <li>
                      <p class="my-2">I currently gig at least: <span class="text-muted">(select one)</span></p>
                      <div class="col-10 col-md-7">
                        <select class="custom-select form-control-sm mb-0" name="gigFreqCurrent">
                          <option value="">Select One</option>
                          <option value="<1">Less than once/month </option>
                          <option value="1-5">1 – 5 times/month </option>
                          <option value="6-10"> 6-10 times/month </option>
                          <option value=">10">Greater than 10 times/month </option>
                          <option value="0">I don’t want to gig </option>
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

    <script src="<?php echo URL;?>js/jquery.validate.js"></script>
    <script src="<?php echo URL;?>js/additional-methods.js"></script>
    <script>
      /* Front End Form Validation */
        var signUpForm = $("#form-2");

        signUpForm.validate({
          /* Error message placement and styling */
            errorPlacement: function(error, element) {
               // error.appendTo( element.parent("div") );
               error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
                if(error[0]['id'] == 'talent1-error'){
                error.css({"color":"transparent"});
               }
               element.parent("div").after(error);
            },

          /* Submit the form */
            submitHandler: function(form) {
              /* test for that the challenges checkboxes are checked */
                var chkbxCounter = 0; 
                $('input[type=checkbox]').each(function(index){
                  console.log($(this)[0]['checked']);
                  if($(this)[0]['checked'] == true){
                    chkbxCounter += 1; 
                  }
                });

                console.log($('#challenges_other').val());
                if(chkbxCounter > 0 || $('#challenges_other').val() != ''){
                  form.submit();
                }
                else{
                  // Display input validation message 
                    var mess = '<span class="pl-3 text-danger font-weight-bold" style="font-size:12px">Please select at least one main challenge</span>';
                    $(mess).appendTo('#chkbxLI');
                }

            },

          /* Set validation rules for the form */
            rules:{
              talent1: {
                require_from_group: [1, ".talent"],
              },
              talent2: {
                require_from_group: [1, ".talent"],
              },
              experience: {
                required: true,
              },
              gigFreqWanted: {
                required: true,
              },
              gigFreqCurrent: {
                required: true,
              }
            },
            messages: {
              talent1: {
                required: 'Please select a talent',
              },
              experience: {
                required: 'Please enter years of experience',
              },
              gigFreqWanted: {
                required: 'How often do you want to gig',
              },
              gigFreqCurrent: {
                required: 'Please tell us how often you gig',
              }
            }
        });
    </script>
  </body>
</html>
