<?php $this->load->view('web/left');?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
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
            yearRange: "1918:n",

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
            <?php $this->load->view('web/header');?>
            <!-- //header-ends -->
            <div id="page-wrapper">
                
				<form method="post" action="<?php echo base_url();?>admin/add">			
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
                                <!--<div class="col-sm-2">
                                    <select name="month" id="month" class="form-control1">
											<option value="">Select Month</option>
											<option value="01" <?php if($month == '01'){ echo "selected"; }?> >January</option>
											<option value="02" <?php if($month == '02'){ echo "selected"; }?> >February</option>
											<option value="03" <?php if($month == '03'){ echo "selected"; }?> >March</option>
											<option value="04" <?php if($month == '04'){ echo "selected"; }?> >April</option>
											<option value="05" <?php if($month == '05'){ echo "selected"; }?> >May</option>
											<option value="06" <?php if($month == '06'){ echo "selected"; }?> >June</option>
											<option value="07" <?php if($month == '07'){ echo "selected"; }?> >July</option>
											<option value="08" <?php if($month == '08'){ echo "selected"; }?> >August</option>
											<option value="09" <?php if($month == '09'){ echo "selected"; }?> >September</option>
											<option value="10" <?php if($month == '10'){ echo "selected"; }?> >October</option>
											<option value="11" <?php if($month == '11'){ echo "selected"; }?> >November</option>
											<option value="12" <?php if($month == '12'){ echo "selected"; }?> >December</option>
											</select>
                                    <div class="invalid-feedback" id="montherror" style="color: red;"></div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" name="year" id="year" class="form-control1" value="<?php echo $year; ?>">

                                    <div class="invalid-feedback" id="yearerror" style="color: red;"></div>
                                </div>-->
                                <div class="col-sm-2">
                                    <!--<input type="submit" name="search" class="btn-success btn" value="Search" name="search">-->
                                    <button class="btn btn-primary" onClick="SubmitForm();" type="submit" >Search</button>
                                    <button class="btn btn-primary" formtarget="_blank"  onClick="Submitdata();" type="submit" <?php if($this->input->get('location') == "") { echo "Disabled"; } ?>>Print</button>
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
                                        <th>Date</th>
										<?php foreach($location_tank_list as $locationtank){ if($locationtank->fuel_type == 'd'){ ?>
										<th><?php echo $locationtank->tank_name; ?></th>
										<?php } } ?>
                                        <th>Diesel Stock</th>
                                        <th>Selling</th>
										<th>Testing</th>
                                        <th>Buy Price</th>
                                        <th>Selling Price</th>
                                        <th>Expense</th>
                                        <th>Pure Benefit</th>
                                        <th>Diesel Buy</th>
                                        <th>Buy vat 20%</th>
                                        <th>vat 20%</th>
                                        <th>Eva in diesel</th>
										<th>Eva in Price</th>
										<?php foreach($location_tank_list as $locationtank){ if($locationtank->fuel_type == 'p'){ ?>
										<th><?php echo $locationtank->tank_name; ?></th>
										<?php } } ?>
                                        <th>Petrol Stock</th>
                                        <th>Selling</th>
										<th>Testing</th>
                                        <th>Buy Price</th>
                                        <th>Selling Price</th>
                                        <th>Pure Benefit</th>
                                        <th>Petrol Buy</th>
                                        <th>Buy vat 20%</th>
                                        <th>vat 20%</th>
                                        <th>Eva in Petrol</th>
										<th>Eva in Price</th>
                                        <th>Oil Amount Stock</th>
										<th>Oil Buying Amount</th>
                                        <th>Oil Selling Amount</th>
										
                                        <th>Oil Pure Benefit</th>
										
										<th>Oil Buying GST</th>
										<th>Oil Selling GST</th>
										<th>Cash on hand</th>
										<th>Sales on Card</th>
										<th>Sales on Rewards</th>
										<th>Sales on Wallet</th>
										<th>Sales on Credit</th>
										<th>Received From Customer</th>
										<!--<th>Today Sell collection</th>-->
										<th>Total Selling</th>
										<th>Total Collection</th>
										<th>Total Overshort</th>
                                                         <?php if($logged_company['type'] == 'c'){ ?>    			<th>Action</th> <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
									$tempselling=0;
									$dtotaldselling=0; 
									$dtotaldsellingbuyprice=0; 
									$dtotaldsellingprice=0; 
									$totalexpence=0; 
									$dpurbenifit=0; 
									$dtotalbuy=0; 
									$dtotaldbuyvat=0; 
									$dtotaldsellingvat=0; 
									$dev=0;		 
									$devprice=0;																
									$ptotaldselling=0; 
									$ptotaldsellingbuyprice=0; 
									$ptotaldsellingprice=0; 
									$ppurbenifit=0; 
									$ptotalbuy=0; 
									$ptotaldbuyvat=0; 
									$ptotaldsellingvat=0; 
									$pev=0;
									$pevprice=0;									
									$oil_reading=0;									
									$oil_pure_benefit=0;		
									$d_testing=0;	 
									$p_testing=0;	
                                                                        $cash_on_hand = 0;
                                                                        $totalcard_fule = 0;
                                                                        $totalioc_fule = 0;
                                                                        $totalcredit_fule = 0;
$totalextracash_fule=0;
                                                                        $ostok = 0;
$oil_cgst=0;$oil_sgst=0;
									$cnt=0;
									foreach ($report as $r) {
										if((strtotime($sdate) <= strtotime($r['date'])) && $cnt == 0){
											$cnt++;
										}
										if($cnt == 0){
											$p_dstock = $r['dstock'];
$p_d_total_selling = $r['d_total_selling'];
$p_d_quantity = $r['d_quantity'];
$p_pstock = $r['pstock'];
$p_p_total_selling = $r['p_total_selling'];
$p_p_quantity = $r['p_quantity'];
										}else{
										?>
                                    <tr>
                                        <td>
										<?php if($logged_company['type'] == 'c'){ ?>
                                            <a href="<?php echo base_url()?>daily_reports/edit?date=<?php echo date('d-m-Y',strtotime($r['date'])); ?>&location=<?php echo $location; ?>&sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>"><?php echo date('d/m/Y',strtotime($r['date'])); ?></a>
										<?php }else{ ?>
											<?php echo date('d/m/Y',strtotime($r['date'])); ?>
										<?php  } ?>
                                        </td>
										<?php foreach($location_tank_list as $locationtank){ if($locationtank->fuel_type == 'd'){ ?>
										
										<td nowrap>
										<?php 
										
											if(isset($finaltank[$r['date']][$r['id']]['d'][$locationtank->id])){
												
													//echo $finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['name']." : ".
													echo $finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading'];
													//echo "<br>";
											}
										?>
										</td>
										<?php } } ?>
                                        <td>
                                            <?php echo round($r['dstock'],2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['d_total_selling'],2); $dtotaldselling = $dtotaldselling+$r['d_total_selling'];?>
                                        </td>
										<td>
                                            <?php echo round($r['d_testing'],2); $d_testing = $d_testing+$r['d_testing']; ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['d_total_selling']*$r['d_new_price'],2); 
											 //echo "(".$r['d_new_price'].")"; 
											$dtotaldsellingbuyprice = $dtotaldsellingbuyprice+($r['d_total_selling']*$r['d_new_price']); 
											
											?>
                                        </td>
                                        <td>
                                            <?php echo round($r['d_total_selling']*$r['dis_price'],2); //echo "(".$r['dis_price'].")"; 
											$dtotaldsellingprice = $dtotaldsellingprice+round($r['d_total_selling']*$r['dis_price'],2); 
											//echo "(".$r['dis_price'].")";
											?>
											
                                        </td>
                                        <td>
                                            <?php echo round($r['expence'],2); $totalexpence = $totalexpence+$r['expence'];?>
                                        </td>
                                        <td><?php //echo "(".$r['d_total_selling']."*".$r['dis_price'].")-(".$r['d_total_selling']."*".$r['d_new_price'].")-".$r['expence']."<br>";	$dpurbenifit = $dpurbenifit+ round(($r['d_total_selling']*$r['dis_price'])-($r['d_total_selling']*$r['d_new_price'])-$r['expence'],2)
										?>
                                            <?php echo round(($r['d_total_selling']*$r['dis_price'])-($r['d_total_selling']*$r['d_new_price'])-$r['expence'],2);	$dpurbenifit = $dpurbenifit+ round(($r['d_total_selling']*$r['dis_price'])-($r['d_total_selling']*$r['d_new_price'])-$r['expence'],2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['d_quantity'],2); $dtotalbuy = $dtotalbuy+$r['d_quantity']; ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['dv_taxamount'],2); $dtotaldbuyvat = $dtotaldbuyvat+$r['dv_taxamount'];?>
                                        </td>
                                        <td>
                                            <?php //echo round($r['d_sales_vat'],2); 
											echo round(((round($r['d_total_selling']*$r['dis_price'],2)*20)/120),2);
											//$dtotaldsellingvat = $dtotaldsellingvat+$r['d_sales_vat'];
											$dtotaldsellingvat = $dtotaldsellingvat+round(((round($r['d_total_selling']*$r['dis_price'],2)*20)/120),2);
											?>
                                        </td>
                                        <td>
                                            <?php 
											if($cnt == 0){
											echo $cdev = round($r['d_ev'],2); 
											}else{
												echo $cdev =  round($r['dstock']-(($p_dstock-$p_d_total_selling)+($p_d_quantity)),2);
												//echo "<br>"; echo $p_dstock."-".$p_d_total_selling."+".$p_d_quantity."-".$r['dstock'];
												}
												$dev = $dev+$cdev;
											?>
                                        </td>
										<td>
                                            <?php echo round($cdev*$r['dis_price'],2); $devprice = $devprice+($cdev*$r['dis_price']); ?>
                                        </td>
										<?php foreach($location_tank_list as $locationtank){ if($locationtank->fuel_type == 'p'){ ?>
										<td nowrap>
										<?php 
											if(isset($finaltank[$r['date']][$r['id']]['p'][$locationtank->id])){
												//foreach($finaltank[$r['date']][$r['id']]['p'] as $tankd){
													//echo $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['name']." : ".
													echo $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['deepreading'];
													//echo "<br>";
												//}												
											}
										?>
										</td>
										<?php } } ?>
                                        <td>
                                            <?php echo round($r['pstock'],2);?>
                                        </td>
                                        <td>
                                            <?php echo round($r['p_total_selling'],2); $ptotaldselling = $ptotaldselling+$r['p_total_selling'];?>
                                        </td>
										<td>
                                            <?php echo round($r['p_testing'],2); $p_testing = $p_testing+$r['p_testing'];?>
                                        </td>
                                        <td>
                                            <?php echo round($r['p_total_selling']*$r['p_new_price'],2); //echo "(".$r['bpprice'].")"; 
											$ptotaldsellingbuyprice = $ptotaldsellingbuyprice+($r['p_total_selling']*$r['p_new_price']); 
											//echo "(".$r['p_new_price'].")";
											?>
                                        </td>
                                        <td>
                                            <?php echo round($r['p_total_selling']*$r['pet_price'],2); //echo "(".$r['pet_price'].")"; 
											$ptotaldsellingprice = $ptotaldsellingprice + round($r['p_total_selling']*$r['pet_price'],2);
											//echo "(".$r['pet_price'].")";
											?>
                                        </td>
                                        <td>
                                            <?php echo round(($r['p_total_selling']*$r['pet_price'])-($r['p_total_selling']*$r['p_new_price']),2); 										
											$ppurbenifit = $ppurbenifit+ ($r['p_total_selling']*$r['pet_price'])-($r['p_total_selling']*$r['p_new_price']);										//$ppurbenifit = 0;?>
                                        </td>
                                        <td>
                                            <?php echo round($r['p_quantity'],2); $ptotalbuy = $ptotalbuy+$r['p_quantity']; ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['pv_taxamount']);
