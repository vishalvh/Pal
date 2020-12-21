	<!--
	Author: W3layouts
	Author URL: http://w3layouts.com
	License: Creative Commons Attribution 3.0 Unported
	License URL: http://creativecommons.org/licenses/by/3.0/
	-->
	<!DOCTYPE HTML>
	<html>
	<head>
	<title>Shri Hari</title>

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
	<link href="<?php echo base_url(); ?>assets1/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url();?>assets1/js/wow.min.js"></script>
		<script>
			 new WOW().init();
		</script>
	<!--//end-animate-->
	<!----webfonts--->
	<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
	<!---//webfonts---> 
	 <!-- Meters graphs -->
	<script src="<?php echo base_url();?>assets1/js/jquery-1.10.2.min.js"></script>
	<!-- Placed js at the end of the document so the pages load faster -->
	<script src="<?php echo base_url(); ?>assets1/jQuery/jQuery-2.1.4.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	
	</head> 
	   
	 <body class="sticky-header left-side-collapsed"  onload="initMap()">
	    <section>
	    <!-- left side start-->
			<?php $this->load->view('web/left');?>
			<!-- left side end-->
	    
			<!-- main content start-->
			<div class="main-content">
				<!-- header-starts -->
				<?php $this->load->view('web/header');?>
			<!-- //header-ends -->
				<div id="page-wrapper">
					<form method="post" action="<?php echo base_url();?>admin/add">			
								<h3 class="blank1" style="margin-top: -20px;">Onlinetransaction Info</h3>
	 								
								</form>

					<h3 class="blank1"></h3>
					<br>
					<?php if ($this->session->flashdata('success')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success'); ?>
							   </div>
							<?php } ?>
							<?php if ($this->session->flashdata('fail')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('fail'); ?>
							   </div>
							<?php } ?>
							<?php if ($this->session->flashdata('success_update')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success_update'); ?>
							   </div>
							<?php } ?>
							
							<?php if ($this->session->flashdata('check_fail')) { ?>
							   <div class="alert alert-danger alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('check_fail'); ?>
							   </div>
							<?php } ?>
						<?php
							$name = $onlinetransaction[0]->UserFName;
						?>
						 <div class="md tabls">
							<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">

								<div class="col-md-4">
									<label class="control-label"><b>Date</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo date('d-m-Y', strtotime($onlinetransaction[0]->date));?></p>
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Name</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo ucfirst($name);?></p>
                                   	</div>
								</div>	
								<div class="col-md-4">
									<label class="control-label"><b>Location</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo $onlinetransaction[0]->l_name;?></p>
                                   	</div>
								</div>		
								<div class="col-md-12" style="margin-top: 15px;">
									<label class="control-label"><b>Invoice Number</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $onlinetransaction[0]->invoice_no;?></p>
                                   	</div>
                                   	
                                   	<label class="control-label"><b>Customer Name</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $onlinetransaction[0]->customer_name;?></p>
                                   	</div>
                                   	
                                   	<label class="control-label"><b>Amount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $onlinetransaction[0]->amount;?></p>
                                   	</div>
                                   	
                                   <label class="control-label"><b>Paid By</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $onlinetransaction[0]->paid_by;?></p>
                                    </div>

                                    <label class="control-label"><b>Cheque Transaction Number</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $onlinetransaction[0]->cheque_tras_no;?></p>
                                    </div>

								</div>

								
						   </div>
						</div>
				<!-- switches -->
			<div class="switches">
				
			</div>
			<!-- //switches -->
							</div>
				<!--body wrapper start-->
				</div>
				 <!--body wrapper end-->
			</div>
	        <!--footer section start-->
				<?php $this->load->view('web/footer');?>
	        <!--footer section end-->

	      <!-- main content end-->
	   </section>
	  
	<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
	<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
	<!-- Bootstrap Core JavaScript -->
	   <script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
	</body>
	</html>

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js')?>"></script>
