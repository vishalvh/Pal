<!DOCTYPE html>
<html>
	<head>
		<meta name = "viewport" content = "width = device-width, initial-scale = 1">
		<link rel = "stylesheet" href = "https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
		<script src = "https://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src = "https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url(); ?>mobile/jquery.mobile.datepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>mobile/jquery.mobile.datepicker.theme.css" />
		<script src="<?php echo base_url(); ?>mobile/external/jquery-ui/datepicker.js"></script>
		<script src="<?php echo base_url(); ?>mobile/jquery.mobile.datepicker.js"></script>
		<script>
			$(function(){
				$( ".date-input-css" ).datepicker();
			})
		</script>
		<style>
		div#ui-datepicker-div {
    z-index: 999 !important;
}
.ui-icon-myicon:after {
	background-image: url("<?php echo base_url(); ?>mobile/customers.png");
	background-size: 18px 18px;
}
		</style>
	</head>
	<body>
		<div data-role = "page" id = "pageone">
			<div data-role = "header">
			<h1>Petty Cash Report <?php echo base_url(); ?></h1>
			</div>
			<div style="border: 1px solid;">
			<div class="ui-grid-a">
				<div class="ui-block-a"><input type="text" class="date-input-css" placeholder="Start Date" id="start_date"></div>
				<div class="ui-block-b"><input type="text" data-role="date" placeholder="End Date" id="end_date"></div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">
					<div class="ui-field-contain">
						<select name="location" id="location" onchange="get_member(this.value);">
							<option value="">Select Location </option> 
							<?php $cnt = 1; foreach ($location as $raw)  { ?>
								<option  value="<?php echo $raw['l_id']; ?>" <?php if($lid == $raw['l_id']){ echo "selected"; } ?>><?php echo ucwords($raw['l_name']); ?></option>
  							<?php } ?>
						</select>
					</div>
				</div>
				<div class="ui-block-b">
					<div class="ui-field-contain">
						<select name="Employeename" id="Employeename">
							<option value="">Select Member </option> 
						</select>
					</div>
				</div>
			</div>
			<div data-role = "main" class = "ui-content">
				<div class="cal-md-12">
					 
					<input type="button" onClick="search();" class="btn btn-primary"  value="search">
				</div>
				
				<div class="ui-grid-solo">
					<div class="ui-block-a" id="newdata">
					</div>
				</div>
			</div>
			</div>
		<div data-role = "footer">
		<h1>Footer Text</h1>
		</div>
		</div>
	</body>
</html>
<script type='text/javascript'>

function get_member(lid){
	 var customer_id = "<?php echo $member_id?>";
		if(lid==""){
				$("#Employeename").html('<option value="">Select Customer </option> ');
		}else{
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>petty_cash_report/member_list/"+customer_id,
				data: {"lid": lid}, // serializes the form's elements.
				success: function (data)
				{
					$("#Employeename").html(data);
				}
			});
		}
}
function search(){	
	var sdate = $("#start_date").val();
	var edate = $("#end_date").val();
	var lid = $("#location").val();
	var member_id = $("#Employeename").val();
	var temp = 0;
	if(sdate == ""){
		$("#start_date_error").html('Required!');
		temp++;
	}
	else {
		$("#start_date_error").html('');
	}

	if(edate == ""){
		$("#end_date_error").html('Required!');
		temp++;
	}
	else {
		$("#end_date_error").html('');
	}
	if(lid == ""){
		$("#locatione_error").html('Required!');
		temp++;
	}
	else {
		$("#locatione_error").html('');
	}
	if(temp==0){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>petty_cash_report/reportlist_mobile",
			data: {'lid': lid,'sdate':sdate,'edate':edate,'member_id':member_id}, // serializes the form's elements.
			success: function (data)
			{
				$("#newdata").html(data);
			}
		});
	}	
}
</script>