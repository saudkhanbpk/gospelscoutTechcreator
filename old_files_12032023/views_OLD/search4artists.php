<?php include('../include/header.php'); ?>
<link href="<?php echo URL;?>css/rating-2.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo URL;?>js/rating-02.js"></script>

<style>
.nav > li > a {
  display: block;
  padding: 4px 11px;
  position: relative;
}
.nav-link {
  padding-left: 12px !important;
  padding-right: 15px !important;
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
  <div class="col-md-12 borderbuttom"> <img src="../img/BusinessCardCollageFinal.png" class="img-responsive" style="width: 900px !important;height: 300px !important;"> </div>
</div>
<div class="clear"></div>
<div class="container">
<?php 
	$states     = $obj->fetchRowAll("states",'country_id = 231');
	$fivecategory = $obj->fetchRowAll("giftmaster","isActive = 1 LIMIT 5");
	$giftmaster = $obj->fetchRowAll("giftmaster","isActive = 1 ");
	$artistList = $obj->fetchSearchedArtist(array());
	$artistListLimit = $obj->fetchSearchedArtistLimit(array());
?>
<div class="col-sm-12 col-md-12 col-lg-12 mb20">

  <input type="button" value="Find an Artist" id="onSearch" class="btn btn-primary" />
  <li class="btn btn-primary"> <a class="nav-link oldView" style="color:#fff; font-weight:normal;" href="#viewmore" role="tab" data-toggle="tab">View More</a> </li>
  <span style="display:none;" id="spval">1</span>
  <select name="radius" id="radius" style="width: 259px !important;"  class="pull-right mt10">
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
    <div class="col-sm-4 col-md-4 col-lg-4">
      <div class="form-group">
        <label for="What kind of Artist?">What kind of Artist?</label>
        <select class="form-control" name="artist_type" id="artist_type">
          <option value="">Select artist</option>
		  <option value="group">Artist Groups</option>
          <?php
				if(count($giftmaster) > 0){
					for($s=0;$s<count($giftmaster);$s++){
				?>
          <option value="<?php echo $giftmaster[$s]['sGiftName'];?>"><?php echo $giftmaster[$s]['sGiftName'];?></option>
          <?php
					}
				}
				?>
        </select>
      </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
      <div class="form-group">
        <label for="Avaibility">Availability</label>
        <select name="avaibility" id="avaibility" class="form-control" >
          <option value="">Select Availability</option>
          <option value="Currently Gigging(Not excepting new gigs)">Currently Gigging(Not excepting new gigs)</option>
          <option value="Looking For Gigs(Currently excepting new gigs)">Looking For Gigs(Currently excepting new gigs)</option>
          <option value="Will Play For Food(Just Cover my cost to get there and back)">Will Play For Food (Just Cover my cost to get there and back)</option>
          <option value="Will Play For Free">Will Play For Free</option>
        </select>
      </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
      <div class="form-group">
        <label for="Looking for a specific artist?">Looking for a specific artist?</label>
        <input type="text" name="artist_name" id="artist_name" class="form-control" />
      </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
      <div class="form-group">
        <label for="views">How Many Views?</label>
        <select name="iViews" id="iViews" class="form-control" >
          <option value="">Select views</option>
          <option value="1-100">1-100</option>
          <option value="100-500">100-500</option>
          <option value="500-1000">500-1000</option>
          <option value="1000-2000">1000-2000</option>
          <option value="2000-4000">2000-4000</option>
          <option value="4000-5000">4000-5000</option>
        </select>
      </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
    
    <script language="javascript" type="text/javascript">
$(function() {
    $("#rateFilter").codexworld_rating_widget({
        starLength: '5',
        initialValue: '0',
        callbackFunctionName: '',
        imageDirectory: '../img/',
        inputAttr: 'postID'
    });
});

</script>
<div class="form-group">
        <label for="views">Star Ratting</label>
		<div class="clear"></div>
		<input name="rateFilter" value="0" id="rateFilter" type="hidden" postID="0" />

    </div>
	 </div>
  </form>
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="form-group">
      <input type="button" value="Search" id="make_search" class="btn btn-primary" />
    </div>
  </div>
</div>
<div class="col-sm-12 col-md-12 col-lg-12 mt50" id="artistDiv2">

  <ul class="nav nav-tabs no-border-bottom test1" role="tablist">
    <li class="nav-item collaps editli"> <a class="nav-link active tabpan" href="#all" role="tab" onClick="setGift('all');" data-toggle="tab">All</a> </li>
	<?php 
	if(!empty($fivecategory)){
		for($five=0;$five<count($fivecategory);$five++){
	?>
    <li class="nav-item collaps editli"> <a class="nav-link tabpan" onClick="setGift('<?php echo $fivecategory[$five]['sGiftName'];?>');" role="tab" data-toggle="tab"><?php echo ucfirst($fivecategory[$five]['sGiftName']);?></a> </li>
    <?php } } ?>
    
  </ul>
  <ul class="nav nav-tabs no-border-bottom newView mayur test2" role="tablist">   
    <?php 
	if(!empty($giftmaster)){
		for($gi=0;$gi<count($giftmaster);$gi++){
			if($gi <= 5){
				continue;	
			}
	?>
    <li class="nav-item collaps editli"> <a class="nav-link tabpan" onClick="setGift('<?php echo $giftmaster[$gi]['sGiftName'];?>');" role="tab" data-toggle="tab"><?php echo ucfirst($giftmaster[$gi]['sGiftName']);?></a> </li>
    <?php } }?>
    <li class="nav-item collaps editli"> <a class="nav-link tabpan" onClick="setGift('group');" role="tab" data-toggle="tab">Group</a> </li>
  </ul>
  <input type="hidden" id="page" value="0"/>
  <input type="hidden" id="gift" value=""/>
  
  <link href="<?php echo URL;?>css/rating-1.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo URL;?>js/rating-01.js"></script>
    
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="all">
      <div class="col-lg-12 col-md-12 col-sm-12 chang m0" id="artist_list_area"> <?php echo getArtistListHtml($artistList);?> </div>
  </div>
  <div class="clear"></div>
  <div class="pagging-main">
   <?php if ( count($artistListLimit) != 0 ) {?>
        <a href="javascript:void(0);" id="next" onClick="setPage('NEXT');" class="btn btn-primary">Next </a> 
      <?php } ?>
      
      
        <a id="PageID">  1</a>
      <a href="javascript:void(0);" id="next1" onClick="setPage('PREV');" style="display:none;" class="btn btn-primary">Prev </a> </div>
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
		searchWith.artist_type	= $('#artist_type').val();
		searchWith.avaibility   = $('#avaibility').val();
		searchWith.artist_name  = $('#artist_name').val();
		searchWith.page  = $('#page').val();
		searchWith.gift  = $('#gift').val();
		if ($('#gift').val() != '') {
			$("#artistDiv1").hide();	
		}
		searchWith.iViews = $('#iViews').val();
		searchWith.rateFilter = $('#rateFilter').val();
		
		var queryString = $.param(searchWith);
		
		$.ajax({
			type: 'GET',
			url: '<?php echo URL;?>views/searchArtistAjax.php',
			data: queryString,
			success: function (data) {

				if(data == 'No Data Found Based on Your Search Criteria.'){
					
					//$('#page').val((parseInt($('#page').val()) -1));
					
					//$('#PageID').text($('#page').val());
					$('#next').hide();
					
				
				}else{
					$('#next').show();
				}
				
				//alert(data);
				$('#artist_list_area').html('');
				$('#artist_list_area').html(data);
			}
		});
		
		$.ajax({
			type: 'GET',
			url: '<?php echo URL;?>views/searchArtistAjaxLimit.php',
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
	
	$('#radius').on('change', function(e) {
		var searchWith = {};
 		
		searchWith.radius = $('#radius').val();
		
		var queryString = $.param(searchWith);
		
		$.ajax({
			type: 'GET',
			url: '<?php echo URL;?>views/searchArtistAjax.php',
			data: queryString,
			success: function (data) {
				
				$('#artist_list_area').html(data);
			}
		});

		$.ajax({
			type: 'GET',
			url: '<?php echo URL;?>views/searchArtistAjaxLimit.php',
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
	
	$(".test1 li").click(function() {
		
		$('.test2 li').removeClass('active');
		//(this).parent().addClass('selected').siblings().removeClass('selected');

    });	
	
	$(".test2 li").click(function() {
		
		$('.test1 li').removeClass('active');
		//(this).parent().addClass('selected').siblings().removeClass('selected');

    });	
	
});
</script>
<?php include('../include/footer.php'); ?>
