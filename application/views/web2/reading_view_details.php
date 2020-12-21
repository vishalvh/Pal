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
								
								</form>

					<h3 class="blank1">Company Reading Details</h3>
					<br>

						 <div class="md tabls">
							<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
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
									if ($query[0]['shift'] == '1') 
									{
										$shift = "Day";
									}
									if ($query[0]['shift'] == '2') 
									{
										$shift = "Night";
									}
									if ($query[0]['shift'] == '3') 
									{
										$shift = "24 hours";
									}
								?>
								<div class="col-md-4">
									<label class="control-label"><b>Date</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo date('d-m-Y', strtotime($query[0]['date']));?></p>
                                   	</div>
                                   	<label class="control-label"><b>Shift</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo $shift;?></p>
                                   	</div>

                                   	<div class="col-md-6" >
									
                                   	<div class="col-md-12">
                                            <p class="form-control-static" style="overflow: hidden;white-space: nowrap;margin-left: -25px;">General Information</p>
                                    </div>

									<label class="control-label"><b>Disel Reading</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $query[0]['DieselReading'];?></p>
                                   	</div>
                                   	<label class="control-label"><b>Petrol Reading</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $query[0]['PatrolReading'];?></p>
                                   	</div>
                                   	<label class="control-label"><b>Meter Reading</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $query[0]['meterReading'];?></p>
                                   	</div>
                                   	<label class="control-label"><b>Total Amount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $query[0]['TotalAmount'];?></p>
                                   	</div>
                                   	<label class="control-label"><b>Total cash</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $query[0]['TotalCash'];?></p>
                                   	</div>
                                   	<label class="control-label"><b>Total Credit</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $query[0]['TotalCredit'];?></p>
                                   	</div>
                                   	<label class="control-label"><b>Total Expense</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $query[0]['TotalExpenses'];?></p>
                                   	</div>
                                   	<label class="control-label"><b>Disel Deep Reading</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $query[0]['disel_deep_reding'];?></p>
                                   	</div>
                                   	<label class="control-label"><b>Petrol Deep Reading</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $query[0]['petrol_deep_reding'];?></p>
                                   	</div>
                               	</div>
							
								
								</div>
								<?php
									$name =$query[0]['UserFName'];
								?>
								<div class="col-md-4">
									<label class="control-label"><b>Name</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo ucfirst($name);?></p>
                                   	</div>
                                   	<label class="control-label"><b></b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"></p>
                                   	</div>	
                                   	<div class="col-md-6">
                                        <div class="col-sm-12">

                                            <p class="form-control-static" style="overflow: hidden;white-space: nowrap;margin-left: -25px;"> Pump Information</p>
                                        </div> 
                          
       <?php  foreach($details as $row ) {?>
                              <div class="form-group header-group-0 " id="form-group-description" style="">
                              			<label class="control-label"><b><?php echo $row['name']; ?></b></label>
										<div class="">
                                        	<p class="form-control-static"><?php echo $row['Reading']; ?></p>
                                   		</div>
                                                       
                                    </div>
	                          
                                <?php } ?>
                            </div>
								</div>	
								<div class="col-md-4">
									<label class="control-label"><b>Location</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo $query[0]['l_name'];?></p>
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
<script type="text/javascript">
 
var table;
 
$(document).ready(function() {
 	
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 		
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/ajax_list?extra=')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
});</script>