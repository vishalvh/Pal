
    <!-- left side start-->
		<?php $this->load->view('web/left');?>
		<!-- left side end-->
    
		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<?php $this->load->view('web/header');?>
		<!-- //header-ends -->
			<div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Send Message</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>message_master	/insert" name="savingdata" onsubmit="return validate()">
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Location</label>
									<div class="col-sm-8">
										<select name="location" id="location" class="form-control1">
										<option value="">Select Location</option>
										<?php 
											foreach ($this->data['all_location_list'] as $row) {
												?>
													<option value="<?php echo $row->l_id?>"><?php echo $row->l_name?></option>
												<?php
											}
										?>
										
									</select>
									<?php echo form_error('location' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
</div>									</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">User Type</label>
									<div class="col-sm-8">
										<select name="user" id="user" class="form-control1">
										<option value="">Select User</option>
										<option value="Customer">Customer</option>
										<option value="Worker">Worker</option>
										<option value="Employee">Employee</option>
										</select>
										<?php echo form_error('user' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
									</div>
								</div>
								
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Message</label>
									<div class="col-sm-8">
										<textarea class="form-control1" name="message" style="height:200px"></textarea>
										<?php echo form_error('message' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Send</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			<!-- switches -->
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