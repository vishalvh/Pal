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
				<td style="font-size: 35px;display: block;text-align: center;font-weight: bold;border-bottom: 2px solid #000;" colspan='2'>TAX INVOICE</td>
			</tr>
								
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
                                    <td style="font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;" colspan='2'><?php echo $location_detail->l_name; ?></td>
                                </tr>
                                   <tr>
                                       
                                    <td colspan='2' style="font-weight:normal;border-bottom: 2px solid #000;padding:5px 0;border-top: 2px solid #000;display: block;font-size: 15px;text-align: center">Dealer: <b><?php echo $location_detail->dealar; ?></b></td>
                                   </tr>
                                   <tr>
                                       
                                    <td colspan='2' style="font-weight:normal;padding:5px 0;display: block;font-size: 18px;"><?php echo $location_detail->address;?></td>
                                   </tr>
                                   <tr>
                                       
                                    <td style="font-weight:normal;padding:5px 0px 5px 0px;display: block;font-size: 18px;"><b>GST No.</b> <?php echo $location_detail->gst; ?></td>
                                    <td style="font-weight:normal;padding:5px 0px 5px 0px;display: block;font-size: 18px;"><b>TIN No.</b> <?php echo $location_detail->tin; ?></td>
									 </tr>  
									 <tr>
									 <td colspan='2'><br></td>
									 </tr>
									 <tr>
									 <td colspan='2' style="font-weight:normal;padding:5px 0;display: block;font-size: 20px; text-align:center;border-top: 2px solid #000;"><b style="border-bottom:5px double #000;">RTGS Detail</b></td>
									 </tr>
<tr>
									<td style="font-weight:normal;padding:5px 0;display: block;font-size: 18px;"><b>Bank Name.</b> <?php echo $location_detail->bankname; ?></td>
									<td style="font-weight:normal;padding:5px 0;display: block;font-size: 18px;"><b>A/C No.</b> <?php echo $location_detail->acno; ?></td>
									</tr>  
<tr>
									<td colspan='2' style="font-weight:normal;padding:5px 0;display: block;font-size: 18px;"><b>A/C Name.</b> <?php echo $location_detail->acname; ?></td>
									</tr>
									<tr>
									<td colspan='2' style="font-weight:normal;padding:5px 0;display: block;font-size: 18px;"><b>Branch.</b> <?php echo $location_detail->branchname; ?></td>
									</tr>  
<tr>
									<td style="font-weight:normal;padding:5px 0;display: block;font-size: 18px;"><b>IFSC (RTGS) Code.</b> <?php echo $location_detail->ifsccode; ?> 
									</td>
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
                    <td style="text-align:left;font-size:21px;font-weight:bold;padding:7px 0px;">Name:<?php echo ucwords($custdetail->name)?></td>
                    <td style="text-align:right;font-size:15px;font-weight:bold;padding:7px 0px;">Billing Date:<?php echo date('d/m/Y',strtotime($_GET['edate'])); ?>
					<br>Printing Date:<?php echo $bildate; ?>
					<br>Due Date:<?php echo  date('d/m/Y', strtotime($_GET['edate']. ' + 5 days'));   ?>
					</td>
                </tr>
				<tr>
                    <td style="font-size:15px;padding:7px 0px;" colspan="2">Address:<?php echo ucwords($custdetail->address)?></td>
				</tr>
				<tr>
					<td style="font-size:15px;padding:7px 0px;" colspan="2">Pan Number: <?php echo strtoupper($custdetail->pan_number)?></td>
				</tr>
				<tr>
					<td style="font-size:15px;padding:7px 0px;" colspan="2">GST Number: <?php echo strtoupper($custdetail->gst_number)?></td>
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
                    <th width="10%">SR.No</th>
                    <th width="15%">Date</th>
                    <th width="20%">Vehicle No.</th>
                    <th width="10%">Bill No</th>
					<th width="10%">Price</th>
                    <th width="10%">Litre</th>
                    <th width="20%">Rs</th>
                </tr>
            </thead>
            <tbody>
                <?php $qty = 0; $amount = 0; $cnt=1; foreach($customerceditlist as $credit){ ?>
				<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo date('d/m/Y',strtotime($credit->date));?></td>
				<td><?php echo $credit->vehicle_no;?></td>
				<td><?php echo $credit->bill_no; ?></td>
				<?php if($credit->fuel_type == 'Diesel'){ ?>
					<td><?php echo $credit->dis_pri; ?></td>
				<?php } else if($credit->fuel_type == 'Petrol'){ ?>
					<td><?php echo amountfun($credit->pet_pri); ?></td>
				<?php } else{ ?>
					<td></td>
				<?php } ?>
				<td><?php echo amountfun($credit->quantity); $qty = $qty+$credit->quantity?></td>
				<td><?php echo amountfun($credit->amount);?></td>
				</tr>
				<?php  $amount = $amount+$credit->amount;
				
				$cnt++; 
			}
			if($cnt == 0){
				$html .= '<tr><td colspan="7">No Data avalieble</td></tr>';
			}
			
			$prevbalence = $totalprev_debit->totalamount-$totalprev_credit->totalamount;
			$final = $amount-$totaldebit->totalamount-$prevbalence;
			?>
			<tr class="bold"><td colspan="5">Total</td><td><?php echo $qty;?></td><td><?php echo amountfun($amount);?></td></tr>
			
			<tr>
				<td colspan="4" rowspan="2" style='text-align:left'>
				<b>FINANCE CHARGE</b><?php if($location_detail->fcharge == ""){ ?>
				is 3:% per month or amount off 5% (monthly) any 
				<center>Previous Balance Paid in 30 days</center>
				<?php }else{
					echo $location_detail->fcharge;
				} ?>
				</td>
				<td colspan="2" style="text-align:right"; >Total Paid Amount</td><td><?php echo amountfun($totaldebit->totalamount); ?></td>
			</tr>';
			<tr>
				
				<td  style="text-align:right"; colspan="2">Previous Balance</td><td><?php echo amountfun($prevbalence); ?> </td>
			</tr>
			<tr>
			<td colspan="4"  style='text-align:left'>
				<b>Terms & Condition</b><br>
				1. "Subject to MANSA Jurisdiction only. E.&.O.E"<br>
				2. "Goods once sold will not be taken back."
				</td>
				<td  style="text-align:right"; colspan="2"><b>Final Total Due Amount</b></td><td><?php echo amountfun($final); ?></td> 
			</tr>
			
             
             
            </tbody>
        </table>
    </div>


</body>

</html>