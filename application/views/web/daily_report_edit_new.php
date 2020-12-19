	
    <!-- left side start-->
		<?php $this->load->view('web/left');?> 
		<!-- left side end-->
    
		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<?php $this->load->view('web/header');?>
		<!-- //header-ends -->
			<div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Update Daily Entry</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form"> 
						
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>daily_reports_new/update?location=<?php echo $location;?>&date=<?php echo $date;?>&sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>" name="savingdata" >
							<?php if ($this->session->flashdata('success')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success'); ?>
							   </div>
							<?php } ?>
							<?php if ($this->session->flashdata('fail')) { ?>
							   <div class="alert alert-danger alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('fail'); ?>
							   </div>
							<?php } ?>
							
								<input type="hidden" name="id" value="<?php echo $readingdetails->id;?>">
								<div class="col-md-6">
								<div class="title-h1">
                                    <h3>Inventory</h3>
                                </div>
								<hr>
								<div class="title-h1">
                                    <h4>Petrol Tank Deep </h4>
                                </div>
								<?php foreach($get_tank_reading_sales as $tankread){
									if($tankread->fuel_type == 'p' && $tankread->xp_type == 'No'){
								?>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $tankread->tank_name; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Tank deep" name="tank_deep_reading[<?php echo $tankread->id;?>]" value="<?php echo $tankread->volume; ?>">
									</div>
								</div>
									<?php } } ?>
									<hr>
									<?php if($_GET['debug'] == 1){?>
									<div class="title-h1">
                                    <h4>XP Petrol Tank Deep </h4>
                                </div>
								<?php foreach($get_tank_reading_sales as $tankread){
									if($tankread->fuel_type == 'p' && $tankread->xp_type == 'Yes'){
								?>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $tankread->tank_name; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Tank deep" name="tank_deep_reading[<?php echo $tankread->id;?>]" value="<?php echo $tankread->volume; ?>">
									</div>
								</div>
									<?php } } ?>
									<hr>
									<?php } ?>
								<div class="title-h1">
                                    <h4>Diesel Tank Deep </h4>
                                </div>
								<?php foreach($get_tank_reading_sales as $tankread){
									if($tankread->fuel_type == 'd'  && $tankread->xp_type == 'No'){
								?>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $tankread->tank_name; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Tank deep" name="tank_deep_reading[<?php echo $tankread->id;?>]" value="<?php echo $tankread->volume; ?>">
									</div>
								</div>
									<?php } } ?>
									
									<?php if($_GET['debug'] == 1){?>
									<div class="title-h1">
                                    <h4>XP Diesel Tank Deep </h4>
                                </div>
								<?php foreach($get_tank_reading_sales as $tankread){
									if($tankread->fuel_type == 'd'  && $tankread->xp_type == 'Yes'){
								?>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $tankread->tank_name; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Tank deep" name="tank_deep_reading[<?php echo $tankread->id;?>]" value="<?php echo $tankread->volume; ?>">
									</div>
								</div>
									<?php } } ?>
									<?php } ?>
<hr>
								<div class="title-h1" style="color: #27cce4;">
                                    <h4>Petrol</h4>
									<?php  if($Petrol_inventory_user_detail) { echo $Petrol_inventory_user_detail->UserFName; } else{ echo "Update By Website"; } echo " - ".date("d-m-Y",strtotime($Petrol_inventory->created_date)); ?> 
                                </div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Invoice</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Invoice" name="petrolinvoice" value="<?php echo $Petrol_inventory->invoice_no;?>">
									</div>
								</div>
								<!--<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Deep Reading</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Deep Reading" name="petroldeepreading" value="<?php echo $Petrol_inventory->deep_reading;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Stock</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Stock" name="petrolstock" value="<?php echo $readingdetails->p_deep_reading;?>">
									</div>
								</div>-->
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Purchase (ltr)</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Purchase" name="petrolpurchase" value="<?php echo $Petrol_inventory->p_quantity;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Purchase Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Purchase Amount" name="petrolpurchaseamount" value="<?php echo $Petrol_inventory->p_fuelamount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Vat Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Vat Amount" name="petrolpurchasevatamount" value="<?php echo $Petrol_inventory->pv_taxamount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">CESS Tax Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol CESS Tax Amount" name="petrolpurchasecesstaxamount" value="<?php echo $Petrol_inventory->p_cess_tax;?>">
									</div>
								</div>
<hr>

