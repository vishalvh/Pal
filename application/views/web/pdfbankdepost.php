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
                            <img src="<?php echo base_url(); ?>uploads/<?php echo $location_detail->logo; ?>" alt="" width="50%">
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

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;text-align: center"><?php echo $location_detail->address; ?></td>
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
                        <td colspan='2' style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Bank Report</td>
                        </td>
                    <tr>
                        <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Start date:<?php echo date('d/m/Y', strtotime($sdate)); ?></td>
                        <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">End Date:<?php echo date('d/m/Y', strtotime($edate)); ?></td>
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
                        <th>Sr No</th>
                        <th>Date</th>
                        <th>Deposit Amount</th>
                        <th>Customer Bank Amount</th>
                        
                         <th>Card Amount</th>
                         <th>Wallet Amount</th>
                         <th>Petty Cash Deposit</th>
                         <th>Petty Cash Withdrawal</th>
						 <th>Withdraw Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                   $fianlarray = array();
        foreach ($list as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['deposit_amount'] = $bankdetail->deposit_amount;
            //$fianlarray[$bankdetail->date]['depositamonut'] = $bankdetail->cs_total;
        }
		foreach ($listnew as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['depositamonut'] = $bankdetail->cs_total;
        }
        foreach ($onlinelist as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['amount'] = $bankdetail->amount;
        }
        foreach ($creadit_dabit_list as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['card_amount'] = $bankdetail->card_amount;
        }
        foreach ($wallet_list as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['wallet_list'] = $bankdetail->card_amount;
        }
        foreach ($petty_cash_deposit_list as $bankdetail) {

            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['petty_cash_deposit'] = $bankdetail->total;
        }
        foreach ($petty_cash_withdrawal_list as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['petty_cash_withdrawal'] = $bankdetail->total;
        }

        // print_r($fianlarray);
//                  foreach ($fianlarray as $as){
//                    echo '<pre>';  print_r($as); 
//                  }
//                  die();
//                      
        function sortByName($a, $b) {
            $a = $a['date'];
            $b = $b['date'];

            if ($a == $b)
                return 0;
            return ($a < $b) ? -1 : 1;
        }

        $base_url = base_url();
        $html = "";
        $msg = '"Are you sure you want to remove this data?"';
        $deposit = 0;
        $onlinetrasectin = 0;
        $withdraw = 0;
        $extra = 0;
        $petty_cash_deposit = 0;
        $petty_cash_withdrawal = 0;
        $list1 = array_merge($list, $onlinelist);
        $list2 = array_merge($list1, $creadit_dabit_list);
        //    print_r($list1);
        // array_multisort($list1,SORT_ASC,SORT_NUMERIC);
        $count = count($list2);
