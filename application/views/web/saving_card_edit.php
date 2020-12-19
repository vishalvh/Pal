<!-- left side start-->
<?php $this->load->view('web/left'); ?>
<!-- left side end-->
<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Saving Card</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>saving_card/update/<?php echo $id;?>/<?php  echo $this->uri->segment('4'); ?>" name="savingdata" onsubmit="return validate()">
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Location</label>
									<div class="col-sm-8">
										<select name="location" id="location" class="form-control1">
											<option value="">Select Location</option>
											<?php foreach ($r->result() as $row) {?>
                                                                                                <option value="<?php echo $row->l_id?>" <?php if($petty_cash_member[0]->location_id == $row->l_id ){ echo "selected"; } ?>><?php echo $row->l_name?></option>
											<?php } ?> 
										</select>
										<div class="invalid-feedback" id="locationerror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" id="name" class="form-control" name="name" placeholder="Name" value="<?php echo $petty_cash_member[0]->name; ?>" />
										<div class="invalid-feedback" id="nameerror" style="color: red;"></div></div>
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

function validate(){
	var name = document.forms["savingdata"]["name"].value;
	var location = document.forms["savingdata"]["location"].value;
	//var mobile = document.forms["savingdata"]["mobile"].value;
	
	var temp = 0;
	if(name == ""){
		$("#nameerror").html("Name Is Required.");
		temp++;
	}
	
	if(location == ""){
		$("#locationerror").html("Select Location.");
		temp++;
	}
	if(temp != 0){
		return false;     
	}
}
</script>