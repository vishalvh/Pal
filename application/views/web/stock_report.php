<?php $this->load->view('web/left'); ?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/css/jquery.mCustomScrollbar.min.css" type='text/css' />
<style>
    .title-h1 {
        display: inline-block;
        width: 100%;
    }

    .title-h1 h3 {
        margin: 0;
        padding: 15px 0;
        color: #27cce4;
        padding-top: 0;
    }


    .bdr .table tr>th,
    .bdr td,
    .bdr th {
        border: 1px solid #eee !important;
    }
</style>

<script type='text/javascript'>
    $(document).ready(function () {
        $("#start_date").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "2017:n",
            maxDate:new Date(),
            onSelect: function () {
                var end_date = $('#end_date');

                var minDate = $(this).datepicker('getDate');

                end_date.datepicker('option', 'minDate', minDate);
            }
        });
        $('#end_date').datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
			yearRange: "2017:n",
            maxDate:new Date(),
        });
    });
</script>
<style>
    .dataTables_filter {
        display: none;
    }
</style>
<!-- left side start-->

<!-- left side end-->

<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">

        <form method="post" action="<?php echo base_url(); ?>admin/add">			
            <h3 class="blank1" style="margin-top: -20px;">Stock Patrak</h3>

        </form>

        <h3 class="blank1"></h3>
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

        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="get" action="" name="savingdata" >

                    <div class="form-group col-sm-12">
                        <hr>
                        <div class="col-md-2">
                            <input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php echo date("d-m-Y", strtotime($sdate)); ?>" />
                            <span class="error" id="sdateerror"></span>
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="<?php echo date("d-m-Y", strtotime($edate)); ?>" />
                            <span class="error" id="edateerror"></span>
                        </div>
                        <div class="col-sm-2">
                            <select name="location" id="location" class="form-control1">
                                <option value="">Select Location</option>
                                <?php
                                foreach ($location_list->result() as $row) {
                                    ?>
                                    <option value="<?php echo $row->l_id; ?>" <?php if ($location == $row->l_id) {
                                    echo "selected";
                                } ?>><?php echo $row->l_name ?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                            <div class="invalid-feedback" id="locationerror" style="color: red;"></div>
                        </div>
                        <div class="col-sm-2">
                            <select name="fueltype" id="fueltype" class="form-control1">
                                <option value="">Select Fuel</option>
                                <option value="d" <?php if($fueltype == "d"){ echo "selected"; }?>>Diesel</option>
								<option value="p" <?php if($fueltype == "p"){ echo "selected"; }?>>Petrol</option>
							</select>
                            <div class="invalid-feedback" id="fueltypeerror" style="color: red;"></div>
                        </div>
                        <div class="col-sm-2">
                            <!--<input type="submit" name="search" class="btn-success btn" value="Search" name="search">-->
                            <button class="btn btn-primary" onClick="return SubmitForm();" type="submit" >Search</button>
							<?php if(in_array("stock_patrak_report_print",$this->data['user_permission_list'])){ ?>
                            <button class="btn btn-primary" formtarget="_blank"  onClick="return Submitdata();" type="submit" <?php if($fueltype == "" || $location == ""){ echo "Disabled"; }?>>Print</button>
							<?php } ?>
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <hr>
                    </div>
                </form>
            </div>
        </div>


        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="title-h1">
                    <h3>Report</h3>
                </div>
                <div class="over-scroll js-scroll bdr">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="12.5%">Date</th>
                                <th width="12.5%">Opening <?php if($fueltype == "p"){ echo "Petrol"; }
								  if($fueltype == "d"){ echo "Diesel"; } ?> Stock</th>
                                <th width="12.5%">Purchase Quantity</th>
								<th width="12.5%">Total</th>
                                <th width="12.5%">Selling</th>
                                <!--<th width="12.5%">Testing</th>-->
                                <th width="12.5%">Sort</th>
                                <th width="12.5%">Closing</th>
                                <th width="12.5%">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							$p_d_total_selling = 0;
							$p_d_quantity = 0;
							$p_p_total_selling = 0;
							$p_p_quantity = 0;
							$p_sort = 0; 
							$d_sort = 0;
                            $cnt=0;
                            foreach($report as $r){
                                if((strtotime($sdate) <= strtotime($r['date'])) && $cnt == 0){
                                    $cnt++;
                                }
                                if($cnt == 0){
                                    
                                }else{
                                ?>
                            <tr>
                                <td><?php echo date("d-m-Y",strtotime($r['date'])); ?></td>
                                <td><?php if($fueltype == "p"){ echo $stock = amountfun($r['p_opening_original_stock']); }
                                          if($fueltype == "d"){ echo $stock = amountfun($r['d_opening_original_stock']); } ?></td>
                                <td><?php if($fueltype == "p"){ echo amountfun($r['p_quantity']); }
                                          if($fueltype == "d"){ echo amountfun($r['d_quantity']); }
                                ?></td>
								<td><?php if($fueltype == "p" ){ echo amountfun($r['p_quantity']+$r['p_opening_original_stock']); }
                                          if($fueltype == "d" ){ echo amountfun($r['d_quantity']+$r['d_opening_original_stock']); }
                                ?></td>
                                <td><?php if($fueltype == "p"){ echo amountfun($r['p_total_selling']); }
                                          if($fueltype == "d"){ echo amountfun($r['d_total_selling']); } ?></td>
                                <td><?php if($fueltype == "p"){ echo amountfun($r['pshort']);  }
                                          if($fueltype == "d"){ echo amountfun($r['dshort']);  } ?></td>
                                <td><?php if($fueltype == "p"){ echo amountfun($r['p_closing_original_stock']);  }
                                          if($fueltype == "d"){ echo amountfun($r['d_closing_original_stock']);  } ?>
                                </td>
                                <td>
                                <?php if($fueltype == "p"){ 
                                    echo amountfun($r['pet_price']); 
                                }
                                      if($fueltype == "d"){ 
                                    echo amountfun($r['dis_price']); 
                                } ?>
                                </td>
                            </tr>
                            <?php
$p_d_total_selling = $p_d_total_selling + $r['d_total_selling'];
$p_d_quantity = $p_d_quantity + $r['d_quantity'];
$p_p_total_selling = $p_p_total_selling + $r['p_total_selling'];
$p_p_quantity = $p_p_quantity + $r['p_quantity'];
$p_sort = $p_sort + $r['pshort'];
$d_sort = $d_sort + $r['dshort'];

$cnt++;
								}}?>
								<tr>
								<td>Total</td>
								<td></td>
								<td>
								<?php if($fueltype == "p"){ 
									echo amountfun($p_p_quantity);
								}else{
									echo amountfun($p_d_quantity); 
								}?></td>
								<td></td>
								<td>
								<?php if($fueltype == "p"){ 
									echo amountfun($p_p_total_selling);
								}else{
									echo amountfun($p_d_total_selling);
								}?>
								</td>
								<td>
								<?php if($fueltype == "p"){ 
									echo amountfun($p_sort);
								}else{
									echo amountfun($d_sort);
								}?>
								</td>
								<td>
								<?php //echo $dev; ?>
								</td>
								<td colspan="2">
								</td>
								</tr>
                        </tbody>
                    </table>
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
<script src="<?php echo base_url(); ?>assets1/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
    (function ($) {
        $(window).on("load", function () {
            $(".bdr").mCustomScrollbar({
                axis: "x",
                advanced: {
                    autoExpandHorizontalScroll: true
                }
            });
        });
    })(jQuery);

    function Submitdata()
    {
        var $start_date =    $("#start_date").val();
     var $end_date =    $("#end_date").val();
     var location =    $("#location").val();
     var fueltype =    $("#fueltype").val();
     var $i = 0;
     
     if($start_date == ""){
      $("#sdateerror").html(" Required!");
      $i++;
     }
     if($end_date == ""){
      $("#edateerror").html(" Required!");
      $i++;
     }
     if(location == ""){
      $("#locationerror").html(" Required!");
      $i++;
     }
     if(fueltype == ""){
      $("#fueltypeerror").html(" Required!");
      $i++;
     }
     
     if($i != 0){
         return false;
         die();
     }
        document.forms['savingdata'].action = '<?php echo base_url(); ?>stock_patrak/print_pdf';
        document.forms['savingdata'].submit();

    }
    function SubmitForm()
    {
     var $start_date =    $("#start_date").val();
     var $end_date =    $("#end_date").val();
     var location =    $("#location").val();
     var fueltype =    $("#fueltype").val();
     var $i = 0;
  
        if($start_date == ""){
      $("#sdateerror").html(" Required!");
      $i++;
     }
     if($end_date == ""){
      $("#edateerror").html(" Required!");
      $i++;
     }
     if(location == ""){
      $("#locationerror").html(" Required!");
      $i++;
     }
     if(fueltype == ""){
      $("#fueltypeerror").html(" Required!");
      $i++;
     }
   //alert($i);
     if($i != 0){
         return false;
//         alert();
            die();
         
     }else{
        document.forms['savingdata'].action = '<?php echo base_url(); ?>stock_patrak/index';
        document.forms['savingdata'].submit();
    }

    }
    var target = 'http://stackoverflow.com';
    $.ajax({
        url: "https://api.linkpreview.net",
        dataType: 'jsonp',
        data: {q: target, key: '5b7a690849f50a7e969da8871cf7bfd1ba51828b82361'},
        success: function (response) {
            console.log(response);
        }
    });
</script>

</body>

</html>