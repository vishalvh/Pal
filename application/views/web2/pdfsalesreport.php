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
                    <td width="7%" style="padding:10px">
                        <img src="<?php echo base_url();?>uploads/<?php echo $location_detail->logo;?>" alt="" width="50%">
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
					<td colspan='2' style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Sales Report</td>
				</td>
                <tr>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Start date:<?php echo date('d/m/Y',strtotime($sdate));?></td>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">End Date:<?php echo date('d/m/Y',strtotime($edate)); ?></td>
                </tr>
            </tbody>
        </table>
<hr style="border:1px solid #000">
        <br>
        <br>
        <br>
        <table width="100%" class="table" style="">
            <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Diesel Selling</th>
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
									
									foreach ($report as $r) {?>
                                    <tr>
                                        <td>
                                            <?php echo date('d/m/Y',strtotime($r['date'])); ?>
                                        </td>
                                        <td>
                                            <?php echo round($r['d_total_selling']*$r['dis_price'],2); //echo "(".$r['dis_price'].")"; 
											$dtotaldsellingprice = $dtotaldsellingprice+round($r['d_total_selling']*$r['dis_price'],2); ?>
                                        </td>
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
                                       
										<td>
                                            <?php echo round($dtotaldsellingprice,2); ?>
                                        </td>
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


</body>

</html>