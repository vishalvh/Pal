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
                                       
                                    <td style="font-weight:normal;border-bottom: 2px solid #000;padding:10px 0;border-top: 2px solid #000;display: block;font-size: 15px;"><b>Dealer: <?php echo $location_detail->dealar; ?>.</b></td>
                                   </tr>
                                   <tr>
                                       
                                    <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;"><?php echo $location_detail->address;?></td>
                                   </tr>
                                   <tr>
                                       
                                    <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;"> Gst No.<?php echo $location_detail->gst; ?></td>
                                   </tr>  
<tr>
                                       
                                    <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;"> Tin No.<?php echo $location_detail->tin; ?></td>
                                   </tr> 		

<tr>
                                    <td style="font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;"><br><br>Company Report</td>
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
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Date:<?php echo date('d/m/Y',strtotime($sdate)); ?> To <?php echo date('d/m/Y',strtotime($edate)); ?></td>
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
									<th>Batch No /<br> Transaction Number </th>
									<th>Deposit Amount</th>
									<th>Withdraw Amount</th>
									<th>Credit Amount</th>
									<th>Debit Amount</th>
								</tr>	
            </thead>
            <tbody>
                <?php 
				$cnt=1;
			$html = '';
			//$html .= '<tr><td colspan ="2">Previous Balance</td><td>'.number_format($prv_ioc_total->totalamount,2).'</td><td>'.number_format($prv_transection_total->totalamount,2).'</td><td>'.number_format($prv_purchase_total->d_total_amount+$prv_purchase_total->p_total_amount,2).'</td></tr>';
			$openingstock = ($prv_ioc_total->totalamount+$prv_transection_total->totalamount+$total_company_credit->totalamount)-($prv_purchase_total->d_total_amount+$prv_purchase_total->p_total_amount+$total_company_debit->totalamount);
			$html .= '<tr><td colspan ="2">Opening Balance</td><td>'.amountfun(($prv_ioc_total->totalamount+$prv_transection_total->totalamount+$total_company_credit->totalamount)-($prv_purchase_total->d_total_amount+$prv_purchase_total->p_total_amount+$total_company_debit->totalamount)).'</td><td></td><td></td><td></td><td></td></tr>';
			foreach($fianlarray as $creditdetail){
				$company_credit = $company_credit + $company_credit_debit['c'][$creditdetail["date"]];
				$company_debit = $company_debit + $company_credit_debit['d'][$creditdetail["date"]];
				$html .= '<tr><td>'.$cnt.'</td><td>'.date("d-m-Y",strtotime($creditdetail["date"])).'</td><td>'.amountfun($creditdetail["amount"]).'</td><td>'.amountfun($creditdetail["wamount"]).'</td><td>'.amountfun($creditdetail["pamount"]).'</td>
				<td>'.amountfun($data['company_credit_debit']['c'][$creditdetail["date"]]).'</td>
					<td>'.amountfun($data['company_credit_debit']['d'][$creditdetail["date"]]).'</td>
					</tr>';
				$cnt++;
			}
			if($cnt == 0){
				$html .= '<tr><td colspan="8">No Data avalieble</td></tr>';
			}
			
			$html .= '<tr><td colspan="2">Balance</td><td>'.amountfun($amount).'</td><td>'.amountfun($wamount).'</td><td>'.amountfun($pamount).'</td><td>'.amountfun($company_credit).'</td><td>'.amountfun($company_debit).'</td></tr>';
$html .= '<tr><td colspan="2">Closing Balance</td><td colspan = "5">'.amountfun((($openingstock)+$amount+$wamount+$company_credit)-($pamount+$company_debit)).'</td></tr>';
			echo $html;
			?>
			
            </tbody>
        </table>
    </div>


</body>

</html>