// Print array elements before sorting
        usort($fianlarray, 'sortByName');
        //echo $pre_deposit_amount->cash_total."+".$pre_cheq_deposit_amount->cheque_total."+".$pre_deposit_wallet_amount->wallet_extra_total."+".$prev_card_depost->total."-".$pre_onlinetransaction->total_onlinetransaction."<br>";
        $opnamont = $pre_deposit_amount->cash_total + $pre_cheq_deposit_amount->cheque_total + $pre_deposit_wallet_amount->wallet_extra_total + $prev_card_depost->total + $prev_petty_cash_deposit->total - $pre_onlinetransaction->total_onlinetransaction - $prev_petty_cash_withdrawal->total;
        $html .= '<tr><td>Opening Balance</td><td></td><td style="text-align: right">' . amountfun($opnamont) . '</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
        foreach ($fianlarray as $customers) {
            $html .= "<tr>";

            $no++;
            $edit = "<a href='" . $base_url . "bank_deposit/bankdonlineeposit_view?date=" . date('d-m-Y', strtotime($customers['date'])) . "&l_id=" . $location . "&sdate=" . $this->input->post('sdate') . "&edate=" . $this->input->post('edate') . "'><i class='fa fa-eye'></i></a> ";
            $dep = $customers['deposit_amount'] + $customers['depositamonut'];
            $html .= "<td>" . $no . "</td>";
            $html .= "<td>" . date('d-m-Y', strtotime($customers['date'])) . "</td>";
            $html .= "<td style='text-align: right'>" . amountfun($customers['deposit_amount']) . "</td>";
            $html .= "<td style='text-align: right'>" . amountfun($customers['depositamonut']) . "</td>";
            
            $html .= "<td style='text-align: right'>" . amountfun($customers['card_amount']) . "</td>";
            $html .= "<td style='text-align: right'>" . amountfun($customers['wallet_list']) . "</td>";
            $html .= "<td style='text-align: right'>" . amountfun($customers['petty_cash_deposit']) . "</td>";
            $html .= "<td style='text-align: right'>" . amountfun($customers['petty_cash_withdrawal']) . "</td>";
			$html .= "<td style='text-align: right'>" . amountfun($customers['amount']) . "</td>";
            //$html .= "<td>".number_format(($customers['deposit_amount']+$customers['depositamonut']+$customers['card_amount']+$opnamont)-($customers['amount']), 2)."</td>";
            

            $html .= "</tr>";
            $deposit = $deposit + $customers['deposit_amount'];
            $card_amount = $card_amount + $customers['card_amount'];
            $withdraw = $withdraw + $customers['depositamonut'];
            $onlinetrasectin = $onlinetrasectin + $customers['amount'];
            $extra = $extra + $customers['wallet_list'];
            $petty_cash_deposit = $petty_cash_deposit + $customers['petty_cash_deposit'];
            $petty_cash_withdrawal = $petty_cash_withdrawal + $customers['petty_cash_withdrawal'];
        }
        $html .= "<tr><td colspan='2'>Total</td><td style='text-align: right'>" . amountfun($deposit) . "</td><td style='text-align: right'>" . amountfun($withdraw) . "</td><td style='text-align: right'>" . amountfun($card_amount) . "</td><td style='text-align: right'>" . amountfun($extra) . "</td><td style='text-align: right'>" . amountfun($petty_cash_deposit) . "</td><td style='text-align: right'>" . amountfun($petty_cash_withdrawal) . "</td><td style='text-align: right'>" . amountfun($onlinetrasectin) . "</td></tr>";
        //$temp = "<br>totaldipostcash=".$deposit."<br>totaldipostcheque=".$withdraw."<br>totalsales on card =".$card_amount."<br>pretotaldipostcash=".$pre_deposit_amount->cash_total."<br>pretotaldipostcheque=".$pre_deposit_amount->cheque_total."<br>pretotal saleson card=".$prev_card_depost->total."<br>pretotalextra=".$pre_deposit_wallet_amount->wallet_extra_total."<br>totalextra=".$extra."<br>totalonline =".$onlinetrasectin."<br>pretotalonline=".$pre_onlinetransaction->total_onlinetransaction;
        //$html .= "<tr><td colspan='2'>Ending Balance</td><td>".$wallet_list[0]->card_amount."+".$deposit."+".$withdraw."+".$card_amount."+".$opnamont."-".$onlinetrasectin."<br>".number_format(($wallet_list[0]->card_amount+$deposit+$withdraw+$card_amount+$opnamont)-$onlinetrasectin, 2)."</td><td></td><td></td><td></td><td>".$temp."</td></tr>";
		$html .= "<tr><td colspan='2'>Month End Total</td><td colspan='4' style='text-align: right'>" . amountfun($deposit+$withdraw+$card_amount+$petty_cash_deposit+$extra) . "</td><td colspan='2' style='text-align: right'>" . amountfun($onlinetrasectin+$petty_cash_withdrawal) . "</td><td  style='text-align: right'>".amountfun(($deposit+$withdraw+$card_amount+$petty_cash_deposit+$extra)-($onlinetrasectin+$petty_cash_withdrawal))."</td></tr>";
        $html .= "<tr><td colspan='2'>Ending Balance</td><td  style='text-align: right'>" . amountfun(($wallet_list[0]->card_amount + $deposit + $withdraw + $card_amount + $opnamont + $petty_cash_deposit) - ($onlinetrasectin + $petty_cash_withdrawal)) . "</td><td></td><td></td><td></td><td></td><td></td><td>" . $temp . "</td></tr>";
        echo $html;
