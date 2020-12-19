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
					<td colspan='2' style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;"><?php  if($worker_id == ""){ ?> Worker <?php }else{ ?> <?php echo $salary[0]->name; } ?>  Salary Report</td>
				</td>
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
								 <th>Sr No</th>
								<?php  if($worker_id == ""){ ?>
								  <th>Name</th>
								<?php } ?>
								  <th>Salary</th>
								  <th>Bonus</th>
								  <th>Extra Pay</th>
								  <th>Paid Salary</th>
								  <th>Paid Loan</th>
								  <th>Total</th>
								  <th>Advance</th>
								  <th>Past Loan</th>
								  <th>Total Loan</th>
								  <th>Remaining Loan</th>
								  
								  </tr>
                                </thead>
                                <tbody>
                                    <?php  
							
    $base_url = base_url();
        $html = "";
        $msg = '"Are you sure you want to remove this data?"';
        $salarytotal = 0;
        $bonas_amount = 0;
        $extra_amount = 0;
        $totaldebit = 0;
        $paid_loan_amount = 0;
        $advance = 0;
        $past_loan_amount = 0;
        foreach ($salary as $salary_detail) {
            $html .= "<tr>";

            $no++;
            $html .= "<td>" . $salary_detail->code . "</td>";
			if($worker_id == ""){
            $html .= "<td>" . $salary_detail->name . "</td>";
		}
//            $html .= "<td>" . $salary_detail->m_salary . "</td>";
            if($salary_detail->salary != 0){
                $salary = $salary_detail->salary;
            
            }else{
                $salary = $salary_detail->c_salary;
                 //$html .= "<td>" . round($salary_detail->c_salary, 2) . "</td>";
            }
            $html .= "<td>" . amountfun($salary) . "</td>";
            $html .= "<td>" . amountfun($salary_detail->bonas_amount) . "</td>";
            $html .= "<td>" . amountfun($salary_detail->extra_amount) . "</td>";
            $html .= "<td>" . amountfun($salary_detail->totaldebit) . "</td>";
            $html .= "<td>" . amountfun($salary_detail->paid_loan_amount) . "</td>";
            $html .= "<td>" . amountfun($salary_detail->salary + $salary_detail->bonas_amount + $salary_detail->extra_amount - $salary_detail->paid_loan_amount) . "</td>";
            $html .= "<td>" . amountfun($salary_detail->advance) . "</td>";
            $html .= "<td>" . amountfun($salary_detail->past_loan_amount) . "</td>";
            $html .= "<td>" . amountfun($salary_detail->past_loan_amount + $salary_detail->advance) . "</td>";
            $html .= "<td>" . amountfun($salary_detail->past_loan_amount + $salary_detail->advance - $salary_detail->paid_loan_amount) . "</td>";
         
            $html .= "</tr>";
            if ($salary_detail->active == 1 ) {
                $salarytotal = $salarytotal + $salary;
            }
            if ($salary_detail->active == 1) {
                $bonas_amount = $bonas_amount + $salary_detail->bonas_amount;
            }
            if ($salary_detail->active == 1) {
                $extra_amount = $extra_amount + $salary_detail->extra_amount;
            }
            if ($salary_detail->active == 1) {
                $totaldebit = $totaldebit + $salary_detail->totaldebit;
            }
            if ($salary_detail->active == 1) {
                $paid_loan_amount = $paid_loan_amount + $salary_detail->paid_loan_amount;
            }
              if($salary_detail->active == 1){
            $advance = $advance + $salary_detail->advance;
              }
              
            $past_loan_amount = $past_loan_amount + $salary_detail->past_loan_amount;
              
        }
        
        $rmloan = $past_loan_amount + $advance - $paid_loan_amount;
        $totalloan = $past_loan_amount + $advance;
        $totalsalary = $salarytotal + $bonas_amount + $extra_amount - $paid_loan_amount;
		$colspan = 1;
		if($worker_id == ""){
			$colspan = 2;
		}
        $html .= "<tr><td colspan='".$colspan."'>Total</td><td>".amountfun($salarytotal)."</td><td>".amountfun($bonas_amount)."</td><td>".amountfun($extra_amount)."</td><td>".amountfun($totaldebit)."</td><td>".amountfun($paid_loan_amount)."</td><td>".amountfun($totalsalary)."</td><td>".amountfun($advance)."</td><td>".amountfun($past_loan_amount)."</td><td>".amountfun($totalloan)."</td><td>".amountfun($rmloan)."</td></tr>";
        echo $html;
        ?>
                                    
                                </tbody>
                            
        </table>
    </div>


</body>

</html>