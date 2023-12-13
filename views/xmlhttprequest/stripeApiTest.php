<?php

/* Stripe API test */

/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");

	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

/* Include Composer's Autoloader file to automatically detect which PHP package's library is required */
	include(realpath($_SERVER['DOCUMENT_ROOT']) . '/Composer1/vendor/autoload.php');	

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_GnBvGrcQ4xknuxXQlziz5r65");

// $charge = \Stripe\Charge::create([
//     'amount' => 999,
//     'currency' => 'usd',
//     'source' => 'tok_visa',
//     'receipt_email' => 'jenny.rosen@example.com',
// ]);

// echo '<pre>';
// echo $charge->id;




/* Create Customer function */
	// function createStripeCust(){

	// }

/*
	0. Securely Collect payment details from users
		a. Set up Stripe Elements 
			i. Include the following on all site pages (footer.php):  <script src="https://js.stripe.com/v3/"></script>
			ii. Create an instance of Elements: 
				0. var stripe = Stripe('pk_test_mvwPTPJ6rSe6P4lmWIr5pbwr');
				1. var elements = stripe.elements();
		b. Create Payment form 
			i. Create empty DOM element (<div id="unique-id"></div>) within payment form for dynamically inserting the payment fields
			ii. Create empty DOM element (<div id="card-errors"></div>) to display errors
		c. Once form is loaded, create instance of an Element and mount to the element container
			i. 	// Custom styling can be passed to options when creating an Element.
				var style = {
				  base: {
				    // Add your base input styles here. For example:
				    fontSize: '16px',
				    color: "#32325d",
				  }
				};

				// Create an instance of the card Element.
				var card = elements.create('card', {style: style});

				// Add an instance of the card Element into the `card-element` <div>.
				card.mount('#card-element');
		d. Create an eventlistener to catch and display errors in real-time to users
			i.	card.addEventListener('change', function(event) {
				  var displayError = document.getElementById('card-errors');
				  if (event.error) {
				    displayError.textContent = event.error.message;
				  } else {
				    displayError.textContent = '';
				  }
				});
		e. Create a token to securely transmit card infomation 
			i.	// Create a token or display an error when the form is submitted.
				var form = document.getElementById('payment-form');
				form.addEventListener('submit', function(event) {
				  event.preventDefault();

				  stripe.createToken(card).then(function(result) {
				    if (result.error) {
				      // Inform the customer that there was an error.
				      var errorElement = document.getElementById('card-errors');
				      errorElement.textContent = result.error.message;
				    } else {
				      // Send the token to your server.
				      stripeTokenHandler(result.token);
				    }
				  });
				});
		f. Submit the token and the rest of your form to your server
			i. Create the function used in step e. to submit the token to the server
			function stripeTokenHandler(token) {
			  // Insert the token ID into the form so it gets submitted to the server
			  var form = document.getElementById('payment-form');
			  var hiddenInput = document.createElement('input');
			  hiddenInput.setAttribute('type', 'hidden');
			  hiddenInput.setAttribute('name', 'stripeToken');
			  hiddenInput.setAttribute('value', token.id);
			  form.appendChild(hiddenInput);

			  // Submit the form
			  form.submit();
			}
		g. Viewport Meta Tag Requirements
			i. <meta name="viewport" content="width=device-width, initial-scale=1" />
	1. Create source 
		a. Create RE-Usable sources Only
	2. create customer
		a. attach RE-Usable source to customer object
	3. Create Product/service
	4. Create charge/invoice for specific product/service 
*/

