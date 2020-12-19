	
    <!-- left side start-->
		<?php $this->load->view('web/left');?>
		<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/css/jquery.mCustomScrollbar.min.css" type='text/css' />
		<!-- left side end-->
    
		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<?php $this->load->view('web/header');?>
		<!-- //header-ends -->
			<div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Update company daily tank density report</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>company_daily_tank_density_report/update?location=<?=$location?>&date=<?=$date?>&sdate=<?=$sdate?>&edate=<?=$edate?>&type=<?=$type?>&tank=<?=$tank?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo $this->uri->segment('3');?>">
								<div class="form-group" style="display:none">
									<label for="focusedinput" class="col-sm-2 control-label">Date</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" readonly id="usernameval" placeholder="Date" name="date" value="<?php echo date('d-m-Y',strtotime($reports[0]->date));?>">
										<?php echo form_error('date','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Challan Quantity</label>
									<div class="col-sm-8">
										<?php if($reports[0]->fuel_type =='d'){?>
										<input type="text" class="form-control1" id="usernameval" placeholder="Challan Quantity" name="d_quantity" value="<?php echo $reports[0]->d_quantity;?>">
										
										<?php }else{ ?>
										<input type="text" class="form-control1" id="usernameval" placeholder="Challan Quantity" name="p_quantity" value="<?php echo $reports[0]->p_quantity;?>">
										<?php } ?>
										<?php echo form_error('p_quantity','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Challan No</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="usernameval" placeholder="Challan No" name="invoice_no" value="<?php echo $reports[0]->invoice_no;?>">
										<?php echo form_error('invoice_no','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Challan Density</label>
									<div class="col-sm-8">
									<?php if($reports[0]->fuel_type =='d'){?>
									<input type="text" class="form-control1" id="usernameval" placeholder="Challan Density" name="d_invoice_density" value="<?php echo $reports[0]->d_invoice_density;?>">
									
									<?php }else{?>
									
									
										<input type="text" class="form-control1" id="usernameval" placeholder="Challan Density" name="p_invoice_density" value="<?php echo $reports[0]->p_invoice_density;?>">
									<?php } ?>
										<?php echo form_error('p_invoice_density','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Observed Density</label>
									<div class="col-sm-8">
									<?php if($reports[0]->fuel_type =='d'){?>
									<input type="text" class="form-control1" id="usernameval" placeholder="Observed Density" name="d_observer_density" value="<?php echo $reports[0]->d_observer_density;?>">
									
									<?php }else{?>
										<input type="text" class="form-control1" id="usernameval" placeholder="Observed Density" name="p_observer_density" value="<?php echo $reports[0]->p_observer_density;?>">
									<?php } ?>
										<?php echo form_error('p_observer_density','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">No. of TT Samples Kept</label>
									<div class="col-sm-8">
									<?php if($reports[0]->fuel_type =='d'){?>
									<input type="text" class="form-control1" id="usernameval" placeholder="No. of TT Samples Kept" name="d_vehicle_no" value="<?php echo $reports[0]->d_vehicle_no;?>">
									
									<?php }else{
										?>
										<input type="text" class="form-control1" id="usernameval" placeholder="No. of TT Samples Kept" name="p_vehicle_no" value="<?php echo $reports[0]->p_vehicle_no;?>">
									<?php } ?>
										<?php echo form_error('p_vehicle_no','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>
								<?php if($reports[0]->fuel_type =='d'){?>
								<?php  $cnt =1;
								
									$jsondecode = json_decode($reports[0]->d_sample,true);
									
									foreach($jsondecode as $vs){
								?>
								
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Seal Number <?php echo $cnt;?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="usernameval" placeholder="Seal Number <?php echo $cnt;?>" name="d_sample[]" value="<?php echo $vs['name'];?>">
										<?php echo form_error('p_sample[]','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>

									<?php $cnt++;} ?>
								<?php }else{?>
								<?php  $cnt =1;
								
									$jsondecode = json_decode($reports[0]->p_sample,true);
									
									foreach($jsondecode as $vs){
								?>
								
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Seal Number <?php echo $cnt;?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="usernameval" placeholder="Seal Number <?php echo $cnt;?>" name="p_sample[]" value="<?php echo $vs['name'];?>">
										<?php echo form_error('p_sample[]','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>

									<?php $cnt++;} ?>
									
								<?php } ?>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update</button>
										<a href="#" onclick="window.history.back();">Back</a>
									</div>
								</div>
							</form>
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