<?php include('../include/header.php'); ?>
<?php
if(isset($_GET['type'])){
	
	if($_GET['type'] == 'user'){
		$cond=" isActive IN(1) AND sUserType = 'user' order by iUserID DESC";	
	}
	http://www.gospelscout.com/
	if($_GET['type'] == 'artist'){
		$cond=" isActive IN(1) AND sUserType = 'artist' order by iUserID DESC";	
	}
	
	if($_GET['type'] == 'church'){
		$cond=" isActive IN(1) AND sUserType = 'church' order by iUserID DESC";	
	}
	
	$usermaster = $obj->fetchRowAll('usermaster',$cond);

	

	$totalusermaster = $obj->fetchNumOfRow('usermaster',$cond);
	
}else{
	
	$cond=" isActive IN(1) order by iUserID DESC";
	$usermaster = $obj->fetchRowAll('usermaster',$cond);
	$totalusermaster = $obj->fetchNumOfRow('usermaster',$cond);	
}

?>
<script type="text/javascript">
	$(function () {

		$("#example1").DataTable({
			"lengthMenu": [20],
			"lengthChange": false,
			"searching": false,
			"pagingType": "numbers",
			"bJQueryUI": true,
			"sDom": '<"H"lfrp>t<"F"ip>',
			"info": false,
			"ordering": false,
			paging : $("#example1").find('tbody tr').length > 10
		});
	
   });
	
function clk(){
	$("#example1").DataTable({
		"lengthMenu": [20],
		"lengthChange": false,
		"searching": false,
		"pagingType": "numbers",
		"bJQueryUI": true,
		"sDom": '<"H"lfrp>t<"F"ip>',
		"info": false,
		"ordering": false,
		paging : $("#example1").find('tbody tr').length > 10
	});							  
}
	
function searchfilter()
{
		showLoader();
		var xmlhttp; 
		$('.error-01').remove();

		var mixvalue = document.getElementById("mixvalue").value; 
		var usertype = document.querySelector('input[name = "usertype"]:checked').value; 

		if (window.XMLHttpRequest){
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("loadusers").innerHTML=xmlhttp.responseText;
				//document.getElementById("btn_delete").style.display = "inline";
				clk();
				hideLoader();
			}
		}
		xmlhttp.open("GET","<?php echo HTTP_SERVER;?>views/loaduser.php?mixvalue="+mixvalue+"&usertype="+usertype,true);
		xmlhttp.send();
	}
</script>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->    
    <div class="row">
      <div class="col-lg-12">
        <h2>Users</h2>
		<hr class="hrforrow" />
        <div class="">
<?php if($objsession->get('gs_message') != ""){?>
<span id="success-message"><?php echo $objsession->get('gs_message'); ?></span>
<?php $objsession->remove('gs_message');}?>
<form method="post" action="export">
<div class="datesearch">
<div class="col-md-3">
<label>Search By :</label>
    <input id="mixvalue" name="mixvalue" class="form-control"  type="text" placeholder="First Name, Last Name" />
</div>
<div class="col-md-3">
<label>User Type :</label>
	<br />
    <input type="radio" name="usertype" id="usertype" value="all" checked="checked" />All
    <input type="radio" name="usertype" id="usertype" value="user" />User
    <input type="radio" name="usertype" id="usertype" value="artist" />Artist
    <input type="radio" name="usertype" id="usertype" value="church" />Church
</div>
<div class="col-md-3">
<div class="input-group">
<label>&nbsp;</label>
<input type="button" class="form-control btn btn-xs btn-info addnew searchfilter" onclick="searchfilter();" name="btn_search" id="btn_search" value="SEARCH" />
<input type="reset" class="form-control btn btn-xs btn-info addnew reset" name="btn_search" id="btn_search" value="CLEAR" />
</div>
</div>
</div>
</form>
<div class="clear"></div>
<div class="" id="loadusers">
<?php
	if($totalusermaster > 0){
?>
          <table border="1" class="table table-hover" id="example1" style="margin-top:10px;">
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Profile</th>
				<th>Email</th>
                <th>Date Of Birth</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
			<?php	
				$folder = '';
				for($i=0;$i<count($usermaster);$i++)
				{
//					$cond = "iCategoryID = ".$prolist[$pro]['iCategoryID'];
//					$catRow = $obj->fetchRow('categorymaster',$cond);	
            ?>
              <tr>
                <td><?php echo $usermaster[$i]['sFirstName'];?></td>
                <td><?php echo $usermaster[$i]['sLastName'];?></td>
                <td><img src="<?php echo URL;?>upload/<?php echo $usermaster[$i]['sUserType'].'/'.$usermaster[$i]['sProfileName'];?>" width="100" height="80" /></td>
				<?php
				$cond1=" isActive IN(1) AND iLoginID = '".$usermaster[$i]['iLoginID']."'";
				$loginmaster = $obj->fetchRow('loginmaster',$cond1);
							
				?>
				<td><?php echo $loginmaster['sEmailID'];?></td>
							
                <td><?php echo date('d-m-Y',strtotime($usermaster[$i]['dDOB']));?></td>                
                <td><a href="<?php echo HTTP_SERVER;?>views/userdetails?iLoginID=<?php echo $usermaster[$i]['iLoginID'];?>" title="View"><i class="fa fa-fw fa-eye"></i></a> | 
                    <a href="<?php echo HTTP_SERVER;?>views/viewusers?iLoginID=<?php echo $usermaster[$i]['iLoginID'];?>" title="Deactive" onClick="return confirm('Are you sure want to Deactive?');"><i class="fa fa-fw fa-remove"></i></a></td>
              </tr>  
            <?php } ?>            
            </tbody>
          </table>
<?php }else{ ?>
<span class="recordnotfound">User not found.</span>
<?php } ?>
</div>
        </div>
      </div>
    </div>
    <!-- /.row --> 
    
  </div>
  <!-- /.container-fluid --> 
</div>
<?php
if(isset($_GET['iLoginID'])){

		$field = array('isActive');
		$value = array(0);
		
		if($obj->update($field, $value, "iLoginID = ".$_GET['iLoginID'],'usermaster') == true){
			
			$obj->update($field, $value, "iLoginID = ".$_GET['iLoginID'],'loginmaster');
			
			$objsession->set('gs_message','User successfully deleted.');	
			redirect(HTTP_SERVER."views/viewusers");
		}
		
		/*$cond = "iProductID = ".$_GET['iProductID'];
		$row = $obj->fetchRow('productmaster',$cond);

		deleteImage($row['sProductImage'],'upload');
		
		if($obj->delete('productmaster',"iProductID = ".$_GET['iProductID']) == true){
			$objsession->set('gs_message','Product successfully deleted.');	
			redirect(HTTP_SERVER."views/productview");
		}*/
}
?>
<?php include('../include/footer.php'); ?>
