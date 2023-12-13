<?php 
	/* GospelScout Terms and Conditions Page */


	/* Require the Header */
		require_once(realpath($_SERVER['DOCUMENT_ROOT']) . "/include/headerNew.php");
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/dbConnect.php');

?>

<div class="container mb-3" style="margin-top:100px;>
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 big-title text-center">
        	<h5>Terms & Conditions</h5>
        	<hr>
        </div>
		<div class="col-md-12 col-sm-12 col-lg-12" style="text-align: left; font-size:14px">
			<!-- Terms & Conditions Intro -->
				<p><b>Please read these Terms of Use carefully before using the <a class="text-gs" href="https://www.stage.gospelscout.com" target="_blank">https://www.stage.gospelscout.com</a> website operated by GospelScout.</b></p>
				<p>Your access to and use of the Site is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Site.</p>
				<p>By accessing or using the Site you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Site.</p>
			<!-- /Terms & Conditions Intro -->

			<!-- Content -->
				<b>Content</b>
				<p>Our Site allows you to post, link, store, share and otherwise make available certain information,text, graphics, videos, and/or other material. You are responsible for posting content that meets GospelScout guidelines. These guidelines include but are not limited to the following:</p>
				<ol>
					<li>Neither User, Artist, Church, nor entity using the site is allowed to post vulgar, provocative, derogatory or any content GospelScout deems to be inappropriate and in conflict with it's moral standards, including but not limited to inappropriate video, pictures, captions, comments, and the like.</li>
					<li>Users, Artists, Churches, and other entities using the Site are expected to post content representative of themselves and not other persons or entities. Failure to comply with this will result in the immediate removal of the misleading content.</li>
				</ol>

				<b>Links To Other Web Sites</b>
				<p>Our Site may contain links to third-party web sites or services that are not owned or controlled by GospelScout.</p>
				<p>GospelScout has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that GospelScout shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.</p>
			<!-- /Content -->
			
			<!-- Google Calenar -->
				<b>Google Calendar Data</b>
				<p>By granting GospelScout permission to access your google calendar data, you are agreeing to the following:</p>
				<ol>
					<li>GospelScout can request and use my data to display my personal Google calendar events on my GospelScout calendar for my view only.</li>
					<li>GospelScout can request and use my data to determine scheduling conflicts when I create or accept a gig on the GospelScout website.</li>
					<li>GospelScout can request and use my data to insert booked gigs into my Google Calendar. </li>
					<li>GospelScout can refresh permissions to access my Google calendar data, through the use of refresh tokens, until I explicitly un-link my Google Calendar from my GospleScout profile, via my <a href="https://www.stage.gospelscout.com/calendar/?u_Id=<?php echo $currentUserID;?>" target="_blank">fullcalendar page</a>, or until I remove my GospelScout profile all together. </li>
				</ol>
			<!-- /Google Calenar -->

			<!-- Liability -->
				<b>Liability</b>
				<p>GospelScout's liability is very limited regarding creative content posted on the site by any user. By using the site you acknowledge and agree to the following:</p>
				<ol>
					<li>GospelScout is not liable for any user, artist, or church failing to provide and/or produce services as they themselves have advertised via their profiles or other website tools. By using the site users, artists, churches, and other entities accept responsibility for their own actions and practices and release GospelScout from liability of any and all deceptive actions or practices and subsequent resulting actions of users that choose to abuse, misuse, and/or misrepresent themselves in any way.</li>
					<li>GospelScout is not a talent agency and does not represent any talent found on the site. GospelScout claims no responsibility for any user that uses the site deceptively or against GospelScout policy. GospelScout is its own separate entity, whose views and opinions are not represented by any user, artist, church, or other entity that uses the site.</li>
				</ol>
			<!-- /Liability -->

			<!-- Changes -->
				<b>Changes</b>
				<p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>
			<!-- /Changes -->

			<!-- Contact -->
				<b>Contact Us</b>
				<p>If you have any questions about these Terms, please <a class="text-gs" href="<?php echo URL; ?>/#Contact-Us" target="_blank">contact us</a>.</p>
			<!-- /Contact -->
		</div>
	</div>
</div>
<?php 
	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>