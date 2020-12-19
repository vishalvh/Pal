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
									<tr>
									<td style="font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;">Salary Slip</td>
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
					<td  style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Name : </td>
					<td  style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;"><?php echo $bd[0]->worker_name; ?></td>
				</td>
				</tr>
                <tr>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Start date:<?php echo date('d/m/Y',strtotime($sdate));?></td>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">End Date:<?php echo date('d/m/Y',strtotime($edate)); ?></td>
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
                                                 <td>Date</td>
                                                <td>Paid Salary</td>
                                            <td>Extra Amount</td>
											<td>Bonus Amount</td>
											<td>Paid Amount</td>
                                            <td>Loan Amount</td>
                                            <td>Paid Loan Amount</td>
                                            <td>Remaning Loan</td>
                                            
                                            <td>Remark</td>
								  </tr>
                                </thead>
                                <tbody>
                                   <?php $cnt = 1; foreach ($bd as $salary){ ?>
                                            <tr><td> <?php  echo date('d/m/Y', strtotime($salary->date));  ?> </td>
                                                  <td> <?php echo $salary->amount; ?> </td>
                                                   <td> <?php echo $salary->extra_amount; ?> </td>
												   <td> <?php echo $salary->bonas_amount; ?> </td>
                                                   <td> <?php echo $salary->extra_amount+$salary->amount+$salary->bonas_amount; ?> </td>
                                                    <td> <?php echo $salary->loan_amount; ?> </td>
                                                     <td> <?php echo $salary->paid_loan_amount; ?> </td>
													 <td> <?php echo $pastloan = ($salary->loan_amount+$pastloan) - $salary->paid_loan_amount; ?> </td>
                                                     
                                                      <td> <?php echo $salary->remark; ?> </td>
													  </tr>
                                      <?php } ?>
<tr><td colspan="9">
<b>This is computer generated payslip and does not require any signature</b></td>
</tr>									  
                                </tbody>
                            
        </table>
    </div>


</body>

</html>