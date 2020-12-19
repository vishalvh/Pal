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
                        <td style="font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;"><br><b>Daily Maintain Report</b></td>
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
            <table width="100%" class="table" style="">
                <thead>
                    <tr>
									<th>Sr no.</th>
									<th>Title</th>
									<th>Result</th>
									<th>Remark</th>
								</tr>
                </thead>
                <tbody>
                    
<?
							$cnt=0;
							foreach($reports as $detail){ ?>
								<tr>
									<td><?php echo ++$cnt; ?></td>
									<td><?php echo $detail->name; ?></td>
									<td><?php echo $detail->report; ?></td>
									<td><?php echo $detail->remark; ?></td>
								</tr>
							<?php }
							?>
							<tr>
							<td colspan="4">
							I, <?php echo ucwords($userdata); ?> Check this all cleaning and maintain all things here. I verified all cleaning by worker and follow rules And regulation . if this is false we are ready to pay fine. 
							</td>
							</tr>
							<tr>
							<td colspan="2">
							<b>SIGNATURE :-</b>
							</td>
							<td style="text-align:right" colspan="2">
							<b>DATE :- <?php echo date('d-m-Y',strtotime($sdate)); ?></b>
							</td>
							</tr>
                </tbody>

            </table>
			
        </div>


    </body>

</html>