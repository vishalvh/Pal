		<?php $this->load->view('web/left');?>
		<div class="main-content">
			<?php $this->load->view('web/header');?>
			<div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Add Wallet</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>wallet/add_wallet" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="tank_name" placeholder="Name" name="tank_name" value=""><?php echo form_error('tank_name','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
										<div class="invalid-feedback" id="tank_nameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Location</label>
									<div class="col-sm-8">
										<select name="tank_location" id="tank_location" class="form-control1">
											<option value="">Select Location</option>
											<?php foreach($r as $row){ ?>
											<option value="<?php echo $row->l_id?>" ><?php echo $row->l_name?></option>
											<?php } ?>
										</select>
									<div class="invalid-feedback" id="tank_locationerror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Image</label>
									<div class="col-sm-8">
										<input type="file" class="" id="img" placeholder="Image" name="img" >
										<div class="invalid-feedback" id="imgerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Add</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('web/footer');?>
</section>
<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
<script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
</body>
</html>
<script>
			
function validate(){
	var tank_location = document.forms["savingdata"]["tank_location"].value;
	var tank_name = document.forms["savingdata"]["tank_name"].value;
	
	var temp = 0;
	if(tank_location == ""){
		$("#tank_locationerror").html("Location is required.");
		temp++;
	}if(tank_name == ""){
		$("#tank_nameerror").html("Name is required.");
		temp++;
	}
	
	if(temp != 0){
		return false;
	}
}
</script>