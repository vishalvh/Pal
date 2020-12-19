
<!-- left side start-->
<?php $this->load->view('web/left');?>
<!-- left side end-->
<!-- main content start-->
<div class="main-content">
<!-- header-starts -->
<?php $this->load->view('web/header');?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<script type='text/javascript'>
$(document).ready(function () {
$("#start_date").datepicker({
dateFormat: "dd-mm-yy",
changeMonth: true,
changeYear: true,
yearRange: "1918:n",

});
});
</script>
<!-- //header-ends -->
	<div id="page-wrapper">
		<form method="post" action="<?php echo base_url();?>admin/add">			
			<h3 class="blank1" style="margin-top: -20px;">On line expanses Transaction Info</h3>
		</form>
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
		<form class="form-horizontal" method="post" action="<?php echo base_url();?>bank_deposit/expanses_online_edit?id=<?php echo $this->input->get('id'); ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
			<div class="md tabls">
				<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
					<div class="col-md-4">
					<label class="control-label"><b>Date</b></label>
						<div class="">
							<input type="text" id="start_date"  readonly class="form-control start_date" name="date" placeholder="Date" value="<?php echo date('d-m-Y', strtotime($expanses_online->date));?>" />
							<div class="invalid-feedback" id="start_dateerror" style="color: red;"></div>
						</div>
					</div>
				<div class="col-md-4">
					<label class="control-label"><b>Amount </b></label>
					<div class="">
						<input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" value="<?php echo $expanses_online->amount;?>" />
						<div class="invalid-feedback" id="amounterror" style="color: red;"></div>
					</div>
				</div>
				<div class="col-md-4">
					<label class="control-label"><b>Reason</b></label>
					<div class="">
						<input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Reason" value="<?php echo $expanses_online->bank_name;?>" />
						<div class="invalid-feedback" id="bank_nameerror" style="color: red;"></div>
					</div>
				</div>
			
				<div class="col-md-4" style="padding-top: 24px;">
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-success btn" type="submit" name="submit">Update</button>
							<a href="#" onclick="window.history.back();">Back</a>
						</div>
					</div>
				</div>

				</div>
			</div>

		<!-- switches -->
		</form>
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

<script>
function validate(){
var date = document.forms["savingdata"]["date"].value;
var memberid = document.forms["savingdata"]["memberid"].value;
var amount = document.forms["savingdata"]["amount"].value;
var type = document.forms["savingdata"]["type"].value;
var paymenttype = document.forms["savingdata"]["paymenttype"].value;
var chequenumber = document.forms["savingdata"]["chequenumber"].value;
var bank_name = document.forms["savingdata"]["bank_name"].value;
var reson = document.forms["savingdata"]["remark"].value;
var temp = 0;
if(date == ""){
$("#amounterror").html("date is required.");
temp++;
}
if(memberid == ""){
$("#memberiderror").html("member is required.");
temp++;
}
if(amount == ""){
$("#amounterror").html("amount is required.");
temp++;
}
if(type == ""){
$("#typeerror").html("type is required.");
temp++;
}
if(paymenttype == ""){
$("#paymenttypeerror").html("payment type is required.");
temp++;
}
if(temp != 0){
return false;     
}

}
</script>