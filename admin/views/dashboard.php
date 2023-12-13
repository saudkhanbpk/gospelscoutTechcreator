<?php include('../include/header.php'); ?>
<?php
$cond = "isActive IN(1,0) AND sUserType = 'artist'";
$artist = $obj->fetchNumOfRow('usermaster',$cond);
$artistids = $obj->getConcateValue('usermaster','iLoginID',$cond);

$cond = "isActive IN(1,0) AND sUserType = 'church'";
$church = $obj->fetchNumOfRow('usermaster',$cond);
$churchids = $obj->getConcateValue('usermaster','iLoginID',$cond);

$cond = "isActive IN(1,0) AND sUserType = 'user'";
$user = $obj->fetchNumOfRow('usermaster',$cond);

$artistTotal = $obj->getTotalNetWeight('eventmaster','amount_deposite','iLoginID IN('.$artistids['ROLL'].')');
$churchTotal = $obj->getTotalNetWeight('eventmaster','amount_deposite','iLoginID IN('.$churchids['ROLL'].')');

//$artistevent = $obj->fetchNumOfRow('eventmaster','iLoginID IN('.$artistids['ROLL'].')');
//$churchevent = $obj->fetchNumOfRow('eventmaster','iLoginID IN('.$churchids['ROLL'].')');
$churchevent="";

?>
<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard
                        </h1>
                        <hr class="hrforrow"  />
                    </div>
                </div>
                <!-- /.row -->                       

                <div class="row">
                
                <h1 style="font-size: 16px; margin-left: 15px;">Users</h1>
                
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php if($artist > 0){ echo $artist;}else{ echo '0';}?></div>
                                        <div>Artist!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo HTTP_SERVER;?>views/viewusers.php?type=artist">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php if($church > 0){ echo $church;}else{ echo '0';}?></div>
                                        <div>Church!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo HTTP_SERVER;?>views/viewusers.php?type=church">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php if($user > 0){ echo $user;}else{ echo '0';}?></div>
                                        <div>User!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo HTTP_SERVER;?>views/viewusers.php?type=user">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">
                <h1 style="font-size: 16px; margin-left: 15px;">Event</h1>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-usd fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php if($artistTotal['TOTAL'] > 0){ echo $artistTotal['TOTAL']; }else{ echo '0';}?></div>
                                        <div>Artist Events!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo HTTP_SERVER;?>views/viewevents.php?type=artist">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-usd fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php if($churchTotal['TOTAL'] > 0){ echo $churchTotal['TOTAL']; }else{ echo '0';}?></div>
                                        <div>Church Events!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo HTTP_SERVER;?>views/viewevents.php?type=church">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                </div>
                
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
        </div>
<?php include('../include/footer.php'); ?>