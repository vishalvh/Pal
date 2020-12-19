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
            <h3 class="blank1" style="margin-top: -20px;">Daily Report</h3>
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
                        <div class="col-sm-4">
                            <button class="btn btn-primary" onClick="SubmitForm();" type="submit" >Search</button>
							<?php if(in_array("daily_report_print",$this->data['user_permission_list'])){ ?>
                            <a href="<?php echo base_url(); ?>daily_reports_new_jun/print_pdf?sdate=<?php echo date("d-m-Y", strtotime($sdate)); ?>&edate=<?php echo date("d-m-Y", strtotime($edate)); ?>&location=<?php echo $location; ?>" class="btn btn-primary" target="_blank"   <?php if ($this->input->get('location') == "") {
                                    echo "Disabled";
                                } ?>>Print</a>
							<?php } ?>
								<?php /* ?><a href="<?php echo base_url(); ?>daily_reports_new_jun/profit_loss_report?sdate=<?php echo date("d-m-Y", strtotime($sdate)); ?>&edate=<?php echo date("d-m-Y", strtotime($edate)); ?>&location=<?php echo $location; ?>" class="btn btn-primary" target="_blank"   <?php if ($this->input->get('location') == "") {
                                    echo "Disabled";
                                } ?>>Profit Loss Report</a><?php */ ?>
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
                <div class="over-scroll js-scroll bdr">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
<?php foreach ($location_tank_list as $locationtank) {
    if ($locationtank->fuel_type == 'd' && $locationtank->xp_type == 'No') { ?>
                                        <th><?php echo $locationtank->tank_name; ?></th>
    <?php }
} ?>
                                <th>Diesel Stock</th>
                                <th>Selling</th>
                                <th>Testing</th>
                                <th>Buy Price</th>
                                <th>Selling Price</th>
                                <th>Expense</th>
                                <th>Pure Benefit</th>
                                <th>Diesel Buy</th>
                                <th>Buy vat</th>
                                <th>Sales vat</th>
                                <th>Eva in diesel</th>
<?php foreach ($location_tank_list as $locationtank) {
    if ($locationtank->fuel_type == 'p' && $locationtank->xp_type == 'No') { ?>
                                        <th><?php echo $locationtank->tank_name; ?></th>
                                    <?php }
                                } ?>
                                <th>Petrol Stock</th>
                                <th>Selling</th>
                                <th>Testing</th>
                                <th>Buy Price</th>
                                <th>Selling Price</th>
                                <th>Pure Benefit</th>
                                <th>Petrol Buy</th>
                                <th>Buy vat</th>
                                <th>Sales vat</th>
                                <th>Eva in Petrol</th>
                                <th>Oil Stock Ltr</th>
                                <th>Oil Amount Stock</th>
                                <th>Oil Buying Amount</th>
                                <th>Oil Selling Amount</th>

                                <th>Oil Pure Benefit</th>
								<th>Oil Buying Ltr</th>
                                <th>Oil Buying GST</th>
                                <th>Oil Selling GST</th>

