	
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
								<h3 class="blank1" style="margin-top: -20px;">Bank Deposit Info</h3>
	 								
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
							$name = $cd[0]->UserFName;
						?>
						 <div class="md tabls">
							<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
								<div class="col-md-4">
									<label class="control-label"><b>Date</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo date('d-m-Y', strtotime($cd[0]->date));?></p>
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
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo $cd[0]->l_name;?></p>
                                   	</div>
								</div>		
								<div class="col-md-12" style="margin-top: 15px;">
									<label class="control-label"><b>Customer Name</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->name;?></p>
                                   	</div>
                                   	<?php
                                   		if ($cd[0]->payment_type == 'c') 
                                   		{
                                   			$payment_type = "Credit";
                                   		}
                                   		if ($cd[0]->payment_type == 'd') 
                                   		{
                                   			$payment_type = "Debit";
                                   		}
                                   	?>
                                   	<label class="control-label"><b>Payment Type</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $payment_type;?></p>
                                   	</div>
                                   	
                                   	<label class="control-label"><b>Bill Number</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->bill_no;?></p>
                                   	</div>
                                   	
                                   <label class="control-label"><b>Vehicle Number</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->vehicle_no;?></p>
                                    </div>
                                    <?php
                                    	if ($cd[0]->fuel_type == 'p') 
                                    	{
                                    		$fuel_type = "Petrol";
                                    	}
                                    	if ($cd[0]->fuel_type == 'd') 
                                    	{
                                    		$fuel_type = "Disel";
                                    	}
                                    	if ($cd[0]->fuel_type == 'o') 
                                    	{
                                    		$fuel_type = "Oil";
                                    	}
                                    ?>
                                    <label class="control-label"><b>Fuel Type</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $fuel_type;?></p>
                                    </div>

                                    <label class="control-label"><b>Amount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->amount;?></p>
                                    </div>

                                    <label class="control-label"><b>Quantity</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->quantity;?></p>
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