<?php if($_GET['debug'] == 1){ ?>

<div class="title-h1" style="color: #27cce4;">
                                    <h4>XP Petrol</h4>
									<?php  if($XP_Petrol_inventory_user_detail) { echo $XP_Petrol_inventory_user_detail->UserFName; } else{ echo "Update By Website"; } echo " - ".date("d-m-Y",strtotime($XP_Petrol_inventory->created_date)); ?> 
                                </div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Invoice</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Invoice" name="xppetrolinvoice" value="<?php echo $XP_Petrol_inventory->invoice_no;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Purchase (ltr)</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Purchase" name="xppetrolpurchase" value="<?php echo $XP_Petrol_inventory->p_quantity;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Purchase Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Purchase Amount" name="xppetrolpurchaseamount" value="<?php echo $XP_Petrol_inventory->p_fuelamount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Vat Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Vat Amount" name="xppetrolpurchasevatamount" value="<?php echo $XP_Petrol_inventory->pv_taxamount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">CESS Tax Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol CESS Tax Amount" name="xppetrolpurchasecesstaxamount" value="<?php echo $XP_Petrol_inventory->p_cess_tax;?>">
									</div>
								</div>
<hr>
<?php } ?>




<div class="title-h1" style="color: #27cce4;">
                                    <h4>Diesel</h4>
									<?php  if($diesel_inventory_user_detail) { echo $diesel_inventory_user_detail->UserFName; } else{ echo "Update By Website"; } echo " - ".date("d-m-Y",strtotime($diesel_inventory->created_date)); ?> 
                                </div>
								<!------------------------------------------------------------------------------------------------------->
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesel Invoice</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Invoice" name="dieselinvoice" value="<?php echo $diesel_inventory->invoice_no;?>">
									</div>
								</div>
								<!--<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesel Deep Reading</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Deep Reading" name="dieseldeepreading" value="<?php echo $diesel_inventory->deep_reading;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesel Stock</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Stock" name="dieselstock" value="<?php echo $readingdetails->d_deep_reading;?>">
									</div>
								</div>-->
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesel Purchase (ltr)</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Purchase" name="dieselpurchase" value="<?php echo $diesel_inventory->d_quantity;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesel Purchase Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Purchase Amount" name="dieselpurchaseamount" value="<?php echo $diesel_inventory->d_fuelamount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Vat Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Vat Amount" name="dieselpurchasevatamount" value="<?php echo $diesel_inventory->dv_taxamount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">CESS Tax Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel CESS Tax Amount" name="dieselpurchasecesstaxamount" value="<?php echo $diesel_inventory->d_cess_tax;?>">
									</div>
								</div>
<hr>




<?php if($_GET['debug'] == 1){ ?>
<div class="title-h1" style="color: #27cce4;">
                                    <h4>Diesel</h4>
									<?php  if($XP_diesel_inventory_user_detail) { echo $XP_diesel_inventory_user_detail->UserFName; } else{ echo "Update By Website"; } echo " - ".date("d-m-Y",strtotime($XP_diesel_inventory->created_date)); ?> 
                                </div>
								<!------------------------------------------------------------------------------------------------------->
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesel Invoice</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Invoice" name="xpdieselinvoice" value="<?php echo $xp_diesel_inventory->invoice_no;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesel Purchase (ltr)</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Purchase" name="xpdieselpurchase" value="<?php echo $xp_diesel_inventory->d_quantity;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesel Purchase Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Purchase Amount" name="xpdieselpurchaseamount" value="<?php echo $xp_diesel_inventory->d_fuelamount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Vat Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel Vat Amount" name="xpdieselpurchasevatamount" value="<?php echo $xp_diesel_inventory->dv_taxamount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">CESS Tax Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Diesel CESS Tax Amount" name="xpdieselpurchasecesstaxamount" value="<?php echo $xp_diesel_inventory->d_cess_tax;?>">
									</div>
								</div>
<hr>

<?php } ?>





<!---------------------------------------------------------------------------------------------------->
<div class="title-h1" style="color: #27cce4;">
                                    <h4>Oil</h4>
									<?php  if($oil_inventory_user_detail) { echo $oil_inventory_user_detail->UserFName; } else{ echo "Auto"; } echo " - ".date("d-m-Y",strtotime($oil_inventory->created_date)); ?> 
                                </div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Oil Invoice</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Oil Invoice" name="oilinvoice" value="<?php echo $oil_inventory->invoice_no;?>">
									</div>
								</div>
