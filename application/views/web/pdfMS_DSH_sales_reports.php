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
                        <td colspan='2' style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;"><?php if($type == 'd'){ echo "Diesel"; }else{ echo "Petrol"; }?> DSR Report</td>
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
                                        <th>Date</th>
										<?php foreach ($tank_list as $locationtank) {
											if ($locationtank->fuel_type == $type) { ?>
												<th><?php echo $locationtank->tank_name; ?> Dip</th>
												<th>Water Dip</th>
											<?php }
										} ?>
                                        <th>OPENING STOCK</th>
                                        <th>RECEIPT</th>
                                        <th>TOTAL STOCK</th>
										<?php foreach ($pump_list as $locationtank) {
											if ($locationtank->type == $type) { ?>
												<th><?php echo $locationtank->name; ?></th>
											<?php }
										} ?>
										<th>Testing</th>
										<th>SALES</th>
										<th>CUMULATIVE SALES</th>
                                    </tr>
                                </thead>
								
                                <tbody>
								<?php foreach($stock_list as $stock){ ?>
								<tr>
                                        <td><?php echo date('d-m-Y',strtotime($stock->DATE)); ?></td>
										<?php foreach ($tank_list as $locationtank) {
											if ($locationtank->fuel_type == $type) { ?>
												<td><?php echo amountfun($finaltank[$stock->DATE][$type][$locationtank->id]); ?></td>
												<td>0</td>
											<?php }
										} ?>
                                        <td><?php if($type=='d'){ $openingstock = $stock->d_tank_reading; } else{ $openingstock = $stock->p_tank_reading; } echo amountfun($openingstock);  ?></td>
                                        <td>
										<?php
											echo amountfun($purches_stock_list[$stock->DATE][$type]);
										?>
										</td>
                                        <td><?php echo amountfun($openingstock+$purches_stock_list[$stock->DATE][$type]); ?></td>
										<?php foreach ($pump_list as $locationtank) {
											if ($locationtank->type == $type) { ?>
												<td><?php echo amountfun($reading_data[$stock->DATE][$locationtank->id]); ?></td>
											<?php }
										} ?>
										<td><?php if($type=='d'){ $testing = $stock->d_testing; } else{ $testing = $stock->p_testing; } echo amountfun($testing); ?></td>
										<td><?php if($type=='d'){ $saleing = $stock->d_total_selling; } else{ $saleing = $stock->p_total_selling; } echo amountfun($saleing); $totalsaleing = $saleing + $totalsaleing; ?></td>
										<td><?php echo amountfun($totalsaleing); ?></td>
                                    </tr>
								<?php } ?>
                                </tbody>

            </table>
        </div>


    </body>

</html>