	
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
						
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>daily_reports/update?location=<?php echo $location;?>&date=<?php echo $date;?>&sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>" name="savingdata" >
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
									if($tankread->fuel_type == 'p'){
								?>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $tankread->tank_name; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Tank deep" name="tank_deep_reading[<?php echo $tankread->id;?>]" value="<?php echo $tankread->volume; ?>">
									</div>
								</div>
									<?php } } ?>
									<hr>
								<div class="title-h1">
                                    <h4>Diesel Tank Deep </h4>
                                </div>
								<?php foreach($get_tank_reading_sales as $tankread){
									if($tankread->fuel_type == 'd'){
								?>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label"><?php echo $tankread->tank_name; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Petrol Tank deep" name="tank_deep_reading[<?php echo $tankread->id;?>]" value="<?php echo $tankread->volume; ?>">
									</div>
								</div>
									<?php } } ?>
								
<hr>
								<div class="title-h1">
                                    <h4>Petrol</h4>
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
<div class="title-h1">
                                    <h4>Diesel</h4>
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
<!---------------------------------------------------------------------------------------------------->
<div class="title-h1">
                                    <h4>Oil</h4>
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
<?php foreach ($meter_details as $meter_detail){ if($meter_detail->type == 'O' || $meter_detail->type == 'o'){ ?>
				
								<div class="form-group">
									<label for="focusedinput" class="col-sm-6 control-label"><?php echo $meter_detail->packet_type;?></label>
									<div class="col-sm-6">
										<input type="text" class="form-control" placeholder="" name="oil_reading[<?php echo $meter_detail->id;?>]" value="<?php echo $meter_detail->Reading;?>">
									</div>
								</div>
<?php } } ?>
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
<hr>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Oil Sales</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="oil_sales" value="<?php echo $readingdetails->oil_reading;?>">
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
								
								</div>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update</button>
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
</body>
</html>