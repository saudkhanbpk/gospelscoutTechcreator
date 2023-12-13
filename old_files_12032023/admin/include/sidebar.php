<style>
.navbar-inverse .navbar-nav > li > a:focus, .navbar-inverse .navbar-nav > li > a:hover
{
color: #fff !important;
background-color: #9968cf !important;
}
.nav.navbar-nav.side-nav { background-color: #fff !important; }
a { color: #9968cf !important; }
.side-nav li a:hover, .side-nav li a:focus { background-color: #9968cf !important; color: #fff !important; }
.panel-primary > .panel-heading { background-color: #9968cf !important; }
.fa.fa-arrow-circle-right { color: #9968cf !important; }
.panel-footer{ color: #9968cf !important; }
.navbar-inverse .navbar-toggle { background-color: #9968cf !important; }
 .top-nav > li > a:hover, .top-nav > li > a:focus, .top-nav > .open > a, .top-nav > .open > a:hover, .top-nav > .open > a:focus
{ color: #000; background-color: transparent; }
.searchfilter{ border-color: #9968CF !important; color: #000 !important;}
.searchfilter:hover { color: #fff !important; }
.btn-info { background-color: #ddd !important; border-color: #9968CF !important; color: #000 !important; }
.btn-info:hover { background-color: #9968CF !important; color: #fff !important; }
.fg-button { background-color: #9968CF !important; color: #fff !important; }
.fg-button:hover { background-color: #9968CF !important; color: #fff !important; }

.btn-default { background-color: #ddd !important; color: #000 !important; border-color: #9968CF !important; }
.btn-default:hover { background-color: #9968CF !important; color: #fff !important; }
.panel.panel-green .panel-footer .fa.fa-arrow-circle-right { color: #5CB85C !important; }
.panel.panel-green .panel-footer {  color: #5CB85C !important; }
.page-header { border:none !important; }
.side-nav { top: 70px; }
.navbar.navbar-inverse.navbar-fixed-top { height:70px; }


@media screen and (min-width:310px) and (max-width:767px){
#example1_wrapper { overflow-x: auto; overflow-y: hidden; width: 100%;}
}
</style>
<div class="collapse navbar-collapse navbar-ex1-collapse" id="top">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a class="active" href="<?php echo HTTP_SERVER;?>views/dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#cat"><i class="fa fa-fw fa-arrows-v"></i> Manage User <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="cat" class="collapse">
                            <li>
                                <a href="<?php echo HTTP_SERVER;?>views/viewusers.php"><i class="fa fa-fw fa-desktop"></i> Active User</a>
                            </li>
                            <li>
                                <a href="<?php echo HTTP_SERVER;?>views/viewdeactiveusers.php"><i class="fa fa-fw fa-desktop"></i> Deactive User</a>
                            </li>
                        </ul>
                    </li> 
					<li>
                        <a href="<?php echo HTTP_SERVER;?>views/content_data.php"><i class="fa fa-fw fa-desktop"></i> Registration Content </a>
                    </li> 
					<!--<li>
                        <a href="<?php echo HTTP_SERVER;?>views/main_banner.php"><i class="fa fa-fw fa-desktop"></i> Manage Main Page Banner </a>
                    </li>-->
					<li>
                        <a href="<?php echo HTTP_SERVER;?>views/viewgifts1.php"><i class="fa fa-fw fa-desktop"></i> Manage Church Gifts </a>
                    </li>                   
                    <li>
                        <a href="<?php echo HTTP_SERVER;?>views/viewgifts.php"><i class="fa fa-fw fa-desktop"></i> Manage Artist Talents</a>
                    </li>  
                    <li>
                        <a href="<?php echo HTTP_SERVER;?>views/viewevents.php"><i class="fa fa-fw fa-desktop"></i> Manage Event</a>
                    </li>                     
                    <li>
                        <a href="<?php echo HTTP_SERVER;?>views/viewcmspages.php"><i class="fa fa-fw fa-file-code-o"></i> Manage CMS</a>
                    </li>
                    
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#cat1"><i class="fa fa-fw fa-arrows-v"></i> Manage Booking <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="cat1" class="collapse">
                            <li>
                                <a href="<?php echo HTTP_SERVER;?>views/artistbook.php">Artist Book</a>
                            </li>
                            <li>
                                <a href="<?php echo HTTP_SERVER;?>views/churchbook.php">Church Book</a>
                            </li>
                             <li>
                                <a href="<?php echo HTTP_SERVER;?>views/eventbook.php">Event Book</a>
                            </li>
                        </ul>
                    </li> 
                    <?php /*?><li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#cat2"><i class="fa fa-fw fa-arrows-v"></i> Banner <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="cat2" class="collapse">
                            <li>
                                <a href="<?php echo HTTP_SERVER;?>artistbanner">Artist Banner</a>
                            </li>
                            <li>
                                <a href="<?php echo HTTP_SERVER;?>churchbanner">Church Banner</a>
                            </li>
                             <li>
                                <a href="<?php echo HTTP_SERVER;?>eventbanner">Event Banner</a>
                            </li>
                        </ul>
                    </li> <?php */?>

                     
                    
                </ul>
            </div>