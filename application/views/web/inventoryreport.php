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
            <h3 class="blank1" style="margin-top: -20px;">Inventory Report</h3>
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
                            <?php if(in_array("inventory_report_print",$this->data['user_permission_list'])){ ?>
							<a href="<?php echo base_url(); ?>daily_reports_new_jun/print_pdf_inventoryreport?sdate=<?php echo date("d-m-Y", strtotime($sdate)); ?>&edate=<?php echo date("d-m-Y", strtotime($edate)); ?>&location=<?php echo $location; ?>" class="btn btn-primary" target="_blank"   <?php if ($this->input->get('location') == "") {
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
                    <h3>Inventory Report</h3>
                </div>
                <div class="over-scroll js-scroll bdr">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Invoice No</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>VAT Amount</th>
                                <th>CESS Amount</th>
                                <th>Other Tax</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>Total Amount</th>
                                <th>Round Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$totalqty = 0;
							$totalamount = 0;
							$totalvatamount = 0;
							$totalsessamount = 0;
							$totalothertax = 0;
							$totaloilcgst = 0;
							$totaloilsgst = 0;
							$totalp = 0;
							$totald = 0;
							$xptotalp = 0;
							$xptotald = 0;
							$totalo = 0;
                            foreach ($report as $r) {
                                $qty = 0.00;
											if($r->fuel_type == 'p'){
												$qty = $r->p_quantity;
											}
											if($r->fuel_type == 'd'){
												$qty = $r->d_quantity;
											}
											if($r->fuel_type == 'xpp'){
												$qty = $r->p_quantity;
											}
											if($r->fuel_type == 'xpd'){
												$qty = $r->d_quantity;
											}
											if($r->fuel_type == 'o'){
												$qty = $r->o_quantity;
											}
											if($qty > 0 || $r->o_amount > 0){
											//if(1){
												$totalamounsum = 0;
                                    ?>
                                    <tr>
                                        <td>
											<?php echo date('d/m/Y', strtotime($r->date)); ?>
                                        </td>
                                        <td>
										<?php 
											echo $r->fuel_type == 'p'? 'Petrol' : '';
											echo $r->fuel_type == 'd'? 'Diesel' : '';
											echo $r->fuel_type == 'xpp'? 'Xtra Premium Petrol' : '';
											echo $r->fuel_type == 'xpd'? 'Xtra Premium Diesel' : '';
											echo $r->fuel_type == 'o'? 'Oil' : '';
										?>
                                        </td>
										<td>
										<?php echo $r->invoice_no; ?>
										</td>
                                        <td>
										<?php 
											echo amountfun($qty);
											
											
											$qty == ''?'0.00':$qty;
											$totalqty = $totalqty+$qty;
											if($r->fuel_type == 'p'){
												$totalp = $totalp+$qty;
											}
											if($r->fuel_type == 'd'){
												$totald = $totald+$qty;
											}
											if($r->fuel_type == 'xpp'){
												$xptotalp = $xptotalp+$qty;
											}
											if($r->fuel_type == 'xpd'){
												$xptotald = $xptotald+$qty;
											}
											if($r->fuel_type == 'o'){
												$totalo = $totalo+$qty;
											}
											
										?>
                                        </td>
                                        <td>
										<?php 
											$amount = 0.00;
											if($r->fuel_type == 'p'){
												$amount = $r->p_fuelamount;
												$totalamountp = $totalamountp + $amount;
											}
											if($r->fuel_type == 'd'){
												$amount = $r->d_fuelamount;
												$totalamountd = $totalamountd + $amount;
											}
											if($r->fuel_type == 'xpp'){
												$amount = $r->p_fuelamount;
												$xptotalamountp = $xptotalamountp + $amount;
											}
											if($r->fuel_type == 'xpd'){
												$amount = $r->d_fuelamount;
												$xptotalamountd = $xptotalamountd + $amount;
											}
											if($r->fuel_type == 'o'){
												$amount = $r->o_amount;
												$totalamounto = $totalamounto + $amount;
											}
											echo amountfun($amount);
											
											
											$amount == ''?'0.00':$amount;
											$totalamount = $totalamount + $amount;
											$totalamounsum = $amount;
										?>
                                        </td>
                                        <td>
										<?php 
											$vatamount = 0.00;
											if($r->fuel_type == 'p'){
												$vatamount = $r->pv_taxamount;
												$totalvatamountp = $totalvatamountp + $vatamount;
											}
											if($r->fuel_type == 'd'){
												$vatamount = $r->dv_taxamount;
												$totalvatamountd = $totalvatamountd + $vatamount;
											}
											if($r->fuel_type == 'xpp'){
												$vatamount = $r->pv_taxamount;
												$xptotalvatamountp = $xptotalvatamountp + $vatamount;
											}
											if($r->fuel_type == 'xpd'){
												$vatamount = $r->dv_taxamount;
												$xptotalvatamountd = $xptotalvatamountd + $vatamount;
											}
											echo amountfun($vatamount);

											$vatamount == ''?'0.00':$vatamount;
											$totalvatamount = $totalvatamount + $vatamount;
											$totalamounsum = $totalamounsum + $vatamount;
										?>
                                        </td>
                                        <td>
										<?php 
											$sessamount = 0.00;
											if($r->fuel_type == 'p'){
												$sessamount = $r->p_cess_tax;
												$totalsessamountp = $totalsessamountp + $sessamount;
											}
											if($r->fuel_type == 'd'){
												$sessamount = $r->d_cess_tax;
												$totalsessamountd = $totalsessamountd + $sessamount;
											}
											if($r->fuel_type == 'xpp'){
												$sessamount = $r->p_cess_tax;
												$xptotalsessamountp = $xptotalsessamountp + $sessamount;
											}
											if($r->fuel_type == 'xpd'){
												$sessamount = $r->d_cess_tax;
												$xptotalsessamountd = $xptotalsessamountd + $sessamount;
											}
											echo amountfun($sessamount);

											$sessamount == ''?'0.00':$sessamount;
											$totalsessamount = $totalsessamount + $sessamount;
											$totalamounsum = $totalamounsum + $sessamount;
										?>
                                        </td>
										
                                        <td>
										<?php 
											$sessamount = 0.00;
											if($r->fuel_type == 'p'){
												$sessamount = $r->p_other_tax;
												$totaltothertaxp = $totaltothertaxp + $sessamount;
											}
											if($r->fuel_type == 'd'){
												$sessamount = $r->d_other_tax;
												$totaltothertaxd = $totaltothertaxd + $sessamount;
											}
											if($r->fuel_type == 'xpp'){
												$sessamount = $r->p_other_tax;
												$xptotaltothertaxp = $xptotaltothertaxp + $sessamount;
											}
											if($r->fuel_type == 'xpd'){
												$sessamount = $r->d_other_tax;
												$xptotaltothertaxd = $xptotaltothertaxd + $sessamount;
											}
											echo amountfun($sessamount);

											$sessamount == ''?'0.00':$sessamount;
											$totalothertax = $totalothertax + $sessamount;
											$totalamounsum = $totalamounsum + $sessamount;
										?>
                                        </td>
										<td>
										<?php 
										$cgst = 0.00;
										if($r->fuel_type == 'o'){
											$cgst = $r->oil_cgst;
										}
										echo amountfun($cgst);
										$totalcgst = $totalcgst + $cgst;
										$totalamounsum = $totalamounsum + $cgst;
										?>
										</td>
										<td>
										<?php 
										$sgst = 0.00;
										if($r->fuel_type == 'o'){
											$sgst = $r->oil_sgst;
										}
										echo amountfun($sgst);
										$totalsgst = $totalsgst + $sgst;
										$totalamounsum = $totalamounsum + $sgst;
										?>
										</td>
                                        <td>
										<?php echo amountfun($totalamounsum); 
										$finaltotalamounsump = $finaltotalamounsump + $totalamounsum;
										if($r->fuel_type == 'p'){
											$totalamounsump = $totalamounsump + $totalamounsum;
										}
										if($r->fuel_type == 'd'){
											$totalamounsumd = $totalamounsumd + $totalamounsum;
										}
										
										if($r->fuel_type == 'xpp'){
											$xptotalamounsump = $xptotalamounsump + $totalamounsum;
										}
										if($r->fuel_type == 'xpd'){
											$xptotalamounsumd = $xptotalamounsumd + $totalamounsum;
										}
										if($r->fuel_type == 'o'){
											$totalamounsumo = $totalamounsumo + $totalamounsum;
										}
										
										?>
										</td>
										
										<td>
										<?php echo amountfun(round($totalamounsum));

										$totalamounsum = round($totalamounsum); 
										
										$roundtotal = $roundtotal + round($totalamounsum); 
										if($r->fuel_type == 'p'){
											$roundtotalp = $roundtotalp + $totalamounsum;
										}
										if($r->fuel_type == 'd'){
											$roundtotald = $roundtotald + $totalamounsum;
										}
										if($r->fuel_type == 'xpp'){
											$xproundtotalp = $xproundtotalp + $totalamounsum;
										}
										if($r->fuel_type == 'xpd'){
											$xproundtotald = $xproundtotald + $totalamounsum;
										}
										if($r->fuel_type == 'o'){
											$roundtotalo = $roundtotalo + $totalamounsum;
										}
										?>
										</td>
                                    </tr>
        <?php
    $cnt++;
											}
}
?>

<tr>
                                <td><b>Petrol Total</b></td>
                                <td></td><td></td>
                                <td><b>
								<?php echo amountfun($totalp); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalamountp); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalvatamountp); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalsessamountp); ?>
                                </td>
								<td><b>
								<?php echo amountfun($totaltothertaxp); ?>
                                </td>
                                <td><b>
								</td>
                                <td><b>
								</td>
                                <td><b>
								<?php echo amountfun($totalamounsump); ?>
								</td>
								<td><b>
								<?php echo amountfun($roundtotalp); ?>
								</td>
								
                            </tr>
							<?php if($location_detail->xp_type == "Yes") { ?>
							<tr>
                                <td><b>XP Petrol Total</b></td>
                                <td></td><td></td>
                                <td><b>
								<?php echo amountfun($xptotalp); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($xptotalamountp); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($xptotalvatamountp); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($xptotalsessamountp); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($xptotaltothertaxp); ?>
                                </td>
                                <td><b>
								</td>
                                <td><b>
								</td>
                                <td><b>
								<?php echo amountfun($xptotalamounsump); ?>
								</td>
								<td><b>
								<?php echo amountfun($xproundtotalp); ?>
								</td>
								
                            </tr>
							<?php } ?>
							<tr>
                                <td><b>Diesel Total</b></td>
                                <td></td>
                                <td></td>
                                <td><b>
								<?php echo amountfun($totald);?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalamountd); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalvatamountd); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalsessamountd); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totaltothertaxd); ?>
                                </td>
                                <td><b>
								</td>
                                <td><b>
								</td>
                                <td><b>
								<?php echo amountfun($totalamounsumd); ?>
								</td>
								<td><b>
								<?php echo amountfun($roundtotald); ?>
								</td>
                            </tr>
							<?php if($location_detail->xp_type == "Yes") { ?>
							<tr>
                                <td><b>XP Diesel Total</b></td>
                                <td></td>
                                <td></td>
                                <td><b>
								<?php echo amountfun($xptotald);?>
                                </td>
                                <td><b>
								<?php echo amountfun($xptotalamountd); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($xptotalvatamountd); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($xptotalsessamountd); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($xptotaltothertaxd); ?>
                                </td>
                                <td><b>
								</td>
                                <td><b>
								</td>
                                <td><b>
								<?php echo amountfun($xptotalamounsumd); ?>
								</td>
								<td><b>
								<?php echo amountfun($xproundtotald); ?>
								</td>
                            </tr>
							<?php } ?>
							<tr>
                                <td><b>Oil Total</b></td>
                                <td></td><td></td>
                                <td><b>
								<?php echo amountfun($totalo); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalamounto); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalvatamounto); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalsessamounto); ?>
                                </td>
                                <td><b>
								
                                </td>
                                <td><b>
								<?php echo amountfun($totalcgst); ?>
								</td>
                                <td><b>
								<?php echo amountfun($totalsgst); ?>
								</td>
                                <td><b>
								<?php echo amountfun($totalamounsumo); ?>
								</td>
								<td><b>
								<?php echo amountfun($roundtotalo); ?>
								</td>
                            </tr>


                            <tr>
                                <td><b>Final Total</td>
                                <td></td>
                                <td></td>
                                <td><b>
								<?php echo amountfun($totalqty); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalamount); ?>
                                </td>
                                <td><b>
								<?php echo amountfun($totalvatamount); ?>
                                </td>
								<td><b>
								<?php echo amountfun($totalsessamount); ?>
								</td>
								<td><b>
								<?php echo amountfun($totalothertax); ?>
								</td>
                                <td><b>
								<?php echo amountfun($totalcgst); ?>
                                </td>
								<td><b>
								<?php echo amountfun($totalsgst); ?>
								</td>
                                <td><b>
								<?php echo amountfun($finaltotalamounsump); ?>
								</td>
								<td><b>
								<?php echo amountfun($roundtotal); ?>
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
                                        var url = '<?php echo base_url(); ?>daily_reports_new/print_pdf_inventoryreport?sdate=<?php echo date("d-m-Y", strtotime($sdate)); ?>&edate=<?php echo date("d-m-Y", strtotime($edate)); ?>&location=<?php echo $location; ?>';
                                        //document.forms['savingdata'].submit();
										window.open(url, '_blank');

                                    }
                                    function SubmitForm()
                                    {

                                        document.forms['savingdata'].action = '<?php echo base_url(); ?>daily_reports_new_jun/inventoryreport';
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