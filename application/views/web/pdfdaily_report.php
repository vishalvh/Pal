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
					<td colspan='2' style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Daily Reports</td>
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
<?php foreach ($location_tank_list as $locationtank) {
    if ($locationtank->fuel_type == 'd') { ?>
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
    if ($locationtank->fuel_type == 'p') { ?>
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
                                <th>Cash on hand</th>
                                <th>Sales on Card</th>
                                <th>Sales on Rewards</th>
                                <th>Sales on Wallet</th>
                                <th>Sales on Credit</th>
                                <th>Received From Customer</th>
                                <th>Total Selling</th>
                                <th>Total Collection</th>
                                <th>Total Overshort</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            $tempselling = 0;
                            $dtotaldselling = 0;
                            $dtotaldsellingbuyprice = 0;
                            $dtotaldsellingprice = 0;
                            $totalexpence = 0;
                            $dpurbenifit = 0;
                            $dtotalbuy = 0;
                            $dtotaldbuyvat = 0;
                            $dtotaldsellingvat = 0;
                            $dev = 0;
                            $devprice = 0;
                            $ptotaldselling = 0;
                            $ptotaldsellingbuyprice = 0;
                            $ptotaldsellingprice = 0;
                            $ppurbenifit = 0;
                            $ptotalbuy = 0;
                            $ptotaldbuyvat = 0;
                            $ptotaldsellingvat = 0;
                            $pev = 0;
                            $pevprice = 0;
                            $oil_reading = 0;
                            $oil_pure_benefit = 0;
                            $d_testing = 0;
                            $p_testing = 0;
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
							$dtotalbuy_total = 0;
						
							$patrol_stock = 0;
							$ptotalbuy_total = 0;
							$ptotaldselling_total = 0;
                            foreach ($report as $r) {
                                if ((strtotime($sdate) <= strtotime($r['date'])) && $cnt == 0) {
                                    $cnt++;
                                }
                                if ($cnt == 0) {
                                    $p_dstock = $r['dstock'];
                                    $p_d_total_selling = $r['d_total_selling'];
                                    $p_d_quantity = $r['d_quantity'];
                                    $p_pstock = $r['pstock'];
                                    $p_p_total_selling = $r['p_total_selling'];
                                    $p_p_quantity = $r['p_quantity'];
                                } else {
                                    ?>
                                    <tr>
                                        <td>
            <?php echo date('d/m/Y', strtotime($r['date'])); ?>
                                            
                                        </td>
                                            <?php foreach ($location_tank_list as $locationtank) {
                                                if ($locationtank->fuel_type == 'd') { ?>

                                                <td nowrap>
                                                    <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                <?php
                if (isset($finaltank[$r['date']][$r['id']]['d'][$locationtank->id])) {
                    echo amountfun($finaltank[$r['date']][$r['id']]['d'][$locationtank->id]['deepreading']);
                }
                ?>
                  </span>
                                                </td>
            <?php }
        } ?>
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
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun(($r['d_total_selling'] * $r['dis_price']) - ($r['d_total_selling'] * $r['d_new_price']) - $r['expence']);
                                            $dpurbenifit = $dpurbenifit + round(($r['d_total_selling'] * $r['dis_price']) - ($r['d_total_selling'] * $r['d_new_price']) - $r['expence'], 2); ?>
                                        </span>
                                        </td>
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
                                        
                                            <?php foreach ($location_tank_list as $locationtank) {
                                                if ($locationtank->fuel_type == 'p') { ?>
                                                <td nowrap>
                                                    <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                                    <?php
                                                    if (isset($finaltank[$r['date']][$r['id']]['p'][$locationtank->id])) {
                                                        echo $finaltank[$r['date']][$r['id']]['p'][$locationtank->id]['deepreading'];
                                                    }
                                                    ?>
                                                </td>
                                                <?php }
                                            } ?>
                                        </span>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
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
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))."  (".$r['p_total_selling'] ."*". $r['pet_price'].") - (".$r['p_total_selling']." * ".$r['p_new_price'].")";?>">
        <?php echo amountfun(($r['p_total_selling'] * $r['pet_price']) - ($r['p_total_selling'] * $r['p_new_price']));
        $ppurbenifit = $ppurbenifit + ($r['p_total_selling'] * $r['pet_price']) - ($r['p_total_selling'] * $r['p_new_price']);
        ?>
    </span>
                                        </td>
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
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                                <?php
                                                if ($cnt == 0) {
                                                     $cdev = round($r['p_ev'], 2);
                                                } else {
                                                     $cdev = round($r['pstock'] - (($p_pstock - $p_p_total_selling) + ($p_p_quantity)), 2);
                                                }
												
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
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php echo amountfun($oil_detail_price[$r['date']]['bay_price']); ?>
                                            <br>
                                         
                                         </span>   
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                            <?php
											
											$totloilselling = $oil_detail_price[$r['date']]['sel_price'];
											echo amountfun($oil_detail_price[$r['date']]['sel_price']);
											$oil_reading = $oil_reading + $oil_detail_price[$r['date']]['sel_price']; ?>
                                        </span>
                                        </td>

                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                        <?php echo amountfun($oil_final_array[$r['date']]['sell']-$oil_final_array[$r['date']]['buy']);
                                        $oil_pure_benefit = $oil_pure_benefit + ($oil_final_array[$r['date']]['sell']-$oil_final_array[$r['date']]['buy']); ?>
                                    </span>
                                        </td>
										<td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
                                                                                    <?php  echo amountfun($bay_stock_array[$r['date']]['total_qty_ltr']);  ?>
                                        </span>
										</td>
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
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
                                        <td>
                                            <span data-toggle="tooltip" title="<?=date('d/m/Y', strtotime($r['date']))?>">
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

                                             $x = $tsell = round(($r['d_total_selling'] * $r['dis_price']) + (($r['p_total_selling'] * $r['pet_price'])) + $totloilselling, 2);
											
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
                                    </tr>
        <?php
        $p_dstock = $r['dstock'];
        $p_d_total_selling = $r['d_total_selling'];
        $p_d_quantity = $r['d_quantity'];
        $p_pstock = $r['pstock'];
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
    if ($locationtank->fuel_type == 'd') { ?>
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
                                        if ($locationtank->fuel_type == 'p') { ?>
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
                                    
                               
                            </tr>
                                </tbody>
                            
        </table>
        <br>
        
    </div>
    


</body>

</html>