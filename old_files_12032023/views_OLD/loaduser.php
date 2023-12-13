<?php
include('../common/config.php');

extract($_GET);

$cond = " isActive IN(1)";

if ($mixvalue != "") {
	$cond .= " AND (sFirstName LIKE '%".$mixvalue."%'";
}

if ($mixvalue != "") {
	$cond .= " OR sLastName	LIKE '%".$mixvalue."%')";
}

if ($usertype != "" && $usertype != 'all') {
	$cond .= " AND sUserType = '".$usertype."'";
}

$usermaster = $obj->fetchRowAll('usermaster',$cond." order by iUserID DESC");
$totalusermaster = $obj->fetchNumOfRow('usermaster',$cond);

if($totalusermaster > 0){
?>
          <table class="table table-hover" id="example1">
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Profile</th>
                <th>Date</th>
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
                <td><?php echo date('d-m-Y',strtotime($usermaster[$i]['dDOB']));?></td>                
                <td><a href="<?php echo HTTP_SERVER;?>userdetails/<?php echo $usermaster[$i]['iLoginID'];?>" title="View"><i class="fa fa-fw fa-eye"></i></a> | 
                    <a href="<?php echo HTTP_SERVER;?>viewusers/<?php echo $usermaster[$i]['iLoginID'];?>" title="Delete" onClick="return confirm('Are you sure want to delete?');"><i class="fa fa-fw fa-remove"></i></a></td>
              </tr>  
            <?php } ?>            
            </tbody>
          </table>
<?php }else{ ?>
<span class="recordnotfound">User not found.</span>
<?php } ?>
