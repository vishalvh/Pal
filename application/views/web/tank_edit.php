		<?php $this->load->view('web/left');?>
		<div class="main-content">
			<?php $this->load->view('web/header');?>
			<div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Update Tank</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>tank_list/update_tank/<?php echo $this->uri->segment(4);?>" name="savingdata" onsubmit="return validate()">
								<input type="hidden" name="id" value="<?php echo $this->uri->segment(3);?>">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Tank Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="tank_name" placeholder="Tank Name" name="tank_name" value="<?php echo $tank[0]->tank_name;?>"><?php echo form_error('tank_name','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
										<div class="invalid-feedback" id="tank_nameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Tank Location</label>
									<div class="col-sm-8">
										<select name="tank_location" id="tank_location" class="form-control1">
											<option value="">Select Location</option>
											<?php foreach($r as $row){ ?>
											<option value="<?php echo $row->l_id?>" <?php if($row->l_id == $tank[0]->location_id){ echo "selected"; } ?> ><?php echo $row->l_name?></option>
											<?php } ?>
										</select>
									<div class="invalid-feedback" id="tank_locationerror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Tank Type</label>
									<div class="col-sm-8">
										<select name="tank_type" id="tank_type" class="form-control1">
											<option value="">Select Type</option>
											<option value="15 kl" <?php if($tank[0]->tank_type == "15 kl"){ echo "selected"; } ?>>15 KL</option>
											<option value="20 kl" <?php if($tank[0]->tank_type == "20 kl"){ echo "selected"; } ?>>20 KL</option>
										</select>
									<div class="invalid-feedback" id="tank_typeerror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Fule type</label>
									<div class="col-sm-8">
										<select name="pump_type" id="pump_type" class="form-control1">
										<option value="">Select Fuel Type</option>
										<option value="d" <?php if($tank[0]->fuel_type == "d"){ echo "selected"; } ?>>Disel</option>
										<option value="p" <?php if($tank[0]->fuel_type == "p"){ echo "selected"; } ?>>Petrol</option>
									</select>
									<div class="invalid-feedback" id="pumptypeerror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Xtra Premium</label>
									<div class="col-sm-8">
										<input type ="checkbox" name="xtrapremium" <?php if($tank[0]->xp_type == "Yes"){ echo "checked"; }?> value = "Yes">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update</button>
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
	var tank_type = document.forms["savingdata"]["tank_type"].value;
		var pump_type = document.forms["savingdata"]["pump_type"].value;

	var temp = 0;
	if(tank_location == ""){
		$("#tank_locationerror").html("Tank Location is required.");
		temp++;
	}if(tank_name == ""){
		$("#tank_nameerror").html("Tank Name is required.");
		temp++;
	}
	if(tank_type == ""){
		$("#tank_typeerror").html("Tank Type is required.");
		temp++;
	}
	if(pump_type == ""){
		$("#pumptypeerror").html("Fule Type is required.");
		temp++;
	}
	if(temp != 0){
		return false;
	}
}
</script>