//											round(($r['p_total_selling']*$r['pet_price']*20)/120,2); 
											
											$ptotaldbuyvat = $ptotaldbuyvat+$r['pv_taxamount']; ?>
                                        </td>
                                        <td>
                                            <?php echo round(($r['p_total_selling']*$r['pet_price']*20)/120,2); $ptotaldsellingvat = $ptotaldsellingvat+round(($r['p_total_selling']*$r['pet_price']*20)/120,2); ?>
                                        </td>
                                        <td>
                                            <?php //echo round($r['p_ev'],2);  $pev = $pev+$r['p_ev']; 
											if($cnt == 0){
												echo $cdev = round($r['p_ev'],2); 
											}else{
												//echo $cdev =  round(($p_pstock-$p_p_total_selling+$p_p_quantity-$r['pstock']),2);
												echo $cdev =  round($r['pstock']-(($p_pstock-$p_p_total_selling)+($p_p_quantity)),2);
												//echo "<br>"; echo $p_dstock."-".$p_d_total_selling."+".$p_d_quantity."-".$r['dstock'];
											}
											$PETEV = $cdev;
											$pev = $pev+$cdev;
											
											?>
                                        </td>
										<td>
                                            <?php echo round($PETEV*$r['pet_price'],2); $pevprice = $pevprice+($PETEV*$r['pet_price']); ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['ostok'],2); ?>
                                        </td>
                                        <!--<td>
                                            <?php //echo round($r['oil_reading'],2);  $oil_reading = $oil_reading+$r['oil_reading']; ?>
                                        </td>-->
										<td>
                                            <?php echo round($oil_final_array[$r['date']]['sell'],2);   ?>
                                        </td>
										<td>
                                            <?php echo round($oil_final_array[$r['date']]['buy'],2);  $oil_reading = $oil_reading+$oil_final_array[$r['date']]['buy'];  ?>
                                        </td>
										
                                        <td>
                                            <?php echo round($oil_final_array[$r['date']]['buy'] - $oil_final_array[$r['date']]['sell'],2); $oil_pure_benefit = $oil_pure_benefit+($oil_final_array[$r['date']]['buy'] - $oil_final_array[$r['date']]['sell']); ?>
                                        </td>
										 <td>
                                            <?php echo round($r['oil_cgst']+$r['oil_sgst'],2); $oil_cgst = $oil_cgst + round($r['oil_cgst']+$r['oil_sgst'],2);?>
                                        </td>
										<td>
                                            <?php echo round((($r['oil_reading']*18)/118),2); $oil_sgst = $oil_sgst + round((($r['oil_reading']*18)/118),2);?>
                                        </td>
										
										<!--<td>
                                            <?php echo round($r['oil_sgst'],2);   ?>
                                        </td>-->
										<td>
                                            <?php echo round($r['cash_on_hand'],2);  ?>
                                        </td>
										<td>
                                            <?php echo round($r['totalcard_fule'],2);  ?>
                                        </td>
										<td>
                                            <?php echo round($r['totalioc_fule'],2);  ?>
                                        </td>
										<td>
                                            <?php echo round($r['totalextracash_fule'],2);  ?>
                                        </td>
										<td>
                                            <?php echo round($r['totalcredit_fule'],2);  ?>
                                        </td>
										<td>
                                            <?php echo round($r['totalcreditcash_fule'],2);  ?>
                                        </td>
										<!--<td>
											<?php echo $tcollection = round($r['cash_on_hand']+$r['totalcard_fule']+$r['totalioc_fule']+$r['totalcredit_fule']-$r['expence'],2);
											?>
										</td>-->
										<td>
										    <?php
