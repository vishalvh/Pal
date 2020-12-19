	
			<?php $this->load->view('web/left');?>
			<!-- left side end-->
	    
			<!-- main content start-->
			<div class="main-content">
				<!-- header-starts -->
				<?php $this->load->view('web/header');?>
			<!-- //header-ends -->
				<div id="page-wrapper">
								
								<div class="page-header">
									<h3 class="blank1 pull-left" style="">Inventory Info</h3>
										
									</div>
	 				
					<?php if ($this->session->flashdata('success')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success'); ?>
							   </div>
							<?php } ?>
							<?php if ($this->session->flashdata('fail')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('fail'); ?>
							   </div>
							<?php } ?>
							<?php if ($this->session->flashdata('success_update')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success_update'); ?>
							   </div>
							<?php } ?>
							
							<?php if ($this->session->flashdata('check_fail')) { ?>
							   <div class="alert alert-danger alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('check_fail'); ?>
							   </div>
							<?php } ?>
						<?php
							$name = $inventory[0]->UserFName;
						?>
						 <div class="xs tabls">
							<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
								<div class="col-sm-4">
									<label class="control-label"><b>Date</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo date('d-m-Y', strtotime($inventory[0]->date));?></p>
                                   	</div>
								</div>
								<div class="col-sm-4">
									<label class="control-label"><b>Name</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo ucfirst($name);?></p>
                                   	</div>
								</div>	
								<div class="col-sm-4">
									<label class="control-label"><b>Location</b></label>
									<div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo $inventory[0]->l_name;?></p>
                                   	</div>
								</div>		
								<div class="col-sm-4" style="margin-top: 15px;">
									<label class="control-label"><b>Petrol InvoiceNumber</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->pi_number;?></p>
                                   	</div>
                                   	
                                   	<label class="control-label"><b>Petrol FuelAmount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->p_fuelamount;?></p>
                                   	</div>
                                   	
                                   	<label class="control-label"><b>Petrol TaxAmount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->pv_taxamount;?></p>
                                   	</div>
                                    
                                    <label class="control-label"><b>Petrol PaymentType</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->p_paymenttype;?></p>
                                    </div>
                                    
                                    <label class="control-label"><b>Petrol Chequenumber</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->p_chequenumber;?></p>
                                    </div>
                                    
                                    <label class="control-label"><b>Petrol PaidAmount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->p_paidamount;?></p>
                                    </div>
                                    <label class="control-label"><b>Petrol Quantity</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->p_quantity;?></p>
                                    </div>
                                    
                                    <label class="control-label"><b>Petrol Tankerreading</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->p_tankerreading;?></p>
                                    </div>

								</div>
								

								<div class="col-sm-4" style="margin-top: 15px;">
									<label class="control-label"><b>Disel InvoiceNumber</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->di_number;?></p>
                                   	</div>
                                   	
                                   	<label class="control-label"><b>Disel FuelAmount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->d_fuelamount;?></p>
                                   	</div>
                                   	
                                   	<label class="control-label"><b>Disel TaxAmount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->dv_taxamount;?></p>
                                   	</div>
                                    
                                    <label class="control-label"><b>Disel PaymentType</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->d_paymenttype;?></p>
                                    </div>
                                    
                                    <label class="control-label"><b>Disel Chequenumber</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->d_chequenumber;?></p>
                                    </div>
                                    
                                    <label class="control-label"><b>Disel PaidAmount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->d_paidamount;?></p>
                                    </div>
                                    <label class="control-label"><b>Disel Quantity</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->d_quantity;?></p>
                                    </div>
                                    
                                    <label class="control-label"><b>Disel Tankerreading</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->d_tankerreading;?></p>
                                    </div>

								</div>


								<div class="col-sm-4" style="margin-top: 15px;">
                                    <label class="control-label"><b>Oil Type</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->oil_type;?></p>
                                    </div>
                                    
                                    <label class="control-label"><b>Oil Quantity</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->o_quantity;?></p>
                                    </div>

                                    <label class="control-label"><b>Oil Amount</b></label>
									<div class="">
                                        <p class="form-control-static"><?php echo $inventory[0]->oil_amount;?></p>
                                    </div>

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

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js')?>"></script>