<?php if($location_detail->xp_type == "Yes" && $location_detail->xpd_type == "Yes" ){ ?>
<?php foreach ($location_tank_list as $locationtank) {
    if ($locationtank->fuel_type == 'd' && $locationtank->xp_type == 'Yes') { ?>
                                        <th><?php echo $locationtank->tank_name; ?></th>
    <?php }
} ?>
								<th>Diesel XP Stock</th>
								<th>XP Selling</th>
                                <th>XP Testing</th>
                                <th>Buy XP Price</th>
                                <th>Selling XP Price</th>
                                <th>XP Diesel Buy</th>
                                <th>XP Buy vat</th>
                                <th>XP Sales vat</th>
                                <th>Eva in XP diesel</th>
                                <th>Benefit</th>
<?php } ?>
<?php if($location_detail->xp_type == "Yes" && $location_detail->xpp_type == "Yes" ){ ?>
<?php foreach ($location_tank_list as $locationtank) {
    if ($locationtank->fuel_type == 'p' && $locationtank->xp_type == 'Yes') { ?>
                                        <th><?php echo $locationtank->tank_name; ?></th>
                                    <?php }
                                } ?>
                                <th>XP Petrol Stock</th>
                                <th>XP Selling</th>
                                <th>XP Testing</th>
                                <th>Buy XP Price</th>
                                <th>Selling XP Price</th>
                                <th>XP Petrol Buy</th>
                                <th>Buy XP vat</th>
                                <th>Sales XP vat</th>
                                <th>Benefit</th>
                                <th>Eva in XP Petrol</th>
<?php } ?>
								
								
                                <th>Cash on hand</th>
                                <th>Sales on Card</th>
                                <th>Sales on Rewards</th>
                                <th>Sales on Wallet</th>
                                <th>Sales on Credit</th>
                                <th>Received From Customer</th>
                                <th>Total Selling</th>
                                <th>Total Collection</th>
                                <th>Total Overshort</th>
                            <?php if(in_array("daily_report_action",$this->data['user_permission_list'])){ ?>    			<th>Action</th> <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tempselling = 0;
                            $dtotaldselling = 0;
                            $xpdtotaldselling = 0;
                            $dtotaldsellingbuyprice = 0;
                            $xpdtotaldsellingbuyprice = 0;
                            $dtotaldsellingprice = 0;
                            $xpdtotaldsellingprice = 0;
                            $totalexpence = 0;
                            $dpurbenifit = 0;
                            $dtotalbuy = 0;
                            $xpdtotalbuy = 0;
                            $dtotaldbuyvat = 0;
                            $xpdtotaldbuyvat = 0;
                            $dtotaldsellingvat = 0;
                            $xpdtotaldsellingvat = 0;
                            $dev = 0;
                            $xpdev = 0;
                            $devprice = 0;
                            $ptotaldselling = 0;
                            $xpptotaldselling = 0;
                            $ptotaldsellingbuyprice = 0;
                            $xpptotaldsellingbuyprice = 0;
                            $ptotaldsellingprice = 0;
                            $xpptotaldsellingprice = 0;
                            $ppurbenifit = 0;
                            $ptotalbuy = 0;
                            $ptotaldbuyvat = 0;
                            $ptotaldsellingvat = 0;
                            $pev = 0;
                            $pevprice = 0;
                            $oil_reading = 0;
                            $oil_pure_benefit = 0;
                            $d_testing = 0;
                            $xpd_testing = 0;
                            $p_testing = 0;
                            $xpp_testing = 0;
                            $cash_on_hand = 0;
                            $totalcard_fule = 0;
                            $totalioc_fule = 0;
                            $totalcredit_fule = 0;
                            $totalextracash_fule = 0;
                            $totalReciveFromCustomer=0;
                            $totalSelling=0;
                            $totalCollection=0;
                            $ostok = 0;
                            $oil_cgst = 0;
                            $oil_sgst = 0;
                            $cnt = 0;
							$dieset_stock = 0;
							$dtotaldselling_total = 0;
							$xpdtotaldselling_total = 0;
							$dtotalbuy_total = 0;
							$xpdtotalbuy_total = 0;
						
							$patrol_stock = 0;
							$xppatrol_stock = 0;
							$ptotalbuy_total = 0;
							$ptotaldselling_total = 0;
                            foreach ($report as $r) {
                                if ((strtotime($sdate) <= strtotime($r['date'])) && $cnt == 0) {
                                    $cnt++;
                                }
                                if ($cnt == 0) {
									$r['pstock'] = 0;
											foreach ($location_tank_list as $locationtank) {
                                                if ($locationtank->fuel_type == 'p'  && $locationtank->xp_type == 'No') {
													
                                                    if (isset($finaltank[$r['date']][$r['id']]['p'][$locationtank->id])) {
                                                        
                                                    }
													if(isset($tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)])){
														echo $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
														$r['pstock'] = $r['pstock'] + $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
													}else{
														echo $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['deepreading'];
														$r['pstock'] = $r['pstock'] + $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['deepreading'];
													}
													}
                                            }
									//$r['pstock'] = 0;
									/*foreach ($location_tank_list as $locationtank) {
									if ($locationtank->fuel_type == 'p') {
										if(isset($tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)])){
											$r['pstock'] = $r['pstock'] + $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
										}else{
											$r['pstock'] = $r['pstock'] + $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['deepreading'];
										}
									}
									}*/
									/*$r['dstock'];
									$r['dstock'] = 0;
									foreach ($location_tank_list as $locationtank) {
									if ($locationtank->fuel_type == 'd') {											
										if(isset($tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['volume'],0,-1)])){
											
											$r['dstock'] = $r['dstock'] + $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['volume'],0,-1)];
										}else{
											$r['dstock'] = $r['dstock'] + $finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading'];
										}
									}
									}*/
									$r['dstock'] = 0;
		foreach ($location_tank_list as $locationtank) {
			if ($locationtank->fuel_type == 'd' && $locationtank->xp_type == 'No') { 
			
				if (isset($finaltank[$r['date']][$r['id']]['d'][$locationtank->id])) {
					
				}
				if(isset($tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)])){
					echo $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
					$r['dstock'] = $r['dstock'] + $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['volume'],0,-1)];
				}else{
					echo $finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading'];
					$r['dstock'] = $r['dstock'] + $finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading'];
				}
				}
		}
                                    $p_dstock = $r['dstock'];
                                    $p_d_total_selling = $r['d_total_selling'];
                                    $p_d_quantity = $r['d_quantity'];
                                    $p_pstock = $r['pstock'];
                                    $xpp_pstock = $r['xppstock'];
                                    $p_p_total_selling = $r['p_total_selling'];
                                    $p_p_quantity = $r['p_quantity'];
                                } else {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php if(in_array("daily_report_action",$this->data['user_permission_list'])){ ?>
                                                <a href="<?php echo base_url() ?>daily_reports_new/edit?date=<?php echo date('d-m-Y', strtotime($r['date'])); ?>&location=<?php echo $location; ?>&sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&debug=1"><?php echo date('d/m/Y', strtotime($r['date'])); ?></a>
                                            <?php } else { ?>
            <?php echo date('d/m/Y', strtotime($r['date'])); ?>
                                            <?php } ?>
                                        </td>
                                            <?php /*foreach ($location_tank_list as $locationtank) {
                                                if ($locationtank->fuel_type == 'd') { ?>

                                                <td nowrap>
                                                    <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                <?php
                if (isset($finaltank[$r['date']][$r['id']]['d'][$locationtank->id])) {
                    echo amountfun($finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading']);
					
					if(isset($tanklistwithdeep[$locationtank->id][rtrim($finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['volume'],'0')])){
						//echo "< >".$tanklistwithdeep[$locationtank->id][rtrim($finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['volume'],'0')];
					}
                }
                ?>
                  </span>
                                                </td>
            <?php }
        }*/ 
		
		
		$r['dstock'] = 0;
		$r['xpdstock'] = 0;
		foreach ($location_tank_list as $locationtank) {
			if ($locationtank->fuel_type == 'd' && $locationtank->xp_type == 'No') { ?>
			<td nowrap>
				<span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
				<?php
				if (isset($finaltank[$r['date']][$r['id']]['d'][$locationtank->id])) {
					
				}
				if(isset($tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)])){
					echo $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
					$r['dstock'] = $r['dstock'] + $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['volume'],0,-1)];
				}else{
					echo $finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading'];
					$r['dstock'] = $r['dstock'] + $finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading'];
				}
				?>
			</td>
			<?php }
		}
		
		?>


                                        <td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
        <?php echo amountfun($r['dstock']);   $dieset_stock = $r['dstock']; ?></span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['d_total_selling']);
                                            $dtotaldselling = $dtotaldselling + $r['d_total_selling'];
                                            $dtotaldselling_total = $r['d_total_selling']; ?>
                                        </span>
                                        </td>
										
                                        <td>
                                        <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
        <?php echo amountfun($r['d_testing']);
        $d_testing = $d_testing + $r['d_testing']; ?>
    </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php
											echo amountfun($r['d_total_selling'] * $r['d_new_price']);
                                            $dtotaldsellingbuyprice = $dtotaldsellingbuyprice + ($r['d_total_selling'] * $r['d_new_price']);
                                            ?>
                                        </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
        <?php
        echo amountfun($r['d_total_selling'] * $r['dis_price']); 
        $dtotaldsellingprice = $dtotaldsellingprice + round($r['d_total_selling'] * $r['dis_price'], 2);
        ?>
