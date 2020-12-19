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
<div class="main-content">
    <?php $this->load->view('web/header'); ?>
    <div id="page-wrapper">
        <form method="post" action="<?php echo base_url(); ?>admin/add">			
            <h3 class="blank1" style="margin-top: -20px;">TT retention sample record</h3>
        </form>
        <h3 class="blank1"></h3>
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
                            <select name="location" id="location" class="form-control1" onchange="gettanklist()">
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
                        
                        <div class="col-sm-4">
                            <button class="btn btn-primary" onClick="SubmitForm();" type="submit" >Search</button>
							<?php if(in_array("company_tank_daily_density_report_print",$this->data['user_permission_list'])){ ?>
                            <a href="<?php echo base_url(); ?>company_daily_tank_density_report/print_pdf?sdate=<?php echo date("d-m-Y", strtotime($sdate)); ?>&edate=<?php echo date("d-m-Y", strtotime($edate)); ?>&location=<?php echo $location; ?>&type=<?php echo $type; ?>" class="btn btn-primary" target="_blank"   <?php if ($this->input->get('location') == "") {
                                    echo "Disabled";
                                } ?>>Print</a>
							<?php } ?>
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
                    <h3></h3>
                </div>
                <div class="over-scroll js-scroll bdr">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Challan Quantity</th>
                                <th>Challan No</th>
                                <th>Challan Density</th>
                                <th>Observed Density</th>
                                <th>Quantity Decanted</th>
                                <th>No. of TT Samples Kept</th>
								<?php for($i = 0;$i < $smapleCollectionCount;$i){ ?>
                                <th>Seal Number <?=++$i?></th>
								<?php } ?>
                                <th>User Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($reports as $r) {
								if($r->fuel_type == 'p'){
									$type = 'Petrol';
								}else{
									$type = 'Diesel';
								}
								?>
								<tr>
									<td><?php echo date('d-m-Y',strtotime($r->date)); ?></td>
									<td><?php
									if($type == 'Petrol'){
										echo $r->p_quantity;
									}else{
										echo $r->d_quantity;
									}
									?></td>
									<td><?php echo $r->invoice_no; ?></td>
									<td><?php
									if($type == 'Petrol'){
										echo $inventorydensity = $r->p_invoice_density;
									}else{
										echo $inventorydensity = $r->d_invoice_density;
									}
									?></td>
									<td><?php 
									if($type == 'Petrol'){
									echo $rdensity = $r->p_observer_density;
									}else{
									echo $rdensity = $r->d_observer_density;
									}
									?></td>
									<td><?php if($inventorydensity > 0){ echo amountfun($inventorydensity - $rdensity); } ?></td>
									<td><?php
									if($type == 'Petrol'){
										echo $r->p_vehicle_no;
									}else{
										echo $r->d_vehicle_no;
									}
									?></td>
									<?php for($i = 0;$i < $smapleCollectionCount;$i++){ ?>
									<td><?php 
									
									if(isset($r->sampleData[$i])){
										echo $r->sampleData[$i]->name;
									}
									?></td>
									<?php } ?>
									
									<td><?php echo $r->UserFName.' '.$r->UserLName; ?></td>
									<td><a href="<?php echo base_url();?>company_daily_tank_density_report/update/<?php echo $r->id;?>?date=<?php echo date('d-m-Y',strtotime($r->date)); ?>&sdate=<?php echo date("d-m-Y", strtotime($sdate)); ?>&edate=<?php echo date("d-m-Y", strtotime($edate)); ?>&location=<?php echo $location; ?>&type=<?php echo $r->fuel_type; ?>&tank=<?=$tank?>"><i class="fa fa-edit"></i></a></td>
								</tr>
								<?php } ?>

                        </tbody>
                    </table>
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
<?php $this->load->view('web/footer'); ?>
<!--footer section end-->
<!-- main content end-->
</section>
<script src="<?php echo base_url(); ?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(); ?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets1/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets1/js/jquery.mCustomScrollbar.concat.min.js"></script>
</body>
</html>
<?php if($location != "" &&  $type != ""){ ?>
<script>
get_tanks('<?=$location?>','<?=$type?>');
</script>
<?php } ?>