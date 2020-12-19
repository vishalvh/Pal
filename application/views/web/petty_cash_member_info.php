
<!-- left side start-->
<?php $this->load->view('web/left'); ?>
<!-- left side end-->
<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
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
        <form method="post" action="<?php echo base_url(); ?>admin/add">			
            <h3 class="blank1" style="margin-top: -20px;">Petty Cash Info</h3>
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
        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>petty_cash_report/info?id=<?php echo $this->input->get('id'); ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>&member_id=<?php echo $this->input->get('member_id'); ?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
            <div class="md tabls">
                <div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
                    <div class="col-md-4">
                        <label class="control-label"><b>Date</b></label>
                        <div class="">

                            <input type="text" id="start_date"  readonly class="form-control start_date" name="date" placeholder="Date" value="<?php echo date('d-m-Y', strtotime($petty_cash_detail->date)); ?>" />
                            <div class="invalid-feedback" id="start_dateerror" style="color: red;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label"><b>Member List</b></label>
                        <div class="">
                            <select id="memberid" name="memberid" class="form-control">
                                <option value=""> Select Member</option>
                                <?php foreach ($member_list as $type) { ?>
                                    <option value="<?php echo $type->id ?>" <?php if ($petty_cash_detail->member_id == $type->id) echo"selected" ?>><?php echo $type->name; ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback" id="memberiderror" style="color: red;"></div>
                        </div>
                    </div>	
                    <div class="col-md-4">
                        <label class="control-label"><b>Amount</b></label>
                        <div class="">
                            <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" value="<?php echo $petty_cash_detail->amount; ?>" />

                            <div class="invalid-feedback" id="amounterror" style="color: red;"></div>
                        </div>
                    </div>	
                    <div class="col-md-4">
                        <label class="control-label"><b>Type</b></label>
                        <div class="">
                            <select id="type" name="type" class="form-control">
                                <option value=""> Select Type</option>
                                <option value="c" <?php if ($petty_cash_detail->type == 'c') echo"selected" ?>>Credit</option>
                                <option value="d" <?php if ($petty_cash_detail->type == 'd') echo"selected" ?>>Debit</option>
                            </select>
                            <div class="invalid-feedback" id="typeerror" style="color: red;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label"><b>Transaction Type</b></label>
                        <div class="">
                            <select id="paymenttype" name="paymenttype" class="form-control">
                                <option value=""> Select Transaction Type</option>
                                <option value="cs" <?php if ($petty_cash_detail->transaction_type == 'cs') echo"selected" ?>>Cash</option>
                                <option value="c" <?php if ($petty_cash_detail->transaction_type == 'c') echo"selected" ?>>Cheque</option>
                                <option value="n" <?php if ($petty_cash_detail->transaction_type == 'n') echo"selected" ?>>Net Banking</option>
                            </select>
                            <div class="invalid-feedback" id="paymenttypeerror" style="color: red;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label"><b>Transaction No/Cheque No</b></label>
                        <div class="">
                            <input type="text" class="form-control" name="chequenumber" id="chequenumber" placeholder="Transaction No/Cheque No" value="<?php echo $petty_cash_detail->transaction_no; ?>" />
                            <div class="invalid-feedback" id="chequenumbererror" style="color: red;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label"><b>Bank Name </b></label>
                        <div class="">
                            <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name" value="<?php echo $petty_cash_detail->bank_name; ?>" />
                            <div class="invalid-feedback" id="bank_nameerror" style="color: red;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label"><b>Reson</b></label>
                        <div class="">
                            <input type="text" class="form-control" name="remark" id="reson" placeholder="Reson" value="<?php echo $petty_cash_detail->remark; ?>" />
                            <div class="invalid-feedback" id="resonerror" style="color: red;"></div>
                        </div>
                    </div>
                    <?php if($petty_cash_detail->type == "c"){ ?>
                    <div class="col-md-4" id="row_dim" >
                        <label class="control-label"><b>Count</b></label> <br>
                        <input type="radio" id="count_yes"  name="count_status" value="1" <?php if ($petty_cash_detail->count_status == 1){ echo "checked"; } ?> > <label for="count_yes" class="control-label"><b> YES</b></label>
                        <input type="radio" id="count_no" name="count_status" value="0" <?php if ($petty_cash_detail->count_status == 0){ echo "checked"; }?>>  <label for="count_no" class="control-label"><b> NO</b></label><br>
                        
                    </div>
                    <?php } ?>
                    <div class="col-md-4" style="padding-top: 24px;">
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button class="btn-success btn" type="submit" name="submit">Update</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- switches -->
            <div class="switches">
        </form>
    </div>
    <!-- //switches -->
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

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script>
     $(function() {
   // $('#row_dim').hide(); 
    $('#type').change(function(){
        if($('#type').val() == 'c') {
            $('#row_dim').show(); 
        } else {
            $('#row_dim').hide(); 
        } 
    });
});

            function validate() {
                var date = document.forms["savingdata"]["date"].value;
                var memberid = document.forms["savingdata"]["memberid"].value;
                var amount = document.forms["savingdata"]["amount"].value;
                var type = document.forms["savingdata"]["type"].value;
                var paymenttype = document.forms["savingdata"]["paymenttype"].value;
                var chequenumber = document.forms["savingdata"]["chequenumber"].value;
                var bank_name = document.forms["savingdata"]["bank_name"].value;
                var reson = document.forms["savingdata"]["remark"].value;
                var temp = 0;
                if (date == "") {
                    $("#amounterror").html("date is required.");
                    temp++;
                }
                if (memberid == "") {
                    $("#memberiderror").html("member is required.");
                    temp++;
                }
                if (amount == "") {
                    $("#amounterror").html("amount is required.");
                    temp++;
                }
                if (type == "") {
                    $("#typeerror").html("type is required.");
                    temp++;
                }
                if (paymenttype == "") {
                    $("#paymenttypeerror").html("payment type is required.");
                    temp++;
                }
                if (temp != 0) {
                    return false;
                }

            }
</script>