?>
<style>
	/**
	* The CSS shown here will not be introduced in the Quickstart guide, but shows
	* how you can use CSS to style your Element's container.
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
</style>


<div class="container mt-5" style="min-height:500px">
	<div class="row">
		<div class="col">
			<a href="#" data-toggle="modal" data-target="#gig-list-sm"> Call Modal</a>


			<!-- Modal to display gigs on small screen -->
				<div class=" modal" id="gig-list-sm" tabindex="-1" role="dialog" aria-labelledby="gig-list-sm" aria-hidden="true">
				    <div class="modal-dialog modal-dialog-centered" role="document">
				      <div class="modal-content">
				        <div class="modal-header">
				          <h5 class="modal-title text-gs" id="gig-list-sm-title">Payment Information</h5>
				          <span id="loadlogin"></span> 
				          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				            <span aria-hidden="true">&times;</span>
				          </button>
				        </div>

				        <div class="container mt-2" style="font-size:12px">
				        	<p>Your information is transmitted and stored safely and securely using our Stripe API.</p>
				        </div>

					      <div class="modal-body px-4" id="gigList-sm">
					      	<form class="" action="<?php echo URL;?>stripePayApi/stripeApiTest.php" method="post" id="payment-form">
								<div class="form-row">
									<div class="container pb-1">
										<p class="mb-0">Credit or debit card</p>
									</div>
									<div class="col d-block" id="card-element">
									<!-- A Stripe Element will be inserted here. -->
									</div>

									<!-- Used to display Element errors. -->
									<div id="card-errors" role="alert"></div>
								</div>

								<button type="submit" class="btn btn-sm btn-gs mt-3">Submit</button>
							</form>
					      </div>
					      <!-- Modal Footer -->
					        <div class="modal-footer px-4" style="font-size:13px">
					          <div class="checkbox container p-0" id="postDisplay-sm"> 
					           <p class="d-inline m-0 font-weight-bold" style="font-size:12px">Powered by </p>
					           <img class="" src="<?php echo URL;?>img/stripeLogo.png" height="30px" width="50px">
					          </div>
					        </div>
					        <!-- /Modal Footer -->
				      </div>
				    </div>
				</div>
			<!-- /Modal to display gigs on small screen -->
		</div>
	</div>

</div>

<?php include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php'); ?>
<script src="https://js.stripe.com/v3/"></script>
<script>
(function() {
  "use strict";
	var stripe = Stripe('pk_test_mvwPTPJ6rSe6P4lmWIr5pbwr');
	var elements = stripe.elements();

	/* Custom styling can be passed to options when creating an Element. */
		var style = {
			base: {
				color: '#32325d',
				fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
				fontSmoothing: 'antialiased',
				fontSize: '16px',
				'::placeholder': {
					color: '#aab7c4'
				}
			},
				invalid: {
				color: '#fa755a',
				iconColor: '#fa755a'
			}
		};

	/* Create an instance of the card Element. */
		var card = elements.create('card', {style: style});

	/* Add an instance of the card Element into the `card-element` <div>. */
		card.mount('#card-element');

	/* Add an event listener to the card element to catch errors */
		card.addEventListener('change', function(event) {
			var displayError = document.getElementById('card-errors');
			// console.log(event);
			if (event.error) {
				displayError.textContent = event.error.message;
			} else {
				displayError.textContent = '';
			}	
		});

	/* Define a function to add the card token to the payment info form and then submit the form to the server */
		function stripeTokenHandler(token) {
			/* Insert the token ID into the form so it gets submitted to the server */
				var form = document.getElementById('payment-form');
				var hiddenInput = document.createElement('input');
				hiddenInput.setAttribute('type', 'hidden');
				hiddenInput.setAttribute('name', 'stripeToken');
				hiddenInput.setAttribute('value', token.id);
				form.appendChild(hiddenInput);

			/* Submit the form */
				form.submit();
		}

	/* Create a token or display an error when the form is submitted. */
		var form = document.getElementById('payment-form');
		form.addEventListener('submit', function(event) {
			event.preventDefault();

			stripe.createToken(card).then(function(result) {
				console.log(result);
				if (result.error) {
					/* Inform the customer that there was an error. */
						var errorElement = document.getElementById('card-errors');
						errorElement.textContent = result.error.message;
				} else {
					/* Send the token to your server. */
						stripeTokenHandler(result.token);
				}
			});
		});

})();
</script>







