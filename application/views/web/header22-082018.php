<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	 <!-- Bootstrap Core CSS -->
	<link href="<?php echo base_url();?>assets1/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<!-- Custom CSS -->
	<link href="<?php echo base_url();?>assets1/css/style.css" rel='stylesheet' type='text/css' />
	<!-- Graph CSS -->
	<link href="<?php echo base_url();?>assets1/css/font-awesome.css" rel="stylesheet"> 
	<!-- jQuery -->
	<!-- lined-icons -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets1/css/icon-font.min.css" type='text/css' />
	<!-- //lined-icons -->
	<!-- chart -->
	<script src="<?php echo base_url();?>assets1/js/Chart.js"></script>
	<!-- //chart -->
	<!--animate-->
	<link href="<?php echo base_url();?>assets1/css/animate.css" rel="stylesheet" type="text/css" media="all">
	<script src="<?php echo base_url();?>assets1/js/wow.min.js"></script>
		<script>
			 new WOW().init();
		</script>
	<!--//end-animate-->
	<!----webfonts--->
	<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
	<!---//webfonts---> 
	 <!-- Meters graphs -->
<!--	<script src="<?php echo base_url();?>assets1/js/jquery-1.10.2.min.js"></script>-->
	<!-- Placed js at the end of the document so the pages load faster -->
<!--	<script src="<?php echo base_url(); ?>assets1/jQuery/jQuery-2.1.4.min.js"></script>-->

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		 <div class="header-section">
			 
			<!--toggle button start-->
			<a class="toggle-btn  menu-collapsed"><i class="fa fa-bars"></i></a>
			<!--toggle button end-->

			<!--notification menu start -->
			<div class="menu-right">
				<div class="user-panel-top">  	
				
					<div class="profile_details">		
						<ul>
							<li class="dropdown profile_details_drop">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<div class="profile_img">	
										<!--<span style="background:url(images/1.jpg) no-repeat center"> </span>--> 
										 <div class="user-name">
											<p><?php echo $logged_company["name"];?><span>Company</span></p>
										 </div>
										 <!--<i class="lnr lnr-chevron-down"></i>
										 <i class="lnr lnr-chevron-up"></i>-->
										<div class="clearfix"></div>	
									</div>	
								</a>
								<ul class="dropdown-menu drp-mnu">
									
									<?php if($logged_company["type"] == 'c' ){ ?>
                                                                    <li> <a href="<?php echo base_url()?>admin/change_pass"><i class="fa fa-cog"></i>Change Password</a> </li> 
                                                                        <li> <a href="<?php echo base_url()?>admin/profile"><i class="fa fa-user"></i>Profile</a> </li> 
                                                                        <li> <a href="<?php echo base_url();?>main/logout"><i class="fa fa-sign-out"></i> Logout</a> </li>
                                                                        <?php } if($logged_company["type"] == 'm' ){ ?>
                                                                        <li> <a href="<?php echo base_url()?>madetor_login/change_pass"><i class="fa fa-cog"></i>Change Password</a> </li>
                                                                        <li> <a href="<?php echo base_url()?>madetor_login/profile"><i class="fa fa-user"></i>Profile</a> </li> 
                                                                        <li> <a href="<?php echo base_url();?>madetor_login/logout"><i class="fa fa-sign-out"></i> Logout</a> </li>
                                                                            <?php } ?>
                                                                        
								</ul>
							</li>
							<div class="clearfix"> </div>
						</ul>
					</div>		
				<div class="clearfix"></div>
				</div>
			  </div>
			<!--notification menu end -->
			</div>