$tcollection = round($r['cash_on_hand']+$r['totalcard_fule']+$r['totalioc_fule']+$r['totalcredit_fule']-$r['expence'],2); 
//echo ($r['d_total_selling']*$r['dis_price'])."+".($r['p_total_selling']*$r['pet_price'])."+".$r['oil_reading']."<br>";
											echo $x = $tsell = round(($r['d_total_selling']*$r['dis_price'])+(($r['p_total_selling']*$r['pet_price']))+$r['oil_reading'],2);
											?> 
										</td>
										<td>
											<?php 
											//echo $r['cash_on_hand']."+".$r['totalcard_fule']."+".$r['totalioc_fule']."+".$r['totalextracash_fule']."+".round($r['totalcredit_fule'],2)."+".$r['expence']."<br>";
											//$tempselling = $tempselling + round($r['salary_admount']+$r['extra_amount']+$r['loan_amount']+$r['extra_salary']);
										//	echo $y = round($r['salary_admount']+$r['extra_amount']+$r['loan_amount']+$r['extra_salary']+$r['cash_on_hand']+$r['totalcard_fule']+$r['totalioc_fule']+$r['totalextracash_fule']+$r['totalcredit_fule']+$r['expence'],2) ;
											?>
											<?php 
											//echo $r['cash_on_hand']."+".$r['totalcard_fule']."+".$r['totalioc_fule']."+".$r['totalextracash_fule']."+".round($r['totalcredit_fule'],2)."+".$r['expence']."<br>";
											$tempselling = $tempselling + round($r['salary_admount']+$r['extra_amount']+$r['loan_amount']+$r['extra_salary']);
											echo $y = round($r['salary_admount']+$r['extra_amount']+$r['loan_amount']+$r['extra_salary']+$r['cash_on_hand']+$r['totalcard_fule']+$r['totalioc_fule']+$r['totalextracash_fule']+$r['totalcredit_fule']+$r['expence'],2) ;
											//echo $r['petty_cash_credit_total'];
											?>
											</td>
										<td>
										    <?php echo round(($y-$x),2); ?>
										</td>
									     <?php if($logged_company['type'] == 'c'){ ?>   	<td>
										    <a href="<?php echo base_url()?>daily_reports/edit?date=<?php echo date('d-m-Y',strtotime($r['date'])); ?>&location=<?php echo $location; ?>&sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>">View</a>
                                                                             </td> <?php } ?>
                                    </tr>
                                    <?php 
