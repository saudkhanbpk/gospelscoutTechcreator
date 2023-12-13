<?php 
	/* Public Gigs */

	$backGround = 'bg2';
	$page = 'Pending Gigs';
	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

    /* Check paid status for the gig */
        $emptyArray = array(); $columnsArray = array('paid'); $paramArray['gigId']['='] = $_GET['g_id'];
        $paidStatus = pdoQuery('postedgigsmaster',$columnsArray,$paramArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray,$emptyArray)[0];
       
        if($currentUserID != ''){
            if($paidStatus['paid'] == 1){
                // if paid status is true - redirect to the ad_details page
                echo '<script>window.location = "'. URL .'publicgigads/ad_details.php?g_id='.$_GET['g_id'].'"</script>';
                exit;
            }
       }else{
        echo '<script>window.location = "'. URL .'home/index.php";</script>';
        exit;
       }
        

    /* when submitting the gig for first time
        1. save gig to db after validation
        2. gig will have a pay status of "un-paid"
        3. once gig ad is saved successfully with a gig status of "un-paid"- redirect to the checkout page 
        4. once paid, redirect to the ad_details page
    */

        /* Upgrade payment functionality

            1. replace card element with payment element on the puw donation page
            2. replace card element with payment element on the publicgigads/index page payment modal
            3. Add a payment intent function to the publicgigads/phpBackend/connectToDb.php with client_secret to be returned for charging
            4. Add a save payment src checkbox to payment element form
            4.5. at check out, list the default payment src (last 4 digits and exp date)
            4.6. add a choose different src of payment anchor
            5. If user chooses to add a different payment src and save payment, use the "setup_future_usage: 'off_session'" config
                a. this will autmatically save this payment source to the customer Obj. (it will not update the default payment src if there is already one in place)
            6. Create section on myAccount.php to update payment info
                a. check db for customer obj id
                b. if customer obj doesn't exist - create a new customer Obj
                c. get customer Obj from stripe
                d. List and display all payment methods
                e. Create functionality to add new or remove existing payment methods from cust. Obj.
                f. Create functionality to update the default payment src 
        */
?>
<!-- Custom styles for this template -->
    <link href="<?php echo URL;?>checkout/css/checkout.css" rel="stylesheet">
<!-- <body> -->
<div class="container " style="margin-top:100px;min-height:300px">
    <div class="row mt-5">
        <div class="col-11 col-md-8 mt-5 pb-3 mx-auto" style="font-size:11px;"><!-- a-prof-shadow-->
            <div class="container mt-5 pb-2" style="border-bottom: 1px solid rgba(0,0,0,.1)">
                <div class="row">
                    <div class="col text-center">
                        <h1>Checkout</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-left">
                        <a href="https://www.gospelscout.com/publicgigads/index.php?gigID=<?php echo $_GET['g_id'];?>" style="text-decoration:underline"><-- Update Gig</a>
                    </div>
                </div>
            </div>
            <div class="container mt-5" id="replace_usage">
                <div class="row">
                    <div class="col col-md-6 mx-auto" id="curr_pay_display">
                        <!--Display default payment method-->
                        <div class="container text-center"><div class="row"><div class="col"><div class="container text-center"><div class="spinner-border text-center text-gs font-weight-bold" style="width:3em;height:3em;" id="payment-spinner" aria-hidden="true" role="status"><span class="sr-only">Loading...</span></div><p style="font-size:1.3em;" class="text-gs ml-0 font-weight-bold typedElement">Just One Sec...</p></div></div></div></div>
                    </div>
                </div>
            </div>
            <div class="container mt-5 pt-3" style="border-top: 1px solid rgba(0,0,0,.1)">
                <div class="row">
                    <div class="col col-md-3  d-none" id="post_gig_btn_cnt">
                        <a type="button" class="btn btn-sm btn-gs sendPost text-white" id="submitInquiry">Post Gig</a>
                    </div>
                    <div class="col col-md-6 pl-0">
                        <input type="hidden" value="<?php echo$_GET['g_id'];?>" name="gigid">
                        <a type="button" href="https://www.gospelscout.com/publicgigads/ad_details.php?g_id=<?php echo $_GET['g_id'];?>" class="btn btn-sm btn-gs">Pay & Post Later</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-6 mx-auto">
                        <div id="main-error-div"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<?php 
	/* Include the Modals page */
        // include(realpath($_SERVER['DOCUMENT_ROOT']) . '/publicgigads/phpBackend/indexModals.php');
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/checkout/phpBackend/checkoutModal.php');

	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>
<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo URL;?>checkout/js/checkoutJSFunctions.js?1"></script> 
<script src="<?php echo URL;?>checkout/js/checkoutJS.js?25"></script>