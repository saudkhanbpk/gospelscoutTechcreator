
<?php 
    /* Public Gigs */

    $backGround = 'bg2';
    $page = 'Pending Gigs';
    /* Require the Header */
        require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
    /* Create DB connection to Query Database for Artist info */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
?>


<section class="features" id="features" style="background-color: rgb(255,255,255);">
    <div class="container p-0">
        <div class="row m-0 p-0">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto p-0 my-0 mb-0" style="box-shadow: 0px 10px 10px 8px #888888;">
                <div class="container bg-white mb-0 pt-4 pb-0">
                    <div class="row mb-0 pb-0">
                        <div class="col text-center mb-0 pb-0"><img class="mx-auto" src="https://www.gospelscout.com/img/logoJpg.jpg" alt="" width="80" height="90" style="object-fit:cover; object-position:0,0;"></div>
                    </div>
                    <div class="row my-0 p-0">
                        <div class="col text-center m-0 p-0" style="padding:0px; margin:0px;">
                            <p class="mb-0 pb-0" style="font-family:boogaloo;font-size:2em;">#artistShowCase<span class="text-gs">LA</span></p>
                            <p class="my-0 p-0" style="font-size:.7em;color:#888888">Sunday, August 6, 2023</p>
                            <p class="mt-0 p-0" style="font-size:1em;">Artist Submissions</p>
                        </div>
                    </div>

                    <div class="row my-0 p-0">
                        <div class="col text-center m-0 p-0" style="padding:0px; margin:0px;" id="tableContainer">
                            <div class="spinner-border text-gs" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php 
    include(realpath($_SERVER['DOCUMENT_ROOT']) . '/ourevents/showcase/showcasela/artistappreview/phpBackend/indexModals.php'); 
    require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/home/include/footer.php");
?>
<script src="<?php echo URL;?>js/jquery.validate.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo URL;?>ourevents/showcase/showcasela/artistappreview/js/indexJS.js?1"></script> 