</span>
                                        </td>
										
                                        <td style="color:red;">
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['expence']);
                                            $totalexpence = $totalexpence + $r['expence']; ?>
                                        </span>
                                        </td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
<?php echo amountfun((+($r['d_total_selling'] * $r['dis_price']) - ($r['d_total_selling'] * $r['d_new_price'])) - $r['expence']); 
$dpurbenifit = $dpurbenifit + round(($r['d_total_selling'] * $r['dis_price']) - ($r['d_total_selling'] * $r['d_new_price']) - $r['expence'], 2); ?>
</span></td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                        <?php echo amountfun($r['d_quantity']);
                                        $dtotalbuy = $dtotalbuy + $r['d_quantity']; 
                                        $dtotalbuy_total = $r['d_quantity']; ?>
                                    </span>
                                        </td>
										
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['dv_taxamount']);
                                            $dtotaldbuyvat = $dtotaldbuyvat + $r['dv_taxamount']; ?>
                                        </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php
											echo amountfun(((round($r['d_total_selling'] * $r['dis_price'], 2) * $vatList[$r["date"]]) / (100+$vatList[$r["date"]])));
                                            $dtotaldsellingvat = $dtotaldsellingvat + round(((round($r['d_total_selling'] * $r['dis_price'], 2) * $vatList[$r["date"]]) / (100+$vatList[$r["date"]])), 2);
                                            ?>
                                        </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php
                                            if ($cnt == 0) {
                                                 $cdev = round($r['d_ev'], 2);
                                            } else {
                                                 $cdev = round($r['dstock'] - (($p_dstock - $p_d_total_selling) + ($p_d_quantity)), 2);
                                            }
											echo amountfun($cdev);
                                            $dev = $dev + $cdev;
                                            ?>
                                        </span>
                                        </td>
										
                                        
                                            <?php
											$r['pstock'] = 0;
											$r['xppstock'] = 0;
											foreach ($location_tank_list as $locationtank) {
                                                if ($locationtank->fuel_type == 'p'  && $locationtank->xp_type == 'No') { ?>
                                                <td nowrap>
                                                    <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                                    <?php
                                                    if (isset($finaltank[$r['date']][$r['id']]['p'][$locationtank->id])) {
                                                        
                                                    }
													if(isset($tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)])){
														echo $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
														$r['pstock'] = $r['pstock'] + $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
													}else{
														echo $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['deepreading'];
														$r['pstock'] = $r['pstock'] + $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['deepreading'];
													}
                                                    ?>
                                                </td>
                                                <?php }
                                            } ?>
                                        
										
										



<td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> hiii">
                                            <?php echo amountfun($r['pstock']); $patrol_stock = $r['pstock']; ?>
                                        </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['p_total_selling']);
                                            $ptotaldselling = $ptotaldselling + $r['p_total_selling']; 
                                            $ptotaldselling_total = $r['p_total_selling']; ?>
                                        </span>
                                        </td>
										
                                        
										<td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['p_testing']);
                                            $p_testing = $p_testing + $r['p_testing']; ?>
                                        </span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php
                                            echo amountfun($r['p_total_selling'] * $r['p_new_price']);
                                            $ptotaldsellingbuyprice = $ptotaldsellingbuyprice + ($r['p_total_selling'] * $r['p_new_price']);
                                            ?>
                                        </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php
                                            echo amountfun($r['p_total_selling'] * $r['pet_price']);
                                            $ptotaldsellingprice = $ptotaldsellingprice + round($r['p_total_selling'] * $r['pet_price'], 2);
                                            ?>
                                        </span>
                                        </td>
										
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))."  (".$r['p_total_selling'] ."*". $r['pet_price'].") - (".$r['p_total_selling']." * ".$r['p_new_price'].")";?>">
<?php echo amountfun(($r['p_total_selling'] * $r['pet_price']) - ($r['p_total_selling'] * $r['p_new_price']));
$ppurbenifit = $ppurbenifit + (($r['p_total_selling'] * $r['pet_price']) - ($r['p_total_selling'] * $r['p_new_price'])); ?></span></td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['p_quantity']);
                                            $ptotalbuy = $ptotalbuy + $r['p_quantity'];
											$ptotalbuy_total = $r['p_quantity']; 
											?>
                                        </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php
                                            echo amountfun($r['pv_taxamount']);
                                            $ptotaldbuyvat = $ptotaldbuyvat + $r['pv_taxamount'];
                                            ?>
                                        </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                                <?php echo amountfun(($r['p_total_selling'] * $r['pet_price'] * $vatList[$r["date"]]) / (100+$vatList[$r["date"]]));
                                                $ptotaldsellingvat = $ptotaldsellingvat + round(($r['p_total_selling'] * $r['pet_price'] * $vatList[$r["date"]]) / (100+$vatList[$r["date"]]), 2); ?>
                                             </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> <?php echo $r['pstock']." - ((".$p_pstock." - ".$p_p_total_selling.") + (".$p_p_quantity."))";?>">
                                                <?php
                                                /*if ($cnt == 0) {
                                                     $cdev = round($r['p_ev'], 2);
                                                } else {*/
                                                     $cdev = round($r['pstock'] - (($p_pstock - $p_p_total_selling) + ($p_p_quantity)), 2);
                                                //}
												//echo "(".$p_pstock ."-". $p_p_total_selling.") + (".$p_p_quantity.")<br>";
												//echo $r['pstock'] ."- ((".$p_pstock ."-". $p_p_total_selling.") + (".$p_p_quantity.")<br>";
												echo amountfun($cdev);
												
                                                $PETEV = $cdev;
                                                $pev = $pev + $cdev;
                                                ?>
                                        </span>
                                        </td>
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> Oil Stock Ltr">
                                            <?php
                                           echo amountfun($oil_detail_price[$r['date']]['total_stock_in_l']);
                                             ?>
                                         </span>
                                        </td>
                                        <td nowrap>
                                                <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> Oil Amount Stock">
                                           
                                                <?php
                                                echo amountfun($oil_detail_price[$r['date']]['total']);
