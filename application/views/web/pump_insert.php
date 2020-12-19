<!-- left side start-->
<?php $this->load->view('web/left'); ?>
<!-- left side end-->
<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <div class="graphs">
            <h3 class="blank1">Add Pump</h3>
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Admin_pump/insert" name="savingdata" onsubmit="return validate()">
                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label">Pump Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" id="pump" placeholder="Enter Pump name" name="pump" value="<?php echo set_value('pump'); ?>">
                                <?php echo form_error('pump', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                <div class="invalid-feedback" id="pumperror" style="color: red;"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="selector1" class="col-sm-2 control-label">Select Location</label>
                            <div class="col-sm-8">
                                <select name="sel_loc" id="location" class="form-control1" onchange="get_tank();">
                                    <option value="">Select Location</option>
                                    <?php
                                    foreach ($r->result() as $row) {
                                        ?>
                                        <option value="<?php echo $row->l_id ?>"><?php echo $row->l_name ?></option>
                                        <?php
                                    }
                                    ?>

                                </select><div class="invalid-feedback" id="locationerror" style="color: red;"></div></div>
                        </div>

                        <div class="form-group">
                            <label for="selector1" class="col-sm-2 control-label">Select Fule type</label>
                            <div class="col-sm-8">
                                <select name="pump_type" id="pump_type" class="form-control1" onchange="get_tank();">
                                    <option value="">Select Fuel Type</option>
                                    <option value="d">Disel</option>
                                    <option value="p">Petrol</option>

                                </select><div class="invalid-feedback" id="pumptypeerror" style="color: red;"></div></div>
                        </div>
						<div class="form-group">
                            <label for="selector1" class="col-sm-2 control-label">Select Tank</label>
                            <div class="col-sm-8">
                                <select name="tank_list" id="tank_list" class="form-control1" >
                                    <option value="">Select Fuel Tank</option>
                                </select>
								<div class="invalid-feedback" id="tanklisteerror" style="color: red;"></div></div>
                        </div>
						<div class="form-group">
                            <label for="selector1" class="col-sm-2 control-label">Nozzle Code</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="nozzel_code" placeholder="Enter Nozzle Pump" id="nozzel_code">
								</div>
                        </div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Xtra Premium</label>
									<div class="col-sm-8">
										<input type ="checkbox" name="xtrapremium" value = "Yes">
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

$(document).ready(function () {

	$("#pump").blur(function () {
		var pump = $("#pump").val();
		if (pump == "") {
			$("#pumperror").html("Pump Name is required.");
		} else {
			$("#pumperror").html('');
		}
	}
	);

	$("#pump_type").blur(function () {
		var pumptype = $("#pump_type").val();
		if (pumptype == "") {
			$("#pumptypeerror").html("Select Pump Type.");
		} else {
			$("#pumptypeerror").html('');
		}
	}
	);

	$("#location").blur(function () {
		var loc = $("#location").val();
		if (loc == "") {
			$("#locationerror").html("Select location.");
		} else {
			$("#locationerror").html('');
		}
	}
	);

});
function validate() {
	var pump = document.forms["savingdata"]["pump"].value;
	var pumptype = document.forms["savingdata"]["pump_type"].value;
	var location = document.forms["savingdata"]["location"].value;


	var temp = 0;
	var tank_list = document.forms["savingdata"]["tank_list"].value;
	if (tank_list == "") {
        $("#tanklisteerror").html("Tank is required.");
        temp++;
    }
	if (pump == "") {
		$("#pumperror").html("Pump Name is required.");
		temp++;
	}
	if (pumptype == "") {
		$("#pumptypeerror").html("Select Pump Type.");
		temp++;
	}
	if (location == "") {
		$("#locationerror").html("Select Location.");
		temp++;
	}
	if (temp != 0) {
		return false;
	}
}
function get_tank(){
	$location = $("#location").val();
	$type = $("#pump_type").val();
	$("#tank_list").html('<option value="">Select Tank</option> ');
	if($location != "" && $type != ""){
		$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>admin_pump/tank_list",
				data: {"lid": $location,"type":$type}, // serializes the form's elements.
				success: function (data)
				{
					$("#tank_list").html(data);
				}
			});
	}
}
</script>