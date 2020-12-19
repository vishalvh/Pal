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
                    <td width="3%" style="padding:10px">
                        <img src="<?php echo base_url();?>uploads/<?php echo $location_detail->logo;?>" alt="" width="20%">
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
                                       
                                    <td colspan='2' style="font-weight:normal;padding:5px 0;display: block;font-size: 15px;"><?php echo $location_detail->address;?></td>
                                   </tr>
                                   <tr>
                                       
                                    <td style="font-weight:normal;padding:5px 0px 5px 0px;display: block;font-size: 15px;"><b>GST No.</b> <?php echo $location_detail->gst; ?></td>
                                    <td style="font-weight:normal;padding:5px 0px 5px 0px;display: block;font-size: 15px;"><b>TIN No.</b> <?php echo $location_detail->tin; ?></td>
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
                                        <td colspan='2' style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Stock Patrak - <?php if($fueltype == "p"){ echo "Petrol"; } if($fueltype == "d"){ echo "Diesel"; } ?></td>
				</td>
                <tr>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Start Date:<?php echo date('d/m/Y',strtotime($sdate));?></td>
                    <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">End Date:<?php echo date('d/m/Y',strtotime($edate)); ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table" style="">
            <thead>
                            <tr>
                                <th width="12.5%">Date</th>
                                <th width="12.5%">Opening <?php if($fueltype == "p"){ echo "Petrol"; }
								  if($fueltype == "d"){ echo "Diesel"; } ?> Stock</th>
                                <th width="12.5%">Purchase Quantity</th>
								<th width="12.5%">Total</th>
                                <th width="12.5%">Selling</th>
                                <!--<th width="12.5%">Testing</th>-->
                                <th width="12.5%">Sort</th>
                                <th width="12.5%">Closing</th>
                                <th width="12.5%">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							$p_d_total_selling = 0;
							$p_d_quantity = 0;
							$p_p_total_selling = 0;
							$p_p_quantity = 0;
							$p_sort = 0; 
							$d_sort = 0;
                            $cnt=0;
                            foreach($report as $r){
                                if((strtotime($sdate) <= strtotime($r['date'])) && $cnt == 0){
                                    $cnt++;
                                }
                                if($cnt == 0){
                                    
                                }else{
                                ?>
                            <tr>
                                <td><?php echo date("d-m-Y",strtotime($r['date'])); ?></td>
                                <td><?php if($fueltype == "p"){ echo $stock = amountfun($r['p_opening_original_stock']); }
                                          if($fueltype == "d"){ echo $stock = amountfun($r['d_opening_original_stock']); } ?></td>
                                <td><?php if($fueltype == "p"){ echo amountfun($r['p_quantity']); }
                                          if($fueltype == "d"){ echo amountfun($r['d_quantity']); }
                                ?></td>
								<td><?php if($fueltype == "p"){ echo amountfun($r['p_quantity']+$r['p_opening_original_stock']); }
                                          if($fueltype == "d"){ echo amountfun($r['d_quantity']+$r['d_opening_original_stock']); }
                                ?></td>
                                <td><?php if($fueltype == "p"){ echo amountfun($r['p_total_selling']); }
                                          if($fueltype == "d"){ echo amountfun($r['d_total_selling']); } ?></td>
                                <td><?php if($fueltype == "p"){ echo amountfun($r['pshort']);  }
                                          if($fueltype == "d"){ echo amountfun($r['dshort']);  } ?></td>
                                <td><?php if($fueltype == "p"){ echo amountfun($r['p_closing_original_stock']);  }
                                          if($fueltype == "d"){ echo amountfun($r['d_closing_original_stock']);  } ?>
                                </td>
                                <td>
                                <?php if($fueltype == "p"){ 
                                    echo amountfun($r['pet_price']); 
                                }
                                      if($fueltype == "d"){ 
                                    echo amountfun($r['dis_price']); 
                                } ?>
                                </td>
                            </tr>
                            <?php
$p_d_total_selling = $p_d_total_selling + $r['d_total_selling'];
$p_d_quantity = $p_d_quantity + $r['d_quantity'];
$p_p_total_selling = $p_p_total_selling + $r['p_total_selling'];
$p_p_quantity = $p_p_quantity + $r['p_quantity'];
$p_sort = $p_sort + $r['pshort'];
$d_sort = $d_sort + $r['dshort'];

$cnt++;
								}}?>
								<tr>
								<td>Total</td>
								<td></td>
								<td>
								<?php if($fueltype == "p"){ 
									echo amountfun($p_p_quantity);
								}else{
									echo amountfun($p_d_quantity); 
								}?></td>
								<td></td>
								<td>
								<?php if($fueltype == "p"){ 
									echo amountfun($p_p_total_selling);
								}else{
									echo amountfun($p_d_total_selling);
								}?>
								</td>
								<td>
								<?php if($fueltype == "p"){ 
									echo amountfun($p_sort);
								}else{
									echo amountfun($d_sort);
								}?>
								</td>
								<td>
								<?php //echo $dev; ?>
								</td>
								<td colspan="2">
								</td>
								</tr>
                        </tbody>
                            
        </table>
    </div>
    


</body>

</html>