<?php
	$start_date = $this->uri->segment('4');
	$end_date =  $this->uri->segment('5');
	$location_id = $this->uri->segment('6');
	$customer_id = $this->uri->segment('7');
?>

   
 <body class="sticky-header left-side-collapsed"  onload="initMap()">
    <section>	
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
					<h3 class="blank1">Update Data</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>credit_debit/update/<?php echo $query[0]->id;?>/<?php echo $start_date?>/<?php echo $end_date?>/<?php echo $location_id?>/<?php echo $customer_id?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">

								<!-- <div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" id="date" name="date" value="<?php echo $query[0]->date?>">
										<div class="invalid-feedback" id="dateerror" style="color: red;"></div>
									</div>
								</div> -->
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input type="text" id="date"  readonly class="form-control end_date" name="date" placeholder="Date" value="<?php echo date('d-m-Y',strtotime($query[0]->date))?>" />
										<div class="invalid-feedback" id="dateerror" style="color: red;"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Payment type<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<select name="type" id="type" class="form-control1" onchange="p_type()">
											<option value="">Select type</option>
											<option value="d" 
											<?php 
											if ($query[0]->payment_type == "d") 
											{
												echo "selected";
											}
											?>
											>Debit</option>
											<option value="c" 
											<?php 
											if ($query[0]->payment_type == "c") 
											{
												echo "selected";
											}
											?>
											>Credit</option>
											
										</select>
										<div class="invalid-feedback" id="typeerror" style="color: red;"></div>
									</div>
								</div>								<div class="form-group" id="fuel_type_div">									<label for="focusedinput" class="col-sm-2 control-label">Fule type<span style="color: red">*</span></label>									<div class="col-sm-8">										<select name="fuel_type" id="fuel_type" class="form-control1">											<option value="">Select type</option>											<option value="Diesel" <?php if ($query[0]->fuel_type == "Diesel") { echo "selected"; } ?> >Diesel</option>											<option value="Petrol" <?php if ($query[0]->fuel_type == "Petrol") { echo "selected"; } ?>>Petrol</option>											<option value="Oil" <?php if ($query[0]->fuel_type == "Oil") { echo "selected"; } ?>>Oil</option>										</select>										<div class="invalid-feedback" id="fuel_type_error" style="color: red;"></div>									</div>								</div>
								<div class="form-group" id="payment_type">
									<label for="focusedinput" class="col-sm-2 control-label">Transaction type<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<select name="ptype" id="ptype" class="form-control1" onchange="p_type2()">
											<option value="">Select type</option>
											<option value="cs"
											<?php 
											if ($query[0]->transaction_type == "cs") 
											{
												echo "selected";
											}
											?>
											>Cash</option>
											<option value="c"
											<?php 
											if ($query[0]->transaction_type == "c") 
											{
												echo "selected";
											}
											?>
											>Cheque</option>
											<option value="n"
											<?php 
											if ($query[0]->transaction_type == "n") 
											{
												echo "selected";
											}
											?>>Netbanking</option>
											<option value="ccard" 
											<?php 
											if ($query[0]->transaction_type == "ccard") 
											{
												echo "selected";
											}
											?>
											>Company Card</option>
										</select>
										<div class="invalid-feedback" id="ttypeerror" style="color: red;"></div>
									</div>
								</div>
								 <div class="form-group" id="cheque_type">
									<label for="focusedinput" class="col-sm-2 control-label">Cheque No<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input placeholder="Cheque No" type="text" class="form-control1" id="chequeno" name="chequeno" value="<?= $query[0]->transaction_number?>">
										<div class="invalid-feedback" id="chequeno_error" style="color: red;"></div>
									</div>
								</div> 								<div class="form-group" id="bnak_type">									<label for="focusedinput" class="col-sm-2 control-label">Bnak Name<span style="color: red">*</span></label>									<div class="col-sm-8">										<input placeholder="Bank Name" type="text" class="form-control1" id="bank_name" name="bank_name" value="<?= $query[0]->bank_name?>">										<div class="invalid-feedback" id="bank_name_error" style="color: red;"></div>									</div>								</div>
								<div class="form-group" id="bill_no12">
									<label for="focusedinput" class="col-sm-2 control-label">Bill No<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input placeholder="Bill No" type="text" class="form-control1" id="bill_no" name="bill_no" value="<?= $query[0]->bill_no?>">
										<div class="invalid-feedback" id="bill_noerror" style="color: red;"></div>
									</div>
								</div>								<div class="form-group" id="vehical_no">
									<label for="focusedinput" class="col-sm-2 control-label">Vihicale No<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input placeholder="Vehicle No" type="text" class="form-control1" id="vehicle_no" name="vehicle_no" value="<?= $query[0]->vehicle_no?>">
										<div class="invalid-feedback" id="vehicle_no_error" style="color: red;"></div>
									</div>
								</div>								<div class="form-group" id="quantity_no">									<label for="focusedinput" class="col-sm-2 control-label">Quantity <span style="color: red">*</span></label>									<div class="col-sm-8">										<input placeholder="Quantity" type="text" class="form-control1" id="quantity" name="quantity" value="<?= $query[0]->quantity?>">										<div class="invalid-feedback" id="quantity_error" style="color: red;"></div>									</div>								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Amount<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input type="text" placeholder="Amount" class="form-control1" id="amount" name="amount" value="<?= $query[0]->amount?>">
										<div class="invalid-feedback" id="amounterror" style="color: red;"></div>
									</div>
								</div>								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Remark<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input type="text" placeholder="Remark" class="form-control1" id="remark" name="remark" value="<?= $query[0]->remark?>">
										<div class="invalid-feedback" id="amounterror" style="color: red;"></div>
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
<script>
function validate(){	//alert("123");
         var date = document.forms["savingdata"]["date"].value;
         var type = document.forms["savingdata"]["type"].value;
         var type1 = $("#type").val();
         var fuel_type = $("#fuel_type").val();
         var chequeno = $("#chequeno").val();
         var bank_name = $("#bank_name").val();
         var amount = document.forms["savingdata"]["amount"].value;
         var ptype = document.forms["savingdata"]["ptype"].value;
     	 var bill_no = document.forms["savingdata"]["bill_no"].value;     	 var vehicle_no = document.forms["savingdata"]["vehicle_no"].value;     	 var quantity = document.forms["savingdata"]["quantity"].value;		 //alert(quantity);
         var temp = 0;		             $("#vehicle_no_error").html("");		             $("#fuel_type_error").html("");		
       if(date == ""){
            $("#dateerror").html("Date is required.");
            temp++;
        }
        else
        {
        	$("#dateerror").html("");
        }
        if(type1 == ""){
            $("#typeerror").html("Select atleast one option.");
            temp++;
        }
        else
        {
        	$("#typeerror").html("");
        }		
		if(ptype == 'cs' || ptype == 'n'){
			if(ptype == ""){	            
				$("#ttypeerror").html("Select atleast one option.");	            
				temp++;
			}else{
				$("#ttypeerror").html("");
			}
			
			if(ptype == 'n'){
				if(chequeno == ""){
					$("#chequeno_error").html("Cheque no is required.");
					temp++;
				}else{
					$("#ttypeerror").html("");
				}
			}
			
			/*if(bank_name == ""){
				$("#bank_nameerror").html("Bank Name no is required.");
				temp++;
			}else{
				$("#ttypeerror").html("");
			}*/
		}
		
        if (type1 == "c") {
			if(quantity == ""){
				$("#quantity_error").html("Quantity is required.");
				temp++;
			}
			if(vehicle_no == ""){
				$("#vehicle_no_error").html("Vehicle No is required.");
				temp++;
			}
			if(bill_no == ""){
				$("#bill_noerror").html("Bill number is required.");
				temp++;
			}
			if(fuel_type == ""){
				$("#fuel_type_error").html("Fuel Type is required.");
				temp++;
			}
	    }
        if(amount == ""){
            $("#amounterror").html("Amount is required.");
            temp++;
        }
        else{
        	$("#amounterror").html("");
        }	//alert(temp);
        if(temp != 0){
        			 return false;     
        }
    }
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			var type = $("#type").val();			
			if (type == "c") {
				$("#payment_type").hide();				$("#cheque_type").hide();				$("#bnak_type").hide();				$("#fuel_type_div").show();				$("#bill_no12").show();				$("#vehical_no").show();				$("#quantity_no").show();
			}else{				$("#payment_type").show();				$("#bnak_type").show();				$("#fuel_type_div").hide();				$("#bill_no12").hide();				$("#vehical_no").hide();				$("#quantity_no").hide();
			}
			if (type == "d") {
				$("#bill_no12").hide();				$("#vehical_no").hide();				$("#quantity").hide();				$("#vehical_no").hide();				$("#quantity_no").hide();
			}else{ 
				$("#bill_no12").show();				$("#vehical_no").show();				$("#quantity").show();				$("#vehical_no").show();				$("#quantity_no").show();
			}			var type = $("#ptype").val();			//alert(type);			if (type == "c" || type == "n" ) {				$("#cheque_type").show();				$("#bnak_type").show();				$("#bill_no12").show();			}else{				$("#cheque_type").hide();				$("#bnak_type").hide();				$("#bill_no12").hide();			}
		});
		function p_type()
		{
			var type = $("#type").val();
			if (type == "c") {
				$("#payment_type").hide();				$("#fuel_type_div").show();				$("#bill_no12").show();				$("#cheque_type").hide();				$("#bnak_type").hide();				$("#bill_no12").hide();				$("#quantity_no").show();				
			}else{
				$("#payment_type").show();				$("#fuel_type_div").hide();				$("#bill_no12").hide();				$("#quantity_no").hide();				$("#cheque_type").show();				$("#bnak_type").show();				$("#bill_no12").show();
			}
			if (type == "d") {
				$("#bill_no12").hide();				$("#vehical_no").hide();				$("#quantity").hide();
			}else{
				$("#bill_no12").show();				$("#vehical_no").show();				$("#quantity").show();
			} 	
		}		function p_type2(){			var type = $("#ptype").val();			if (type == "c" || type == "n" ) {				$("#cheque_type").show();				$("#bnak_type").show();				$("#bill_no12").show();			}else{				$("#cheque_type").hide();				$("#bnak_type").hide();				$("#bill_no12").hide();			}		}
		
	</script>