$latoil = round($oil_detail_price[$r['date']]['total'], 2);
												?>

                                            </span>
                                        </td>
                                        <td nowrap>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> buy price">
                                            <?php echo amountfun($oil_detail_price[$r['date']]['bay_price']); ?>
                                            <br>
                                         
                                         </span>   
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> oil stock">
                                            <?php
											
											$totloilselling = $oil_detail_price[$r['date']]['sel_price'];
											echo amountfun($oil_detail_price[$r['date']]['sel_price']);
											$oil_reading = $oil_reading + $oil_detail_price[$r['date']]['sel_price']; ?>
                                        </span>
                                        </td>

                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> oil profit">
                                        <?php echo amountfun($oil_final_array[$r['date']]['sell']-$oil_final_array[$r['date']]['buy']);
                                        $oil_pure_benefit = $oil_pure_benefit + ($oil_final_array[$r['date']]['sell']-$oil_final_array[$r['date']]['buy']); ?>
                                    </span>
                                        </td>
										<td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> oil qty ">
                                                                                    <?php  echo amountfun($bay_stock_array[$r['date']]['total_qty_ltr']);  ?>
                                        </span>
										</td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> GST">
                                    <?php echo amountfun($r['oil_cgst'] + $r['oil_sgst']);
                                    $oil_cgst = $oil_cgst + round($r['oil_cgst'] + $r['oil_sgst'], 2); ?>
                                </span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> Oil Selling GST">
                                    <?php echo amountfun((($totloilselling * 18) / 118));
                                    $oil_sgst = $oil_sgst + round((($totloilselling * 18) / 118), 2); ?>
                                </span>
                                        </td>
										
										
									
<?php if($location_detail->xp_type == "Yes" && $location_detail->xpd_type == "Yes" ){ ?>									
							<?php			
$r['xpdstock'] = 0;
		foreach ($location_tank_list as $locationtank) {
			
			if ($locationtank->fuel_type == 'd' && $locationtank->xp_type == 'Yes') { ?>
			<td nowrap>
				<span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
				<?php
				if (isset($finaltank[$r['date']][$r['id']]['d'][$locationtank->id])) {
					
				}
				if(isset($tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)])){
					echo $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
					$r['xpdstock'] = $r['xpdstock'] + $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['volume'],0,-1)];
				}else{
					echo $finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading'];
					$r['xpdstock'] = $r['xpdstock'] + $finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading'];
				}
				?>
			</td>
			<?php }
		}
		
		?>
	
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>"><?php echo amountfun($r['xpdstock']); $xpdieset_stock = $r['xpdstock']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>"><?php echo amountfun($r['xpd_total_selling']); $xpdtotaldselling = $xpdtotaldselling + $r['xpd_total_selling']; $xpdtotaldselling_total = $r['xpd_total_selling']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>"><?php echo amountfun($r['xpd_testing']); $xpd_testing = $xpd_testing + $r['xpd_testing']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>"><?php echo amountfun($r['xpd_total_selling'] * $r['xpd_new_price']); $xpdtotaldsellingbuyprice = $xpdtotaldsellingbuyprice + ($r['xpd_total_selling'] * $r['xpd_new_price']); ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>"><?php echo amountfun($r['xpd_total_selling'] * $r['xpdis_price']); $xpdtotaldsellingprice = $xpdtotaldsellingprice + ($r['xpd_total_selling'] * $r['xpdis_price']); ?></span></td>

<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>"><?php echo amountfun($r['xpd_quantity']); $xpdtotalbuy = $xpdtotalbuy + $r['xpd_quantity']; $xpdtotalbuy_total = $r['xpd_quantity']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>"><?php echo amountfun($r['xpdv_taxamount']); $xpdtotaldbuyvat = $xpdtotaldbuyvat + $r['xpdv_taxamount']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>"><?php echo amountfun(((round($r['xpd_total_selling'] * $r['xpdis_price'], 2) * $vatList[$r["date"]]) / (100+$vatList[$r["date"]]))); $xpdtotaldsellingvat = $xpdtotaldsellingvat + round(((round($r['xpd_total_selling'] * $r['xpdis_price'], 2) * $vatList[$r["date"]]) / (100+$vatList[$r["date"]])), 2); ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
<?php echo amountfun((($r['xpd_total_selling'] * $r['xpdis_price']) - ($r['xpd_total_selling'] * $r['xpd_new_price']))); 
$xpdpurbenifit = $xpdpurbenifit + round(($r['xpd_total_selling'] * $r['xpdis_price']) - ($r['xpd_total_selling'] * $r['xpd_new_price']), 2); ?>
</span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>"><?php
if ($cnt == 0) {
	$xpcdev = round($r['xpd_ev'], 2);
} else {
	$xpcdev = round($r['xpdstock'] - (($xpp_dstock - $xpp_d_total_selling) + ($xpp_d_quantity)), 2);
}
echo amountfun($xpcdev);
$xpdev = $xpdev + $xpcdev;
?></span></td>
<?php } ?>

