<?php $this->load->view('web/left');?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
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

        .over-scroll,
        .bdr {
            display: inline-block;
            width: 100%;
            overflow-x: scroll;
        }

        .bdr .table tr>th,
        .bdr td,
        .bdr th {
            border: 1px solid #eee !important;
        }
    </style>
  
<script type='text/javascript'>
    $(document).ready(function() {
        $("#start_date").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "2017:n",
maxDate:new Date(),
            onSelect: function() {
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
        <div class="main-content">
            <!-- header-starts -->
            <?php $this->load->view('web/header');?>
            <!-- //header-ends -->
            <div id="page-wrapper">
                <div class="page-header">
                    <h3 class="blank1 pull-left" style="">DSR Report</h3>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="horizontal-form">
                        <form class="form-horizontal" method="get" action="<?php echo base_url();?>MS_DSH_sales_reports/index" name="savingdata" onsubmit="return validate()">

                            <div class="form-group col-sm-12">
                                <hr>
								<div class="col-md-2">
									<input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php  echo date("d-m-Y",strtotime($sdate)); ?>" />
									<span class="error" id="sdateerror"></span>
								</div>
								<div class="col-md-2">
									<input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="<?php  echo date("d-m-Y",strtotime($edate)); ?>" />
									<span class="error" id="edateerror"></span>
								</div>
                                <div class="col-sm-2">
                                    <select name="location" id="location" class="form-control1">
											<option value="">Select Location</option>
											<?php 

												foreach ($location_list->result() as $row) {
													?>
														<option value="<?php echo $row->l_id; ?>" <?php if($location == $row->l_id){ echo "selected"; }?>><?php echo $row->l_name?></option>
													<?php
												}
											?>
											</select>
                                    <div class="invalid-feedback" id="locationerror" style="color: red;"></div>
                                </div>
                                
                                <div class="col-sm-2">
									<select name="fueltype" id="fueltype" class="form-control1">
                                <option value="">Select Fuel</option>
                                <option value="d" <?php if($type=='d'){ echo "selected"; } ?>>Diesel</option>
								<option value="p" <?php if($type=='p'){ echo "selected"; } ?>>Petrol</option>
							</select>
                                </div>
								<div class="col-sm-2">
                                    <input type="submit" name="search"  class="btn-success btn" value="Search" name="search">
									<?php if($stock_list){ ?>
									<?php if(in_array("dsr_report_print",$this->data['user_permission_list'])){ ?>
									<a href="<?php echo base_url(); ?>MS_DSH_sales_reports/print_pdf?fueltype=<?php echo $type;?>&location=<?php echo $location; ?>&edate=<?php  echo date("d-m-Y",strtotime($edate)); ?>&sdate=<?php  echo date("d-m-Y",strtotime($sdate)); ?>" class="btn btn-primary" target="_blank"  >Print</a>
									<?php } } ?>
                                </div>
								<div class="col-sm-2">
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
                        <div class="over-scroll bdr">
						<?php if($stock_list){ ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
										<?php foreach ($tank_list as $locationtank) {
											if ($locationtank->fuel_type == $type) { ?>
												<th><?php echo $locationtank->tank_name; ?> Dip</th>
												<th>Water Dip</th>
											<?php }
										} ?>
                                        <th>OPENING STOCK</th>
                                        <th>RECEIPT</th>
                                        <th>TOTAL STOCK</th>
										<?php foreach ($pump_list as $locationtank) {
											if ($locationtank->type == $type) { ?>
												<th><?php echo $locationtank->name; ?></th>
											<?php }
										} ?>
										<th>Testing</th>
										<th>SALES</th>
										<th>CUMULATIVE SALES</th>
                                    </tr>
                                </thead>
								
                                <tbody>
								<?php foreach($stock_list as $stock){ ?>
								<tr>
                                        <td><?php echo date('d-m-Y',strtotime($stock->DATE)); ?></td>
										<?php foreach ($tank_list as $locationtank) {
											if ($locationtank->fuel_type == $type) { ?>
												<td><?php echo amountfun($finaltank[$stock->DATE][$type][$locationtank->id]); ?></td>
												<td>0</td>
											<?php }
										} ?>
                                        <td><?php if($type=='d'){ $openingstock = $stock->d_tank_reading; } else{ $openingstock = $stock->p_tank_reading; } echo amountfun($openingstock);  ?></td>
                                        <td>
										<?php
											echo amountfun($purches_stock_list[$stock->DATE][$type]);
										?>
										</td>
                                        <td><?php echo amountfun($openingstock+$purches_stock_list[$stock->DATE][$type]); ?></td>
										<?php foreach ($pump_list as $locationtank) {
											if ($locationtank->type == $type) { ?>
												<td><?php echo amountfun($reading_data[$stock->DATE][$locationtank->id]); ?></td>
											<?php }
										} ?>
										<td><?php if($type=='d'){ $testing = $stock->d_testing; } else{ $testing = $stock->p_testing; } echo amountfun($testing); ?></td>
										<td><?php if($type=='d'){ $saleing = $stock->d_total_selling; } else{ $saleing = $stock->p_total_selling; } echo amountfun($saleing); $totalsaleing = $saleing + $totalsaleing; ?></td>
										<td><?php echo amountfun($totalsaleing); ?></td>
                                    </tr>
								<?php } ?>
                                </tbody>
                            </table>
						<?php } ?>
                        </div>
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
<script>
function Submitdata()
{
	document.forms['savingdata'].action = '<?php echo base_url(); ?>MS_DSH_sales_reports/print_pdf';
	document.forms['savingdata'].submit();
}
	function validate(){
	 $(".error").html("");
		var $fdate = $('#start_date').val();
		var $tdate = $('#end_date').val();
		var $location = $('#location').val();	
		var temp = 0;
		if($fdate == ""){
			temp++;
			$("#sdateerror").html('Required!');
		}
		if($tdate == ""){
			temp++;
			$("#edateerror").html('Required!');
		}
		if($location == ""){
			temp++;
			$("#locationerror").html('Required!');
		}
		if(temp !=0 ){
			return false
		}
    
 }
	</script>