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
                        <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Saving Report</td>
                        <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;"><?php echo date('d/m/Y', strtotime($sdate)); ?> TO <?php echo date('d/m/Y', strtotime($edate)); ?> </td>

                    </tr>

                </tbody> 
            </table>
            <hr style="border:1px solid #000">
            <br>
            <br>
            <br>
            <table width="100%" class="table" style="">
                <?php $ftotal = 0; ?>
                <thead>
                    <tr>
                        <th>SR.No</th>
                        <th>Member Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                    </tr> 
                </thead>
                <tbody>
                    <?php
                    $fianlarray = array();

                    foreach ($report_data as $report) {

                        $n_array = array("date" => $report->date,
                            "amount" => $report->total_amount,
                            "name" => $report->name,
                            "member_id" => $report->member_id);
                        $fianlarray[] = $n_array;
                    }

                    function sortByName($a, $b) {
                        $a = $a['date'];
                        $b = $b['date'];

                        if ($a == $b)
                            return 0;
                        return ($a < $b) ? -1 : 1;
                    }


                    $base_url = base_url();
                    $cnt = 1;
                    $html = '';
                    foreach ($fianlarray as $credit) {

                        $tamount1 = 0;
                        $tamount2 = 0;
                        $date = $credit['date'];
                        $debittotal = '';
                        $credittotal = '';
                        $cashdebit = '';
                        $creshcrdit = '';
                        $bank_cradit = '';
                        $bank_debit = '';

                        $type = '';
                        $total_saving_amount = $total_saving_amount + $credit['amount'];

                        $cashdebit = $credit['cashdebit'];
                        $creshcrdit = $credit['creshcrdit'];
                        $bank_cradit = $credit['bank_cradit'];
                        $bank_debit = $credit['bank_debit'];

                        $member_id = $credit['member_id'];
                        $dtotal = $credit['d_amount'] + $dtotal;
                        $debittotal = $credit['d_amount'];

                        // $name = $credit['name'];
                        // $remark = $credit['remark'];
                        $paymentfor = '';
                        
                        $html .= '<tr><td>' . $cnt . '</td><td>' . ucfirst($credit['name']) . '</td><td>' . date('d/m/Y', strtotime($date)) . '</td><td>' . amountfun($credit['amount']) . '</td></tr>';
                        $cnt++;
                    }

                    if ($cnt == 0) {
                        $html .= '<tr><td colspan="2">No Data avalieble</td></tr>';
                    }

                    $html .= '<tr><td colspan="2">Total</td><td></td><td>' . amountfun($total_saving_amount) . '</td></tr>';

                    echo $html;
                    ?></tbody>
            </table>
        </div>
    </body>
</html>