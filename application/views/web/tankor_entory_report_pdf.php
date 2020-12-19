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
                        <td style="font-size: 35px;display: block;text-align: center;font-weight: bold;padding:10px 0;"><br><b>Tanker Variation Report</b></td>
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
	<?php foreach($result as $list){ ?>
	<tr><th colspan="2"><center>Date : <?php echo date('d-m-Y',strtotime($list->date));?><center></th></tr>
	<tr>
		<td>
			<table width="100%" class="table" style="">
			<thead>
			<tr>
			<th>Tank Name</th>
			<th>BEFOR DEEP</th>
			<th>BEFORE LITER</th>
			<th>AFTER DEEP</th>
			<th>AFTER LITER</th>
			<th>Add Stock</th>
			</tr>
			</thead>
			<tbody id="newdata">
			<?php $addstock = 0; foreach($list->tankdetail as $tankdetail){ ?>
			<tr>
			<td><?php echo $tankdetail->name;?></td>
			<td><?php echo $tankdetail->befor_deep;?></td>
			<td><?php echo $tankdetail->befor_liter;?></td>
			<td><?php echo $tankdetail->after_deep;?></td>
			<td><?php echo $tankdetail->after_liter;?></td>
			<td><?php echo $add = $tankdetail->after_liter-$tankdetail->befor_liter; $addstock = $addstock+$add; ?></td>
			</tr>
			<?php } ?>
			<tr>
			<th colspan='5'>Add stock</th>
			<td><?php echo $addstock; ?></td>
			</tr>
			</tbody>
			</table>
		</td>
		<td>
			<table width="100%" class="table" style="">
			<thead>
			<tr>
			<th>Name</th>
			<th>BEFORE MITER</th>
			<th>AFTER METER</th>
			<th>TOTAL SALE</th>
			</tr>
			</thead>
			<tbody id="newdata">
			<?php $totalselling = 0; foreach($list->meterdetail as $meterdetail){ ?>
			<tr>
			<td><?php echo $meterdetail->name;?></td>
			<td><?php echo $meterdetail->befor_meter;?></td>
			<td><?php echo $meterdetail->after_meter;?></td>
			<td><?php echo $meterdetail->selling; $totalselling = $totalselling+$meterdetail->selling;?></td>
			</tr>
			<?php } ?>
			<tr>
			<th colspan ='3'> Total Selling </td>
			<td><?php echo $totalselling; ?></td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td  colspan="2">
			<table width="100%" class="table" style="">
			<thead>
			<tr>
			<th>BUYING LITER</th>
			<th>ADD STOCK</th>
			<th>TOTAL SALES</th>
			<th>OVER SHORT</th>
			</tr>
			</thead>
			<tr>
			<td><?php echo $list->buying_liter; ?></td>
			<td><?php echo $addstock;?></td>
			<td><?php echo $totalselling;?></td>
			<td><?php echo (($addstock+$totalselling)-$list->buying_liter); ?></td>
			</tr>
			</table>
		</td>
	</tr>
	<?php } ?>
</table>


    </body>

</html>