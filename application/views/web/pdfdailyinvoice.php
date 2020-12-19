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
                        <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Date:<?php echo date('d/m/Y', strtotime($_GET['sdate'])); ?></td>
                    </tr>
					 <tr>
                        <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Daily Invoice</td>
                    </tr>
                </tbody>
            </table>
            <hr style="border:1px solid #000">
            <br>
            <br>
            <table width="100%" class="table" style="">
                <thead>
                    <tr>
                        <th>Sr no.</th>
                        <th>Date</th>
                        <th>Name</th>
						<th>Ltr</th>
                        <th>Today Paid</th>
                        <th>Today Due</th>
                        <th>Past Due</th>
                        <th>Total Due</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cnt = 1;
                    $html = '';
                    $finalcurrentdue = 0;
                    $finalpastdue = 0;
					$totalquantity = 0;
                    foreach ($totalprev_credit as $creditdetail) {
                        $currentdue = number_format($creditdetail->current_credit - $creditdetail->current_debit, 2);
                        $pastdue = number_format($creditdetail->past_credit - $creditdetail->past_debit, 2);
                        $due = number_format(($creditdetail->current_credit - $creditdetail->current_debit) + ($creditdetail->past_credit - $creditdetail->past_debit), 2);
                        $test1 = $test1 + $creditdetail->current_credit;
                        $test2 = $test2 + $creditdetail->current_debit;
						$quantity = number_format($creditdetail->current_credit/$dailyprice->dis_price,2);
				$totalquantity = $totalquantity+$quantity;
                        $html .= '<tr><td>' . $cnt . '</td><td>' . $sdate . '</td><td>' . $creditdetail->name . '</td><td>'.$quantity.'</td><td>' . number_format($creditdetail->current_debit, 2) . '</td><td>' . number_format($creditdetail->current_credit, 2) . '</td><td>' . $pastdue . '</td><td>' . $due . '</td></tr>';
                        $finalcurrentdue = $finalcurrentdue + ($creditdetail->current_credit - $creditdetail->current_debit);
                        $finalpastdue = $finalpastdue + ($creditdetail->past_credit - $creditdetail->past_debit);
                        $cnt++;
                    }
                    if ($cnt == 0) {
                        $html .= '<tr><td colspan="8">No Data avalieble</td></tr>';
                    }
                    $final = $finalpastdue + $finalcurrentdue;
                    $html .= '<tr><td colspan="3">Total</td><td>'.number_format($totalquantity,2).'</td><td>' . number_format($test2, 2) . '</td><td>' . number_format($test1, 2) . '</td><td>' . number_format($finalpastdue, 2) . '</td><td>' . number_format($final, 2) . '</td></tr>';

                    echo $html;
                    ?>

                </tbody>
            </table>
        </div>


    </body>

</html>