<?php foreach ($oil_inventory_Detail as $oildetail){?>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $oildetail->name." ".$oildetail->packet_type;?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="oilinventory[<?php echo $oildetail->id;?>]" value="<?php echo $oildetail->qty;?>">
									</div>
								</div>
<?php } ?>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Purchase Oil in Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Oil Amount" name="oilamount" value="<?php echo $oil_inventory->o_amount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Oil Stock in Amount</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Oil Amount" name="oilamountstock" value="<?php echo $oil_inventory->oil_total_amount;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Oil CGST</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Oil CGST" name="oilcgst" value="<?php echo $oil_inventory->oil_cgst;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Oil SGST</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Oil SGST" name="oilsgst" value="<?php echo $oil_inventory->oil_sgst;?>">
									</div>
								</div>
								</div>
								<div class="col-md-6">
								<div class="title-h1">
                                    <h3>Sales</h3>
                                </div>
<hr>
<div class="title-h1" style="color: #27cce4;">
                                   <?php  if($readingdetails_user_detail) { echo $readingdetails_user_detail->UserFName; } else{ echo "Auto"; } echo " - ".date("d-m-Y",strtotime($readingdetails->created_at)); ?> 
									
                                </div>
<div class="title-h1">
                                    <h4>Petrol</h4>
                                </div>
<?php foreach ($meter_details as $meter_detail){ if($meter_detail->type == 'p' || $meter_detail->type == 'P'){ ?>
				
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $meter_detail->name;?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="petrol_reading[<?php echo $meter_detail->id;?>]" value="<?php echo $meter_detail->Reading;?>">
									</div>
								</div>
<?php } } ?>
<hr>
<div class="title-h1">
                                    <h4>Diesel</h4>
                                </div>
<?php foreach ($meter_details as $meter_detail){ if($meter_detail->type == 'd' || $meter_detail->type == 'D'){ ?>
				
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $meter_detail->name;?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="diesel_reading[<?php echo $meter_detail->id;?>]" value="<?php echo $meter_detail->Reading;?>">
									</div>
								</div>
<?php } } ?>
<hr>
<div class="title-h1">
                                    <h4>Oil</h4>
                                </div>
								<?php 

								$sumtotal = 0; 
								$multotal = 0;
								$selprice = 0;
								$buyPriceMulOnlyPrice =0;
								$sellPriceMulOnlyPrice =0;
								$finalarray = array();
								$finalarraydetail = array();
								foreach ($meter_details as $meter_detail){ 
									if($meter_detail->type == 'O' || $meter_detail->type == 'o'){
										$finalarray[] = $meter_detail->id;
										$finalarraydetail[$meter_detail->id] = $meter_detail;
									}
								}
									foreach ($get_oil_meter_details as $meter_detail){
										
										if(in_array($meter_detail->id,$finalarray)){
											$no++;
										//if($meter_detail->type == 'O' || $meter_detail->type == 'o'){
											$meter_detail = $finalarraydetail[$meter_detail->id];
									
									$sumtotal = $sumtotal+$meter_detail->Reading;
									$multotal = ($meter_detail->bay_price + $multotal) ;
									$selprice = ($meter_detail->sel_price+ $selprice);
									$buyPriceMulOnlyPrice += ($meter_detail->Reading *$meter_detail->bay_price);
									$sellPriceMulOnlyPrice += ($meter_detail->Reading *$meter_detail->sel_price);

									 ?>
			<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $meter_detail->packet_type;?></label>
									<div class="col-sm-2">
										<input type="text" class="form-control qty" placeholder="" name="oil_reading[<?php echo $meter_detail->id;?>]" value="<?php echo $meter_detail->Reading;?>" id="total<?php echo $no;?>" onkeyup="calc(<?php echo $no;?>)">
										<input type="hidden" name="tab_n" class="tab_n" value="<?php echo $meter_detail->Reading;?>">
									</div>
									<label class="col-sm-3 control-label" >Buy price = <?php echo $meter_detail->bay_price;?>
										<input type="hidden" id="buyidprice<?php echo $no;?>"  value="<?php echo $meter_detail->bay_price;?>">
									</label>
									<label class="col-sm-3 control-label"  >Sell price = <?php echo $meter_detail->sel_price;?></label>
									<input type="hidden" id="saleidprice<?php echo $no;?>"  value="<?php echo $meter_detail->sel_price;?>">
									
								</div>
							<?php } else{ if($meter_detail->bay_price != ""){
$no++;								?>
								
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $meter_detail->packet_type;?></label>
									<div class="col-sm-2">
										<input type="text" class="form-control qty" placeholder="" name="oil_reading[<?php echo $meter_detail->id;?>]" value="0" id="total<?php echo $no;?>" onkeyup="calc(<?php echo $no;?>)">
										<input type="hidden" name="tab_n" class="tab_n" value="<?php echo $meter_detail->Reading;?>">
									</div>
									<label class="col-sm-3 control-label" >Buy price = <?php echo $meter_detail->bay_price;?>
										<input type="hidden" id="buyidprice<?php echo $no;?>"  value="<?php echo $meter_detail->bay_price;?>">
									</label>
									<label class="col-sm-3 control-label"  >Sell price = <?php echo $meter_detail->sel_price;?></label>
									<input type="hidden" id="saleidprice<?php echo $no;?>"  value="<?php echo $meter_detail->sel_price;?>">
									
								</div>
							<?php } }
							} ?>
							<div class="form-group">
									<label for="focusedinput" class="col-sm-3 control-label" >Total</label>
									<label for="focusedinput" class="col-sm-2 control-label" id="sumtotal"><?=$sumtotal?>
										<input type="hidden" id="hiddenid" value="<?=$sumtotal?>">
									</label>

									<label for="focusedinput" class="col-sm-3 control-label" id="total_buy"><?php echo (number_format($buyPriceMulOnlyPrice,2)); ?>
										<input type="hidden" id="buyprice" value="<?php echo ($buyPriceMulOnlyPrice); ?>">
									</label>
									<label for="focusedinput" class="col-sm-3 control-label" id="total_sale"><?php echo (number_format($sellPriceMulOnlyPrice,2)); ?>
										<input type="hidden" id="selprice" value="<?php echo ($sellPriceMulOnlyPrice); ?>">
									</label>
									
								</div>
