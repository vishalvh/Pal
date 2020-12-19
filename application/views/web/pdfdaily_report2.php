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
                            <table width="100%" >
                                 <tr>
                    <td colspan="34" style="font-size: 15px;font-weight: bold;text-align:center">
                        Daily 
                    </td>
                </tr>
                                <thead>
                                    <tr >
                                        <th style="border:1px solid #000">Date</th>
                                        <th>Diesel Stock</th>
                                        <th>Selling</th>
			<th>Testing</th>
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
					<th>Sales on Card</th>
					<th>Sales on Rewards</th>
					<th>Sales on Debite</th>
					
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
									$cnt=0;
									foreach ($report as $r) {
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
										
										
                                    </tr>
                                    <?php
$p_dstock = $r['dstock'];
$p_d_total_selling = $r['d_total_selling'];
$p_d_quantity = $r['d_quantity'];
$p_pstock = $r['pstock'];
$p_p_total_selling = $r['p_total_selling'];
$p_p_quantity = $r['p_quantity'];
										}
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
                        
        
</body>

</html>