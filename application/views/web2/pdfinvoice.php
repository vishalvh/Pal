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
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Name:<?php echo ucwords($custdetail->name)?></td>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Date:<?php echo date('d/m/Y'); ?></td>
                </tr>
				<tr>
                    <td style="font-size:15px;padding:7px 0px;" colspan="2">Address:<?php echo ucwords($custdetail->address)?></td>
                    
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
                    <th>SR.No</th>
                    <th>Date</th>
                    <th>Vehicle Num</th>
                    <th>Bill No</th>
                    <th>Liter</th>
                    <th>Rs</th>
                </tr>
            </thead>
            <tbody>
                <?php $qty = 0; $amount = 0; $cnt=1; foreach($customerceditlist as $credit){ ?>
				<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo date('d/m/Y',strtotime($credit->date));?></td>
				<td><?php echo $credit->vehicle_no;?></td>
				<td><?php echo $credit->bill_no; ?></td>
				<td><?php echo $credit->quantity; $qty = $qty+$credit->quantity?></td>
				<td><?php echo $credit->amount;?></td>
				</tr>
				<?php  $amount = $amount+$credit->amount;
				
				$cnt++; 
			}
			if($cnt == 0){
				$html .= '<tr><td colspan="6">No Data avalieble</td></tr>';
			}
			
			$prevbalence = $totalprev_credit->totalamount-$totalprev_debit->totalamount;
			$final = $amount-$totaldebit->totalamount+$prevbalence;
			?>
			<tr class="bold"><td colspan="4">Total</td><td><?php echo $qty;?></td><td><?php echo $amount;?></td></tr>
			
			<tr><td colspan="5">Total Paid amount </td><td><?php echo $totaldebit->totalamount; ?></td></tr>';
			<tr><td colspan="5">Previes Belance </td><td><?php echo $prevbalence; ?> </td></tr>
			<tr><td colspan="5">Final Total Due Amount</td><td><?php echo $final; ?></td></tr>
			
             
             
            </tbody>
        </table>
    </div>


</body>

</html>