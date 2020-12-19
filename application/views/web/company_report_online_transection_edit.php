<?php $this->load->view('web/left'); ?>
<!-- left side end-->
<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
	<?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <form method="post" action="<?php echo base_url(); ?>admin/add">			
            <h3 class="blank1" style="margin-top: -20px;">Online Transaction Edit</h3>
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
        <div class="md tabls">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>company_report/online_transection_edit/<?php echo $id; ?>" name="savingdata" onsubmit="return validate()">
                <div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">

                    
							<div class="col-md-12">
								<div class="col-md-4">
									<label class="control-label"><b>Date</b></label>
								</div>
								<div class="col-sm-8">
									<label class="control-label"><?php echo validation_errors(); ?><?php echo date('d-m-Y', strtotime($detail->date)); ?></label>
								</div>
							</div>
                            <div class="col-md-12" > 
                                
                                    <div class="col-md-4">
                                        <label class="control-label"><b style="float:left;text-align:left;">Deposit Amount</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input  id="deposit_amount" type="text" class="form-control1 "  placeholder="Deposit Amount" name="deposit_amount" value="<?php echo $detail->amount; ?>">
                                        <?php echo form_error('deposit_amount', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                        <div class="invalid-feedback" id="deposit_amount_error" style="color: red;"></div>
                                    </div>
                                
                            </div>
                            <div class="col-md-12" > 
                                    <div class="col-md-4">
                                        <label class="control-label"><b style="float:left;text-align:left;">Transaction No</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input  id="batch_no" type="text" class="form-control1 "  placeholder="Batch No" name="batch_no" value="<?php echo $detail->cheque_tras_no; ?>">
                                        <?php echo form_error('batch_no', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                        <div class="invalid-feedback" id="chequeerror" style="color: red;"></div>

                                    </div>
                            </div>
                    
					<br>
                    <div class="form-group" class="col-md-12">
                        <br>
						<div class="col-md-4">
						</div>
                        <div class="col-sm-8">
						<br>
                            <button style="padding-top:  10px;padding-right: 15px;" class="btn-success btn" type="submit" name="submit">Update</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
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
function validate() {

	var deposit_amount = document.forms["savingdata"]["deposit_amount"].value;
	var batch_no = document.forms["savingdata"]["batch_no"].value;
	var temp = 0;
	
	if (deposit_amount == "") {
		$("#deposit_amount_error").html("Amount is required.");
		temp++;
	}
	
	if (batch_no == "") {
		$("#chequeerror").html("Transaction No is required.");
		temp++;
	}
	if (temp != 0) {
		return false;
	}
}
</script>