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
    <!-- //lined-icons -->
    <!-- chart -->
    <!-- //chart -->
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
                    <h3 class="blank1 pull-left" style="">Sales Report</h3>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="horizontal-form">
                        <form class="form-horizontal" method="get" action="<?php echo base_url();?>sales_reports/index" name="savingdata" onsubmit="return validate()">

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
                                    <input type="submit" name="search" class="btn-success btn" value="Search" name="search">
									<a href="<?php base_url();?>print_report?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&location_id=<?php echo $location;?>" target="_blank" class="btn-success btn">Print</a>
                                </div>
                                <div class="col-sm-2">
									
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <!--<th>Selling</th>-->
                                        <th>Diesel Selling</th>
                                        <!--<th>Selling</th>-->
                                        <th>Petrol Selling</th>
                                        <th>Oil Selling</th>
										<th>Total Selling</th>
										<th>Sales on Cash</th>
										<th>Sales on Card</th>
										<th>Sales on Rewards card</th>
										<th>Sales on Debit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
									$dtotaldsellingprice=0; 
									$ptotaldsellingprice=0; 
									$oil_reading=0;									
									$totalselling = 0;
									$totalcash = 0;
									$totalcard = 0;
									$totalioc = 0;
									$totalcredit = 0;
									foreach ($report as $r) {?>
                                    <tr>
                                        <td>
                                            <?php echo date('d/m/Y',strtotime($r['date'])); ?>
                                        </td>
                                        <!--<td>
                                            <?php echo round($r['d_total_selling'],2); $dtotaldselling = $dtotaldselling+$r['d_total_selling'];?>
                                        </td>-->
                                        <td>
                                            <?php echo round($r['d_total_selling']*$r['dis_price'],2); //echo "(".$r['dis_price'].")"; 
											$dtotaldsellingprice = $dtotaldsellingprice+round($r['d_total_selling']*$r['dis_price'],2); ?>
                                        </td>
                                        <!--<td>
                                            <?php echo round($r['p_total_selling'],2); $ptotaldselling = $ptotaldselling+$r['p_total_selling'];?>
                                        </td>-->
                                        <td>
                                            <?php echo round($r['p_total_selling']*$r['pet_price'],2); //echo "(".$r['pet_price'].")"; 
											$ptotaldsellingprice = $ptotaldsellingprice + round($r['p_total_selling']*$r['pet_price'],2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['oil_reading'],2);  $oil_reading = $oil_reading+$r['oil_reading']; ?>
                                        </td>
										<td>
											<?php echo $tselling = round($r['d_total_selling']*$r['dis_price'],2)+round($r['p_total_selling']*$r['pet_price'],2)+round($r['oil_reading'],2);  $totalselling = $totalselling + $tselling;
											?>
										</td>
										<td>
                                            <?php echo round($r['cash_on_hand'],2); $totalcash = $totalcash + round($r['cash_on_hand'],2);  ?>
                                        </td>
										<td>
                                            <?php echo round($r['totalcard_fule'],2); $totalcard = $totalcard + round($r['totalcard_fule'],2); ?>
                                        </td>
										<td>
                                            <?php echo round($r['totalioc_fule'],2); $totalioc = $totalioc + round($r['totalioc_fule'],2); ?>
                                        </td>
										<td>
                                            <?php echo round($r['totalcredit_fule'],2); $totalcredit = $totalcredit + round($r['totalcredit_fule'],2); ?>
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
                                        <!--<td>
                                            <?php echo round($dtotaldselling,2);?>
                                        </td>-->
										<td>
                                            <?php echo round($dtotaldsellingprice,2); ?>
                                        </td>
                                        <!--<td>
                                            <?php echo round($ptotaldselling,2);?>
                                        </td>-->
										 <td>
                                            <?php echo round($ptotaldsellingprice,2); ?>
                                        </td>
                                        <td>
                                            <?php echo round($oil_reading,2); ?>
                                        </td>
                                        <td>
											<?php echo $totalselling; ?>
										</td>
										
										<td>
											<?php echo $totalcash; ?>
										</td>
										<td>
											<?php echo $totalcard; ?>
										</td>
										<td>
											<?php echo $totalioc; ?>
										</td>
										<td>
											<?php echo $totalcredit; ?>
										</td>
                                    </tr>
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