
<!--<style>
    body{
        height:100%
    }
</style>-->


<!-- left side start-->
<?php $this->load->view('web/left'); ?>
<!-- left side end-->

<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <form method="post" action="<?php echo base_url(); ?>admin/add">			
            <h3 class="blank1" style="margin-top: -20px;">Bank Deposit Edit</h3>

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
        <?php
        $name = $bd[0]->UserFName;
        ?>
        <div class="md tabls">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>bank_deposit/bankdeposit_edit_cradit?id=<?php echo $id; ?>&sdate=<?php echo $this->input->get('sdate');?>&edate=<?php echo $this->input->get('edate');?>&l_id=<?php echo $this->input->get('l_id');?>" name="savingdata" onsubmit="return validate()">
			<div class="clo-md-12">
			<?php echo validation_errors(); ?>
			</div>
                <div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
                    <div class="col-md-4">
                        <div class="col-md-4">
                            <label class="control-label"><b>Date</b></label>
                        </div>
                        <div class="col-sm-8">
                            <label class="control-label"><?php echo date('d-m-Y', strtotime($bd[0]->date)); ?></label>

                            <?php echo form_error('date', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                            <div class="invalid-feedback" id="dateerror" style="color: red;"></div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="col-md-4">
                            <label class="control-label"><b>Name</b></label>
                        </div>
                        <div class="col-sm-8">
                            <label class="control-label"><?php echo ucfirst($name); ?></label>

                            <?php echo form_error('date', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                            <div class="invalid-feedback" id="dateerror" style="color: red;"></div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="col-md-4">
                            <label class="control-label"><b>Location</b></label>

                        </div>
                        <div class="col-sm-8">
                            <label class="control-label"><?php echo $bd[0]->l_name; ?></label>

                            <?php echo form_error('l_name', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                            <div class="invalid-feedback" id="l_name_error" style="color: red;"></div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <input  id="id" type="hidden" class="form-control1 "  name="id" value="<?php echo $bd[0]->id; ?>">
<!--                            <div class="col-md-4" > 
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="col-md-4">
                                        <label class="control-label"><b style="float:left;text-align:left;">Deposit Amount</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                       
                                        <?php echo form_error('date', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                        <div class="invalid-feedback" id="deposit_amount_error" style="color: red;"></div>

                                    </div>
                                </div>
                            </div>-->
<!--                            <div class="col-md-4" > 
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="col-md-4">
                                        <label class="control-label"><b style="float:left;text-align:left;">Total Amount</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input  id="total_amount" type="text" class="form-control1 " readonly  placeholder="" name="total_amount" value="<?php //echo $bd[0]->amount; ?>">
                                        <?php echo form_error('date', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                        <div class="invalid-feedback" id="deposit_amount_error" style="color: red;"></div>

                                    </div>
                                </div>
                            </div>-->
                        </div>
                        <div class="col-md-12"> 
                            <?php foreach ($d_amount as $amout) { ?>
                                <div class="col-md-4">

                                    <div class="col-md-12"  style="margin-top: 15px;">
                                        <div class="col-md-4" >
                                            <label class="control-label"><b>Customer </b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <select  name="c_name_<?php echo $amout->id ?>" id="c_anme_by" class="form-control1 ">
                                                <?php foreach ($user_list as $user) { ?>
                                                    <option value="<?php echo $user->id; ?>" <?php
                                                    if ($user->id == $amout->customer_id) {
                                                        echo "selected";
                                                    }
                                                    ?> > <?php echo $user->name; ?> </option>
                                                        <?php } ?>
                                            </select>

                                            <?php echo form_error('cheque_no', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                            <div class="invalid-feedback" id="chequeerror" style="color: red;"></div>

                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <div class="col-md-4">
                                            <label class="control-label"><b>Deposited By</b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <select name="transaction_type<?php echo $amout->id ?>" id="transaction_type_<?php echo $amout->id; ?>" onchange="changetrasectiontype(<?php echo $amout->id; ?>);" class="form-control1 " > 
                                                <option value="cs"<?php
                                                if ($amout->transaction_type == 'cs') {
                                                    echo "selected";
                                                }
                                                ?> >Cash</option>
                                                <option value="c" <?php
                                                if ($amout->transaction_type == 'c') {
                                                    echo "selected";
                                                }
                                                ?> >Cheque</option>
                                                <option value="n" <?php
                                                if ($amout->transaction_type == 'n') {
                                                    echo "selected";
                                                }
                                                ?> >Net Banking</option>
                                            </select>
                                            <?php echo form_error('withdraw_amount', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                            <div class="invalid-feedback" id="deposited_by_error" style="color: red;"></div>

                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 15px; display: <?php if ($amout->transaction_type == 'cs') { echo "none"; }else{ echo "block";  } ?>" id="cheque_div_<?php echo $amout->id; ?>">
                                        <div class="col-md-4">
                                            <label class="control-label"><b>Cheque or Transaction No. </b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type ="text" name="cheque_no_<?php echo $amout->id ?>" id="cheque_no_<?php echo $amout->id; ?>" class="form-control1" value="<?php echo $amout->transaction_number;?>" > 
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 15px; display: <?php if ($amout->transaction_type == 'cs') { echo "none"; }else{ echo "block";  } ?>" id="bank_div_<?php echo $amout->id; ?>">
                                        <div class="col-md-4">
                                            <label class="control-label"><b>Bank Name</b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type ="text" name="bank_name_<?php echo $amout->id ?>" id="bank_name_<?php echo $amout->id; ?>" class="form-control1 " value="<?php echo $amout->bank_name;?>" > 
                                        </div>
                                    </div>
                                    <div class="col-md-12"  style="margin-top: 15px;">
                                        <div class="col-md-4" >
                                            <label class="control-label"><b>Amount</b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input  onkeyup="total();"  id="amount_<?php echo $amout->id ?>" type="text" class="form-control1 "  placeholder="Cheque No" name="amount_<?php echo $amout->id ?>" value="<?php echo $amout->amount; ?>">

                                            <?php echo form_error('cheque_no', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                            <div class="invalid-feedback" id="chequeerror" style="color: red;"></div>

                                        </div>
                                    </div>
                                </div>          
                            <?php } ?>
                        </div>
                    </div>




                    <br>
                    <div class="form-group" class="col-md-12" style="padding-top:  10px;padding-right: 15px;" >
                        <br>
                        <div class="col-sm-8 col-sm-offset-2" style="padding-top:  10px;padding-right: 15px;">
                            <button style="padding-top:  10px;padding-right: 15px;" class="btn-success btn" type="submit" name="submit">Update</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- switches -->
    <div class="switches">

    </div>
    <!-- //switches -->
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

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script>
                                                function changetrasectiontype(id) {
                                                   // alert(id);
                                                    $type = $("#transaction_type_"+id).val();
                                                    if($type == "cs"){
                                                        $("#cheque_div_"+id).hide();
                                                        $("#bank_div_"+id).hide();
                                                    }else{
                                                        $("#cheque_div_"+id).show();
                                                        $("#bank_div_"+id).show();
                                                    }
                                                }
                                                function total() {
                                                    var $total = 0;
<?php foreach ($d_amount as $amout) { ?>

                                                        var $amount_<?php echo $amout->id ?> = $('#amount_<?php echo $amout->id ?>').val();
                                                        $total = parseFloat($amount_<?php echo $amout->id ?>) + $total;
<?php } ?>

                                                    $("#total_amount").val($total.toFixed(2));
                                                }
<?php foreach ($d_amount as $amout) { ?>

                                                    function show_hide_<?php echo $amout->id ?>() {
                                                        alert("1");
                                                    }
<?php } ?>

                                                $(document).ready(function () {

                                                    if ($('#deposited_by').val() == 'c') {
                                                        $('#Cheque_Number').show();
                                                    } else {
                                                        $('#Cheque_Number').hide();
                                                    }



                                                    $("#deposit_amount").blur(function () {
                                                        var deposit_amount = $("#deposit_amount").val();
                                                        if (deposit_amount == "") {
                                                            $("#deposit_amount_error").html("Deposit Amount is required.");
                                                        } else {
                                                            $("#deposit_amount_error").html('');
                                                        }
                                                    }
                                                    );

                                                    $("#withdraw_amount").blur(function () {
                                                        var withdraw_amount = $("#withdraw_amount").val();
                                                        if (withdraw_amount == "") {
                                                            $("#withdraw_amount_error").html("Withdraw Amount is required.");
                                                        } else {
                                                            $("#withdraw_amount_error").html('');
                                                        }
                                                    }
                                                    );

                                                    $("#deposited_by").blur(function () {
                                                        var deposited_by = $("#deposited_by").val();
                                                        if (deposited_by == "") {
                                                            $(deposited_by_error).html("Deposited by is required.");
                                                        } else {
                                                            $("#deposited_by_error").html('');
                                                        }
                                                    }
                                                    );

                                                    $("#cheque").blur(function () {
                                                        var chq = $("#cheque").val();
                                                        if (chq == "") {
                                                            $("#chequeerror").html("Cheque Number is required.");
                                                        } else {
                                                            $("#chequeerror").html('');
                                                        }
                                                    }
                                                    );


                                                });
                                                function validate() {
                                                   // var deposit_amount = document.forms["savingdata"]["deposit_amount"].value;
                                                    var withdraw_amount = document.forms["savingdata"]["withdraw_amount"].value;
                                                    var deposited_by = document.forms["savingdata"]["deposited_by"].value;
                                                    var cheque = document.forms["savingdata"]["cheque"].value;
                                                    var temp = 0;
                                                    if (deposit_amount == "") {
                                                        $("#deposit_amount_error").html("Deposit Amount is required.");
                                                        temp++;
                                                    }
                                                    if (withdraw_amount == "") {
                                                        $("#withdraw_amount_error").html("Withdraw Amount is required.");
                                                        temp++;
                                                    }
                                                    if (deposited_by == "") {
                                                        $(deposited_by_error).html("Deposited by is required.");
                                                        temp++;
                                                    }
                                                    if (deposited_by == 'c') {
                                                        if (cheque == "") {
                                                            $("#chequeerror").html("Cheque Number is required.");
                                                            temp++;
                                                        }
                                                    }



                                                    if (temp != 0) {
                                                        return false;
                                                    }
                                                }
</script>
