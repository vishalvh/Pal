<html>

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: verdana;
            padding: 20px;
        }

        table {
            width: 100%;
        }

        table {
            border-collapse: collapse;

        }

        .table th {
            font-weight: bold;
        }

        .bold td {
            font-weight: bold;
        }

        table th,
        table td {
            font-size: 12px;
            text-align: left;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 5px;
            font-size: 12px;
            text-align: center;
        }

        h3 {
            margin: 0;
            padding: 10px;
        }

        .border {
            border: 2px solid #000;
            padding: 25px;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .bold td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="border">
        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="2" style="font-size: 15px;font-weight: bold;text-align:right">
                        Mo.:<?php echo $location_detail->phone_no; ?>
                    </td>
                </tr>
                <tr>
                    <td width="3%" style="padding:10px">
                        <img src="<?php echo base_url();?>uploads/<?php echo $location_detail->logo;?>" alt="" width="20%">
                    </td>
                    <td width="93%">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;"><?php echo $location_detail->l_name; ?></td>
                                </tr>
                                   <tr>
                                       
                                    <td style="font-weight:normal;border-bottom: 2px solid #000;padding:10px 0;border-top: 2px solid #000;display: block;font-size: 15px;text-align: center">Dealer: <?php echo $location_detail->dealar; ?>.</td>
                                   </tr>
                                   <tr>
                                       
                                    <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;text-align: center"><?php echo $location_detail->address;?></td>
                                   </tr>
                                   <tr>
                                       
                                    <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;text-align: center"> Gst No.<?php echo $location_detail->gst; ?></td>
                                   </tr>  
<tr>
                                       
                                    <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;text-align: center"> Tin No.<?php echo $location_detail->tin; ?></td>
                                   </tr> 								   
                            </tbody>
                        </table>


                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%"  style="border-top:2px solid #000;border-bottom: 2px solid #000">
            <tbody>
				<tr>
					<td colspan='2' style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Inventory Report</td>
				</td>
                <tr>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Start Date:<?php echo date('d/m/Y',strtotime($sdate));?></td>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">End Date:<?php echo date('d/m/Y',strtotime($edate)); ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table" style="">
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
        <br>
        
    </div>
    


</body>

</html>