<?php if($location_detail->xp_type == "Yes" && $location_detail->xpp_type == "Yes" ){ ?>
<?php
											$r['xppstock'] = 0;
											foreach ($location_tank_list as $locationtank) {
                                                
												if ($locationtank->fuel_type == 'p'  && $locationtank->xp_type == 'Yes') { ?>
                                                <td nowrap>
                                                    <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                                    <?php
                                                    if (isset($finaltank[$r['date']][$r['id']]['p'][$locationtank->id])) {
                                                        
                                                    }
													if(isset($tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)])){
														echo $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
														$r['xppstock'] = $r['xppstock'] + $tanklistwithdeep[$locationtank->id][substr($finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['volume'],0,-1)];
													}else{
														echo $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['deepreading'];
														$r['xppstock'] = $r['xppstock'] + $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['deepreading'];
													}
                                                    ?>
                                        </span>
                                                </td>
                                                <?php }
                                            } ?>						
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> xppstock"><?php echo amountfun($r['xppstock']); $xppatrol_stock = $r['xppstock']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> sell"><?php echo amountfun($r['xpp_total_selling']); $xpptotaldselling = $xpptotaldselling + $r['xpp_total_selling']; $xpptotaldselling_total = $r['xpp_total_selling']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> testing"><?php echo amountfun($r['xpp_testing']); $xpp_testing = $xpp_testing + $r['xpp_testing']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> buy price"><?php echo amountfun($r['xpp_total_selling'] * $r['xpp_new_price']); $xpptotaldsellingbuyprice = $xpptotaldsellingbuyprice + ($r['xpp_total_selling'] * $r['xpp_new_price']); ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> sell price"><?php echo amountfun($r['xpp_total_selling'] * $r['xppet_price']); $xpptotaldsellingprice = $xpptotaldsellingprice + round($r['xpp_total_selling'] * $r['xppet_price'], 2); ?> </span> </td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> purches qty"><?php echo amountfun($r['xpp_quantity']); $xpptotalbuy = $xpptotalbuy + $r['xpp_quantity']; $ptotalbuy_total = $r['xpp_quantity']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> tax"><?php echo amountfun($r['xppv_taxamount']); $xpptotaldbuyvat = $xpptotaldbuyvat + $r['xppv_taxamount']; ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> sall vat"><?php echo amountfun(($r['xpp_total_selling'] * $r['xppet_price'] * $vatList[$r["date"]]) / (100+$vatList[$r["date"]])); $xpptotaldsellingvat = $xpptotaldsellingvat + round(($r['xpp_total_selling'] * $r['xppet_price'] * $vatList[$r["date"]]) / (100+$vatList[$r["date"]]), 2); ?></span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> purbenifit">
<?php echo amountfun((($r['xpp_total_selling'] * $r['xppet_price']) - ($r['xpp_total_selling'] * $r['xpp_new_price']))); 
$xpppurbenifit = $xpppurbenifit + round(($r['xpp_total_selling'] * $r['xppet_price']) - ($r['xpp_total_selling'] * $r['xpp_new_price']), 2); ?>
</span></td>
<td><span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> pev   <?php echo $r['xppstock']."-((".$xpp_pstock."-".$xpp_p_total_selling.")+(".$xpp_p_quantity."))";	?>">
<?php if ($cnt == 0) {
		$xpcdev = round($r['xpp_ev'], 2);
	} else {
		$xpcdev = round($r['xppstock'] - (($xpp_pstock - $xpp_p_total_selling) + ($xpp_p_quantity)), 2);
	}
	echo amountfun($xpcdev);
	$xpPETEV = $xpcdev;
	$xppev = $xppev + $xpcdev;
?>
</span>
</td>
<?php } ?>	
										
										
										
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> cash_on_hand">
                                            <?php echo amountfun($r['cash_on_hand']); ?>
                                        </span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['totalcard_fule']); ?>
                                        </span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['totalioc_fule']); ?>
                                        </span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['totalextracash_fule']); ?>
                                        </span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> Sales on credit">
                                            <?php echo amountfun($r['totalcredit_fule']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($r['totalcreditcash_fule']);  ?>
                                        </span>
                                        </td>
                                                                                <!--<td>
                                            <?php $tcollection = round($r['cash_on_hand'] + $r['totalcard_fule'] + $r['totalioc_fule'] + $r['totalcredit_fule'] - $r['expence'], 2);
											
											
											echo amountfun($tcollection);
                                            ?>
                                                                                </td>-->
										<?php /*?><td><?php echo isset($company_credit_debit['c'][$r['date']])?$company_credit_debit['c'][$r['date']]:'0.00'; ?></td>
										<td><?php echo isset($company_credit_debit['d'][$r['date']])?$company_credit_debit['d'][$r['date']]:'0.00'; ?></td>
										<?php */ ?>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php
											
											
                                            $tcollection = round($r['cash_on_hand'] + $r['totalcard_fule'] + $r['totalioc_fule'] + $r['totalcredit_fule']+ - $r['expence'], 2);

                                             $x = $tsell = round(($r['xpd_total_selling'] * $r['xpdis_price']) + (($r['xpp_total_selling'] * $r['xppet_price'])) + ($r['d_total_selling'] * $r['dis_price']) + (($r['p_total_selling'] * $r['pet_price'])) + $totloilselling, 2);
											
											echo amountfun($x);
                                            ?> 
                                           </span> 
                                        </td>
                                        <td>
										<?php 
										$bankexpense =0;
		if(isset($bank_expense[$r['date']])){
			$bankexpense =$bank_expense[$r['date']];
		}
										?>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?> total collection bank expance <?php echo $bankexpense;?>">
        <?php
		$onlinetransactioncs = 0;
        if(isset($onlinetransaction_cs[$r['date']])){
			//$onlinetransactioncs = $onlinetransaction_cs[$r['date']];
		}
		
		
											$y = round((isset($online_bank_expance_array[$r['date']])?$online_bank_expance_array[$r['date']]:0)+$onlinetransactioncs+$r['salary_admount']  + $r['loan_amount'] + $r['extra_salary'] + $r['cash_on_hand'] + $r['totalcard_fule'] + $r['totalioc_fule'] + $r['totalextracash_fule'] + $r['totalcredit_fule'] + $r['expence']+($r['petty_cash_transaction_amount']==""?0:$r['petty_cash_transaction_amount'])+$savingList[$r['date']]-$bankexpense, 2);
											
											echo amountfun($y);
                                            ?>
                                        </span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($y - $x);?>
                                            </span>
                                        </td>
                                        <?php if(in_array("daily_report_action",$this->data['user_permission_list'])){ ?>   	<td>
                                            <span data-toggle="tooltip" title="view">
                                                <a href="<?php echo base_url() ?>daily_reports_new/edit?date=<?php echo date('d-m-Y', strtotime($r['date'])); ?>&location=<?php echo $location; ?>&sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&debug=1">View</a>
                                             </span>   
                                            </td> <?php } ?>
                                    </tr>
        <?php
        $p_dstock = $r['dstock'];
        $xpp_dstock = $r['xpdstock'];
        $p_d_total_selling = $r['d_total_selling'];
        $p_d_quantity = $r['d_quantity'];
        $p_pstock = $r['pstock'];
        $xpp_pstock = $r['xppstock'];
        $p_p_total_selling = $r['p_total_selling'];
        $p_p_quantity = $r['p_quantity'];
        $cash_on_hand = $r['cash_on_hand'] + $cash_on_hand;
        $totalcard_fule = $r['totalcard_fule'] + $totalcard_fule;
        $totalioc_fule = $r['totalioc_fule'] + $totalioc_fule;
        $totalcredit_fule = $r['totalcredit_fule'] + $totalcredit_fule;
        $totalextracash_fule = $r['totalextracash_fule'] + $totalextracash_fule;
        $totalReciveFromCustomer=$r['totalcreditcash_fule']+ $totalReciveFromCustomer;
        $totalSelling= $x+ $totalSelling;
        $totalCollection= $y+ $totalCollection;
        $totalOvershortvalue=round(($y - $x), 2);
        $totalOvershort= $totalOvershortvalue + $totalOvershort;
    }
    $cnt++;
}
?>
                            <tr>
