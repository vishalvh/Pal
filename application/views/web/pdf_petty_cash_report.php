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

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px"><?php echo $location_detail->address; ?></td>
                                    </tr>
                                    <tr>

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px"> Gst No.<?php echo $location_detail->gst; ?></td>
                                    </tr>  
                                    <tr>

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px"> Tin No.<?php echo $location_detail->tin; ?></td>
                                    </tr> 								   
                                </tbody>
                            </table>


                        </td>
						
                    </tr>
					<tr>
                        <td colspan='2' style="font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;"><u>Petty Cash Report</u></td>
					</tr>
					
                </tbody>
            </table>
            <table width="100%"  style="border-top:2px solid #000;border-bottom: 2px solid #000">
                <tbody>
				<?php if($memberdetail->name != ""){ ?>
                    <tr>
                        <td style="font-size:21px;font-weight:bold;padding:7px 0px;">Name:<?php echo ucwords($memberdetail->name)?></td>
                    </tr>
				<?php } ?>
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
                        <th>Cash  Credit (OUT)</th>
                        <th>Cash Debit(IN)</th>
                        <th>Bank Credit (OUT)</th>
                        <th>Bank Debit (IN)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        $cashdebit = $total_balance[0]->cashdebit;
        $creshcrdit = $total_balance[0]->creshcrdit;
        $checkcrdit = $total_balance[0]->checkcrdit;
        $checkdebit = $total_balance[0]->checkdebit;
        $netcrdit = $total_balance[0]->netcrdit;
        $netdebit = $total_balance[0]->netdebit;
        $totalcreadit = $checkcrdit + $netcrdit;
        $totalnetdebit = $netdebit + $checkdebit;

        $cash_balance = $creshcrdit - $cashdebit;
        $bank_balance = $totalcreadit - $totalnetdebit;
       
       
       
        $cashdebit_n = $total_balance1[0]->cashdebit;
        $creshcrdit_n = $total_balance1[0]->creshcrdit;
        $checkcrdit_n = $total_balance1[0]->checkcrdit;
        $checkdebit_n = $total_balance1[0]->checkdebit;
        $netcrdit_n = $total_balance1[0]->netcrdit;
        $netdebit_n = $total_balance1[0]->netdebit;
        $totalcreadit_n = $checkcrdit_n + $netcrdit_n;
        $totalnetdebit_n = $netdebit_n + $checkdebit_n;

        $cash_balance_n = $creshcrdit_n - $cashdebit_n;
        $bank_balance_n = $totalcreadit_n - $totalnetdebit_n;

        $total_cash_balance = $cash_balance_n + $cash_balance;
        $total_bank_balance = $bank_balance + $bank_balance_n;
        $date2 = "";
        $fianlarray = array();

        foreach ($customercedit_list as $cedit) {

            $fianlarray[$cedit->date]['date'] = $cedit->date;
            $fianlarray[$cedit->date]['amount'] = $cedit->amount;
            $fianlarray[$cedit->date]['name'] = $cedit->name;
            $fianlarray[$cedit->date]['id'] = $cedit->id;
            $fianlarray[$cedit->date]['remark'] = $cedit->remark;
            $fianlarray[$cedit->date]['count_status'] = $cedit->count_status;
        }
        foreach ($customerdebit_list as $cedit) {

            $fianlarray[$cedit->date]['date'] = $cedit->date;
            $fianlarray[$cedit->date]['name'] = $cedit->name;
            $fianlarray[$cedit->date]['id'] = $cedit->id;
            $fianlarray[$cedit->date]['remark'] = $cedit->remark;
            $fianlarray[$cedit->date]['d_amount'] = $cedit->amount;
            $fianlarray[$cedit->date]['count_status'] = "";
        }

        //    print_r($fianlarray);

        function sortByName($a, $b) {
            $a = $a['date'];
            $b = $b['date'];

            if ($a == $b)
                return 0;
            return ($a < $b) ? -1 : 1;
        }

        usort($fianlarray, 'sortByName');

        $base_url = base_url();
        $ctotal = 0;
        $dtotal = 0;
        $cnt = 1;
        $html = '';
        $html .= '<tr><td><b>Prevous cash balance</b> </td><td><b>' . $cash_balance . '</b></td><td><b>Prevous Bank balance</b></td><td><b>' . $bank_balance . '</b></td><td></td></tr>';
        $qty = 0;
        $amount = 0;
        $prevbalence = 0;
        $tcredit = 0;
        $debit = 0;
        $cashdebittotal = 0;
        $creshcrdittotal = 0;
        $bank_cradittotal = 0;
        $bank_debittotal = 0;
        //print_r($report_data);
        foreach ($report_data as $credit) {

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

            $cashdebittotal = $credit['cashdebit'] + $cashdebittotal;
            $creshcrdittotal = $credit['creshcrdit'] + $creshcrdittotal;
            $bank_cradittotal = $credit['bank_cradit'] + $bank_cradittotal;
            $bank_debittotal = $credit['bank_debit'] + $bank_debittotal;

            $cashdebit = $credit['cashdebit'];
            $creshcrdit = $credit['creshcrdit'];
            $bank_cradit = $credit['bank_cradit'];
            $bank_debit = $credit['bank_debit'];


            $dtotal = $credit['d_amount'] + $dtotal;
            $debittotal = $credit['d_amount'];

            // $name = $credit['name'];
            // $remark = $credit['remark'];
            $paymentfor = '';
            $msg = '"Are you sure you want to remove this data?"';
            if ($this->session->userdata('logged_company')['type'] == 'c') {
                $edit = "<a href='" . $base_url . "petty_cash_report/petty_cash_report_view?date=" . $credit['date'] . "&sdate=" . $sdate . "&edate=" . $edate . "&l_id=" . $lid . "&member_id=" . $member_id . "'><i class='fa fa-eye'></i></a>  
						 ";
            } else {
                $edit = "";
            }
            $html .= '<tr><td>' . $cnt . '</td><td>' . date('d/m/Y', strtotime($date)) . '</td><td>' . amountfun($creshcrdit) . '</td><td>' . amountfun($cashdebit) . '</td><td>' . amountfun($bank_cradit) . '</td><td>' . amountfun($bank_debit) . '</td>
						<td>
							' . $edit . '
						</td>
					</tr>';
            $cnt++;
        }

        if ($cnt == 0) {
            $html .= '<tr><td colspan="2">No Data avalieble</td></tr>';
        }
        $temp = $total_cash_balance + $total_bank_balance;
        $f_cresh_total = $creshcrdittotal - $cashdebittotal;
        $f_bank_total = $bank_cradittotal - $bank_debittotal;

        $html .= '<tr><td colspan="2">Total</td><td>' . amountfun($creshcrdittotal) . '</td><td>' . amountfun($cashdebittotal) . '</td><td>' . amountfun($bank_cradittotal) . '</td><td>' . amountfun($bank_debittotal) . '</td></tr>';
        $html .= '<tr><td colspan="2"><b>Final Total</b></td><td><b>' . amountfun($f_cresh_total) . '</b></td><td></td><td><b>' . amountfun($f_bank_total) . '</b></td><td></td></tr>';
        $html .= '<tr><td><b>Total cash balance</b> </td><td><b>' . amountfun($total_cash_balance) . '</b></td><td><b>Total Bank balance</b></td><td><b>' . amountfun($total_bank_balance) . '</b></td><td></td></tr>';
        $html .= '<tr><td><b>Final balance</b> </td><td>' . amountfun($temp) . '</td></tr>';
        echo $html;
                    ?>

                </tbody>

            </table>
        </div>


    </body>

</html>