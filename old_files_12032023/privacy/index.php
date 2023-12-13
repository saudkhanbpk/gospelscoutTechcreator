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
        	<h4 style="font-weight:700">Privacy</h4>
        	<hr>
        </div>
		<div class="col-md-12 col-sm-12 col-lg-12" id="privPageDiv" style="text-align: left; font-size:14px">
			<p>GospelScout operates <a href="https://www.gospelscout.com" target="_blank">https://www.gospelscout.com</a> . This page informs you of our policies regarding the collection, use and disclosure of Personal Information we receive from users of the Site.</p>

			<p>We use your Personal Information only for providing and improving the Site. By using the Site, you agree to the collection and use of information in accordance with this policy.</p>

			<h4 class="mb-0" style="font-weight:700">Information Collection And Use</h4>

			<p>While using our Site, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information may include, but is not limited to your name, email address, street address, city, state, zip code, and date of birth. Your name, email address, and other information pertinent to the function of the website may be viewable and discoverable by other users, in accordance with your settings on your account.</p>

			<h4 class="mb-0" style="font-weight:700">Google Calendar Data</h4>

			<p class="mb-0">
				Gospelscout will <strong>ONLY</strong> access and/or use data from your google calendar for any one of the following reasons: 
				<ol>
					<li>To determine & reduce scheduling conflicts when you book an event on our site. </li>
					<li>To display current events, from your google calendar, on your gospelscout calendar
						<ul style="list-style:none"><li><strong>Note:</strong>  The events displayed that originate from your google calendar can only be viewed by you. </li></ul>
					</li>

					<li>GospelScout will not disperse or disseminate any information or data received from google, on the user&apos;s behalf, to any third party entities without expressed consent from the user.</li>
					<li>GospelScout will not sell any information or data received from google, on a user&apos;s behalf, to any third party entities. </li>
					<li>Permission to access a user&apos;s Google Calendar data is not required in order for the user to utilize the main functionality of the GospelScout website, however data received by GospelScout, from Google, on the user&apos;s behalf will be used to enhance site functionality and usability for the user.</li>
				</ol>
			</p>
			
			<h4 class="mb-0" style="font-weight:700">Log Data</h4>

			<p>Like many site operators, we collect information that your browser sends whenever you visit our Site.</p>

			<p>This Log Data may include information such as your computer&#39;s Internet Protocol (&quot;IP&quot;) address, browser type, browser version, the pages of our Site that you visit, the time and date of your visit, the time spent on those pages and other statistics.</p>

			<h4 class="mb-0" style="font-weight:700">Communications</h4>

			<p>We may use your Personal Information to contact you in response to certain actions you initiate or engage in on the site, including but not limited to booking artists, being booked by other users, and other financial transactions. In addition we may use your Personal Information to contact you with newsletters, marketing or promotional materials and other information that will help increase the usability of the Site.</p>

			<h4 class="mb-0" style="font-weight:700">Links to Other Sites</h4>

			<p>GospelScout.com may link to other sites outside of our control and ownership. We at GospelScout advise you to read the Privacy Policies of each website you visit.</p>

			<h4 class="mb-0" id="cookies" style="font-weight:700">Cookies</h4>

			<p>Cookies are files with small amounts of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and stored on your computer&#39;s hard drive.</p>

			<p>Like many sites, we use &quot;cookies&quot; to collect information. GospelScout.com may store cookies on your computer when you visit the pages of our website. In addition, we may use third party services such as Google Analytics that collect, monitor and analyze this data in order to optimize site performance. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Site.</p>

			<h4 class="mb-0" style="font-weight:700">Security</h4>

			<p>The security of your Personal Information is important to us, but remember that no method of transmission over the Internet, or method of electronic storage, is 100% secure. While we strive to use commercially acceptable means to protect your Personal Information, we cannot guarantee its absolute security.</p>

			<h4 class="mb-0" style="font-weight:700">Changes To This Privacy Policy</h4>

			<p>This Privacy Policy is effective as of 07/14/2016 and will remain in effect except with respect to any changes in its provisions in the future, which will be in effect immediately after being posted on this page.</p>

			<p>We reserve the right to update or change our Privacy Policy at any time and you should check this Privacy Policy periodically. Your continued use of the Site after we post any modifications to the Privacy Policy on this page will constitute your acknowledgment of the modifications and your consent to abide and be bound by the modified Privacy Policy.</p>

			<p>If we make any material changes to this Privacy Policy, we will notify you either through the email address you have provided us, or by placing a prominent notice on our website.</p>

			<h4 class="mb-0" style="font-weight:700">Contact Us</h4>

			<p>If you have any questions about this Privacy Policy, please <a class="text-gs" href="<?php echo URL;?>/#Contact-Us" target="_blank">contact us</a>.</p>
		</div>
	</div>
</div>
<?php 
	/* Include the footer */ 
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/include/footerNew.php');
?>