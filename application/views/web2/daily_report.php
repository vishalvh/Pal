<!DOCTYPE HTML>
<html>

<head>
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
    <title>Shri Hari</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets1/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets1/css/style.css" rel='stylesheet' type='text/css' />
    <!-- Graph CSS -->
    <link href="<?php echo base_url();?>assets1/css/font-awesome.css" rel="stylesheet">
    <!-- jQuery -->
    <!-- lined-icons -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets1/css/icon-font.min.css" type='text/css' />
    <link rel="stylesheet" href="<?php echo base_url();?>assets1/css/jquery.mCustomScrollbar.min.css" type='text/css' />
    <!--animate-->
    <link href="<?php echo base_url();?>assets1/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(); ?>assets1/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
</head>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>

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

<body class="sticky-header left-side-collapsed">
    <section>
        <!-- left side start-->
        <?php $this->load->view('web/left');?>
        <!-- left side end-->

        <!-- main content start-->
        <div class="main-content">
            <!-- header-starts -->
            <?php $this->load->view('web/header');?>
            <!-- //header-ends -->
            <div id="page-wrapper">
                <div class="page-header">
                    <h3 class="blank1 pull-left" style="">Daily Report</h3>
                </div>
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
                        <form class="form-horizontal" method="get" action="<?php echo base_url();?>daily_reports/index" name="savingdata" onsubmit="return validate()">

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
                                    <input type="submit" name="search" class="btn-success btn" value="Search" name="search">

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
                                        <th>Oil Selling Amount</th>
                                        <th>Oil Pure Benefit</th>
										<th>Oil Buying GST</th>
										<th>Oil Selling GST</th>
										<th>Cash on hand</th>
										<th>Pay by Card</th>
										<th>Pay By Ioc</th>
										<th>Sales on Debite</th>
										<th>Received From Customer</th>
										<th>Today Sell collection</th>
										<th>Total Selling</th>
										<th>Today Total Collection</th>
										<th>Total Overshort</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
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
$oil_cgst=0;$oil_sgst=0;
									
									foreach ($report as $r) {?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url()?>daily_reports/edit?date=<?php echo date('d-m-Y',strtotime($r['date'])); ?>&location=<?php echo $location; ?>"><?php echo date('d/m/Y',strtotime($r['date'])); ?></a>
                                        </td>
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
                                            <?php echo round($r['d_total_selling']*$r['d_new_price'],2); // echo "(".$r['bdprice'].")"; 
											$dtotaldsellingbuyprice = $dtotaldsellingbuyprice+($r['d_total_selling']*$r['d_new_price']); ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['d_total_selling']*$r['dis_price'],2); //echo "(".$r['dis_price'].")"; 
											$dtotaldsellingprice = $dtotaldsellingprice+round($r['d_total_selling']*$r['dis_price'],2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['expence'],2); $totalexpence = $totalexpence+$r['expence'];?>
                                        </td>
                                        <td>
                                            <?php echo round(($r['d_total_selling']*$r['dis_price'])-($r['d_total_selling']*$r['d_new_price'])-$r['expence'],2);	$dpurbenifit = $dpurbenifit+ round(($r['d_total_selling']*$r['dis_price'])-($r['d_total_selling']*$r['d_new_price'])-$r['expence'],2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['d_quantity'],2); $dtotalbuy = $dtotalbuy+$r['d_quantity']; ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['dv_taxamount'],2); $dtotaldbuyvat = $dtotaldbuyvat+$r['dv_taxamount'];?>
                                        </td>
                                        <td>
                                            <?php echo round($r['d_sales_vat'],2); $dtotaldsellingvat = $dtotaldsellingvat+$r['d_sales_vat']; ?>
                                        </td>
                                        <td>
                                            <?php 
											if($cnt == 0){
											echo $cdev = round($r['d_ev'],2); 
											}else{
												echo $cdev =  round(($p_dstock-$p_d_total_selling+$p_d_quantity-$r['dstock']),2);
												//echo "<br>"; echo $p_dstock."-".$p_d_total_selling."+".$p_d_quantity."-".$r['dstock'];
												}
												$dev = $dev+$cdev;
											
											?>
                                        </td>
										<td>
                                            <?php echo round($cdev*$r['dis_price'],2); $devprice = $devprice+($cdev*$r['dis_price']); ?>
                                        </td>
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
											$ptotaldsellingbuyprice = $ptotaldsellingbuyprice+($r['p_total_selling']*$r['p_new_price']);?>
                                        </td>
                                        <td>
                                            <?php echo round($r['p_total_selling']*$r['pet_price'],2); //echo "(".$r['pet_price'].")"; 
											$ptotaldsellingprice = $ptotaldsellingprice + round($r['p_total_selling']*$r['pet_price'],2); ?>
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
												echo $cdev =  round(($p_pstock-$p_p_total_selling+$p_p_quantity-$r['pstock']),2);
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
                                        <td>
                                            <?php echo round($r['oil_reading'],2);  $oil_reading = $oil_reading+$r['oil_reading']; ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['oil_pure_benefit'],2); $oil_pure_benefit = $oil_pure_benefit+$r['oil_pure_benefit']; ?>
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
                                            <?php echo round($r['totalcredit_fule'],2);  ?>
                                        </td>
										<td>
                                            <?php echo round($r['totalcreditcash_fule'],2);  ?>
                                        </td>
										<td>
											<?php echo $tcollection = round($r['cash_on_hand']+$r['totalcard_fule']+$r['totalioc_fule']+$r['totalcredit_fule']-$r['expence'],2);
											?>
										</td>
										<td>
										    <?php echo $x = $tsell = round(($r['d_selling_price'])+($r['p_selling_price'])+$r['oil_reading'],2);
											?>
										</td>
										<td>
											<?php echo $y = $tcollection - round($r['totalcreditcash_fule'],2) ;
											?>
											</td>
										<td>
										    <?php echo round(($y-$x),2); ?>
										</td>
										<td>
										    <a href="<?php echo base_url()?>daily_reports/edit?date=<?php echo date('d-m-Y',strtotime($r['date'])); ?>&location=<?php echo $location; ?>">View</a>
										</td>
                                    </tr>
                                    <?php