$p_dstock = $r['dstock'];
$p_d_total_selling = $r['d_total_selling'];
$p_d_quantity = $r['d_quantity'];
$p_pstock = $r['pstock'];
$p_p_total_selling = $r['p_total_selling'];
$p_p_quantity = $r['p_quantity'];
$cash_on_hand = $r['cash_on_hand']+$cash_on_hand;
$totalcard_fule = $r['totalcard_fule']+$totalcard_fule;
$totalioc_fule = $r['totalioc_fule']+$totalioc_fule;
$totalcredit_fule = $r['totalcredit_fule']+$totalcredit_fule;	
$totalextracash_fule = $r['totalextracash_fule']+$totalextracash_fule;								}
$cnt++;
											}?>
                                    <tr>
                                        <td>Total</td>
										<?php foreach($location_tank_list as $locationtank){ if($locationtank->fuel_type == 'd'){ ?>
										<th><?php echo $locationtank->tank_name; ?></th>
										<?php } } ?>
                                        <th style="color:blue"><b>Diesel</b></th>
										
                                        <td>
                                            <?php echo round($dtotaldselling,2);?>
                                        </td>
										 <td>
                                            <?php echo round($d_testing,2);?>
                                        </td>
                                        <td>
                                            <?php echo round($dtotaldsellingbuyprice,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($dtotaldsellingprice,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($totalexpence,2);?>
                                        </td>
                                        <td>
                                            <?php echo round($dpurbenifit,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($dtotalbuy,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($dtotaldbuyvat,2);?>
                                        </td>
                                        <td>
                                            <?php echo round($dtotaldsellingvat,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($dev,2);?>
                                        </td>
										<td>
                                            <?php echo round($devprice,2);?>
                                        </td>
										<?php foreach($location_tank_list as $locationtank){ if($locationtank->fuel_type == 'p'){ ?>
										<th><?php echo $locationtank->tank_name; ?></th>
										<?php } } ?>
                                        <th style="color:green"><b>Petrol</b></th>
                                        <td>
                                            <?php echo round($ptotaldselling,2);?>
                                        </td>
										<td>
                                            <?php echo round($p_testing,2);?>
                                        </td>
                                        <td>
                                            <?php echo round($ptotaldsellingbuyprice,2);?>
                                        </td>
                                        <td>
                                            <?php echo round($ptotaldsellingprice,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($ppurbenifit,2);?>
                                        </td>
                                        <td>
                                            <?php echo round($ptotalbuy,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($ptotaldbuyvat,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($ptotaldsellingvat,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($pev,2); ?>
                                        </td>
										<td>
                                            <?php echo round($pevprice,2);?>
                                        </td>
                                        <th style="color:red"><b>Oil</b></th>
										<td>
										</td>
                                        <td>
                                            <?php echo round($oil_reading,2); ?>
                                        </td>
										
                                        <td>
                                            <?php echo round($oil_pure_benefit,2); ?>
                                        </td>
										 <td>
                                            <?php echo round($oil_cgst,2); ?>
                                        </td>
										<td>
                                            <?php echo round($oil_sgst,2); ?>
                                        </td>
                                        					<td>
                                            <?php echo round($cash_on_hand,2); ?>
                                        </td>
                                         
                                            <td>
                                            <?php echo round($totalcard_fule,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($totalioc_fule,2); ?>
                                        </td>
					<td>
                                            <?php echo round($totalextracash_fule,2); ?>
                                        </td>
                                         
					<td>
                                            <?php echo round($totalcredit_fule,2); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
						<?php $totalsalary=0; foreach($salary as $salary_detail){  
						 $totalsalary = $totalsalary+$salary_detail->salary; } 
						 
						 $paidvat = round($dtotaldbuyvat+$ptotaldbuyvat,2);
						 $vat = $paidvat + $oilgst;
						 $oilgst = $oil_sgst-$oil_cgst;
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
                                                    <?php echo round($totalprofit = $dpurbenifit+$ppurbenifit+$oil_pure_benefit,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total Salary</th>
                                                <td>
                                                    <?php echo round($totalsalary,2);
													//echo "<br>"; echo $tempselling;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Vat</th>
                                                <td>
                                                    <?php echo round($vat = $dtotaldsellingvat+$ptotaldsellingvat,2);?>
                                                </td>
                                            </tr>
											
                                            <tr>
                                                <th>Paid Vat</th>
                                                <td>
                                                    <?php echo $paidvat;?>
                                                </td>
                                            </tr>
											<tr>
                                                <th>Payble vat</th>
                                                <td>
                                                    <?php  echo $payblval = round($vat - $paidvat,2);?>
                                                </td>
                                            </tr>
											
											
											<tr>
                                                <th>GST</th>
                                                <td>
												<?php echo round($oil_sgst,2); ?>
                                                    
                                                </td>
                                            </tr>
											
                                            <tr>
                                                <th>Paid GST</th>
                                                <td>
                                                    <?php echo round($oil_cgst,2); ?> 
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
                                                    <?php echo round($totalprofit - $totalsalary - $payblval - $oilgst,2);?>
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
                                            <?php $salaryadvance = 0; $cnt=1; $totalsalary=0; $totalbonas=0; foreach($salary as $salary_detail){  ?>
                                            <tr>
                                                <th>
                                                    <?php echo $salary_detail->code; $cnt++; ?>
                                                </th>
                                                <th>
                                                    <?php echo $salary_detail->name; ?>
                                                </th>
                                                <th>
                                                    <?php echo round($salary_detail->salary,2); $totalsalary = $totalsalary+$salary_detail->salary; ?>
                                                </th>
												<th>
                                                    <?php echo round($salary_detail->bonas,2); $totalbonas= $totalbonas+$salary_detail->bonas; ?>
                                                </th>
                                                <th>
                                                    <?php echo round($salary_detail->totaldebit,2); ?>
                                                </th>

                                                <th>
                                                    <?php echo round($salary_detail->salary-$salary_detail->totaldebit,2); $salaryadvance = $salaryadvance+$salary_detail->salary-$salary_detail->totaldebit; ?>
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
                                                    <?php //echo $lastday->petrol;
													$finaltemptotal = 0;
													//echo "(".$r['pstock']."-".$r['p_total_selling']."+".$r['p_quantity'].")*".$r['p_new_price']."<br>";
													echo round(((($r['pstock']-$r['p_total_selling'])+($r['p_quantity']))*($r['p_new_price'])),2);
													//echo "<br>(".$r['pstock']."-".$r['p_total_selling']."+".$r['p_quantity'].")*".$r['p_new_price'].")";
													//$finaltemptotal = $finaltemptotal +(($r['pstock']-$r['p_total_selling']+$r['p_quantity'])*$r['p_new_price']);
													//echo "(".$r['p_new_price'].")";
													$finaltemptotal = $finaltemptotal +round(($r['pstock']-$r['p_total_selling']+$r['p_quantity'])*$r['p_new_price'],2);
													echo "<br>".$finaltemptotal;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Diesel</th>
                                                <td>
                                                    <?php //echo $lastday->diesel;
													if($_GET['ddd'] == 1){ echo $r['dstock']."-".$r['d_total_selling']."+".$r['d_quantity'].")*".$r['d_new_price']."<br>"; }
													echo round(($r['dstock']-$r['d_total_selling']+$r['d_quantity'])*$r['d_new_price'],2);
													//echo "(".$r['d_new_price'].")";
												//	echo "((".$r['dstock']."-".$r['d_total_selling']."+".$r['d_quantity'].")*".$r['d_new_price'].")";
													//$finaltemptotal = $finaltemptotal +(($r['dstock']-$r['d_total_selling']+$r['d_quantity'])*$r['d_new_price']);
													$finaltemptotal = $finaltemptotal +round(($r['dstock']-$r['d_total_selling']+$r['d_quantity'])*$r['d_new_price'],2);
													//echo "(".$r['dstock']."-".$r['d_total_selling']."+".$r['d_quantity'].")*".$r['d_new_price'];
													echo "<br>".$finaltemptotal;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Oil</th>
                                                <td>
                                                    <?php //echo //$lastday->oil;
													echo round($r['ostok']-$r['oil_reading'],2);
													//$finaltemptotal = $finaltemptotal +$r['ostok']-$r['oil_reading'];
													$finaltemptotal = $finaltemptotal +round($r['ostok']-$r['oil_reading'],2);
													echo "<br>".$finaltemptotal;
													?>
                                                </td>
                                            </tr>
                                            <!--<tr>
                                                <th>Axis Bank</th>
                                                <td>
                                                    <?php echo round($lastday->axis_bank,2);?>
                                                </td>
                                            </tr>-->
                                            <tr>
                                                <th>Remaining Worker Loan</th>
                                                <td>
                                                    <?php //echo $lastday->advance_pay;
													//echo "00";
													echo round($loansalary->loanamont-$loansalary->paid_loan_amount,2); 
													//$finaltemptotal = $finaltemptotal +round($loansalary->loanamont-$loansalary->paid_loan_amount,2);
													$finaltemptotal = $finaltemptotal +round($loansalary->loanamont-$loansalary->paid_loan_amount,2); 
													echo "<br>".$finaltemptotal;
													?>
                                                </td>
                                            </tr>
											<!--<tr>
                                                <th>Previous Bank Balance</th>
                                                <td>
                                                    <?php
//print_r($pre_deposit_amount); print_r($prev_card_depost); 
//echo round(($pre_deposit_amount->cash_total+$pre_deposit_amount->cheque_total+round($prev_card_depost,2))-($pre_onlinetransaction->total_onlinetransaction),2)

?>
                                                </td>
                                            </tr>-->
                                            <tr>
                                                <th>Bank Balance </th>
                                                <td>
                                                    <?php
//echo $deposit_amount->cash_total."+".$deposit_amount->cheque_total."+".round($totalcard_fule,2)."-".$onlinetransaction->total_onlinetransaction."<br>";
//echo $bank_balence = round(($deposit_amount->cash_total+$deposit_amount->cheque_total+round($totalcard_fule,2))-($onlinetransaction->total_onlinetransaction),2);                   

//$bank_balence = ($deposit_amount->cash_total)-($deposit_amount->cheque_total+$onlinetransaction->total_onlinetransaction);

//echo $pre_deposit_amount->cash_total."+".$pre_cheq_deposit_amount->cheque_total."+".$pre_deposit_wallet_amount->wallet_extra_total."+".$prev_card_depost->total."-".$pre_onlinetransaction->total_onlinetransaction."<br>";
echo $bank_balence = ($pre_deposit_amount->cash_total+$pre_cheq_deposit_amount->cheque_total+$pre_deposit_wallet_amount->wallet_extra_total+$prev_card_depost->total+$petty_cash_deposit_list->total)-($pre_onlinetransaction->total_onlinetransaction+$prev_petty_cash_withdrawal->total);
//echo $bank_balence = round(($deposit_amount->cash_total+$pre_cheq_deposit_amount->cheque_total+$totalcard_fule+$pre_deposit_amount->cash_total+$pre_deposit_amount->cheque_total+$prev_card_depost->total+$prev_extra_depost->total+$totalextracash_fule)-($onlinetransaction->total_onlinetransaction+$pre_onlinetransaction->total_onlinetransaction),2);
// echo "<br>totaldipostcash=".$deposit_amount->cash_total."<br>totaldipostcheque=".$deposit_amount->cheque_total."<br>totalsales on card =".$totalcard_fule."<br>pretotaldipostcash=".$pre_deposit_amount->cash_total."<br>pretotaldipostcheque=".$pre_deposit_amount->cheque_total."<br>pretotal saleson card=".$prev_card_depost->total."<br>pretotalextra=".$prev_extra_depost->total."<br>totalextra=".$totalextracash_fule."<br>totalonline =".$onlinetransaction->total_onlinetransaction."<br>pretotalonline=".$pre_onlinetransaction->total_onlinetransaction;
$finaltemptotal = $finaltemptotal +$bank_balence ;
echo "<br>".$finaltemptotal;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Rewards Card Balance (Company)</th>
                                                <td>
                                                    <?php //echo round($lastday->ioc_amount,2);
													//echo round($ioc_balence->total,2); 
													//$finaltemptotal = $finaltemptotal +$ioc_balence->total;
													//$finaltemptotal = $finaltemptotal +$lastday->ioc_amount;
													
													echo round(($prv_ioc_total->totalamount+$prv_transection_total->totalamount)-($prv_purchase_total->p_total_amount+$prv_purchase_total->d_total_amount),2); 
													//$finaltemptotal = $finaltemptotal + round(($prv_ioc_total->totalamount+$prv_transection_total->totalamount)-($prv_purchase_total->p_total_amount+$prv_purchase_total->d_total_amount),2);
													$finaltemptotal = $finaltemptotal + round(($prv_ioc_total->totalamount+$prv_transection_total->totalamount)-($prv_purchase_total->p_total_amount+$prv_purchase_total->d_total_amount),2);
													echo "<br>".$finaltemptotal;
													
													?>
													<?php if($logged_company['type'] == 'c'){ ?> <!--     <a href="<?php echo base_url()?>daily_reports/last_day_entry?sdate=<?php echo $sdate ; ?>&edate=<?php echo $edate; ?>&location=<?php echo $location; ?>"><i class="fa fa-edit"></i></a>--> <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Cash On Hand</th>
                                                <td>
                                                    <?php 
													echo round($lastday->cash_on_hand,2);
													//$finaltemptotal = $finaltemptotal +$lastday->cash_on_hand;
													$finaltemptotal = $finaltemptotal + round($lastday->cash_on_hand,2);
													echo "<br>".$finaltemptotal;
													?>
                                                  <?php if($logged_company['type'] == 'c'){ ?>      <a href="<?php echo base_url()?>daily_reports/last_day_entry?sdate=<?php echo $sdate ; ?>&edate=<?php echo $edate; ?>&location=<?php echo $location; ?>"><i class="fa fa-edit"></i></a> <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><!--Debite-->Credit</th>
                                                <td>
                                                    <?php // echo $lastday->debit;?>
													<?php 
													// print_r($get_credit->total);
													// echo "<br>here ";
													
													// print_r($get_debit->total);
													echo round($get_credit->total-$get_debit->total,2);
													//echo round($get_customer_credit->totalamount,2);  ///round($get_customer_credit->totalamount-$get_customer_debit->totalamount,2);
//$finaltemptotal = $finaltemptotal +$get_customer_credit->totalamount-$get_customer_debit->totalamount;
//$finaltemptotal = $finaltemptotal +$get_customer_credit->totalamount;
                                                      $finaltemptotal = $finaltemptotal + round($get_credit->total-$get_debit->total,2);
													  echo "<br>".$finaltemptotal;
													  $payblval = round($vat - $paidvat,2);
													?>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Personal Credit Debit</th>
                                                <td>
                                                    <?php echo round($personal_debite_credit,2);
													//echo round($lastday->credit,2);
													//$finaltemptotal = $finaltemptotal + $lastday->credit;
													//$finaltemptotal = $finaltemptotal + round($lastday->credit,2);
													$finaltemptotal = $finaltemptotal - round($petty_cash_deposit_list_cash->total,2);
													echo "<br>".$finaltemptotal;
													?>
                                                  <?php if($logged_company['type'] == 'c'){ ?>    	     
												  <!--<a href="<?php echo base_url()?>daily_reports/last_day_entry?sdate=<?php echo $sdate ; ?>&edate=<?php echo $edate; ?>&location=<?php echo $location; ?>"><i class="fa fa-edit"></i></a> -->
												  <?php } ?>
                                                </td>
                                            </tr>
<!--											<tr>
                                                <th>Personal DebitCredit</th>
                                                <td>
                                                    <?php echo round($prev_petty_cash_withdrawal_cash->total,2);
													//echo round($lastday->debit,2);
													//$finaltemptotal = $finaltemptotal + $lastday->debit;
													//$finaltemptotal = $finaltemptotal - round($lastday->debit,2);
													$finaltemptotal = $finaltemptotal + round($prev_petty_cash_withdrawal_cash->total,2);
													echo "<br>".$finaltemptotal;
													?>
                                               <?php if($logged_company['type'] == 'c'){ ?>
											   <a href="<?php echo base_url()?>daily_reports/last_day_entry?sdate=<?php echo $sdate ; ?>&edate=<?php echo $edate; ?>&location=<?php echo $location; ?>"><i class="fa fa-edit"></i></a>
 <?php } ?>
                                                </td>
                                            </tr>-->
                                            <tr>
                                                <th>Total Stock</th>
                                                <td>
                                                    <?php echo round($finaltemptotal,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Budget</th>
                                                <td>
                                                    <?php echo round($lastday->budget,2);?>
                                             <?php if($logged_company['type'] == 'c'){ ?>    	         <a href="<?php echo base_url()?>daily_reports/last_day_entry?sdate=<?php echo $sdate ; ?>&edate=<?php echo $edate; ?>&location=<?php echo $location; ?>"><i class="fa fa-edit"></i></a> <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Salary</th>
                                                <td>
                                                    <?php echo round($totalsalary,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Vat</th>
                                                <td>
                                                    <?php //echo $payblval."+".$oil_cgst."<br>"; 
													echo $vat = $payblval+$oilgst;
													//echo round($vat,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Pure Benefits</th>
                                                <td>
                                                    <?php

													//echo round($totalprofit - $totalsalary - $vat - $paidvat + $oilgst,2);?>
													<?php echo $pb= round($totalprofit - $totalsalary - $payblval - $oilgst,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Mis Match</th>
                                                <td>
                                                    <?php
                                                    
                                                    //echo $finaltemptotal."-(".$pb."+".$vat."+".$totalsalary."+".$lastday->budget.")<br><br>";
													echo round($finaltemptotal-($pb+$vat+$totalsalary+$lastday->budget),2);
													// echo round($lastday->mis_match,2);?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                </div>
                            
							<div class="col-md-6">
                                <!--<div class="title-h1">
                                    <h3>Expense</h3>
                                </div>
                                <div class="bdr js-scroll">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Expense</th>
                                                <th>Reson</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $cnt=1; $totalexpence=0; foreach($monthly_expence as $monthly_expence_detail){  ?>
                                            <tr>
                                                <th>
                                                    <?php echo date('d/m/Y',strtotime($monthly_expence_detail->date)); ?>
                                                </th>
                                                <th>
                                                    <?php echo round($monthly_expence_detail->amount,2); $totalexpence=$totalexpence+$monthly_expence_detail->amount; ?>
                                                </th>
                                                <th>
                                                    <?php echo $monthly_expence_detail->reson; ?>
                                                </th>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <th>Total</th>
                                                <th>
                                                    <?php echo round($totalexpence,2); ?>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>-->
                            </div>
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
    <script src="<?php echo base_url();?>assets1/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
        (function($) {
            $(window).on("load", function() {
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
        document.forms['savingdata'].action='<?php echo base_url();?>daily_reports/print_pdf';
        document.forms['savingdata'].submit();
    
}
   function SubmitForm()
{   
    
        document.forms['savingdata'].action='<?php echo base_url();?>daily_reports/index';
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