<?php $this->load->view('web/left');?>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets1/css/jquery.mCustomScrollbar.min.css" type='text/css' />
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
        <!-- main content start-->
<div class="main-content">
            <!-- header-starts -->
	<?php $this->load->view('web/header');?>
            <!-- //header-ends -->
		<div id="page-wrapper">
			<div class="page-header">
				<h3 class="blank1 pull-left" style="">Density record report</h3>
			</div>
            <form method="get" action="<?php echo base_url();?>company_daily_density_report" id="pdffrom">			
				<div class="cal-md-12">
					<div class="col-md-2">
						<input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php echo $this->input->get('sdate'); ?>" />
						<span class="error" id="sdateerror"></span>
					</div>
					<div class="col-md-2">
                            <input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="<?php echo $this->input->get('edate'); ?>" />
                            <span class="error" id="edateerror"></span>
                        </div>
					<div class="col-sm-2">
                            <select name="location" id="location" class="form-control1"  onchange="gettanklist()">
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
                            <select name="type" id="type" class="form-control1" onchange="gettanklist()">
                                <option value="p" <?=($type == 'p')?'selected':''?>>Petrol</option>
                                <option value="d" <?=($type == 'd')?'selected':''?>>Diesel</option>
                                
                            </select>
                            <div class="invalid-feedback" id="locationerror" style="color: red;"></div>
                        </div>
						<div class="col-sm-2">
                            <select name="tank" id="tank" class="form-control1" >
							<option value="">Tank</select>
                            </select>
                            <div class="invalid-feedback" id="locationerror" style="color: red;"></div>
                        </div>
					<input type="submit"  class="btn btn-primary"  value="Preview">
					<?php if(in_array("company_daily_maintain_print",$this->data['user_permission_list'])){ ?>
					<a href="<?php base_url();?>company_daily_density_report/print_pdf?location_id=<?php echo $location?>&sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&type=<?php echo $type; ?>&tank=<?php echo $tank; ?>"  class="btn btn-primary" target="_blank">Print</a>
					<?php } ?>
				</div>
			</form>
			<div class="xs tabls">
				<div class="bs-example4" data-example-id="contextual-table">
					<div class="title-h1">
						<h3>Report</h3>
					</div>
					<div class="over-scroll bdr">
					<table class="table">
					<thead>
					<tr>
					<th>Date</th>
					<th colspan="3"><center>Observed Morning Density</center></th>
					<th colspan="4"><center>Receipt Tank Truck</center></th>
					<th colspan="4"><center>Density At 15 c After Decanting TT And After Dispensing 50 LTS. Of Product</center></th>
					<th rowspan="2">Action</th>
					</tr>
					<tr>
					<th>Date</th>
					<th>Hydro Reading</th>
					<th>Temp</th>
					<th>Converted</th>
					<th>Challan No</th>
					<th>Quantity</th>
					<th>Density Per Challan</th>
					<th>Observed Density In Tank Truck</th>
					<th>Hydrometer Reading</th>
					<th>Temp</th>
					<th>Converted</th>
					<th>User Name</th>
					</tr>
					</thead>
					<body>
					<?
							$cnt=0;
							foreach($reports as $detail){ ?>
					<tr>
					<td><?php echo date('d-m-Y',strtotime($detail->date)); ?></td>
					<td><?php echo $detail->hydro_reading; ?></td>
					<td><?php echo $detail->temp; ?></td>
					<td><?php echo $detail->density; ?></td>
					
					<td><?php
					echo $detail->inventoryData->invoice_no; 
					?></td>
					<td><?php if($type == 'p'){
						echo $detail->inventoryData->p_quantity; 
					}else{
						echo $detail->inventoryData->d_quantity;
					}?></td>
					<td><?php if($type == 'p'){
						echo $detail->inventoryData->p_invoice_density; 
					}else{
						echo $detail->inventoryData->d_invoice_density;
					}?></td>
					<td><?php if($type == 'p'){
						echo $detail->inventoryData->p_observer_density; 
					}else{
						echo $detail->inventoryData->d_observer_density;
					}?></td>
					<td><?php if($type == 'p'){
						echo $detail->daily_density->p_decant_hydro_reading; 
					}else{
						echo $detail->daily_density->d_decant_hydro_reading;
					}?></td>
					<td><?php if($type == 'p'){
						echo $detail->daily_density->p_decant_temp; 
					}else{
						echo $detail->daily_density->d_decant_temp;
					}?>
					</td>
					<td><?php if($type == 'p'){
						echo $detail->daily_density->p_decant_density; 
					}else{
						echo $detail->daily_density->d_decant_density;
					}?></td>
					<td><?php echo $detail->inventoryData->UserFName.' '.$detail->inventoryData->UserLName; ?></td>
					<td>
					<a href='<?php echo base_url(); ?>company_daily_density_report/edit?date=<?php echo $detail->date; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&location=<?php echo $this->input->get('location'); ?>&type=<?php echo $this->input->get('type'); ?>&tank=<?php echo $this->input->get('tank'); ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
					</td>
					</tr>
							<?php } ?>
					</tbody>
					</table>
					<?php /* ?>
						<table class="table">
							<thead>
								<tr>
									<th>Date.</th>
									<th>Petrol Morning Hydro Reading</th>
									<th>Petrol Morning Temp</th>
									<th>Petrol Morning Density</th>
									<th>Petrol Decant Hydro Reading</th>
									<th>Petrol Decant Temp</th>
									<th>Petrol Decant Density</th>
									<th>Diesel Morning Hydro Reading</th>
									<th>Diesel Morning Temp</th>
									<th>Diesel Morning Density</th>
									<th>Diesel Decant Hydro Reading</th>
									<th>Diesel Decant Temp</th>
									<th>Diesel Decant Density</th>
								</tr>
							</thead>
							<tbody>
							<?
							$cnt=0;
							foreach($reports as $detail){ ?>
								<tr>
									<td><?php echo date('d/m/Y',strtotime($detail->date)); ?></td>
									<td><?php echo $detail->p_morning_hydro_reading; ?></td>
									<td><?php echo $detail->p_morning_temp; ?></td>
									<td><?php echo $detail->p_morning_density; ?></td>
									<td><?php echo $detail->p_decant_hydro_reading; ?></td>
									<td><?php echo $detail->p_decant_temp; ?></td>
									<td><?php echo $detail->p_decant_density; ?></td>
									<td><?php echo $detail->d_morning_hydro_reading; ?></td>
									<td><?php echo $detail->d_morning_temp; ?></td>
									<td><?php echo $detail->d_morning_density; ?></td>
									<td><?php echo $detail->d_decant_hydro_reading; ?></td>
									<td><?php echo $detail->d_decant_temp; ?></td>
									<td><?php echo $detail->d_decant_density; ?></td>
								</tr>
							<?php }
							?>
							</tbody>
						</table>
						<?php */ ?>
					</div>
				</div>
			</div>
			<!-- switches -->
		</div>
	</div>
</div>
<script>
function gettanklist(){
	$location = $("#location").val();
	$type = $("#type").val();
	get_tanks($location,$type);
}
function get_tanks(location,type){
	if(type == "Diesel"){ type = 'd'; }
	if(type == "Petrol"){ type = 'p'; }
	$("#tank").html('<option value="">Select Tank</option> ');
	var tank = "<?php echo $tank; ?>";
	if(location != "" && type != ""){
	$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>/admin_pump/tank_list",
				data: {"lid": location,"type":type,"tank":tank}, // serializes the form's elements.
				success: function (data)
				{
					$("#tank").html(data);
				}
			});
	}
}
</script>
<?php $this->load->view('web/footer');?>
</section>
<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets1/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
$(document).ready(function () {
   $("#start_date").datepicker({
	   dateFormat: "dd-mm-yy",
		changeMonth: true,
	  changeYear: true,
	   yearRange: "2018:n",
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
            maxDate:new Date(),
        });
});
</script>
</body>
</html>
<?php if($location != "" &&  $type != ""){ ?>
<script>
get_tanks('<?=$location?>','<?=$type?>');
</script>
<?php } ?>