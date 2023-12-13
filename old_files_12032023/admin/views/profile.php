<?php include('../include/header.php'); ?>
<?php
$row = array();
$iServicesID = 0;
if($objsession->get('log_loginid') != ""){
	$cond = '';
	$iLoginID = $objsession->get('log_loginid');
	$cond = "iLoginID = ".$iLoginID;
	$row = $obj->fetchRow('loginmaster',$cond);	
}
?>
<script>
$().ready(function() {
		$("#frmProfile").validate({
			debug: false,
			errorClass: "error",
			errorElement: "span",
			rules: {
				sEmailID:"required",
				cConfirmPassword:{
					equalTo:"#sNewPassword",
					minlength:6,
				},
			},
			messages: {
				sEmailID:"Please enter your email",
				cConfirmPassword:{
					equalTo: "Password doesn't match",
					minlength:"Minimum 6 character length"
				},
			
			},
			highlight: function(element, errorClass) {
				$('input').removeClass('error');
			},			
			submitHandler: function(form) {
				if(form_submit() == true){
					form.submit();
				}
			}
		});
	});

function validemail(str){
	var xmlhttp;    
	if (str=="") {
	  	return null;
	}
	
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    	document.getElementById("error_email").innerHTML=xmlhttp.responseText;
      }
  }
  xmlhttp.open("GET","<?php echo HTTP_SERVER; ?>validmail?table=loginmaster&str="+str+"&loginID=<?php echo $objsession->get('log_loginid');?>",true);
  xmlhttp.send();
}

function form_submit(){
	var e = 0;		
	if(document.getElementById('valid_id').value != '')	{
		document.getElementById('valid_info').innerHTML = "";
	}else{
		$("#valid_info").removeClass("suc-msg-forgot");
		if(isEmpty01("valid_id", "You've already registered.", "valid_info")){
			e++;
		}	
	}

	if(e > 0){
		return false;
	}else{
		return true;
	}
}

function isEmpty01(e, t, n){

	var r = document.getElementById(e);
	var n = document.getElementById(n);
	if(r.value.replace(/\s+$/, "") == ""){
		n.innerHTML = t;
		r.value = "";
		r.focus();
		return true
	}else{
		n.innerHTML = "";
		return false
	}
}

</script>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->    
    <div class="row">
      <div class="col-lg-12">
        <h2>Profile</h2>
               
<?php if($objsession->get('gs_message') != ""){?>
<div class="error-message">
<?php echo $objsession->get('gs_message');?>
</div>
<?php $objsession->remove('gs_message');}
else if($objsession->get('gs_errmessage') != ""){
?>
<span class="err_span"><?php echo $objsession->get('gs_errmessage');?></span>
<?php
$objsession->remove('gs_errmessage');
}
?> 

          <form name="frmProfile" method="post" id="frmProfile">
          <span id="error_email">
              <input type="hidden" name="valid_id" id="valid_id" value="valid" />
              </span>
          <div class="row">
          	<div class="col-lg-2">
                <label>Email</label>
             </div>
             <div class="col-lg-6 mb10">
                <input type="text" onkeypress="return validemail(this.value);" onchange="return validemail(this.value);" name="sEmailID" class="form-control" id="sEmailID" value="<?php if(!empty($row)){ echo htmlentities($row['sEmailID']);} ?>" >
                <span class="error" id="valid_info"></span>
            </div>
           </div>
           <div class="row">
             <div class="col-lg-2">
                <label>New Password</label>
            </div>
            <div class="col-lg-6 mb10">
              	<input type="password" class="form-control" name="sNewPassword" id="sNewPassword" >
            </div>
           </div>
           <div class="row">
            <div class="col-lg-2">
                <label>Confirm Password</label>
            </div>
            <div class="col-lg-6 mb10">
                <input type="password" name="cConfirmPassword" class="form-control" id="cConfirmPassword" >
            </div>
           </div>
           <div class="row">
            <div class="col-lg-6">
             	<input type="submit" onClick="return form_submit();" class="btn btn-default" name="btn_add" value="Submit">
            </div>
            </div>
          </form>
      </div>
    </div>
    <!-- /.row --> 
    
  </div>
  <!-- /.container-fluid --> 
</div>
<?php
if(isset($_POST['btn_add'])){
	extract($_POST);
	$currentDate = date('Y-m-d');
		
	$cond = "sEmailID = '".$sEmailID."' AND iLoginID != ".$objsession->get('log_loginid');
	$userdetail = $obj->fetchRow('loginmaster',$cond);
	
	if(count($userdetail) == 0){
			
		if($sNewPassword != ""){
			$field = array('sEmailID','sPassword');
			$values = array($sEmailID,md5($sNewPassword));
		}else{
			$field = array('sEmailID');
			$values = array($sEmailID);
		}
		 		 
		$obj->update($field,$values,'iLoginID = '.$objsession->get('log_loginid'),'loginmaster');	
		$objsession->set('gs_message','Profile updated successfully.');	

	}else{
		$objsession->set('gs_errmessage','Email is already existing');			
	}
	redirect(HTTP_SERVER."views/profile");
}
?>
<?php include('../include/footer.php'); ?>