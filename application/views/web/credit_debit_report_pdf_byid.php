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

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;"><?php echo $location_detail->address; ?></td>
                                    </tr>
                                    <tr>

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;"> Gst No.<?php echo $location_detail->gst; ?></td>
                                    </tr>  
                                    <tr>

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;"> Tin No.<?php echo $location_detail->tin; ?></td>
                                    </tr> 								   
                                </tbody>
                            </table>


                        </td>
                    </tr>
					 <tr>
                        <td colspan='2' style="font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;"><u>Payment Receipt</u></td>
					</tr>
                </tbody>
            </table>
            <table width="100%"  style="border-top:2px solid #000;border-bottom: 2px solid #000">
                <tbody>
                   
                    <tr>
                        <td style="font-size:21px;font-weight:bold;padding:7px 0px;">Name:<?php echo ucwords($custdetail->name)?></td>
                        <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Type:<?php echo $credit; ?></td>
                    </tr>
					<tr>
                    <td style="font-size:15px;padding:7px 0px;"colspan='2' >Address:<?php echo ucwords($custdetail->address)?></td>
                    
					
                    
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
                        <th>Sr no.</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Debit Type</th>
                        <th><!--Credit-->Paid Amount</th>

                        

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cnt = 1;
                    $html = '';
                    $qty = 0;
                    $amount = 0;
                    $prevbalence = $totalprev_credit->totalamount - $totalprev_debit->totalamount;
                    $tcredit = 0;
                    $debit = 0;
                    foreach ($customerceditlist as $credit) {
                        $tamount1 = 0;
                        $tamount2 = 0;
                        $date = $credit->date;
                        $paymentfor = '';
                        if ($credit->payment_type == 'c') {
                            $type = 'Credit';
                            $debit = $debit + $credit->amount;
                            $tamount1 = $credit->amount;
                            $paymentfor = $credit->bill_no;
                        } else {
                            $type = 'Debit';
                            $tamount2 = $credit->amount;
                            $tcredit = $tcredit + $credit->amount;
                            if ($credit->transaction_type == 'cs') {
                                $paymentfor = 'Cash';
                            }
                            if ($credit->transaction_type == 'c') {
                                $paymentfor = 'Cheque';
                            }
                            if ($credit->transaction_type == 'n') {
                                $paymentfor = 'Netbanking';
                            }
                        }

                        $msg = '"Are you sure you want to remove this data?"';
                        if ($this->session->userdata('logged_company')['type'] == 'c') {

                            $html .= '<tr><td>' . $cnt . '</td><td>' . date('d/m/Y', strtotime($date)) . '</td><td>' . $type . '</td><td>' . $paymentfor . '</td><td>' . $tamount2 . '</td>
						
					</tr>';
                        } else {
                            $html .= '<tr><td>' . $cnt . '</td><td>' . date('d/m/Y', strtotime($date)) . '</td><td>' . $type . '</td><td>' . $paymentfor . '</td><td>' . $tamount2 . '</td>
					</tr>';
                        }

                        $cnt++;
                    }
                    if ($cnt == 0) {
                        $html .= '<tr><td colspan="6">No Data avalieble</td></tr>';
                    }

                    $html .= '<tr><td colspan="3"></td><td><b>Total</b></td><td><b>' . $tcredit . '</b></td></tr>';


                    echo $html;
                    ?>
<tr rowspan="7" style="height:115px"><td colspan="4" style="color:red;font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;"><b>We Appreciate your Business</b></td><td><br><br><b style="font-size:20px;"><?php echo $empdetail->UserFName;?></b><br>--------------------------------<br>For,<?php echo $location_detail->l_name; ?><br>Thank you</td></tr>
                </tbody>

            </table>
        </div>


    </body>

</html>