<?php include('../include/header.php'); ?>
<script>
$(document).ready(function() {
	
	$('#when').datetimepicker({
		//locale: "en-GB",
		format: 'YYYY-MM-DD',		
		//minDate: moment().subtract(1,'d'),
		//ignoreReadonly: true,
		//disabledDates:[moment().subtract(1,'d')],
		
	});	
});
</script> 
<style>
.hovereffect img {
  height: 220px;
  width: 270px;
}
.newView
{
	padding-top:10px;	
}

.newView li
{
	margin-bottom:10px !important;
}

#PageID {
  padding: 8px 0 0 0;
  text-align: center;
}

.pagging-main a {
  float: right;
  width: 60px !important;
}

.pagging-main {
  padding-top: 20px !important;
}


</style>
<div class="container">
<?php if($objsession->get('gs_msg') != ""){?>
<div class="suc-message"> <?php echo $objsession->get('gs_msg');?> </div>
<?php $objsession->remove('gs_msg');}
else if($objsession->get('gs_error_msg') != ""){
?>
<span class="error_class"><?php echo $objsession->get('gs_error_msg');?></span>
<?php
$objsession->remove('gs_error_msg');
}
?>
<style>
.demo-table {width: 100%;border-spacing: initial;margin: 0px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
.demo-table th {background: #999;padding: 5px;text-align: left;color:#FFF;}
.demo-table td {padding: 5px;}
.demo-table td div.feed_title{text-decoration: none;color:#00d4ff;font-weight:bold;}
.demo-table ul{margin:0;padding:0;}
.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
</style>
<?php /*?><script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script> <?php */?>
<script>function highlightStar(obj,id) {
	removeHighlight(id);		
	$('.demo-table #tutorial-'+id+' li').each(function(index) {
		$(this).addClass('highlight');
		if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
			return false;	
		}
	});
}

function removeHighlight(id) {
	$('.demo-table #tutorial-'+id+' li').removeClass('selected');
	$('.demo-table #tutorial-'+id+' li').removeClass('highlight');
}
/*
function addRating(obj,id) {
	
	$('.demo-table #tutorial-'+id+' li').each(function(index) {
		$(this).addClass('selected');
		$('#tutorial-'+id+' #rating').val((index+1));
		if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
			return false;	
		}
	});
	//alert(id);
	$.ajax({	
	url: "add_rating",
	data:'id='+id+'&lid='+<?php echo $objsession->get('gs_login_id'); ?>+'&rating='+$('#tutorial-'+id+' #rating').val(),
	type: "POST"
	});
}
*/
function resetRating(id) {
	if($('#tutorial-'+id+' #rating').val() != 0) {
		$('.demo-table #tutorial-'+id+' li').each(function(index) {
			$(this).addClass('selected');
			if((index+1) == $('#tutorial-'+id+' #rating').val()) {
				return false;	
			}
		});
	}
} </script>
<div class="carousel-holder">
    <div class="col-md-12 borderbuttom"> <img src="../img/slider2.jpg" class="img-responsive" style="width: 900px !important;height: 300px !important;"> </div>
</div>
<?php 
	$states     = $obj->fetchRowAll("states",'country_id = 231');
	//$fivecategory = $obj->fetchRowAll("giftmaster","isActive = 1 LIMIT 5");
	//$giftmaster = $obj->fetchRowAll("giftmaster","isActive = 1 ");
	$eventtypes = $obj->fetchRowAll("eventtypes","isActive = 1 ");
	$eventList = $obj->fetchSearchedEvent(array());
	$eventListLimit = $obj->fetchSearchedEventLimit(array());
?>
<div class="col-sm-12 col-md-12 col-lg-12 mb20">
  <input type="button" value="Find an Event" id="onSearch" class="btn btn-primary" />
  <span style="display:none;" id="spval">1</span>
  
  <select name="radius" id="radius" style="width: 259px !important;margin-left: 8px;"  class="pull-right mt10">
  	<option value="">Select by radius</option>
    <option value="1-10">1-10</option>
    <option value="10-20">10-20</option>
    <option value="20-30">20-30</option>
    <option value="30-40">30-40</option>
    <option value="40-50">40-50</option>
    <option value="50-60">50-60</option>
    <option value="60-70">60-70</option>
    <option value="70-80">70-80</option>
    <option value="80-90">80-90</option>
    <option value="90-100">90-100</option>
    <option value="100-150">100-150</option>
    <option value="150-20">150-200</option>
    <option value="200-300">200-300</option>
    <option value="300-400">300-400</option>
    <option value="400-500">400-500</option>
  </select>
  
  <?php if($objsession->get('gs_login_id') > 0){?>
  <a href="<?php echo URL;?>views/event.php" class="newevent" style="float:right;">Add New Event</a>
  <?php }?>
</div>

<div id="artistDiv1">
  <form role="form">
<div class="col-sm-4 col-md-4 col-lg-4 mt20">      
    <div class="form-group">
 		<label for="state">State</label>
        <select name="iStateID" class="form-control states" id="stateId">
            <option value="">Select State</option>
	            <?php
					if(count($states) > 0){
						for($s=0;$s<count($states);$s++){
				?>
		    <option value="<?php echo $states[$s]['id'];?>"><?php echo $states[$s]['name'];?></option>
	            <?php
						}
					}
				?>
         </select>
       </div>   
</div>
<div class="col-sm-4 col-md-4 col-lg-4 mt20">
	<div class="form-group">
       <label for="city">City</label>
		<select name="city" class="form-control cities" id="cityId">
	    	<option value="">Select City</option>
         </select>
        </div>
</div>
<div class="col-sm-4 col-md-4 col-lg-4 mt20">        
    	<div class="form-group">
        <label for="ZipCode">ZipCode</label>
           	<input type="text" name="zip" id="zip" class="form-control" />
        </div>
</div>        	
 <div class="col-sm-6 col-md-6 col-lg-6">        
    	<div class="form-group">
        <label for="What kind of Artist?">What Kind of Event is it?</label>   
		<select class="form-control" name="event_type" id="event_type">
          <option value="">Select event type</option>
          <?php
				if(count($eventtypes) > 0){
					for($s=0;$s<count($eventtypes);$s++){
				?>
          <option value="<?php echo $eventtypes[$s]['iEventID'];?>"><?php echo $eventtypes[$s]['sName'];?></option>
          <?php
					}
				}
				?>
        </select>
        </div>
</div>
 <div class="col-sm-6 col-md-6 col-lg-6">        
    	<div class="form-group">
        <label for="Event in Month of">Event in Month of:</label>
        	<select name="month" id="month" class="form-control" >
                <option selected="" default="" value="">----- Select ----- </option>
				<option value="1">January</option>
				<option value="2">February</option>
				<option value="3">March</option>
				<option value="4">April</option>
				<option value="5">May</option>
				<option value="6">June</option>
				<option value="7">July</option>
				<option value="8">August</option>
				<option value="9">September</option>
				<option value="10">Octomber</option>
				<option value="11">November</option>
				<option value="12">December</option>
	        </select>
        </div>
 </div>
  <div class="col-sm-4 col-md-4 col-lg-4 mt20">        
    	<div class="form-group">  
         <label for="Name">Event Name</label>
        	<input type="text" name="title" id="title" class="form-control" />
        </div>
  </div>
  <div class="col-sm-4 col-md-4 col-lg-4 mt20">        
    	<div class="form-group">  
         <label for="when is it?">When is it?</label>
            <input type="text" name="when" id="when" class="form-control" />
        </div>
  </div>
  <!--<div class="col-sm-4 col-md-4 col-lg-4 mt20">        
    	<div class="form-group">  
         <label for="Who's Sponsor By">Who's Sponsoring the Event? </label>
            <input type="text" name="sponsor" id="sponsor" class="form-control" />
        </div>
  </div>-->
</form>
<div class="col-sm-12 col-md-12 col-lg-12">        
  	<div class="form-group">
		<input type="button" value="Search" id="make_search" class="btn btn-primary" />
    </div>
</div> 
</div>
<div class="col-sm-12 col-md-12 col-lg-12 mt50" id="artistDiv2">
<div class="">
  <?php /*?><ul class="nav nav-tabs no-border-bottom" role="tablist">
    <li class="nav-item collaps editli"> <a class="nav-link active tabpan" href="#all" role="tab" onClick="setGift('all');" data-toggle="tab">All</a> </li>
	<?php 
	if(!empty($fivecategory)){
		for($five=0;$five<count($fivecategory);$five++){
	?>
    <li class="nav-item collaps editli"> <a class="nav-link tabpan" onClick="setGift('<?php echo $fivecategory[$five]['iGiftID'];?>');" role="tab" data-toggle="tab"><?php echo ucfirst($fivecategory[$five]['sGiftName']);?></a> </li>
    <?php } } ?>
    <li class="nav-item collaps editli"> <a class="nav-link tabpan oldView" href="#viewmore" role="tab" data-toggle="tab">View More</a> </li>
  </ul>
  <ul class="nav nav-tabs no-border-bottom newView mayur" role="tablist">   
    <?php 
	if(!empty($giftmaster)){
		for($gi=0;$gi<count($giftmaster);$gi++){
			if($gi <= 5){
				continue;	
			}
	?>
    <li class="nav-item collaps editli"> <a class="nav-link tabpan" onClick="setGift('<?php echo $giftmaster[$gi]['iGiftID'];?>');" role="tab" data-toggle="tab"><?php echo ucfirst($giftmaster[$gi]['sGiftName']);?></a> </li>
    <?php } }?>
    
  </ul>  <?php */?>
  <input type="hidden" id="page" value="0"/>
  <input type="hidden" id="gift" value=""/>
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="all">
      <div class="col-lg-12 col-md-12 col-sm-12 chang m0" id="artist_list_area"> <?php echo getEventListHtml($eventList);?> </div>
      
      <div class="clear"></div>
  <div class="pagging-main">
  <?php if ( count($eventListLimit) != 0 ) {?>
       <a href="javascript:void(0);" id="next" onClick="setPage('NEXT');" class="btn btn-primary">Next </a> 
      <?php } ?>
             
        <a id="PageID">  1</a>
      <a href="javascript:void(0);" onClick="setPage('PREV');" id="next1" style="display:none;" class="btn btn-primary">Prev </a> </div>
      
      </div>
  </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function (){
	
					/*$("#artistDiv2").show();
					$("#artistDiv1").hide();*/	
					
					$("#artistDiv2").fadeIn();
					$("#artistDiv1").fadeOut();
					
										$(".newView").hide();	
					
	
	$('.oldView').click(function(){
		$(".newView").fadeToggle("slow");
	});
	
	$('#onSearch').click(function(){
		var flag = $('#spval').text();

			if(flag == "1")
			{				
				/*$("#artistDiv1").show();	
				$("#artistDiv2").hide();*/
				
				$("#artistDiv1").fadeIn();	
				$("#artistDiv2").fadeOut();
				
				$('#spval').text("0");
			}
			else
			{
					/*$("#artistDiv2").show();	
					$("#artistDiv1").hide();	*/
					
					$("#artistDiv2").fadeIn();	
					$("#artistDiv1").fadeOut();	
					
				$('#spval').text("1");
			}
		});
		
			$('#make_search').click(function(){

				/*$("#artistDiv1").show();	
				$("#artistDiv2").show();*/
				
				$("#artistDiv1").fadeIn();	
				$("#artistDiv2").fadeIn();
			});
		
		
		
		
	
	$('#stateId').on('change', function (e) {
		
			  $('#cityId').html('');
			  var stateId = $('#stateId').val();
			  e.preventDefault();
			  
				//var formData = $('#contactform').serialize();
				
			  $.ajax({
				type: 'post',
				url: '<?php echo URL;?>views/managearea.php?type=city&iStateID='+stateId,
				//data: formData,
				success: function (data) {
				  if(data == 'Please select state'){
					 $('#cityId').html("<option value=''>Select City</option>");
				  }else{
					 $('#cityId').html(data);
				  }
				}
			  });
		});

	$('#make_search').on('click', function(e) {
		var searchWith = {};
 		
		searchWith.state = $('#stateId').val();
 		searchWith.city  = $('#cityId').val();
		searchWith.zip	 = $('#zip').val();
		searchWith.event_type	= $('#event_type').val();
		searchWith.month   = $('#month').val();
		searchWith.title  = $('#title').val();
		searchWith.when  = $('#when').val();
		searchWith.page  = $('#page').val();
		searchWith.gift  = $('#gift').val();
		searchWith.sponsor = $('#sponsor').val();
		searchWith.radius = $('#radius').val();
		
		if ($('#gift').val() > 0) {
			$("#artistDiv1").hide();	
		}
		
		var queryString = $.param(searchWith);
			
		$.ajax({
			type: 'GET',
			url: '<?php echo URL;?>views/searchEventAjax.php',
			data: queryString,
			success: function (data) {

				if(data == 'Artist record not found.'){
					//$('#next').css('display','block');	
					$('#artist_list_area').html('Event not found');
					$("#artistDiv1").hide();
					$('#spval').text("1");
					
					$('#next').css('display','none');
				}else{				
					$('#next').css('display','block');	
					$('#artist_list_area').html(data);
					$("#artistDiv1").hide();
					$('#spval').text("1");
				}
			}
		});
		
		$.ajax({
			type: 'GET',
			url: '<?php echo URL;?>views/searchEventAjaxLimit.php',
			data: queryString,
			success: function (data) {
				
				if(data == 0){
					$('#next').css('display','none');		
				}else{
					$('#next').css('display','block');				
				}
			}
		});
		
	});

	$('#make_search').on('click', function(e) {
		var searchWith = {};
 		
		searchWith.when = $('#when').val();
		
		var queryString = $.param(searchWith);
		
		$.ajax({
			type: 'GET',
			url: '<?php echo URL;?>views/abc.php',
			data: queryString,
			success: function (data) {
				if(data == 'Artist record not found.'){
					$('#artist_list_area').html('There are currently no events listed.');
				}else{
					$('#artist_list_area').html('');
					$('#artist_list_area').html(data);	
				}				
			}
		});
	});
	
	$('#radius').on('change', function(e) {
		var searchWith = {};
 		
		searchWith.radius = $('#radius').val();
		
		var queryString = $.param(searchWith);
		
		$.ajax({
			type: 'GET',
			url: '<?php echo URL;?>views/searchEventAjax.php',
			data: queryString,
			success: function (data) {
				if(data == 'Artist record not found.'){
					$('#artist_list_area').html('There are currently no events listed.');
				}else{
					$('#artist_list_area').html('');
					$('#artist_list_area').html(data);	
				}				
			}
		});
	});
	
	window.setPage = function(mode){
		
		if (mode == 'NEXT') {
			$('#next1').show();
			$('#page').val((parseInt($('#page').val()) + 1 ));
			$('#PageID').text(parseInt($('#page').val()) + 1);
			$('#make_search').trigger('click');
		} else {
			
			if (parseInt($('#page').val()) == 1) {
				$('#next1').hide();
			}
			
			if (parseInt($('#page').val()) > 0) {
	    		$('#PageID').text($('#page').val() );
				$('#page').val((parseInt($('#page').val()) -1));
				
    			$('#make_search').trigger('click');
			}
		}
		
							$("#artistDiv1").hide();	
	}
	
	window.setGift = function(mode){		
		$('#gift').val(mode);
		$('#make_search').trigger('click');
	}
	
});
</script>
<?php include('../include/footer.php'); ?>
