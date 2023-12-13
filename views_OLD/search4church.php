<?php include('../include/header.php'); ?>
<style>
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
    <div class="col-md-12 borderbuttom"> <img src="../img/slider2.jpg" class="img-responsive" style="width: 900px !important;height: 300px !important;"> </div>
</div>
<div class="clear"></div>
<div class="container">
    <?php 
	$states     = $obj->fetchRowAll("states",'country_id = 231');
	$amenitimaster = $obj->fetchRowAll("amenitimaster",'1=1');
	$churchList = $obj->fetchSearchedChurch(array());
	$churchListLimit = $obj->fetchSearchedChurchLimit(array());
?>
    <div>
        <input type="button" value="Find a Church" id="onSearch" class="mb10 btn btn-primary" />
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
            <div class="col-sm-3 col-md-3 col-lg-3 mt20">
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
            <div class="col-sm-3 col-md-3 col-lg-3 mt20">
                <div class="form-group">
                    <label for="city">City</label>
                    <select name="city" class="form-control cities" id="cityId">
                        <option value="">Select City</option>
                    </select>
                </div>
            </div>            
            <div class="col-sm-3 col-md-3 col-lg-3 mt20">
                <div class="form-group">
                    <label for="ZipCode">ZipCode</label>
                    <input type="text" name="zip" id="zip" class="form-control" />
                </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3 mt20">
                <div class="form-group">
                    <label for="Looking for a specific artist?">Street Name</label>
                    <input type="text" name="street_name" id="street_name" class="form-control" />
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 ">
            <div class="col-lg-3 col-md-3 col-sm-3 ">
                <h4>Church Ministries</h4>




                <div class="ChurchScroll" id="checkboxes">
<?php
$cond=" isActive IN(1,0) order by iGiftID DESC";
$catlist = $obj->fetchRowAll('giftmaster1',$cond);

for($cat=0;$cat<count($catlist);$cat++)
{
?>
					<label>
                        <input type="checkbox" name="sMinistrieName[]" id="sMinistrieName" value="<?php echo $catlist[$cat]['sGiftName'];?>">
                       <?php echo $catlist[$cat]['sGiftName'];?></label>
<?php
				}
?>
                       
                    <!--<label>
                        <input type="checkbox" name="sMinistrieName[]" id="sMinistrieName" value="Dance_ministry">
                        Dance ministry</label>
                        
                    <label>
                        <input type="checkbox" name="sMinistrieName[]" id="sMinistrieName" value="Drama_ministry">
                        Drama ministry</label>
                        
                    <label>
                        <input type="checkbox" name="sMinistrieName[]" id="sMinistrieName" value="Media_ministry"> 
                        Media ministry</label>
                        
                        <label>
                        <input type="checkbox" name="sMinistrieName[]" id="sMinistrieName" value="Mime_ministry"> 
                        Mime ministry</label>
                        
                        <label>
                        <input type="checkbox" name="sMinistrieName[]" id="sMinistrieName" value="Music_ministry"> 
                        Music ministry</label>
                        <label>
                        <input type="checkbox" name="sMinistrieName[]" id="sMinistrieName" value="Sound_ministry"> 
                        Sound ministry</label>
                        <label>
                        <input type="checkbox" name="sMinistrieName[]" id="sMinistrieName" value="Youth_ministry"> 
                        Youth ministry</label>
                        <label>
                        <input type="checkbox" name="sMinistrieName[]" id="sMinistrieName" value="Others"> 
                        Others</label>-->
                </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                <h4>Church Amenities</h4>
                <div class="ChurchScroll ChurchScroll1" id="checkboxes1" style="width:180px !important;" >
					<?php
                    if(count($amenitimaster) > 0){
                    for($c=0;$c<count($amenitimaster);$c++){
                    ?>
                    <label>
                        <input type="checkbox" name="aminity[]" id="aminity" value="<?php echo $amenitimaster[$c]['iAmityID'];?>">&nbsp;<?php echo mysql_real_escape_string($amenitimaster[$c]['sAmityName']);?></label>
                        <br />
                   <?php
                    }
                    }
                    ?> 
                    
                </div>
                
            </div>
            
            
                <div class="col-lg-3 col-md-3 col-sm-3">
				<h4>Day</h4>
				<select name="sTitle" id="sTitle" class="span2" style="width:80px;float:left;margin-left: 4px;margin-bottom:10px !important;">
									<option value="">Select days</option>
									<option value="All days">All days</option>
									<option value="Weekend">Weekend</option>
									<option value="Monday">Monday</option>
									<option value="Tuesday">Tuesday</option>
									<option value="Wednesday">Wednesday</option>
									<option value="Thursday">Thursday</option>
									<option value="Friday">Friday</option>
									<option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
								
                <h4>Denomination</h4>
                    <select id="denomination" name="denomination">
                    <option value="">----- Select -----</option>
                <option value="Anglican" name="denomination">Anglican</option>
                <option value="Apostolic" name="denomination">Apostolic</option>
                <option value="Baptist" name="denomination">Baptist</option>
                <option value="Catholic" name="denomination">Catholic</option>
                <option value="Episcopal" name="denomination">Episcopal</option>                
                <option value="Evangelistic" name="denomination">Evangelistic</option>
                <option value="Lutheran" name="denomination">Lutheran</option>
                <option value="Methodist" name="denomination">Methodist</option>
                <option value="Non_Denominational" name="denomination">Non-Denominational</option>
                <option value="Pentecostal" name="denomination">Pentecostal</option>
                <option value="Presbyterian" name="denomination">Presbyterian</option>
                <option value="Seventh_Day_Adventist" name="denomination">Seventh Day Adventist</option>
                <option value="Other" name="denomination">Other</option>
                </select>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-3">
                <h4>Service Time</h4>
                    <input type="text" name="services" id="services" class="form-control" />
                </div>
                
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h4>Looking For a Specific Church?</h4>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="Church Name">Church Name</label>
                        <input id="churchname" class="form-control" type="text" name="churchname">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="Pastor Name">Pastor Name</label>
                        <input id="pastorname" class="form-control" type="text" name="pastorname">
                    </div>
                </div>
            </div>
        </form>
 <script>