<td>Total</td>
	<?php foreach ($location_tank_list as $locationtank) {
	if ($locationtank->fuel_type == 'd' && $locationtank->xp_type == 'No') { ?>
	<th><?php echo $locationtank->tank_name; ?></th>
	<?php }
	} ?>
<?php
$dieset_stock_total = ($dieset_stock + $dtotalbuy_total) - $dtotaldselling_total;
?>
<th><b style="color:blue">Diesel</b><br/><?php echo amountfun($dieset_stock_total); ?></th>

<td>
<?php echo amountfun($dtotaldselling); ?>
</td>
<td>
<?php echo amountfun($d_testing); ?>
</td>
<td>
<?php echo amountfun($dtotaldsellingbuyprice); ?>
</td>
<td>
<?php echo amountfun($dtotaldsellingprice); ?>
</td>
<td style="color:red;">
<?php echo amountfun($totalexpence); ?>
</td>
<td>
<?php echo amountfun($dpurbenifit); ?>
</td>
<td>
<?php echo amountfun($dtotalbuy); ?> 
</td>
<td>
<?php echo amountfun($dtotaldbuyvat); ?>
</td>
<td>
<?php echo amountfun($dtotaldsellingvat); ?>
</td>
<td>
<?php echo amountfun($dev); ?>
</td>
<?php foreach ($location_tank_list as $locationtank) {
if ($locationtank->fuel_type == 'p' && $locationtank->xp_type == 'No') { ?>
<th><?php echo $locationtank->tank_name; ?></th>
<?php }
} ?>

<?php
$patrol_stock_total = ($patrol_stock + $ptotalbuy_total) - $ptotaldselling_total;
?>
<th><b  style="color:green" >Petrol</b><br/>  <?php echo amountfun($patrol_stock_total); ?></th>
<td>
<?php echo amountfun($ptotaldselling); ?>
</td>
<td>
<?php echo amountfun($p_testing); ?>
</td>
<td>
<?php echo amountfun($ptotaldsellingbuyprice); ?>
</td>
<td>
<?php echo amountfun($ptotaldsellingprice); ?>
</td>
<td>
<?php echo amountfun($ppurbenifit); ?>
</td>
<td>
<?php echo amountfun($ptotalbuy); ?>
</td>
<td>
<?php echo amountfun($ptotaldbuyvat); ?>
</td>
<td>
<?php echo amountfun($ptotaldsellingvat); ?>
</td>
<td>
<?php echo amountfun($pev); ?>
</td>
<td>
</td>
<th style="color:red"><b>Oil</b></th>
<td>
</td>
<td>
<?php echo amountfun($oil_reading); ?>
</td>

<td>
<?php echo amountfun($oil_pure_benefit); ?>
</td>
<td>
</td>
<td>
<?php echo amountfun($oil_cgst); ?>
</td>
<td>
<?php echo amountfun($oil_sgst); ?>
</td>
<?php if($location_detail->xp_type == "Yes" && $location_detail->xpd_type == "Yes" ){ ?>
<?php foreach ($location_tank_list as $locationtank) {
	if ($locationtank->fuel_type == 'd' && $locationtank->xp_type == 'Yes') { ?>
	<th><?php echo $locationtank->tank_name; ?></th>
	<?php }
	} ?>
<th><b style="color:blue">XP Diesel</b><br/><?php $xpdieset_stock_total = ($xpdieset_stock + $xpdtotalbuy_total) - $xpdtotaldselling_total; echo amountfun($xpdieset_stock_total); ?></th>
<td><?php echo amountfun($xpdtotaldselling); ?></td>
<td><?php echo amountfun($xpd_testing); ?></td>
<td><?php echo amountfun($xpdtotaldsellingbuyprice); ?></td>
<td><?php echo amountfun($xpdtotaldsellingprice); ?></td>
<td><?=amountfun($xpdtotalbuy)?></td>
<td><?=amountfun($xpdtotaldbuyvat)?></td>
<td><?=amountfun($xpdtotaldsellingvat)?></td>
<td><?=amountfun($xpdpurbenifit)?></td>
<td><?=amountfun($xpdev)?></td>
<?php } ?>
<?php if($location_detail->xp_type == "Yes" && $location_detail->xpp_type == "Yes" ){ ?>
<?php foreach ($location_tank_list as $locationtank) {
	if ($locationtank->fuel_type == 'p' && $locationtank->xp_type == 'Yes') { ?>
	<th><?php echo $locationtank->tank_name; ?></th>
	<?php }
	} ?>
<th><b style="color:blue">XP Petrol</b><br/><?php $xpdieset_stock_total = ($xppatrol_stock + $xpptotalbuy_total) - $xpptotaldselling_total; echo amountfun($xpdieset_stock_total); ?></th>
<td><?php echo amountfun($xpptotaldselling); ?></td>
<td><?php echo amountfun($xpp_testing); ?></td>
<td><?php echo amountfun($xpptotaldsellingbuyprice); ?></td>
<td><?php echo amountfun($xpptotaldsellingprice); ?></td>
<td><?=amountfun($xpptotalbuy)?></td>
<td><?=amountfun($xpptotaldbuyvat)?></td>
<td><?=amountfun($xpptotaldsellingvat)?></td>
<td><?=amountfun($xpppurbenifit)?></td>
<td><?=amountfun($xppev)?></td>
<?php } ?>
<td>
<?php echo amountfun($cash_on_hand); ?>
</td>
<td>
<?php echo amountfun($totalcard_fule); ?>
</td>
<td>
<?php echo amountfun($totalioc_fule); ?>
</td>
<td>
<?php echo amountfun($totalextracash_fule); ?>
</td>