<hr>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Testing</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="petrol_testing" value="<?php echo $readingdetails->p_testing;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesel Testing</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="Diesal_testing" value="<?php echo $readingdetails->d_testing;?>">
									</div>
								</div>
								
								
					<?php if($_GET['debug'] == 1){ ?>			
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">XP Petrol Testing</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="XP_petrol_testing" value="<?php echo $readingdetails->xpp_testing;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">XP Diesel Testing</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="XP_Diesal_testing" value="<?php echo $readingdetails->xpd_testing;?>">
									</div>
								</div>
					<?php } ?>
								
								
<hr>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Oil Sales</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="oil_sales" value="<?php echo $sellPriceMulOnlyPrice; //$readingdetails->oil_reading;
										 ?>">
									</div>
								</div>
<hr>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Cash On Hand</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="cash_on_hand" value="<?php echo $readingdetails->cash_on_hand;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Petrol Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="p_price_per_l" value="<?php echo $daily_price->pet_price;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Diesal Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="d_price_per_l" value="<?php echo $daily_price->dis_price;?>">
									</div>
								</div>
								
								
								<?php if($_GET['debug'] == 1){ ?>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">XP Petrol Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="xp_p_price_per_l" value="<?php echo $daily_price->xp_pet_price;?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">XP Diesal Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="xp_d_price_per_l" value="<?php echo $daily_price->xp_dis_price;?>">
									</div>
								</div>
								<?php } ?>
								
								
								
								
								</div>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update</button>
										<a href="#" onclick="window.history.back();">Back</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					
					
  
						
				</div>
			<!-- switches -->
		<div class="switches">
			
		</div>
		<!-- //switches -->
						</div>
			<!--body wrapper start-->
			</div>
			 <!--body wrapper end-->
		</div>
        <!--footer section start-->
			<?php $this->load->view('web/footer');?>
        <!--footer section end-->

      <!-- main content end-->
   </section>
  
<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
   <script >
	function calc(id){

		var sum = 0;
		var m = 0;
		var totalMul = 0;
    	var mul1=0;
     	var  new_price=0;
     	var sale1=0;
     	var test = $("buyidprice").val();
    	cnt =1;
    	cnt2 =1;
    
    
    $(".qty").each(function(){
    	m = parseFloat($.trim($(this).val()));
    	mul1 = $("#buyidprice"+cnt).val();
    	sale1 = $("#saleidprice"+cnt2).val();
    	if(m == null){
			m=0;
		}
		console.log(cnt+" "+m+" #buyidprice"+ cnt +" " +mul1+" "+sale1);
    	mul1 = parseFloat(m)*parseFloat(mul1);
    	sale1 = parseFloat(m)*parseFloat(sale1);
    	totalMul = parseFloat(totalMul) + parseFloat(mul1);
    	new_price = parseFloat(new_price) + parseFloat(sale1);  
        sum +=parseFloat($(this).val());
		cnt2++;
		cnt++;
    });
    
    
   $("#sumtotal").html(sum);
  
   $("#total_buy").html(totalMul);
   $("#total_sale").html(new_price);
	}
</script>
</body>
</html>