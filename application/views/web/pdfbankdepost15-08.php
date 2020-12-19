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
                        <th>Cheque Amount</th>
                        <th>Cheque Number</th>
                        <th>Withdraw Amount</th>

                        <th>Withdraw Transection Number</th>
                         <th>Card Amount</th>
                        <th>Batch No</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php

                    function sortByName($a, $b) {
                        $a = $a->date;
                        $b = $b->date;

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
                    $list1 = array_merge($list, $onlinelist);
                   $list2 =  array_merge($list1,$creadit_dabit_list);
           //    print_r($list1);
              // array_multisort($list1,SORT_ASC,SORT_NUMERIC);
            $count = count($list2);
// Print array elements before sorting
            usort($list2, 'sortByName');
         
       	foreach ($list2 as $customers) 
       	{
                        $html .= "<tr>";

                        $no++;
                        if ($customers->flage == '1') {
                            $edit = "<a href='" . $base_url . "bank_deposit/bankdeposit_edit/" . $customers->id . " '><i class='fa fa-edit'></i></a>   
			<a href='" . $base_url . "bank_deposit/bankdeposit_delete/" . $customers->id . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a>";
                        } else if ($customers->flage == '2') {
                            $edit = "<a href='" . $base_url . "bank_deposit/bankdonlineeposit_edit/" . $customers->id . " '><i class='fa fa-edit'></i></a> <a href='" . $base_url . "bank_deposit/bankdonlineeposit_delete/" . $customers->id . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a>";
                        }else if($customers->flage == '3'){
                             $edit = "";
                        }
                        $dep = $customers->deposit_amount + $customers->depositamonut;
                        $html .= "<td>" . $no . "</td>";
                        $html .= "<td>" . date('d-m-Y', strtotime($customers->date)) . "</td>";
                        $html .= "<td>" . $customers->deposit_amount . "</td>";
                        $html .= "<td>" . $customers->depositamonut . "</td>";
                        $html .= "<td>" . $customers->cheque_no . "</td>";
                        $html .= "<td>" . $customers->amount . "</td>";

                        $html .= "<td>" . $customers->cheque_tras_no . "</td>";
                        $html .= "<td>".$customers->card_amount."</td>";
                        $html .= "<td>".$customers->batch_no."</td>";
                        //$html .= "<td>".$deposited_by."</td>";


                        $html .= "</tr>";
                        $deposit = $deposit + $customers->deposit_amount;
                        $withdraw = $withdraw + $customers->depositamonut;
                        $card_amount = $card_amount + $customers->card_amount;
                        $onlinetrasectin = $onlinetrasectin + $customers->amount;
                    }
                    $html .= "<tr><td colspan='2'>Total</td><td>".number_format($deposit, 2)."</td><td>".number_format($withdraw, 2)."</td><td></td><td>". number_format($onlinetrasectin, 2)."</td><td ></td><td>". number_format($card_amount, 2)."</td><td colspan='3'></td></tr>"; 
                    echo $html;
                    ?>

                </tbody>

            </table>
        </div>


    </body>

</html>