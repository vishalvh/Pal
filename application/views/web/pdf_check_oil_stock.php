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
                        <td colspan='2' style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Oil Stock Report</td>
                        </td>
                    <tr>
                        <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">Start date:<?php echo date('d/m/Y', strtotime($sdate)); ?></td>
                        <td style="font-size:21px;font-weight:bold;text-align:center;padding:7px 0px;">End Date:<?php echo date('d/m/Y', strtotime($edate)); ?></td>
                    </tr>
                </tbody>
            </table>
            <hr style="border:1px solid #000">
        <br>
        <table width="100%" class="table" style="">
							<thead>
							<tr>
								<th>Name</th>
								<th>Stock</th>
								<?php for($i=$sdate; strtotime($edate) >= strtotime($i);$i = date('Y-m-d', strtotime($i . ' +1 day'))){ ?>
								<th ><?php echo date('d',strtotime($i)); ?></th>
								<?php } ?>
								<th>Stock</th>
							</tr>
							</thead>
							<tbody>
								<?php
$olisellingtotalday =array();
$startstock = 0;
								foreach ($startoilstock as $oil_data){ ?>
								
								<tr>
									<td nowrap><?php echo $oil_data->packet_type ?></td>
									<!--<td><?php echo $oil_data->stock; $startstock = $startstock+$oil_data->stock; ?></td>-->
									<td><?php echo $ssoil[$oil_data->id]; $startstock = $startstock+$ssoil[$oil_data->id]; ?></td>
									<?php for($i=$sdate; strtotime($edate) >= strtotime($i);$i = date('Y-m-d', strtotime($i . ' +1 day'))){ ?>
									<td data-toggle="tooltip" title=" <?php echo $oil_data->packet_type ?> <?=date('d/m/Y', strtotime($i))?>" >
									<?php 
										if(isset($oilsellingparday[$i][$oil_data->id])) { 
										echo $oilsellingparday[$i][$oil_data->id];
										$olisellingtotalday[$i] = $olisellingtotalday[$i] + $oilsellingparday[$i][$oil_data->id];
										}else{ echo '0'; } 
									?></td>
									<?php } ?>
									<td >
									<?php foreach($endoilstock as $estok){
										if($estok->id == $oil_data->id){
											$endstock = $endstock + $estok->stock;
											echo $estok->stock;
										}
									}?>
									</td>
								</tr>
								<?php } ?>
							
							 
							 <tr>
							<td>Total</td>
							<td><?php echo $startstock; ?></td>
							<?php for($i=$sdate; strtotime($edate) >= strtotime($i);$i = date('Y-m-d', strtotime($i . ' +1 day'))){ ?>
							<td nowrap><?php if(isset($olisellingtotalday[$i])) { echo $olisellingtotalday[$i]; }else{ echo '0'; }?></td>
							<?php } ?>
							<td><?php echo $endstock; ?></td>
							</tr>
							</tbody>
							</table> </div>


    </body>

</html>