$(document).ready(function() {
	 $('#services').datetimepicker({
                    format: 'LT'
                });
	
});
</script> 
        <div class="col-sm-12 col-md-12 col-lg-12 ">
            <div class="form-group">
                <input type="button" value="Search" id="make_search" class="btn btn-primary" />
            </div>
        </div>
    </div>
    <div class="mt50" id="artistDiv2"> 
    <input type="hidden" id="page" value="0"/>
    
    <div class="chang m0" id="artist_list_area"> <?php echo getChurchListHtml($churchList);?> </div>
     
     <div class="clear"></div>
  	 <div class="pagging-main">
     <?php if ( count($churchListLimit) != 0 ) {?>
      <a href="javascript:void(0);" onClick="setPage('NEXT');" id="next" class="btn btn-primary">Next</a> 
      <?php } ?>
        
        <a id="PageID">  1</a>
      <a href="javascript:void(0);" onClick="setPage('PREV');" id="next1" style="display:none;" class="btn btn-primary">Prev </a> </div>
       
    </div>
</div>
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
 		
		var selected = [];
		$('#checkboxes input:checked').each(function() {
			selected.push($(this).attr('value'));
		});
			
		var selected1 = [];
		$('#checkboxes1 input:checked').each(function() {
			selected1.push($(this).attr('value'));
		});
		
		searchWith.state = $('#stateId').val();
 		searchWith.city  = $('#cityId').val();
		searchWith.zip	 = $('#zip').val();
		searchWith.sTitle	 = $('#sTitle').val();
		searchWith.street_name   = $('#street_name').val();
		if(selected != ''){
			searchWith.ministries = selected;
		}else{
			searchWith.ministries = '';
		}
		if(selected1 != ''){
			searchWith.amenitis = selected1;
		}else{
			searchWith.amenitis = '';
		}
		searchWith.denomination  = $('#denomination').val();
		searchWith.services  = $('#services').val();
		searchWith.page  = $('#page').val();
		searchWith.churchname  = $('#churchname').val();
		searchWith.pastorname  = $('#pastorname').val();
		searchWith.radius = $('#radius').val();
			
		var queryString = $.param(searchWith);
		
		$.ajax({
			type: 'GET',
			url: '<?php echo URL;?>views/searchChurchAjax.php',
			data: queryString,
			success: function (data) {

				if(data == 'No Data Found Based on Your Search Criteria.'){
					$('#next').css('display','none');
					
					$('#artist_list_area').html(data);
					$("#artistDiv1").hide();
					$('#spval').text("1");
				
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
			url: '<?php echo URL;?>views/searchChurchAjaxLimit.php',
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
			url: '<?php echo URL;?>views/searchChurchAjax.php',
			data: queryString,
			success: function (data) {
				$('#artist_list_area').html('');
				$('#artist_list_area').html(data);
			}
		});

	});
	
	window.setPage = function(mode){
		
		if (mode == 'NEXT') {
			$("#next1").show();
			$('#page').val((parseInt($('#page').val()) + 1 ));
			$('#PageID').text(parseInt($('#page').val()) + 1);
			$('#make_search').trigger('click');
		} else {
			
			if (parseInt($('#page').val()) == 1) {
				$("#next1").hide();
			}
			
			if (parseInt($('#page').val()) > 0) {
	    		$('#PageID').text($('#page').val() );
				$('#page').val((parseInt($('#page').val()) -1));
				
    			$('#make_search').trigger('click');
			}
		}
		
							$("#artistDiv1").hide();	
	}
});
</script>
<?php include('../include/footer.php'); ?>
