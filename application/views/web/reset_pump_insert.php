<!-- left side start-->
<?php $this->load->view('web/left'); ?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<!-- left side end-->
<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Reset Pump</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>reset_pump/insert" name="savingdata" onsubmit="return validate()">
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Location</label>
									<div class="col-sm-8">
										<select name="location" id="location" class="form-control1" onchange="get_location_pump(this.value);">
											<option value="">Select Location</option>
											<?php foreach ($r->result() as $row) {?>
												<option value="<?php echo $row->l_id?>"><?php echo $row->l_name?></option>
											<?php } ?>
										</select>
										<div class="invalid-feedback" id="locationerror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Pump</label>
									<div class="col-sm-8">
										<select name="pumplist" id="pumplist" class="form-control1">
											<option value="">Select Pump</option>
										</select>
										<div class="invalid-feedback" id="pumplisterror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Date</label>
									<div class="col-sm-8">
										<input type="text" id="date"  readonly class="form-control date" name="date" placeholder="Date" value="<?php  echo date("d-m-Y"); ?>" />
										<div class="invalid-feedback" id="dateerror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Last Reading</label>
									<div class="col-sm-8">
										<input type="text" name="reading" id="reading" class="form-control1">
										<div class="invalid-feedback" id="readingerror" style="color: red;"></div></div>
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
		<!--body wrapper start-->
	</div>
<!--body wrapper end-->
</div>
<!--footer section start-->
<?php $this->load->view('web/footer'); ?>
<!--footer section end-->
<!-- main content end-->
</section>

<script src="<?php echo base_url(); ?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(); ?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets1/js/bootstrap.min.js"></script>
</body>
</html>
<script>
$(document).ready(function() {
        $("#date").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "2017:n",
            maxDate: new Date() 
        });
    });
function validate(){
	
	var pumplist = document.forms["savingdata"]["pumplist"].value;
	var location = document.forms["savingdata"]["location"].value;
	var date = document.forms["savingdata"]["date"].value;
	var reading = document.forms["savingdata"]["reading"].value;
	var temp = 0;
	if(pumplist == ""){
		$("#pumplisterror").html("Select Pump.");
		temp++;
	}
	if(date == ""){
		$("#dateerror").html("Select Pump Type.");
		temp++;
	}
	if(location == ""){
		$("#locationerror").html("Select Location.");
		temp++;
	}
	if(reading == ""){
		$("#readingerror").html("Reading is required.");
		temp++;
	}
	if(temp != 0){
		return false;     
	}
}
function get_location_pump(lid){
	$("#pumplist").html('<option value="">Select Pump</option> ');
	if(lid != "" ){
		$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>reset_pump/pump_list",
				data: {"lid": lid}, // serializes the form's elements.
				success: function (data)
				{
					$("#pumplist").html(data);
				}
			});
	}
}
</script>