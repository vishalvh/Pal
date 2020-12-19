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
                        <td colspan='2' style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Daily cash report</td>
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
                        <th>Cash on hand</th>
                        <th>Petty Cash in</th>
                        <th>Customer cash in</th>
                        <th>Bank Deposit Amount</th>
                        <th>Final Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                   $fianlarray = array();
        foreach ($cash_on_hand_list as $cash_on_hand) {
            $fianlarray[$cash_on_hand->date]['date'] = $cash_on_hand->date;
            $fianlarray[$cash_on_hand->date]['deposit_amount'] = $cash_on_hand->cash_on_hand;
            
        }
     
        foreach ($onlinelist as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['bank_deposit_amount'] = $bankdetail->deposit_amount;
            $fianlarray[$bankdetail->date]['user_deposit_amount'] = $bankdetail->amount;
        }
        foreach ($petty_cash_in as $cash_in) {
            $fianlarray[$cash_in->date]['date'] = $cash_in->date;
            $fianlarray[$cash_in->date]['petty_cash_in'] = $cash_in->petty_cash_in;
        }
        foreach ($customer_cash_in as $cash_in) {
            $fianlarray[$cash_in->date]['date'] = $cash_in->date;
            $fianlarray[$cash_in->date]['customer_cash_in'] = $cash_in->customer_cash_in;
        }
//           echo "<pre>";
//        print_r($fianlarray);
//        die();
        function sortByName($a, $b) {
            $a = $a['date'];
            $b = $b['date'];

            if ($a == $b)
                return 0;
            return ($a < $b) ? -1 : 1;
        }

        $base_url = base_url();
        $html = "";
        usort($fianlarray, 'sortByName');
        $no = 0;
        $deposit_amount_total = 0;
        $bank_deposit_amount_total = 0;
        $user_deposit_amount = 0;
        $petty_cash_in_total = 0;
        $customer_cash_in_total = 0;
        $f_total = 0;
        foreach ($fianlarray as $customers) {
            $html .= "<tr>";
            $no++;
            $total = 0;
            $deposit_amount_total = $deposit_amount_total+$customers['deposit_amount'];
            if($customers['bank_deposit_amount'] != ""){
            $bank_deposit_amount_total = $bank_deposit_amount_total+$customers['bank_deposit_amount'];
            }
            $user_deposit_amount = $user_deposit_amount+$customers['user_deposit_amount'];
            $petty_cash_in_total = $petty_cash_in_total+$customers['petty_cash_in'];
            $customer_cash_in_total = $customer_cash_in_total+$customers['customer_cash_in'];
           
            $html .= "<td>" . $no . "</td>";
            $html .= "<td>" . date('d-m-Y', strtotime($customers['date'])) . "</td>";
            $html .= "<td>" . $deposit_amount =  amountfun($customers['deposit_amount']) . "</td>";
            
            $html .= "<td>" . $petty_cash_in = amountfun($customers['petty_cash_in']) . "</td>";
            $html .= "<td>" .$customer_cash_in = amountfun($customers['customer_cash_in']) . "</td>";
            $html .= "<td>" . $bank_deposit_amount = amountfun($customers['bank_deposit_amount']) . "</td>";
             $total = $customers['deposit_amount']+$customers['petty_cash_in']+$customers['customer_cash_in']-$customers['bank_deposit_amount'];
            $html .= "<td>" . amountfun($total) . "</td>";
            $f_total = $f_total+$total;
//            $html .= "<td>" . number_format($customers['user_deposit_amount'], 2) . "</td>";
            $html .= "</tr>";
        }
        $html .= "<tr><td colspan='2'>Total</td><td>" . amountfun($deposit_amount_total) . "</td><td>" . amountfun($petty_cash_in_total) . "</td><td>" . amountfun($customer_cash_in_total) . "</td><td>" . amountfun($bank_deposit_amount_total) . "</td><td>" . amountfun($f_total) . "</td></tr>";
		
		$html .= "<tr><td colspan='4'>Final total</td><td>" . amountfun($deposit_amount_total+$petty_cash_in_total+$customer_cash_in_total) . "</td><td>" . amountfun($bank_deposit_amount_total) . "</td><td>" . amountfun(($deposit_amount_total+$petty_cash_in_total+$customer_cash_in_total)-($bank_deposit_amount_total)) . "</td></tr>";
		
		
        echo $html;

                    ?>
                    

                </tbody>

            </table>
        </div>


    </body>

</html>