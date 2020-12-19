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
					<td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Expense Report </td>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;"><?php echo date('d/m/Y',strtotime($sdate)); ?> TO <?php echo date('d/m/Y',strtotime($edate)); ?> </td>
                   
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
                    <th>Date</th>
					<th>Type</th>
					<th>Reason</th>
                    <th>Total</th>
                  
                </tr> 
            </thead>
            <tbody>
                <?php $qty = 0; $amount = 0; $cnt=1; foreach($customerceditlist as $expense){ 
				$tamount1 = 0;
				$tamount2 = 0;
				$date = $expense->date;
				$l_name = $expense->l_name;
				$ftotal = amountfun($expense->total+$ftotal); 
				$total = amountfun($expense->total);
				$exps_name = $expense->exps_name;
				$reson = $expense->reson;
				$paymentfor = '';?>
				<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo date('d/m/Y',strtotime($date));?></td>
				
				<td><?php echo $exps_name;?></td>
				<td><?php echo $reson;?></td>
				<td><?php echo $total ?></td>
				
				</tr>
				<?php  
				
				$cnt++; 
			}
			if($cnt == 0){
				$html .= '<tr><td colspan="6">No Data avalieble</td></tr>';
			}
			
			$prevbalence = $totalprev_credit->totalamount-$totalprev_debit->totalamount;
			$final = $amount-$totaldebit->totalamount+$prevbalence;
			?>
			<tr class="bold"><td colspan="4">Total</td><td><?php echo $ftotal;?></td></tr>
			
			
			
             
             
            </tbody>
        </table>
    </div>


</body>

</html>