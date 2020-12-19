

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
            <h3 class="blank1" style="margin-top: -20px;">Last Day Entry </h3>
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
        $name = $expense[0]->UserFName;
        ?>
        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>daily_reports_new/last_day_entry?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&location=<?php echo $location; ?>&id=<?php echo $lastday->id; ?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
            <div class="md tabls">
                <div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="control-label"><b>Personal Debit</b></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="debit" id="debit" placeholder="Debit" value="<?php echo $lastday->debit; ?>" />
                            <div class="invalid-feedback" id="debit_error" style="color: red;"></div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12" style="padding-top: 24px;">
                        <div class="col-md-3">
                            <label class="control-label"><b>Personal Credit</b></label>
                        </div>	<div class="col-md-6">
                            <input type="text" class="form-control" name="credit" id="credit" placeholder="Credit" value="<?php echo $lastday->credit; ?>" />
                            <div class="invalid-feedback" id="credit_error" style="color: red;"></div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12" style="padding-top: 24px;">
                        <div class="col-md-3">
                            <label class="control-label"><b>Budget</b></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="budget" id="budget" placeholder="Budget" value="<?php echo $lastday->budget; ?>" />
                            <div class="invalid-feedback" id="budget_error" style="color: red;"></div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12" style="padding-top: 24px;">
                        <div class="col-md-3">
                            <label class="control-label"><b>Rewards Card Balance (Company)</b></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="ioc" id="ioc" placeholder="Rewards Card Balance (Company)" value="<?php echo $lastday->ioc_amount; ?>" />
                            <div class="invalid-feedback" id="ioc_error" style="color: red;"></div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12" style="padding-top: 24px;">
                        <div class="col-md-3">
                            <label class="control-label"><b>Cash On Hand</b></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cash_on_hand" id="cash_on_hand" placeholder="Cash On Hand" value="<?php echo $lastday->cash_on_hand; ?>" />
                            <div class="invalid-feedback" id="cash_on_hand_error" style="color: red;"></div>
                        </div>
                    </div>	
                    <div class="col-md-12" style="padding-top: 24px;">
                        <div class="col-md-3">
                            <label class="control-label"><b>Salary</b></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" value="<?php echo $lastday->l_salary; ?>" />
                            <div class="invalid-feedback" id="salary_error" style="color: red;"></div>
                        </div>
                    </div>	
                    <div class="col-md-12" style="padding-top: 24px;">
                        <div class="col-md-3">
                            <label class="control-label"><b>Company discount</b></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="company_discount" id="company_discount" placeholder="Company discount" value="<?php echo $lastday->company_discount; ?>" />
                            <div class="invalid-feedback" id="company_discount_error" style="color: red;"></div>
                        </div>
                    </div>	
                    <div class="col-md-12" style="padding-top: 24px;">
                        <div class="col-md-3">
                            <label class="control-label"><b>Company Charge</b></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="company_charge" id="company_charge" placeholder="Company Charge" value="<?php echo $lastday->company_charge; ?>" />
                            <div class="invalid-feedback" id="company_charge_error" style="color: red;"></div>
                        </div>
                    </div>	
                    <br>
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

    $(document).ready(function () {

        $("#debit").blur(function () {
            var loc = $("#debit").val();
            if (loc == "") {
                $("#debit_error").html("Debit is required.");
            }
            else {
                $("#debit_error").html('');
            }
        }
        );

        $("#credit").blur(function () {
            var credit = $("#credit").val();
            if (credit == "") {
                $("#credit_error").html("Credit is required.");
            }
            else {
                $("#credit_error").html('');
            }
        }
        );

        $("#budget").blur(function () {
            var budget = $("#budget").val();
            if (budget == "") {
                $("#budget_error").html("Budget is required.");
            }
            else {
                $("#budget_error").html('');
            }
        }
        );
        $("#cash_on_hand").blur(function () {
            var cash_on_hand = $("#cash_on_hand").val();
            if (cash_on_hand == "") {
                $("#cash_on_hand_error").html("Cash on hand is required.");
            }
            else {
                $("#cash_on_hand_error").html('');
            }
        });
//        $("#salary").blur(function () {
//            var salary = $("#salary").val();
//            if (salary == "") {
//                $("#salary_error").html("Salary  is required.");
//            }
//            else {
//                $("#salary_error").html('');
//            }
//        });
//        $("#company_discount").blur(function () {
//            var company_discount = $("#company_discount").val();
//            if (company_discount == "") {
//                $("#company_discount_error").html("Company discount is required.");
//            }
//            else {
//                $("#company_discount_error").html('');
//            }
//        });
//        $("#company_charge").blur(function () {
//            var cash_on_hand = $("#company_charge").val();
//            if (cash_on_hand == "") {
//                $("#company_charge_error").html("Company charge is required.");
//            }
//            else {
//                $("#company_charge_error").html('');
//            }
//        }
//        );

    });
    function validate() {
        var debit = document.forms["savingdata"]["debit"].value;
        var credit = document.forms["savingdata"]["credit"].value;
        var budget = document.forms["savingdata"]["budget"].value;
        var cash_on_hand = document.forms["savingdata"]["cash_on_hand"].value;
//        var salary = document.forms["savingdata"]["salary"].value;
//        var company_discount = document.forms["savingdata"]["company_discount"].value;
//        var company_charge = document.forms["savingdata"]["company_charge"].value;

        var temp = 0;
        if (debit == "") {
            $("#debit_error").html("Debit is required.");
            temp++;
        }
//        if (company_discount == "") {
//            $("#company_discount_error").html("Company discount is required.");
//            temp++;
//        }
//        if (company_charge == "") {
//            $("#company_charge_error").html("Company charge is required.");
//            temp++;
//        }
//        if (salary == "") {
//            $("#salary_error").html("Salary is required.");
//            temp++;
//        }
        if (credit == "") {
            $("#credit_error").html("Credit is required.");
            temp++;
        }
        if (budget == "") {
            $("#budget_error").html("Budget is required.");
            temp++;
        }
        if (cash_on_hand == "") {
            $("#cash_on_hand_error").html("Cash on hand is required.");
            temp++;
        }
        if (temp != 0) {
            return false;
        }
    }
</script>