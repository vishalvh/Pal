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

<style>
    .dataTables_filter {
        display: none;
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
<!-- left side start-->

<!-- left side end-->

<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <form method="post" action="<?php echo base_url(); ?>admin/add">			
            <h3 class="blank1" style="margin-top: -20px;">Profit Loss Report</h3>
        </form>
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
                            <button class="btn btn-primary"  type="submit" >Search</button>
                            
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <hr>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="get" action="" name="savingdata" >
					<div class="form-group col-sm-12">
                        <hr>
                        <div class="col-md-2">
							<div class="title-h1">
								<h3>Start Date</h3>
							</div>
                            <?php echo date("d-m-Y", strtotime($sdate)); ?>
                        </div>
                        <div class="col-sm-2">
							<div class="title-h1">
								<h3>End Date</h3>
							</div>
                            <?php echo date("d-m-Y", strtotime($edate)); ?>
                        </div>
                        <div class="col-sm-2">
							<div class="title-h1">
								<h3>Profit</h3>
							</div>
                            <?php 
							$tempgst = $oil_sgst+$oil_cgst-$sgst;
							if($tempgst > 0){
								echo number_format(($companybalnce)+$totalprofit-$totalsalary-(($dtotaldsellingvat+$ptotaldsellingvat)-($dtotaldbuyvat + $ptotaldbuyvat))-$tempgst,2); 
							}else{
								echo number_format(($companybalnce)+$totalprofit-$totalsalary-(($dtotaldsellingvat+$ptotaldsellingvat)-($dtotaldbuyvat + $ptotaldbuyvat))+$tempgst,2); 
							}
							?>
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
            <?php
				$vat = $paidvat + $oilgst;
				$oilgst = $oil_sgst - $oil_cgst;
			?>
				<div class="row">
                    <div class="col-md-6">
                        <div class="title-h1">
                            <h3>IN</h3>
                        </div>
                        <div class="bdr js-scroll">
                            <table class="table">
                                <tbody>
									<tr>
										<th>Title</th>
										<th>Value</th>
									</tr>
									<tr>
										<td>Petrol</td>
										<td>
											<?php
											$tablea = 0; 
											echo $pstock; 
											$tablea = $tablea + $pstock;
											?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Diesel</td>
                                        <td>
                                            <?php
											echo $dstock;
                                            $tablea = $tablea + $dstock;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oil</td>
                                        <td>
                                            <?php
                                            echo $ostock;
                                            $tablea = $tablea + $ostock;
                                            ?>
                                        </td>
									</tr>
									<tr>
										<td <?php echo $f_bank_total; ?>   	1973584.17 >Bank Balance</td>
										<td <?php echo $pattybank_balance; ?>>
										<?php 
										echo $bank_balence = $pre_deposit_amount->cash_total + $pre_cheq_deposit_amount->cheque_total + $pre_deposit_wallet_amount->wallet_extra_total + $prev_card_depost->total + $prev_petty_cash_deposit->total - $pre_onlinetransaction->total_onlinetransaction - $prev_petty_cash_withdrawal->total - $f_bank_total;
										$tablea = $tablea + $bank_balence;
										?>
										</td>
									</tr>
									<tr>
                                        <td>Rewards Card Balance (Company)</td>
                                        <td>
                                            <?php
                                            echo round($iocbalnce, 2);
                                            $tablea = $tablea + round($iocbalnce, 2);
                                            ?>
                                        </td>
                                    </tr>
									 <tr>
                                        <td>Credit</td>
                                        <td>
											<?php
												echo round($get_credit->total - $get_debit->total, 2);
												$tablea = $tablea + round($get_credit->total - $get_debit->total, 2);
											?>
                                        </td>
                                    </tr>
									<tr>
                                        <td>Cash On Hand</td>
                                        <td>
											<?php
											echo round($lastday->cash_on_hand, 2);
											$tablea = $tablea + round($lastday->cash_on_hand, 2);
											?>
											<?php 
												if ($logged_company['type'] == 'c') {
											?>
											<a href="<?php echo base_url() ?>daily_reports_new/last_day_entry?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&location=<?php echo $location; ?>"><i class="fa fa-edit"></i></a> 
											<?php } ?>
                                        </td>
                                    </tr>
									<tr>
                                        <td>Remaining Worker Loan</td>
                                        <td>
										<?php
											echo round($workerloan, 2);
											$tablea = $tablea + round($workerloan, 2);
										?>
                                        </td>
                                    </tr>
									<tr>
										<td>Total</td>
										<td><?php echo round($tablea,2); ?></td>
									</tr>
								</tbody>	
							</table>	
						</div>
					</div>
					<div class="col-md-6">
                        <div class="title-h1">
                            <h3>OUT</h3>
                        </div>
                        <div class="bdr js-scroll">
                            <table class="table">
                                <tbody>
									<tr>
										<th>Title</th>
										<th>Value</th>
									</tr>
                                    <tr>
                                        <td>Total Profit</td>
                                        <td>
											<?php
//echo $ptxt. "=";
											echo round($totalprofit,2); 
											$tableb = $totalprofit;
											?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Salary</td>
                                        <td>
											<?php
											/*echo round($paidsalary, 2);
											$tableb = $tableb + $totalsalary;*/
											
											echo round($paidsalary->amount, 2);
											$tableb = $tableb + $paidsalary->amount;
											?>
                                        </td>
                                    </tr>
                                    <?php /* ?><tr>
                                        <td>Patty Cash</td>
                                        <td data-toggle="tooltip" title="<?php echo $pattycash_balance."-".$pattybank_balance;?>">
											<?php 
											echo $pattycash = $pattycash_balance-$pattybank_balance;
											$tableb = $tableb + $pattycash;
											?>
                                        </td>
                                    </tr><?php */ ?>
									<tr>
                                        <td>Patty Cash</td>
                                        <td>
											<?php 
											echo $pattycash_balance;
											?>
                                        </td>
                                    </tr>
									<tr>
                                        <td>Patty Cash Bank</td>
                                        <td>
											<?php 
											echo $pattybank_balance;
											?>
                                        </td>
                                    </tr>
									<tr>
                                        <td>Patty Cash Balance</td>
                                        <td>
											<?php 
											echo $pattycash = $pattycash_balance+$pattybank_balance;
											$tableb = $tableb + $pattycash;
											?>
                                        </td>
                                    </tr>
									<tr>
                                        <td>Vat</td>
                                        <td>
										<?php echo round($vat = $dtotaldsellingvat+$ptotaldsellingvat,2);?>
                                        </td>
                                    </tr>
									<tr>
                                        <td>Paid Vat</td>
                                        <td title="<?php echo $dtotaldbuyvat."-".$ptotaldbuyvat;?>">
										<?php echo $paidvat = round($dtotaldbuyvat + $ptotaldbuyvat, 2); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Payable vat</td>
                                        <td>
										<?php echo $payblval = round($vat - $paidvat, 2); 
										$tableb = $tableb + $payblval;
										?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>GST</td>
                                        <td>
											<?php echo $sgst; ?>
                                        </td>
                                    </tr>
									
									<tr>
                                        <td>Paid GST</td>
                                        <td>
											<?php echo $paidgst = $oil_sgst+$oil_cgst; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Payable Oil GST</td>
                                        <td>
										<?php echo $payablegst = $paidgst-$sgst; 
										$tableb = $tableb + $payablegst;
										?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Total</td>
                                        <td>
                                            <?php echo $tableb; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="title-h1">
                            <h3><!--Salary--></h3>
                        </div>
                        <div class="bdr js-scroll">
                         

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
                                        document.forms['savingdata'].action = '<?php echo base_url(); ?>daily_reports_new/print_pdf';
                                        document.forms['savingdata'].submit();

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