//                    $fianlarray = array();
//                  foreach ($list as $bankdetail){
//                      $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
//                      $fianlarray[$bankdetail->date]['deposit_amount'] = $bankdetail->deposit_amount;
//                      $fianlarray[$bankdetail->date]['depositamonut'] = $bankdetail->depositamonut;
//                  }
//                  foreach ($onlinelist as $bankdetail){
//                      $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
//                      $fianlarray[$bankdetail->date]['amount'] = $bankdetail->amount;
//                  }
//                  foreach ($creadit_dabit_list as $bankdetail){
//                      $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
//                      $fianlarray[$bankdetail->date]['card_amount'] = $bankdetail->card_amount;
//                  }                      
//                function sortByName($a, $b){
//					$a = $a['date'];
//					$b = $b['date'];
//
//					if ($a == $b) return 0;
//						return ($a < $b) ? -1 : 1;
//				}
//		$html = "";
//		// $html .= "<tr>";
//		// $html .= "<td colspan='2'>Previous Bank Balance</td>";
//		// $html .= "<td>".number_format($pre_deposit_amount->cash_total, 2) ."</td>";
//		// $html .= "<td>".number_format($pre_deposit_amount->cheque_total, 2)."</td>";
//		// $html .= "<td>".number_format($pre_onlinetransaction->total_onlinetransaction, 2)."</td>";
//		// $html .= "<td>".number_format($prev_card_depost->total, 2)."</td>";
//		
//		// $html .= "</tr>";
//                $opnamont = $pre_deposit_amount->cash_total+$pre_cheq_deposit_amount->cheque_total+$pre_deposit_wallet_amount->wallet_extra_total+$prev_card_depost->total+$prev_petty_cash_deposit->total-$pre_onlinetransaction->total_onlinetransaction-$prev_petty_cash_withdrawal->total;
//		$html .= '<tr><td>Opening Balance</td><td></td><td>'.number_format($opnamont,2).'</td><td></td><td></td><td></td></tr>';
//		$deposit = 0;
//		$onlinetrasectin = 0;
//		$withdraw = 0;
//               $list1 =  array_merge($list,$onlinelist);
//               $list2 =  array_merge($list1,$creadit_dabit_list);
//            $count = count($list2);
//            usort($fianlarray, 'sortByName');
//         
//       	foreach ($fianlarray as $customers) 
//       	{
//			$html .= "<tr>";
//       		
//			$no++;
//
//                         $edit = "<a href='".$base_url."bank_deposit/bankdonlineeposit_view?date=".date('d-m-Y', strtotime($customers['date']))."&l_id=".$location." '><i class='fa fa-eye'></i></a> ";
//                        $dep = $customers['deposit_amount']+$customers['depositamonut'];
//			$html .= "<td>".$no."</td>";
//			$html .= "<td>".date('d-m-Y', strtotime($customers['date']))."</td>";
//			$html .= "<td>".number_format($customers['deposit_amount'], 2) ."</td>";
//			$html .= "<td>". number_format($customers['depositamonut'], 2)."</td>";
//			
//			$html .= "<td>".number_format($customers['amount'], 2)."</td>";
//			
//                        $html .= "<td>".number_format($customers['card_amount'], 2)."</td>";
//        	
//			
//		   $html .= "</tr>";
//			$deposit = $deposit + $customers['deposit_amount'];
//                        $card_amount = $card_amount + $customers['card_amount'];
//			$withdraw = $withdraw + $customers['depositamonut'];
//                        $onlinetrasectin = $onlinetrasectin + $customers['amount'];
//	}
//	
//	$html .= "<tr><td colspan='2'>Total</td><td>".number_format($deposit, 2)."</td><td>".number_format($withdraw, 2)."</td><td>". number_format($onlinetrasectin, 2)."</td><td>". number_format($card_amount, 2)."</td></tr>";
//	$html .= "<tr><td colspan='2'>Ending Balance</td><td>".number_format((($deposit+$pre_deposit_amount->cash_total+$withdraw+$pre_deposit_amount->cheque_total+$card_amount)-($onlinetrasectin)), 2)."</td><td></td><td></td><td></td></tr>";
//	echo $html;
                    ?>
                    

                </tbody>

            </table>
        </div>


    </body>

</html>