$p_dstock = $r['dstock'];
$p_d_total_selling = $r['d_total_selling'];
$p_d_quantity = $r['d_quantity'];
$p_pstock = $r['pstock'];
$p_p_total_selling = $r['p_total_selling'];
$p_p_quantity = $r['p_quantity'];
$cnt++;
									}?>
                                    <tr>
                                        <td>Total</td>
                                        <td>Diesel</td>
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
                                        <td>Petrol</td>
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
                                        <td>Oil</td>
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
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="row">
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
													echo round(($r['pstock']-$r['p_total_selling']+$r['p_quantity'])*$r['p_new_price'],2);
													$finaltemptotal = $finaltemptotal +(($r['pstock']-$r['p_total_selling']+$r['p_quantity'])*$r['p_new_price']);
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Diesel</th>
                                                <td>
                                                    <?php //echo $lastday->diesel;
													echo round(($r['dstock']-$r['d_total_selling']+$r['d_quantity'])*$r['d_new_price'],2);
													$finaltemptotal = $finaltemptotal +(($r['dstock']-$r['d_total_selling']+$r['d_quantity'])*$r['d_new_price']);
													//echo "(".$r['dstock']."-".$r['d_total_selling']."+".$r['d_quantity'].")*".$r['d_new_price'];
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Oil</th>
                                                <td>
                                                    <?php //echo //$lastday->oil;
													echo round($r['ostok']-$r['oil_reading'],2);
													$finaltemptotal = $finaltemptotal +$r['ostok']-$r['oil_reading'];
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
                                                <th>Advance</th>
                                                <td>
                                                    <?php //echo $lastday->advance_pay;
													echo round($salaryadvance,2); 
													$finaltemptotal = $finaltemptotal +$salaryadvance;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Bank Balance</th>
                                                <td>
                                                    <?php echo round($deposit_amount->cash_total+$deposit_amount->cheque_total-$onlinetransaction->total_onlinetransaction,2);
$finaltemptotal = $finaltemptotal +$deposit_amount->cash_total+$deposit_amount->cheque_total-$onlinetransaction->total_onlinetransaction;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>IOC Balance</th>
                                                <td>
                                                    <?php echo round($ioc_balence->total,2); 
													$finaltemptotal = $finaltemptotal +$ioc_balence->total;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Cash On Hand</th>
                                                <td>
                                                    <?php echo round($lastday->cash_on_hand,2);
													$finaltemptotal = $finaltemptotal +$lastday->cash_on_hand;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Debite</th>
                                                <td>
                                                    <?php // echo $lastday->debit;?>
													<?php echo round($get_customer_credit->totalamount,2);  ///round($get_customer_credit->totalamount-$get_customer_debit->totalamount,2);
//$finaltemptotal = $finaltemptotal +$get_customer_credit->totalamount-$get_customer_debit->totalamount;
$finaltemptotal = $finaltemptotal +$get_customer_credit->totalamount;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Credit</th>
                                                <td>
                                                    <?php echo round($lastday->credit,2);
													$finaltemptotal = $finaltemptotal + $lastday->credit;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td>
                                                    <?php echo round($finaltemptotal,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Budget</th>
                                                <td>
                                                    <?php echo round($lastday->budget,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Salary</th>
                                                <td>
                                                    <?php echo round($totalsalary,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>vat</th>
                                                <td>
                                                    <?php echo round($vat - $paidvat + $oilgst,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Pure Benefite</th>
                                                <td>
                                                    <?php echo round($totalprofit - $totalsalary - $vat - $paidvat + $oilgst,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Mis Match</th>
                                                <td>
                                                    <?php echo round($lastday->mis_match,2);?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
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
												<?php $salaryadvance = 0; $cnt=1; $totalsalary=0; $totalbonas=0; foreach($salary as $salary_detail){  ?>
												<?php $totalsalary = $totalsalary+$salary_detail->salary; } ?>
                                                    <?php echo round($totalprofit = $dpurbenifit+$ppurbenifit+$oil_pure_benefit,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total Salary</th>
                                                <td>
                                                    <?php echo round($totalsalary,2);?>
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
                                                    <?php echo round($paidvat = $dtotaldbuyvat+$ptotaldbuyvat,2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Oil GST</th>
                                                <td>
                                                    <?php 
													echo $oilgst = $oil_sgst-$oil_cgst;
													//echo round($oilgst = $oil_reading*18/118,2)-$oil_cgst-$oil_sgst;
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Payble vat</th>
                                                <td>
                                                    <?php  echo $payblval = round($vat - $paidvat,2);?>
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
                                    <h3>Salary</h3>
                                </div>
                                <div class="bdr js-scroll">
                                    <table class="table">
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
    </script>
</body>

</html>