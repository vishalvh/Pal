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

                                        <td style="font-weight:normal;border-bottom: 2px solid #000;padding:10px 0;border-top: 2px solid #000;display: block;font-size: 15px">Dealer: <?php echo $location_detail->dealar; ?>.</td>
                                    </tr>
                                    <tr>

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px"><?php echo $location_detail->address; ?></td>
                                    </tr>
                                    <tr>

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;"> Gst No.<?php echo $location_detail->gst; ?></td>
                                    </tr>  
                                    <tr>

                                        <td style="font-weight:normal;padding:10px 0;display: block;font-size: 15px;"> Tin No.<?php echo $location_detail->tin; ?></td>
                                    </tr> 	
<tr>
                        <td style="font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;"><br><b>Daily Density Report</b></td>
                        </td>
					</tr>									
                                </tbody>
                            </table>


                        </td>
                    </tr>
                </tbody>
            </table>
            <hr style="border:1px solid #000">
            <br>
            <br>
            <br>
            <table class="table">
							<thead>
							<tr>
					<th>Date</th>
					<th colspan="3"><center>Observed Morning Density</center></th>
					<th colspan="4"><center>Receipt Tank Truck</center></th>
					<th colspan="4"><center>Density At 15 c After Decanting TT And After Dispensing 50 LTS. Of Product</center></th>
					</tr>
					<tr>
					<th>Date</th>
					<th>Hydro Reading</th>
					<th>Temp</th>
					<th>Converted</th>
					<th>Challan No</th>
					<th>Quantity</th>
					<th>Density Per Challan</th>
					<th>Observed Density In Tank Truck</th>
					<th>Hydrometer Reading</th>
					<th>Temp</th>
					<th>Converted</th>
					<th>User Name</th>
					</tr>
							</thead>
							<tbody>
							<? $cnt=0;
							foreach($reports as $detail){ ?>
					<tr>
					<td><?php echo date('d-m-Y',strtotime($detail->date)); ?></td>
					<td><?php echo $detail->hydro_reading; ?></td>
					<td><?php echo $detail->temp; ?></td>
					<td><?php echo $detail->density; ?></td>
					
					<td><?php
					echo $detail->inventoryData->invoice_no; 
					?></td>
					<td><?php if($type == 'p'){
						echo $detail->inventoryData->p_quantity; 
					}else{
						echo $detail->inventoryData->d_quantity;
					}?></td>
					<td><?php if($type == 'p'){
						echo $detail->inventoryData->p_invoice_density; 
					}else{
						echo $detail->inventoryData->d_invoice_density;
					}?></td>
					<td><?php if($type == 'p'){
						echo $detail->inventoryData->p_observer_density; 
					}else{
						echo $detail->inventoryData->d_observer_density;
					}?></td>
					<td><?php if($type == 'p'){
						echo $detail->daily_density->p_decant_hydro_reading; 
					}else{
						echo $detail->daily_density->d_decant_hydro_reading;
					}?></td>
					<td><?php if($type == 'p'){
						echo $detail->daily_density->p_decant_temp; 
					}else{
						echo $detail->daily_density->d_decant_temp;
					}?>
					</td>
					<td><?php if($type == 'p'){
						echo $detail->daily_density->p_decant_density; 
					}else{
						echo $detail->daily_density->d_decant_density;
					}?></td>
					<td><?php echo $detail->inventoryData->UserFName.' '.$detail->inventoryData->UserLName; ?></td>
					</tr>
							<?php } ?>
							</tbody>
						</table>
			
        </div>


    </body>

</html>