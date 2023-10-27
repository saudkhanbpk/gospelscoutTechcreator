
<?php 
    /* Public Gigs */

    $backGround = 'bg2';
    $page = 'Pending Gigs';
    /* Require the Header */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
    /* Create DB connection to Query Database for Artist info */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
?>

<!-- Dropzone.js file upload plugin -->
    <link href="<?php echo URL; ?>node_modules/dropzone/dist/dropzone.css" rel="stylesheet">
    <script src="<?php echo URL;?>node_modules/dropzone/dist/dropzone.js"></script>


<!-- style the stripe form -->
<style>
    /**
    * The CSS shown here will not be introduced in the Quickstart guide, but shows
    * how you can use CSS to style your Element's container
    */
    .StripeElement {
        box-sizing: border-box;

        height: 40px;
        color: blue;
        padding: 10px 12px;
        display: block;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;

        box-shadow: 2px 1px 3px 2px #d2d7dd;// e6ebf1
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
    ul {
        list-style: none;
    }
    li {
        font-size: 12px;
    }

    /* Dropzone Css  */
        h1 { text-align: center; }

        .dropzone1 {
            background: white;
            border-radius: 5px;
            border: 2px dashed rgba(149,73,173,1);
            border-image: none;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
    /* Dropzone Css */
</style>
   

<section class="features" id="features" style="background-color: rgb(255,255,255);">
    <div class="container p-0">
        <div class="row m-0 p-0">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto p-0 my-0 mb-0" style="box-shadow: 0px 10px 10px 8px #888888;">
                
                <!-- Vendor Form Body -->
                <div class="container bg-white mb-0 pt-4 pb-0">
                    <div class="row mb-0 pb-0">
                        <div class="col text-center mb-0 pb-0"><img class="mx-auto" src="https://www.gospelscout.com/img/logoJpg.jpg" alt="" width="80" height="90" style="object-fit:cover; object-position:0,0;"></div>
                    </div>
                    <div class="row my-0 p-0">
                        <div class="col text-center m-0 p-0" style="padding:0px; margin:0px;">
                            <p class="mb-0 pb-0" style="font-family:boogaloo;font-size:2em;">#artistShowCase<span class="text-gs">LA</span></p>
                            <p class="my-0 p-0" style="font-size:.7em;color:#888888">Sunday, August 6, 2023</p>
                            <p class="mt-0 p-0" style="font-size:1em;">Artist Submission</p>
                        </div>
                    </div>
                </div>

                <div class="container mt-0 pt-0">
                    <form  action="" method="post" name="artistSubmission" id="artist-form" class="needs-validation gigEdit pb-4" table="gigdetails" novalidate>
                        <div class="container">
                            <h5 class="text-gs text-center text-md-left">Artist Info</h5>
                            <div class="row p-0 pl-md-2">
                                <div class="col-12 col-md-7">
                                    <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Name<span class="colon">*</span></label>
                                    <input type="text" class="form-control form-control-sm mb-2" name="name" placeholder="Name" value="">
                                </div>
                                <div class="col-12 col-md-7">
                                    <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">City<span class="colon">*</span></label>
                                    <input type="text" class="form-control form-control-sm mb-2" name="city" placeholder="City" value="">
                                </div>

                                <!-- State -->
                                    <?php 
                                        /* Fetch States */
                                            $paramArray['country_id']['='] = 231;  
                                            $emptyArray = array();
                                            $stateArray = pdoQuery('states','all',$paramArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray);

                                        /* END - Fetch States */
                                    ?>
                                    <div class="col-12 col-md-7">
                                        <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">State<span class="colon">*</span></label>
                                        <select class="custom-select dropdown"  name="state" id="state" style="height: 30px;font-size: 14px;font-color:rgba(0,0,0,.01);">
                                            <option  value="">State</option>
                                            <?php 
                                                foreach($stateArray as $evID => $state) {
                                                        echo '<option id="'.$state['id'].'"  value="' .$state['name'] . '" >' . $state['name'] . '</option>'; 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                
                                <div class="col-12 col-md-7">
                                    <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Zip Code<span class="colon">*</span></label>
                                    <input type="text" class="form-control form-control-sm mb-2" name="zipcode" placeholder="Zip Code" value="">
                                </div>
                                <div class="col-12 col-md-7">
                                    <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Contact Phone</label>
                                    <input type="text" class="form-control form-control-sm mb-2" placeholder="(xxx)-xxx-xxxx" name="phone" id="vendorPhone" value="">
                                </div>
                                <div class="col-12 col-md-7">
                                    <label class="text-gs mb-1" style="font-size:12px;font-weight:bold" for="">Email</label>
                                    <input type="text" class="form-control form-control-sm mb-2" placeholder="example@example.com" name="email" id="vendorEmail" value="">
                                </div>	
                                <div class="col-12 col-md-7">
                                    <label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;">What's your talent?</label>
                                    <select class="custom-select form-control-sm my-2 py-1" name="talent" required>
                                        <option value="">Select Your Talent</option>
                                        <?php 
                                            // $getAllTalents = $obj->fetchRowAll('giftmaster', 'isActive = 1');
											$getAllTalents = $obj->fetchRowAll('giftmaster', 'isActive = 1', $db);
											// $getTalents = $obj->fetchRowAll('talentmaster', 'iLoginID = ' . $currentUserID, $db);
                                            foreach($getAllTalents as $tal){
                                                echo '<option value="' . $tal['iGiftID'] . '">' . $tal['sGiftName'] . '</option>';
                                            }
                                        ?>
                                    </select>
                                    <!-- <textarea class="form-control mb-2" name="productDescription" placeholder="Brief description of your goods and services..." wrap="" rows="5" aria-label="With textarea"></textarea> -->
                                </div>
                            </div>
                            <div class="row pt-2 pl-md-2">
                                <div class="col-12 col-md-7"> 
                                    <label class="text-gs mb-1 mt-2" style="font-size:12px;font-weight:bold;">Social Media</label>
                                    <input type="text" class="form-control form-control-sm mb-2" placeholder="https://www.instagram.com/[yourhandle]/" name="ig" id="ig" value="">
                                    <input type="text" class="form-control form-control-sm mb-2" placeholder="https://www.facebook.com/[yourhandle]/" name="fb" id="fb" value="">
                                    <input type="text" class="form-control form-control-sm mb-2" placeholder="https://www.youtube.com/channel/[uid]" name="yt" id="yt" value="">
                                </div>
                            </div>
                        </div>
                        
                        <hr class="featurette-divider my-5" id="upcomingDates">
                        
                        <div class="container">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class= "btn btn-md btn-gs" >Submit</button>
                                </div>
                            </div>
                        </div>

                        
                    </form>
                </div>
                <!-- END - Vendor Form Body -->
                              

            </div>
        </div>
    </div>
</section>





<?php 
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/ourevents/showcase/showcasela/artistapp/phpBackend/indexModals.php'); 
    require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/footer.php");
?>
<script src="<?php echo URL;?>js/jquery.validate.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo URL;?>ourevents/showcase/showcasela/artistapp/js/indexJS.js?1"></script> 