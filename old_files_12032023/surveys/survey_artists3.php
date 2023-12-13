<?php
  
  /* Include header page */
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/surveys/survey_header.php');


      /*** Evaluate User data and Insert into the database ***/
        
        /* Define 'id' var - unset id element */
          $survey_ID = $_POST['id'];
          unset($_POST['id']);

        /* Define the table update vars */
          $table = 'artist_surveys';
          $cond = 'id = ' . $survey_ID;


        if($_POST['surveyComplete']){
          /* Remove the survey complete element */
            unset($_POST['surveyComplete']);

          /*** Evaluate User data and Insert into the database ***/
          foreach ($_POST as $index => $val) {
            if($val != ''){
              if($index == 'gigSource' || $index == 'platformSources' || $index == 'platformsUsed' || $index == 'showcaseChannels'){
                /* Remove all empty elements from nest array */
                  $tempArr0 = array();

                  foreach($val as $val_1){
                    if($val_1 != ''){
                      $tempArr0[] = $val_1;
                    }
                  }
                  $val = implode(',',$tempArr0);

                /* test that # of characters is <= 150 */
                  if(strlen($val) > 150){
                    $val = 'Error - Number of characters exceeds 150';
                  }
              }

              $post[$index] = $val;
            }
            else{
              echo 'Form Incomplete';
            }
          }

          if(count($post) > 0){
            /* update the data base*/
              foreach ($post as $index1 => $val1) {
                $field[] = $index1;
                $value[] = $val1; 
              }

              $surveyID = $obj->update($field,$value,$cond,$table);
          }
          /* END - Evaluate User data and Insert into the database */

          /* Display thank you message for completing the survey */
            echo '<div class="container"><h4 class="text-muted">Thank You for your time!!!</h4></div>';
            exit;
        }
        elseif($_POST){
          /* Remove talent2 element if talent1 is present */
            if($_POST['talent1'] != ''){
              $_POST['talent'] = $_POST['talent1'];
              unset($_POST['talent1']);
              unset($_POST['talent2']);
            }
            elseif($_POST['talent2'] != ''){
              $_POST['talent'] = $_POST['talent2'];
              unset($_POST['talent1']);
              unset($_POST['talent2']);
            }

          /* Loop thru post array and test each element value */
            foreach($_POST as $index0 => $value0){
              if($value0 != ''){

                /* turn list of challenges to comma separated list */
                  if($index0 == 'challenges'){
                    foreach($value0 as $value0_1){
                      if($value0_1 != ''){
                        $tmpArr1[] = $value0_1;
                      }
                    }
                    $value0 = $tmpArr1;
                    $value0 = implode(',',$value0);
                  }
                  
                /* Create new array to eliminate empty elements */
                  $post[$index0] = $value0;
              }
            }

            if(count($post) < 5 ){
              echo 'Validation Error!!!';
              exit;
            }
          /* END - Loop thru post array and test each element value */

          /* Insert into the Database */
            foreach($post as $index1 => $value1){
              $field[] = $index1;
              $value[] = $value1;
            }
            
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
                <span class="font-weight-bold" style="font-size:12px">Page 3 of 3</span>
              </div>
              <form class="form-signin text-left" name="form-signin" id="form-3" method="post">
                  <input type="hidden" name="surveyComplete" value="true">
                  <input type="hidden" name="id" value="<?php echo $survey_ID;?>">
                  <ol start="11">
                    <li>
                      <p class="mb-1">I find most of my gigs through: <span class="text-muted">(select all that Apply)</span></p>
                      <div class="col-10 col-md-7">
                          <div class="container rounded py-2" style="background-color:rgba(245,245,245,1);border: 1px solid rgba(0,0,0,.2);">
                            <input class="gigSource" name="gigSource[]" type="checkbox" value="Friends/family" aria-label="Friends/family">
                            <span class="ml-1">Friends/family</span><br> 
                            <input class="gigSource" name="gigSource[]" type="checkbox" value="online" aria-label="online">
                            <span class="ml-1">Online and/or social media</span><br>
                            <input class="gigSource" name="gigSource[]" type="checkbox" value="ads" aria-label="ads">
                            <span class="ml-1">Ads</span><br>
                            <input class="gigSource" name="gigSource[]" type="checkbox" value="agency/agent" aria-label="agency/agent">
                            <span class="ml-1">Talent Agent/agency</span><br>
                            <input class="gigSource" name="gigSource[]" type="checkbox" value="none" aria-label="none">
                            <span class="ml-1">I don’t usually find gigs</span><br> 
                          </div>
                        </div>
                        <div class="container mt-1">
                          <span class="text-muted">Or (if not listed above)</span>
                          <textarea class="form-control my-2" id="currentSources_other" style="font-size:15px; max-width:350px" name="gigSource[]" placeholder="If not listed above, write a comma seperated list..." wrap="" rows="3" aria-label="With textarea"></textarea>
                        </div>
                        <span class="pl-3 text-danger font-weight-bold" id="chkbxGS" style="font-size:12px"></span>
                    </li>
                    
                    <li class="mt-1">
                      <p class="mb-1">I usually charge at least: (Select one) </p>

                      <div class="col-10 col-md-7">
                        <select class="custom-select form-control-sm mb-2" name="currentPay">
                          <option value="">Select One</option>
                          <option value="<20">Less than $20/hr.</option>
                          <option value="20-50">$20 - $50/hr.</option>
                          <option value="50-100">$50 - $100/hr.</option>
                          <option value=">100">$100+ /hr.</option>
                          <option value="0">I play for free</option>
                        </select>
                      </div>
                    </li>
                    
                    <li>
                      <p class="mb-1">I search for gigs <span class="text-muted">(select one)</span></p>
                      <div class="col-10 col-md-7">
                        <select class="custom-select form-control-sm mb-2" name="gigSearchFreq">
                          <option value="">Select One</option>
                          <option value="1-4">1 – 4 times a week</option>
                          <option value="5-10">5 -10 times a week</option>
                          <option value="11 -15">11 -15 times a week</option>
                          <option value=">15">More than 15 times a week</option>
                          <option value="0">I do not search for gigs </option>
                        </select>
                      </div>
                    </li>

                    <li>
                      <p class="mb-1">I use the following social media platforms to search for gigs <span class="text-muted">(select all that Apply)</span></p>
                      <div class="col-10 col-md-7">
                          <div class="container rounded py-2" style="background-color:rgba(245,245,245,1);border: 1px solid rgba(0,0,0,.2);">
                            <input class="platformSources" name="platformSources[]" type="checkbox" value="craigslist" aria-label="Craigslist">
                            <span class="ml-1">Craigslist</span><br> 
                            <input class="platformSources" name="platformSources[]" type="checkbox" value="facebook" aria-label="facebook">
                            <span class="ml-1">Facebook</span><br>
                            <input class="platformSources" name="platformSources[]" type="checkbox" value="instagram" aria-label="instagram">
                            <span class="ml-1">Instagram</span><br>
                            <input class="platformSources" name="platformSources[]" type="checkbox" value="Sonicbids" aria-label="Sonicbids">
                            <span class="ml-1">Sonicbids</span><br>
                            <input class="platformSources" name="platformSources[]" type="checkbox" value="Reverbnation" aria-label="Reverbnation">
                            <span class="ml-1">Reverbnation</span><br> 
                            <input class="platformSources" name="platformSources[]" type="checkbox" value="none" aria-label="none">
                            <span class="ml-1">I don’t use social media to search for gigs</span><br> 
                          </div>
                        </div>
                        <div class="container mt-1">
                          <span class="text-muted">Or (For platforms not listed above)</span>
                          <textarea class="form-control my-2" id="sources_other" style="font-size:15px; max-width:350px" name="platformSources[]" placeholder="If not listed above, write a comma seperated list..." wrap="" rows="3" aria-label="With textarea"></textarea>
                        </div>
                        <span class="pl-3 text-danger font-weight-bold" id="chkbxPS" style="font-size:12px"></span>
                    </li>
                    <li>
                      <p class="my-2">In general, I use the following social media platforms at least 2 – 3 times a week: <span class="text-muted">(select all that apply)</span></p>
                      <div class="col-10 col-md-7">
                        <div class="container rounded py-2" style="background-color:rgba(245,245,245,1);border: 1px solid rgba(0,0,0,.2);">
                          <input class="platformsUsed" name="platformsUsed[Facebook]" type="checkbox" value="Facebook" aria-label="Facebook">
                          <span class="ml-1">Facebook</span><br> 
                          <input class="platformsUsed" name="platformsUsed[Instagram]" type="checkbox" value="Instagram" aria-label="Instagram">
                          <span class="ml-1">Instagram</span><br>
                          <input class="platformsUsed" name="platformsUsed[]" type="checkbox" value="Google +" aria-label="Google +">
                          <span class="ml-1">Google + </span><br>
                          <input class="platformsUsed" name="platformsUsed[]" type="checkbox" value="Snapchat" aria-label="Snapchat">
                          <span class="ml-1">Snapchat</span><br>
                          <input class="platformsUsed" name="platformsUsed[]" type="checkbox" value="Twitter" aria-label="Twitter">
                          <span class="ml-1">Twitter</span><br> 
                          <input class="platformsUsed" name="platformsUsed[]" type="checkbox" value="none" aria-label="none">
                          <span class="ml-1">I don’t use social media that often</span><br> 
                        </div>
                        <span class="pl-3 text-danger font-weight-bold" id="chkbxPU" style="font-size:12px"></span>
                      </div>
                    </li>
                     <li>
                      <p class="my-2">I currently showcase/advertise my talent through the following channels: <span class="text-muted">(select all that apply)</span></p>
                      <div class="col-10 col-md-7">
                        <div class="container rounded py-2" style="background-color:rgba(245,245,245,1);border: 1px solid rgba(0,0,0,.2);">
                          <input class="showcaseChannels" name="showcaseChannels[]" type="checkbox" value="facebook" aria-label="facebook">
                          <span class="ml-1">Facebook</span><br>
                          <input class="showcaseChannels" name="showcaseChannels[]" type="checkbox" value="instagram" aria-label="instagram">
                          <span class="ml-1">Instagram</span><br>
                          <input class="showcaseChannels" name="showcaseChannels[]" type="checkbox" value="YouTube" aria-label="YouTube">
                          <span class="ml-1">YouTube</span><br> 
                          <input class="showcaseChannels" name="showcaseChannels[]" type="checkbox" value="Personal website" aria-label="Personal website">
                          <span class="ml-1">Personal website</span><br>
                          <input class="showcaseChannels" name="showcaseChannels[]" type="checkbox" value="Live performances" aria-label="Live performances">
                          <span class="ml-1">Live performances</span><br> 
                          <input class="showcaseChannels" name="showcaseChannels[]" type="checkbox" value="none" aria-label="none">
                          <span class="ml-1">I don’t showcase/advertise my talent</span><br> 
                        </div>
                      </div>
                      <div class="container mt-1">
                          <span class="text-muted">Or (For platforms not listed above)</span>
                          <textarea class="form-control my-2" style="font-size:15px; max-width:350px" id="showcaseChan_other" name="showcaseChannels[]" placeholder="If not listed above, write a comma seperated list..." wrap="" rows="3" aria-label="With textarea"></textarea>
                        </div>
                        <span class="pl-3 text-danger font-weight-bold" id="chkbxSC" style="font-size:12px"></span>
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

  <script>
     /* Front End Form Validation */
        var signUpForm = $("#form-3");

        signUpForm.validate({
          /* Error message placement and styling */
            errorPlacement: function(error, element) {
               error.css({"color":"red","font-size":"12px","font-weight":"bold","padding-left":"12px"});
                if(error[0]['id'] == 'gigSource1-error'){
                error.css({"color":"transparent"});
               }
               element.parent("div").after(error);
            },

          /* Submit the form */
            submitHandler: function(form) {
              var chkbxGrpCounter = 0;

              /**** Current gig source checkboxes are checked ****/
                var chkbxCounter2 = 0; 
                $('.gigSource').each(function(index){
                  if($(this)[0]['checked'] == true){
                    chkbxCounter2 += 1; 
                  }
                });

                if(chkbxCounter2 > 0 || $('#currentSources_other').val() != ''){
                  chkbxGrpCounter += 1;
                  $('#chkbxGS').html('');
                }
                else{
                  /*Display input validation message */
                    var mess = 'Please select at least one';
                    $('#chkbxGS').html(mess);
                }
              /* END - Social media gig source checkboxes are checked */

              /**** Social media gig source checkboxes are checked ****/
                var chkbxCounter0 = 0; 
                $('.platformSources').each(function(index){
                  if($(this)[0]['checked'] == true){
                    chkbxCounter0 += 1; 
                  }
                });

                if(chkbxCounter0 > 0 || $('#sources_other').val() != ''){
                  chkbxGrpCounter += 1;
                  $('#chkbxPS').html('');
                }
                else{
                  /*Display input validation message */
                    var mess = 'Please select at least one';
                    $('#chkbxPS').html(mess);
                }
              /* END - Social media gig source checkboxes are checked */

              /**** social platform general use checkboxes are checked ****/
                var chkbxCounter = 0;  
                $('.platformsUsed').each(function(index){
                  if($(this)[0]['checked'] == true){
                    chkbxCounter += 1; 
                  }
                });
                                                                                                                                                         
                if(chkbxCounter > 0){
                  chkbxGrpCounter += 1;
                  $('#chkbxPU').html('');
                }
                else{
                  /* Display input validation message */
                    var mess = 'Please select at least one';
                    $('#chkbxPU').html(mess);
                }
              /* END - social platform general use checkboxes are checked */

              /**** Social media gig source checkboxes are checked ****/
                var chkbxCounter1 = 0; 
                $('.showcaseChannels').each(function(index){
                  if($(this)[0]['checked'] == true){
                    chkbxCounter1 += 1; 
                  }
                });
                
                if(chkbxCounter1 > 0 || $('#showcaseChan_other').val() != ''){
                  chkbxGrpCounter += 1;
                  $('#chkbxSC').html('');
                }
                else{
                  /*Display input validation message */
                    var mess = 'Please select at least one';
                    $('#chkbxSC').html(mess);
                }
              /* END - Social media gig source checkboxes are checked */

              /* Check that all checkbox groups have at least one selection */
                if(chkbxGrpCounter == 4){
                  form.submit();
                }
            },

          /* Set validation rules for the form */
            rules:{
              gigSource1: {
                require_from_group: [1, ".gigSource"],
              },
              gigSource2: {
                require_from_group: [1, ".gigSource"],
              },
              currentPay: {
                required: true,
              },
              gigSearchFreq: {
                required: true,
              },
            },
            messages: {
              talent1: {
                required: 'Please select a talent',
              }
            }
        });  
  </script>
  
  </body>
</html>