<td>
<?php echo amountfun($totalcredit_fule); ?>
</td>
<td><?php echo amountfun($totalReciveFromCustomer); ?></td>
<td><?php echo amountfun($totalSelling); ?></td>
<td><?php echo amountfun($totalCollection); ?></td>
<td><?php echo amountfun($totalOvershort); ?></td>
<td></td>


</tr>
                        </tbody>
                    </table>
					<?php 
				//	echo $r['dstock'] . "-" . $r['d_total_selling'] . "+" . $r['d_quantity'] . ")*" . $r['d_new_price'] . "<br>";
					?>
                </div>
                <hr>
                                            <?php
											/*
                                            $totalsalary = 0;
                                            foreach ($salary as $salary_detail) {
                                                if ($salary_detail->active == 1) {
                                                    if($salary_detail->salary != 0 && $salary_detail->salary != ""){
                                                    $totalsalary = $totalsalary + $salary_detail->salary;
                                                    }else{
                                                        $totalsalary = $totalsalary + $salary_detail->c_salary;
                                                    }
                                                }
                                            }

                                            $paidvat = round($dtotaldbuyvat + $ptotaldbuyvat, 2);
                                            $vat = $paidvat + $oilgst;
                                            $oilgst = $oil_sgst - $oil_cgst;
                                            ?>



                <div class="row">
                    <div class="col-md-6">
                        <div class="title-h1">
                            <h3>Profit</h3>
                        </div>
                        <div class="bdr js-scroll">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Total Profit</th>
                                        <td>
<?php echo round($totalprofit = $dpurbenifit + $ppurbenifit + $oil_pure_benefit, 2); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Salary</th>
                                        <td>
<?php
echo $finaltotalsalary = round($totalsalary, 2);
//echo "<br>"; echo $tempselling;
?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Vat</th>
                                        <td>
                            <?php echo round($vat = $dtotaldsellingvat + $ptotaldsellingvat, 2); ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Paid Vat</th>
                                        <td>
<?php echo $paidvat; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payble vat</th>
                                        <td>
<?php echo $payblval = round($vat - $paidvat, 2); ?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <th>GST</th>
                                        <td>
                            <?php echo round($oil_sgst, 2); ?>

                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Paid GST</th>
                                        <td>
<?php echo round($oil_cgst, 2); ?> 
                                        </td>
                                    </tr>


                                    <tr>
                                        <th>Payble Oil GST</th>
                                        <td>
<?php
echo $oilgst;
//echo round($oilgst = $oil_reading*18/118,2)-$oil_cgst-$oil_sgst;
?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Pure Benefit</th>
                                        <td>
                                            <?php echo $lastpb = round($totalprofit - $totalsalary - $payblval - $oilgst, 2); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="title-h1">
                            <h3><!--Salary--></h3>
                        </div>
                        <div class="bdr js-scroll">
                          <!--  <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Name</th>
                                        <th>PAGAR</th>
                                                                                        <th>BONUS</th>
                                        <th>Paid Amount</th>
                                        <th>Remaning Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                            <?php $salaryadvance = 0;
                                            $cnt = 1;
                                            $totalsalary = 0;
                                            $totalbonas = 0;
                                            foreach ($salary as $salary_detail) { ?>
                                        <tr>
                                            <th>
    <?php echo $salary_detail->code;
    $cnt++; ?>
                                            </th>
                                            <th>
                                        <?php echo $salary_detail->name; ?>
                                            </th>
                                            <th>
    <?php echo round($salary_detail->salary, 2);
    $totalsalary = $totalsalary + $salary_detail->salary; ?>
                                            </th>
                                                                                            <th>
                                                <?php echo round($salary_detail->bonas, 2);
                                                $totalbonas = $totalbonas + $salary_detail->bonas; ?>
                                            </th>
                                            <th>
                                                <?php echo round($salary_detail->totaldebit, 2); ?>
                                            </th>

                                            <th>
    <?php echo round($salary_detail->salary - $salary_detail->totaldebit, 2);
    $salaryadvance = $salaryadvance + $salary_detail->salary - $salary_detail->totaldebit; ?>
                                            </th>
                                        </tr>
                                    <?php } ?> </tbody>
                            </table>
                            --> </div>

                    </div>

                    <div class="col-md-6">
                        <div class="title-h1">
                            <h3>Stock</h3>
                        </div>
                        <div class="bdr js-scroll">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Stock</th>
                                        <th>Rupees</th>
                                    </tr>
                                    <tr>
                                        <th>Petrol</th>
                                        <td>
<?php
//echo $lastday->petrol;
$finaltemptotal = 0;
//echo "(".$r['pstock']."-".$r['p_total_selling']."+".$r['p_quantity'].")*".$r['p_new_price']."<br>";
echo round(((($r['pstock'] - $r['p_total_selling']) + ($r['p_quantity'])) * ($r['p_new_price'])), 2);

$finaltemptotal = $finaltemptotal + round(($r['pstock'] - $r['p_total_selling'] + $r['p_quantity']) * $r['p_new_price'], 2);
////echo "<br>".$finaltemptotal."<br>";

?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Diesel</th>
                                        <td>
                                            <?php
                                            //echo $lastday->diesel;
                                            if ($_GET['ddd'] == 1) {
                                                echo $r['dstock'] . "-" . $r['d_total_selling'] . "+" . $r['d_quantity'] . ")*" . $r['d_new_price'] . "<br>";
                                            }
                                            echo round(($r['dstock'] - $r['d_total_selling'] + $r['d_quantity']) * $r['d_new_price'], 2);
                                           
                                            $finaltemptotal = $finaltemptotal + round(($r['dstock'] - $r['d_total_selling'] + $r['d_quantity']) * $r['d_new_price'], 2);
											////echo "<br>".$finaltemptotal."<br>";
                                            
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Oil</th>
                                        <td>
                                            <?php
                                            echo $latoil;
                                            
                                            $finaltemptotal = $finaltemptotal + $latoil;
											////echo "<br>".$finaltemptotal."<br>";
                                            ?>
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <th>Remaining Worker Loan</th>
                                        <td>
<?php
echo round($loansalary->loanamont - $loansalary->paid_loan_amount, 2);
$finaltemptotal = $finaltemptotal + round($loansalary->loanamont - $loansalary->paid_loan_amount, 2);
////echo "<br>".$finaltemptotal."<br>";
?>
                                        </td>
                                    </tr>
                                                                               
                                    <tr>
                                        <th>Bank Balance </th>
                                        <td>
                                    <?php

                                    echo $bank_balence = ($pre_deposit_amount->cash_total + $pre_cheq_deposit_amount->cheque_total + $pre_deposit_wallet_amount->wallet_extra_total + $prev_card_depost->total + $petty_cash_deposit_list->total) - ($pre_onlinetransaction->total_onlinetransaction + $prev_petty_cash_withdrawal->total);

                                    $finaltemptotal = $finaltemptotal + $bank_balence;
									////echo "<br>".$finaltemptotal."<br>";
                                    ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rewards Card Balance (Company)</th>
                                        <td>
                                            <?php
                                          

                                            echo round(($prv_ioc_total->totalamount + $prv_transection_total->totalamount) - ($prv_purchase_total->p_total_amount + $prv_purchase_total->d_total_amount), 2);
                                           
                                            $finaltemptotal = $finaltemptotal + round(($prv_ioc_total->totalamount + $prv_transection_total->totalamount) - ($prv_purchase_total->p_total_amount + $prv_purchase_total->d_total_amount), 2);
											////echo "<br>".$finaltemptotal."<br>";
                                            ?>
<?php if ($logged_company['type'] == 'c') { ?>  <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Cash On Hand</th>
                                        <td>
<?php
echo round($lastday->cash_on_hand, 2);
$finaltemptotal = $finaltemptotal + round($lastday->cash_on_hand, 2);
////echo "<br>".$finaltemptotal."<br>";
?>
                                            <?php if ($logged_company['type'] == 'c') { ?>      <a href="<?php echo base_url() ?>daily_reports_new/last_day_entry?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&location=<?php echo $location; ?>"><i class="fa fa-edit"></i></a> <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><!--Debite-->Credit</th>
                                        <td>
<?php
echo round($get_credit->total - $get_debit->total, 2);

$finaltemptotal = $finaltemptotal + round($get_credit->total - $get_debit->total, 2);
////echo "<br>".$finaltemptotal."<br>";
$payblval = round($vat - $paidvat, 2);
?>

                                        </td>
                                    </tr>
                                    
									<tr>
                                        <th>Pety Cash Credit Debit</th>
                                        <td>
<?php
echo round($creshcrdit-$cashdebit, 2);
$finaltemptotal = $finaltemptotal + round($creshcrdit-$cashdebit, 2);
////echo "<br>".$finaltemptotal."<br>";
?>

                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Company discount</th>
                                        <td>
<?php echo round($lastday->company_discount, 2);

$finaltemptotal = $finaltemptotal + round($lastday->company_discount, 2);
////echo "<br>".$finaltemptotal."<br>";
?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Stock</th>
                                        <td>
<?php echo round($finaltemptotal, 2); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Budget</th>
                                        <td>
<?php echo round($lastday->budget, 2); ?>
<?php if ($logged_company['type'] == 'c') { ?>    	         <a href="<?php echo base_url() ?>daily_reports_new/last_day_entry?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&location=<?php echo $location; ?>"><i class="fa fa-edit"></i></a> <?php } ?>
                                        </td>
                                    </tr>
                                     <tr>
                                        <th>Company charge</th>
                                        <td>
                                              <?php echo round($lastday->company_charge, 2); ?>
                                            <!--<br>-->
<?php  
//echo round($finaltemptotal, 2); 
$finaltemptotal = $finaltemptotal - round($lastday->company_charge, 2);
//echo "<br>";
//echo round($finaltemptotal, 2); 
?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Salary</th>
                                        <td>
                                              <?php echo round($lastday->l_salary, 2); ?>
                                            <br>
<?php // echo round($finaltotalsalary, 2); 
$finaltotalsalary = round($lastday->l_salary, 2); ?>
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <th>Vat</th>
                                        <td>
<?php
//echo $payblval."+".$oil_cgst."<br>"; 
echo $vat = $payblval + $oilgst;
//echo round($vat,2);
?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pure Benefits</th>
                                        <td>
<?php //echo round($totalprofit - $totalsalary - $vat - $paidvat + $oilgst,2); ?>
<?php echo $pb = $lastpb;//echo $pb = round($totalprofit - $totalsalary - $payblval - $oilgst, 2); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Mis Match</th>
                                        <td>
<?php
//echo $finaltemptotal."-(".$pb."+".$vat."+".$totalsalary."+".$lastday->budget.")<br><br>";
echo round($finaltemptotal - ($pb + $vat + $finaltotalsalary + $lastday->budget), 2);
// echo round($lastday->mis_match,2);
?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
				<?php */ ?>
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
                                        var url = '<?php echo base_url(); ?>daily_reports_new/print_pdf?sdate=<?php echo date("d-m-Y", strtotime($sdate)); ?>&edate=<?php echo date("d-m-Y", strtotime($edate)); ?>&location=<?php echo $location; ?>';
                                        //document.forms['savingdata'].submit();
										window.open(url, '_blank');

                                    }
                                    function SubmitForm()
                                    {

                                        document.forms['savingdata'].action = '<?php echo base_url(); ?>daily_reports_new_jun/index';
                                        document.forms['savingdata'].submit();

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