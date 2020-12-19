<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->




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
            <h3 class="blank1" style="margin-top: -20px;">Salary Details Edit</h3>

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
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>worker_salary/worker_salary_edit?id=<?php echo $id; ?>&sdate=<?php echo $this->input->get("sdate");?>&edate=<?php echo $this->input->get("edate");?>&l_id=<?php echo $this->input->get("l_id");?>&worker_id=<?php echo $this->input->get("worker_id");?>" name="savingdata" onsubmit="return validate()">
                <div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
                    <div class="col-md-12" style="margin-top: 15px;">
                        <div class="col-md-2">
                            <label class="control-label"><b>Paid Salary Amount</b></label>
                        </div>
                        <div class="col-sm-4">
                            <input  id="salary" type="text" class="form-control1 "  placeholder="Salary Amount" name="amount" value="<?php echo $salary_details[0]->amount; ?>">

                            <?php echo form_error('amount', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                            <div class="invalid-feedback" id="salary_error" style="color: red;"></div>

                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px;">
                        <div class="col-md-2">
                            <label class="control-label"><b>Loan Amount</b></label>
                        </div>
                        <div class="col-sm-4">
                            <input  id="loan_amount" type="text" class="form-control1 "  placeholder="Loan Amount" name="loan_amount" value="<?php echo $salary_details[0]->loan_amount; ?>">

                            <?php echo form_error('loan_amount', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                            <div class="invalid-feedback" id="loan_amount_error" style="color: red;"></div>

                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px;">
                        <div class="col-md-2">
                            <label class="control-label"><b>Paid Loan Amount</b></label>
                        </div>
                        <div class="col-sm-4">
                            <input  id="paid_loan_amount" type="text" class="form-control1 "  placeholder="Paid Loan Amount" name="paid_loan_amount" value="<?php echo $salary_details[0]->paid_loan_amount; ?>">

                            <?php echo form_error('withdraw_amount', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                            <div class="invalid-feedback" id="paid_loan_amount_error" style="color: red;"></div>

                        </div>
                    </div>
                     <div class="col-md-12" style="margin-top: 15px;">
                        <div class="col-md-2">
                            <label class="control-label"><b>Extra Amount</b></label>
                        </div>
                        <div class="col-sm-4">
                            <input  id="extra_amount" type="text" class="form-control1 "  placeholder="Bonus Amount" name="extra_amount" value="<?php echo $salary_details[0]->extra_amount; ?>">

                            <?php echo form_error('withdraw_amount', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                            <div class="invalid-feedback" id="extra_amount_error" style="color: red;"></div>

                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px;">
                        <div class="col-md-2">
                            <label class="control-label"><b>Bonus Amount</b></label>
                        </div>
                        <div class="col-sm-4">
                            <input  id="bonas_amount" type="text" class="form-control1 "  placeholder="Bonus Amount" name="bonas_amount" value="<?php echo $salary_details[0]->bonas_amount; ?>">

                            <?php echo form_error('withdraw_amount', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                            <div class="invalid-feedback" id="bonas_amount_error" style="color: red;"></div>

                        </div>
                    </div>


                    <br>
                    <div>


                    </div>
                    <div class="form-group" class="col-md-12" style="
                         padding-top:  10px;
                         padding-right: 15px;
                         " >
                        <br>
                        <div class="col-sm-8 col-sm-offset-2" style="
                             padding-top:  10px;
                             padding-right: 15px;
                             ">
                            <button style="
                                    padding-top:  10px;
                                    padding-right: 15px;
                                    " class="btn-success btn" type="submit" name="submit">Update</button>
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

               

                $(document).ready(function () {

                    if ($('#deposited_by').val() == 'c') {
                        $('#Cheque_Number').show();
                    } else {
                        $('#Cheque_Number').hide();
                    }



                    $("#salary").blur(function () {
                        var salary = $("#salary").val();
                        if (salary == "") {
                            $("#salary_error").html("Salary Amount is required.");
                        } else {
                            $("#salary_error").html('');
                        }
                    }
                    );

                    $("#extra_amount").blur(function () {
                        var extra_amount = $("#extra_amount").val();
                        if (extra_amount == "") {
                            $("#extra_amount_error").html("Extra Amount is required.");
                        } else {
                            $("#extra_amount_error").html('');
                        }
                    }
                    );
              $("#loan_amount").blur(function () {
                        var loan_amount = $("#loan_amount").val();
                        if (loan_amount == "") {
                            $("#loan_amount_error").html("Loan Amount is required.");
                        } else {
                            $("#loan_amount_error").html('');
                        }
                    }
                    );

                    $("#paid_loan_amount").blur(function () {
                        var paid_loan_amount = $("#paid_loan_amount").val();
                        if (paid_loan_amount == "") {
                            $("#paid_loan_amount_error").html("Paid Loan Amount is required.");
                        } else {
                            $("#paid_loan_amount_error").html('');
                        }
                    }
                    );

                    $("#bonas_amount").blur(function () {
                        var bonas_amount = $("#bonas_amount").val();
                        if (bonas_amount == "") {
                            $("#bonas_amount_error").html("Bonas amount  is required.");
                        } else {
                            $("#bonas_amount_error").html('');
                        }
                    }
                    );


                });
                function validate() {
                    var salary = document.forms["savingdata"]["salary"].value;
                    var loan_amount = document.forms["savingdata"]["loan_amount"].value;
                    var extra_amount = document.forms["savingdata"]["extra_amount"].value;
                    var paid_loan_amount = document.forms["savingdata"]["paid_loan_amount"].value;
                    var bonas_amount = document.forms["savingdata"]["bonas_amount"].value;
                    var temp = 0;
                    if (salary == "") {
                        $("#salary_error").html("Salary Amount is required.");
                        temp++;
                    }
                    if (loan_amount == "") {
                    $("#loan_amount_error").html("Loan Amount is required.");
                        temp++;
                    }
                    if (extra_amount == "") {
                         $("#extra_amount_error").html("Extra Amount is required.");
                        temp++;
                    }
                      if (paid_loan_amount == "") {
                       $("#paid_loan_amount_error").html("Paid Loan Amount is required.");
                        temp++;
                    }
                      if (bonas_amount == "") {
                           $("#bonas_amount_error").html("Bonas amount  is required.");
                        temp++;
                    }
                   



                    if (temp != 0) {
                        return false;
                    }
                }
</script>
