

<?php 
	/*
		Make public gig post more dynamic - allow users to request multiple artist within one gig post

		1. Turn type of artist select menue to a checkbox menu 
		2. create new table to store all artists needed for posted gig
			a. id
			b. gigId varchar
			c. artistType int
			d. status 
			e. iLoginID int
			f. selectionDate datetime

	*/

	/*

		apply trial period Action Plan

		level 1
			2. create user Subscription w/ trial period
				a. Get user's customer object
				b. create subscription object 
					i. Include the trial_period_days parameter with value "30"


		OR

		Apply Discount Action Plan

		level 1 
			1. create a coupon
				a. name: free-post-bid-period
				b. duration: once
				c. percent-off: 100
			2. Apply discount when user first bids or posts 
				a. get stripe subscription id
				b. create the update subscription object
					i. Include the coupon parameter with value "[coupon_id]"
			3. Modify and Update str_subscription table
				a. add column that indicates if coupon has been applied
				b. update column when discount is first apllied (prevents site from reapply discount)
	*/

?>

