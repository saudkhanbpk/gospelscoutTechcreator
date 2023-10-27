<?php 
	/************************************* Profile Subscribe Tab Content *****************************/
    	/* Returns the number of subscribers */
            $subscrib = $obj->fetchNumOfRow("subscription","iRollID = ".$currentUserID." AND isActive = 1"); 
        
        /* Returns Your Subscribers */
            $subscribersArray = $obj->fetchRowAll("subscription","iRollID = ".$currentUserID." AND isActive = 1");

        /* Returns Your Subscriptions */
             $subscriptionArray = $obj->fetchRowAll("subscription","iLoginID = ".$currentUserID." AND isActive = 1");

        /* Returns the current user's subscibe settings */
        	$subscribeeSettings = $obj->fetchRow('subscribeesetting', 'iRollID='.$currentUserID);
        	$subscriberSettings = $obj->fetchRow('subscribersetting', 'iLoginID='.$currentUserID);	

        /* Check if the user is logged in - display different output, contingent upon a user being logged */
            if($profOwner == "1") {
?>
    <!-- Subscribee Settings -->	
        <h6 class="text-gs mt-3 mb-2">My Subscribers </h6>
        <h6 style="font-size:15px">You Have <span class="text-danger"><?php echo $subscrib; ?></span> Subscriber(s)</h6>
        <h6 class="text-gs" style="font-size: 12px">Subscribe Settings</h6>
        <div class="container pb-4" style="border-bottom: 1px solid rgba(0,0,0,.5)">
        	<h6 class="text-gs" style="font-size: 12px">Notify My Subscribers When:</h6>
        	<form name="subscribeeSettings" id="subscribeeSettingsChange" action="" method="post" enctype="multipart/form-data">
        	    <div class="subscribeSettings" style="font-size:13px">
        	    	<div class="custom-control custom-checkbox"> 
        			  <input type="checkbox" class="custom-control-input subscribeeSettings" name="vidNotification" id="custom-Check1" value="1" <?php if($subscribeeSettings['vidNotification'] == 1){echo 'checked';}?>>
        			  <label class="custom-control-label" for="custom-Check1">New Videos are Uploaded</label>
        			</div>
        			<div class="custom-control custom-checkbox">
        			  <input type="checkbox" class="custom-control-input subscribeeSettings" name="picNotification" id="custom-Check2" value="1" <?php if($subscribeeSettings['picNotification'] == 1){echo 'checked';}?>>
        			  <label class="custom-control-label" for="custom-Check2">New Photos are Uploaded</label>
        			</div>
        			<div class="custom-control custom-checkbox">
        			  <input type="checkbox" class="custom-control-input subscribeeSettings" name="eventNotification" id="custom-Check3" value="1" <?php if($subscribeeSettings['eventNotification'] == 1){echo 'checked';}?>>
        			  <label class="custom-control-label" for="custom-Check3">New <span class="text-gs">Public</span> Events Are Added to My Calendar</label>
        			</div>
        			<div class="custom-control custom-checkbox">
        			  <input type="checkbox" class="custom-control-input subscribeeSettings" name="gigNotification" id="custom-Check4" value="1" <?php if($subscribeeSettings['gigNotification'] == 1){echo 'checked';}?>>
        			  <label class="custom-control-label" for="custom-Check4">New <span class="text-gs">Public</span> Gigs Are Added to My calendar</label>
        			</div>
        	    </div>

        		<input type="hidden"  name="userID" value="<?php echo $currentUserID;  ?>">
        	    <button type="submit" id="subscribeeButton" class="settingsChange mt-3 btn-sm">Save Changes</button>
        	    <div id='chngSaved'></div>
        	</form>
        </div>
    <!-- /Subscribee Settings -->	

	<!-- Subscriber Settings -->	
    	<h6 class="text-gs mt-3 mb-2">My Subscriptions </h6>
    	<h6 class="text-gs" style="font-size: 12px">Subscription Settings</h6>
    	<div class="container pb-4">
    		<h6 class="text-gs" style="font-size: 12px">Notify Me When:</h6>
    		<form name="subscriberSettings" id="subscriberSettingsChange" action="" method="post" enctype="multipart/form-data">
    	      	<div class="subscribeSettings" style="font-size: 13px"> 
    	            <div class="custom-control custom-checkbox"> 
    				  <input type="checkbox" class="custom-control-input subscriberSettings" name="vidNotification" id="SubscriptionCheck1" value="1" <?php if($subscriberSettings['vidNotification'] == 1){echo 'checked';}?>>
    				  <label class="custom-control-label" for="SubscriptionCheck1">New Videos are Uploaded</label>
    				</div>
    				<div class="custom-control custom-checkbox">
    				  <input type="checkbox" class="custom-control-input subscriberSettings" name="picNotification" id="SubscriptionCheck2" value="1" <?php if($subscriberSettings['picNotification'] == 1){echo 'checked';}?>>
    				  <label class="custom-control-label" for="SubscriptionCheck2">New Photos are Uploaded</label>
    				</div>
    				<div class="custom-control custom-checkbox">
    				  <input type="checkbox" class="custom-control-input subscriberSettings" name="eventNotification" id="SubscriptionCheck3" value="1" <?php if($subscriberSettings['eventNotification'] == 1){echo 'checked';}?>>
    				  <label class="custom-control-label" for="SubscriptionCheck3">New Events Are Added to Their Calendar</label>
    				</div>
    				<div class="custom-control custom-checkbox">
    				  <input type="checkbox" class="custom-control-input subscriberSettings" name="gigNotification" id="SubscriptionCheck4" value="1" <?php if($subscriberSettings['gigNotification'] == 1){echo 'checked';}?>>
    				  <label class="custom-control-label" for="SubscriptionCheck4">New Gigs Are Added Their calendar</label>
    				</div>
    	            <input type="hidden" name="userID" value="<?php echo $currentUserID;  ?>">
    	        </div>
    	        <button type="button" id="subscriberButton" class="settingsChange mt-3 btn-sm">Save Changes</button>
    	    </form>
        	<div id='chngSaved1'></div>
    	</div>
    <!-- /Subscriber Settings -->


    <form action="" method="POST" enctype="multipart/form-data" id="muteRemoveForm">
        <!-- Display artists and churched that you are currently subscribed to -->
            <h6 class="text-gs" style="font-size: 12px">Subscriptions:</h6>
            <div class="container">
                <div class="row" style="font-size: 13px">
                    <?php foreach($subscriptionArray as $subscription){ ?>

                        <div class="col-12 col-md-6">
                            <div class="custom-control custom-checkbox"> 
                                <input type="checkbox" class="custom-control-input subscCheckbox" name="userSubscriptions[<?php echo $subscription['iRollID']; ?>]" id="userID_<?php echo $subscription['iRollID']; ?>" value="1">
                                <label class="custom-control-label" for="userID_<?php echo $subscription['iRollID']; ?>"><a href="<?php echo URL;?>views/<?php if($subscription['sType'] == 'artist' || $subscription['sType'] == 'group'){echo 'artist';}else{echo 'church';}?>profile.php?<?php if($subscription['sType'] == 'artist' || $subscription['sType'] == 'group'){echo 'artist=';}else{echo 'church=';}?><?php echo $subscription['iRollID'];?>" class="text-gs"><?php echo ucwords($subscription['sName']);?></a></label>
                                <img class="ml-1 <?php if($subscription['muteNotification'] == 0){echo 'd-none';}?>" src="<?php echo URL;?>img/muteSymbol.png" height="12px" width="12px" class="img-fluid" alt="Responsive image">
                                 <?php 
                                    // if($subscription['muteNotification'] == '1'){
                                    //     echo '<img class="ml-1" src="../img/muteSymbol.png" height="12px" width="12px" class="img-fluid" alt="Responsive image">';
                                    // } 
                                ?>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
            <!-- user_<?php echo $subscription['iRollID']; ?> -->
        <!-- /Display artists and churched that you are currently subscribed to -->

        <input type="hidden" name="table" value="subscription">
        <input type="hidden" name="iLoginID" value="<?php echo $currentUserID;  ?>">

        <!-- Mute notifications for specific artists/churches or unsubscribe to specific artists/churches -->
            <div class="container my-3">
                <div class="row">
                    <div class="col col-md-3 col-lg-2 mt-1"> 
                        <button type="button" class="btn btn-gs btn-sm muteRemove-choice" id="muteNot">Mute</button>
                    </div>
                    <div class="col col-md-4 col-lg-3 mt-1">
                        <button type="button" class="btn btn-gs btn-sm muteRemove-choice" id="unMuteNot">Un-Mute</button>
                    </div>
                    <div class="col col-md-4 col-lg-3 mt-1">
                        <button type="button" class="btn btn-gs btn-sm muteRemove-choice" id="unsubscribe">Unsubscribe</button>
                    </div>
                </div>
                <div class="row mt-2">
                   
                </div>
            </div>
        <!-- /Mute notifications for specific artists/churches or unsubscribe to specific artists/churches -->
    </form>
<?php 
    }
    elseif($profGuest == "1"){
        echo '<input type="hidden" name="currentUserID" value="' . $currentUserID . '">';

        if($artistUserID){
            $isSubscribed = $obj->fetchRow('subscription','iLoginID=' . $currentUserID . ' AND iRollID=' . $artistUserID);
            if(count($isSubscribed) > 0){
                ?>
                    <div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">You Have Already Subscribed To This Artist!!!</h1><h6>To Unsubscribe Click The Button Below. </h6><button type="button" class="btn btn-gs btn-sm checkexist" style="display:inline-block;" id="subFalse">UnSubscribe</button></div>
                <?php
            }
            else{
                echo '<div class="container mt-5 text-center  subAdded" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">To Stay Updated on my Latest Gigs, Please Subscribe!!!</h1><button type="button" class="btn btn-gs btn-sm checkexist" style="display:inline-block" id="subTrue">Subscribe</button></div>';
            }
        }
        elseif($churchUserID){
            $isSubscribed = $obj->fetchRow('subscription','iLoginID=' . $currentUserID . ' AND iRollID=' . $churchUserID);
            if(count($isSubscribed) > 0){
                ?>
                    <div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">You Have Already Subscribed To This Church!!!</h1><h6>To Unsubscribe Click The Button Below. </h6><button type="button" class="btn btn-gs btn-sm checkexist" style="display:inline-block;" id="subFalse">UnSubscribe</button></div>
                <?php
            }
            else{
                echo '<div class="container mt-5 text-center  subAdded" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">To Stay Updated on our latest events, Please Subscribe!!!</h1><button type="button" class="btn btn-gs btn-sm checkexist" style="display:inline-block" id="subTrue">Subscribe</button></div>';
            }
        }  
    }
    elseif($siteGuest == "1") {
        if($artistUserID){
            echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">Please Login To Subscribe To This Artist!!!</h1></div>';            
        }
        elseif($churchUserID){
            echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">Please Login To Subscribe To This Church!!!</h1></div>';            
        }
    }
    else{
        echo '<div class="container mt-5 text-center" id="bookme-choice"><h1 class="" style="color: rgba(204,204,204,1)">Sorry we are having technical difficulties!!!  :-(</h1></div>';
    }
?>

<script src="<?php echo URL;?>js/jquery-1.11.1.min.js"></script>

<script>
	
    /* Update the Subsribee Seetings */
        $('#subscribeeButton').click(function(event){
        	event.preventDefault(); 
        	
        	if($('input[name=vidNotification].subscribeeSettings').prop('checked')){
        		var vid = '1'; 
        	}
        	else{
        		var vid = '0';
        	}
        	if($('input[name=picNotification].subscribeeSettings').prop('checked')){
        		var pic = '1'; 
        	}
        	else{
        		var pic = '0';
        	}
        	if($('input[name=eventNotification].subscribeeSettings').prop('checked')){
        		var events = '1'; 
        	}
        	else{
        		var events = '0';
        	}
        	if($('input[name=gigNotification].subscribeeSettings').prop('checked')){
        		var gigs = '1'; 
        	}
        	else{
        		var gigs = '0';
        	}
        	console.log(vid+','+pic+','+events+','+gigs);

            var iRollID = $('input[name=userID]').val(); 
        	var subscribeeSettingsDisplay = new XMLHttpRequest(); 
        	subscribeeSettingsDisplay.onreadystatechange = function(){
        		if(subscribeeSettingsDisplay.status == 200 && subscribeeSettingsDisplay.readyState == 4){
        			document.getElementById('chngSaved').innerHTML = 'Saved!'; 
        		}
        	}
        	subscribeeSettingsDisplay.open('GET','subscribeSettingsUpdate.php?table=subscribeesetting&iRollID='+iRollID+'&vidNotification='+vid+'&picNotification='+pic+'&eventNotification='+events+'&gigNotification='+gigs); 
        	subscribeeSettingsDisplay.send(); 
        });
    /* END - Update the Subsribee Seetings */

    /* Update the SubsriberSettings */
    	 $('#subscriberButton').click(function(event){
    		event.preventDefault(); 

        	if($('input[name=vidNotification].subscriberSettings').prop('checked')){
        		var vid = '1'; 
        	}
        	else{
        		var vid = '0';
        	}
        	if($('input[name=picNotification].subscriberSettings').prop('checked')){
        		var pic = '1'; 
        	}
        	else{
        		var pic = '0';
        	}
        	if($('input[name=eventNotification].subscriberSettings').prop('checked')){
        		var events = '1'; 
        	}
        	else{
        		var events = '0';
        	}
        	if($('input[name=gigNotification].subscriberSettings').prop('checked')){
        		var gigs = '1'; 
        	}
        	else{
        		var gigs = '0';
        	}
        	console.log(vid+','+pic+','+events+','+gigs);

            var iLoginID = $('input[name=userID]').val(); 
        	var subscriberSettingsDisplay = new XMLHttpRequest(); 
        	subscriberSettingsDisplay.onreadystatechange = function(){
        		if(subscriberSettingsDisplay.status == 200 && subscriberSettingsDisplay.readyState == 4){
        			document.getElementById('chngSaved1').innerHTML = 'Saved!'; 
        		}
        	}
        	subscriberSettingsDisplay.open('GET','subscribeSettingsUpdate.php?table=subscribersetting&iLoginID='+iLoginID+'&vidNotification='+vid+'&picNotification='+pic+'&eventNotification='+events+'&gigNotification='+gigs); 
        	subscriberSettingsDisplay.send(); 
        });
    /* Update the Subsriber Settings */

    /* Mute or Remove a Subscription */
        $('.muteRemove-choice').click(function(event){
            event.preventDefault(); 

            /* Create New formData Object to send form Data via POST method - Append additional element to $_POST array  */
                var form3 = document.forms.namedItem("muteRemoveForm");
                var formData = new FormData(form3); 
                var param1 = $(this).attr('id');
                formData.append('option', param1);
            /* END - Create New formData Object to send form Data via POST method - Append additional element to $_POST array  */

            /* Create New XMLHttpRequest */
                var muteRemove = new XMLHttpRequest(); 
                muteRemove.onreadystatechange = function(){
                    if(muteRemove.status == 200 && muteRemove.readyState == 4){
                        console.log(muteRemove.responseText);
                        if(muteRemove.responseText == 'unsubscribed'){
                            console.log(muteRemove.responseText);
                            location.reload(); 
                        }

                        // var x = document.getElementById("addCommentForm").elements.length - 1;
                        // var x = document.forms.namedItem("muteRemoveForm").elements.length - 1;
                        // console.log(x);
                         // for(var f=0; f<x; f++){
                         //    comKey = document.getElementById("addCommentForm").elements[f].name;
                         //    comVal = document.getElementById("addCommentForm").elements[f].value;
                         //    // console.log(f+': '+comKey+' = '+comVal);
                         //    data[comKey] = comVal;
                         // }
                        if(muteRemove.responseText == 'muted'){
                            location.reload(); 
                        }
                        if(muteRemove.responseText == 'unmuted'){
                            location.reload(); 
                        }
                    }
                }
                muteRemove.open('POST', 'subscribeSettingsUpdate');
                muteRemove.send(formData);
            /* END - Create New XMLHttpRequest */
        });

        /* Add/Remove Subscription via the subscribee's page */
            $('.checkexist').click(function(event){
                event.preventDefault(); 
                if($(this).attr('id') == 'subFalse'){
                    var param9 = '?del=1';
                }
                else{
                    var param9 = '?add=1';
                }
                
                var param10 = '&iRollID='+ $('.userID').val();
                var param11 = '&iLoginID='+ $('input[name=currentUserID]').val();
                var del = new XMLHttpRequest(); 
                del.onreadystatechange = function(){
                    if(del.status == 200 && del.readyState == 4){

                        if(del.responseText == 'muted' || del.responseText == 'unsubscribed'){
                            location.reload(); 
                        }
                        if(del.responseText == 'added'){
                            var subAdded = '<h1 class="" style="color: rgba(204,204,204,1)">Thanks For Subscibing!!!</h1>';
                            $('.subAdded').html(subAdded);
                        }
                    }
                }
                del.open('GET', 'subscribeSettingsUpdate.php'+param9+param10+param11);
                del.send();
            });
        /* END - Add/Remove Subscription via the subscribee's page */        
    /* END - Mute or Remove a Subscription */
</script>