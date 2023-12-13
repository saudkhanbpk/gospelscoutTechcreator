<?php 
	/* Help Page */

	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');
?>


<div class="container mt-5">
	<div class="row">
		<div class="col">
			<h3 class="my-3">User Help Guide</h3>

			<div class="accordion" id="accordionExample">
			  <div class="card">
			    <div class="card-header" id="headingOne">
			      <h2 class="mb-0">
			        <button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			          How to create a profile
			        </button>
			      </h2>
			    </div>
			    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
			      <div class="card-body">
			      	<ul>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 1</span> - Navigate to the site's homepage by one of two ways: 
			      			<ul>
			      				<li>Click the “Login/Signup” link in the top right hand corner of the any page,  then click the “Create Account” link </li>
			      				<li>Click the “GospelScout” link in the top left corner of any page</li>
			      			</ul>
			      		</li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 2</span> - Scroll down to the “Create an Account” section and select the type of profile you would like to build
			      			<ul>
			      				<li>Artist</li>
			      				<li>Church</li>
			      				<li>General User</li>
			      			</ul>
			      		</li>
			      		<li class="list-unstyled my-1">
			      			<span class="font-weight-bold">Step 3</span> - Follow the 5 step guided prompt (the completion of all fields is required)
			      		</li>
			      	</ul>
			      </div>
			    </div>
			  </div>
			  <div class="card">
			    <div class="card-header" id="headingTwo">
			      <h2 class="mb-0">
			        <button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			          How to deactivate your account
			        </button>
			      </h2>
			    </div>
			    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
			      <div class="card-body">
			        <ul>
			        	<li class="list-unstyled my-1"><span class="font-weight-bold">Step 1</span> - Sign into your account </li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 2</span> - Navigate to your "Edit Profile" page by: 
			      			<ol>
			      				<li>Clicking on the profile menu icon in the top left corner of the page</li>
			      				<li>Click on the "Acct Info" link</li>
			      			</ol>
			      		</li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 3</span> - Scroll down to the “Deactivate My Account” section
			      			<ol>
			      				<li>Explain reason for deactivation</li>
			      				<li>Click the "Deactivate My Account" button </li>
			      				<li>Confirm account deactivation</li>
			      			</ol>
			      		</li>
			      		<li class="list-unstyled my-1">
			      			<span class="font-weight-bold">NOTE:</span> 
			      			<ul>
			      				<li>
			      					Once your account is deactivated you will need to log in with your email address and password and request that your account be reactivated
			      				</li>
			      			</ul>
			      		</li>
			      	</ul>
			      </div>
			    </div>
			  </div>
			  <div class="card">
			    <div class="card-header" id="headingThree">
			      <h2 class="mb-0">
			        <button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
			          How to upload videos
			        </button>
			      </h2>
			    </div>
			    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
			      <div class="card-body">
			        <ul>
			        	<li class="list-unstyled my-1"><span class="font-weight-bold">Step 1</span> - Sign into your account </li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 2</span> - Navigate to your Profile page by:  
			      			<ol>
			      				<li>Clicking on your name in the top left corner of the page</li>
			      			</ol>
			      		</li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 3</span> - Click on the "VIDEOS" tab</li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 4</span> - Click on the "Add New Videos" button</li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 5</span> - Follow the step by step prompt:  
			      			<ol>
			      				<li>Select a the talent associated with the video being uploaded</li>
			      				<li>You can embed a youtube video or upload an mp4 video under 200MB from your personal device.
			      					<ol style="font-size: 13px">
			      						<li class="list-unstyled my-1">
							      			<span class="font-weight-bold">NOTE:</span> 
							      			<ul>
							      				<li>
							      					Click on the “how?” link to view directions on embedding youtube videos
							      				</li>
							      			</ul>
							      		</li>
			      					</ol>
			      				</li>
			      				<li>Add a video title and optionally, a video description</li>
			      				<li>Click the Submit button to add new video</li>
			      			</ol>
			      		</li>
			      	</ul>
			      </div>
			    </div>
			  </div>
			  <div class="card">
			    <div class="card-header" id="headingFour">
			      <h2 class="mb-0">
			        <button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
			          How to upload photos
			        </button>
			      </h2>
			    </div>
			    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
			      <div class="card-body">
			         <ul>
			        	<li class="list-unstyled my-1"><span class="font-weight-bold">Step 1</span> - Sign into your account </li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 2</span> - Navigate to your Profile page by:  
			      			<ol>
			      				<li>Clicking on your name in the top left corner of the page</li>
			      			</ol>
			      		</li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 3</span> - Click on the "PHOTOS" tab</li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 4</span> - Click on the "Add New Photos" button</li>
			      		<li class="list-unstyled my-1"><span class="font-weight-bold">Step 5</span> - Complete the required fields:  
			      			<ol>
			      				<li>Select an existing album or Create a new album to store the photos under.</li>
			      				<li>Add a photo caption</li>
			      				<li>Browse and select an image from your personal device</li>
			      				<li>Click the "Add Photo" button to add new photo</li>
			      			</ol>
			      		</li>
			      	</ul>
			      </div>
			    </div>
			  </div>
			  <div class="card">
			    <div class="card-header" id="headingFive">
			      <h2 class="mb-0">
			        <button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
			          How to find gigs
			        </button>
			      </h2>
			    </div>
			    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
			      <div class="card-body">
			         <ul>
			        	<li class="list-unstyled my-1"><span class="font-weight-bold">Step 1</span> - Sign into your account </li>
			        	<li class="list-unstyled my-1"><span class="font-weight-bold">Step 2</span> - Click on the profile menu icon in the top left corner of the page</li>
			        	<li class="list-unstyled my-1"><span class="font-weight-bold">Step 3</span> - Click the "Find Gigs" link</li>
			        	<li class="list-unstyled my-1">
			      			<span class="font-weight-bold">NOTE:</span> 
			      			<ul>
			      				<li>
			      					Availabe gigs are listed by the state, then city, then month in which they will occur.  If no gigs are availible the page will be empty.
			      				</li>
			      			</ul>
			      		</li>
			        </ul>
			      </div>
			    </div>
			  </div>
			  <div class="card">
			    <div class="card-header" id="headingSix">
			      <h2 class="mb-0">
			        <button class="btn btn-link collapsed text-gs" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree">
			          How to post gigs
			        </button>
			      </h2>
			    </div>
			    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
			      <div class="card-body">
			        <ol>
			        	<li class="my-1"><span class="font-weight-bold">Users can post public gigs</span> - A gig post made available to all artists on the gospelScout website, for which all qualified artists can place a bid to play.
			        		<ul>
			        			<li class="list-unstyled my-1"><span class="font-weight-bold">Step 1</span> - Sign into your account </li>
			        			<li class="list-unstyled my-1"><span class="font-weight-bold">Step 2</span> - Click on the profile menu icon in the top left corner of the page</li>
			        			<li class="list-unstyled my-1"><span class="font-weight-bold">Step 3</span> - Click the "Manage Gigs" link</li>
			        			<li class="list-unstyled my-1"><span class="font-weight-bold">Step 4</span> - Click the "Manage Gigs" button</li>
			        			<li class="list-unstyled my-1"><span class="font-weight-bold">Step 5</span> - Click the "Post A Public Gig" button</li>
			        			<li class="list-unstyled my-1"><span class="font-weight-bold">Step 6</span> - Complete the form and Submit</li>
			        		</ul>
			        	</li>
			        	<li class="my-1"><span class="font-weight-bold">Users can submit private gig requests</span> - A gig request is created by, what we refer to as a “gig manager”.  The gig request outlines all the pertinent details of the gig and provides the capability for the gig manager to request specific artists to play.</li>
			        </ol>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>

<?php 
	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>