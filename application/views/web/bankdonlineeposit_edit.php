	<!--
	Author: W3layouts
	Author URL: http://w3layouts.com
	License: Creative Commons Attribution 3.0 Unported
	License URL: http://creativecommons.org/licenses/by/3.0/
	-->
	
      <script>
$(document).ready(function () {
       $("#start_date").datepicker({
           dateFormat: "dd-mm-yy",
		   	changeMonth: true,
          changeYear: true,
		   yearRange: "1918:n",
		  
       });
   });

        </script> 
	
	    <!-- left side start-->
			<?php $this->load->view('web/left');?>
			<!-- left side end-->
	    
			<!-- main content start-->
			<div class="main-content">
				<!-- header-starts -->
				<?php $this->load->view('web/header');?>
			<!-- //header-ends -->
				<div id="page-wrapper">
					<form method="post" action="<?php echo base_url();?>admin/add">			
								<h3 class="blank1" style="margin-top: -20px;">Online Transaction  Edit</h3>
	 								
								</form>

					<h3 class="blank1"></h3>
					<br>
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
							$name = $bd[0]->UserFName;
						?>
						 <div class="md tabls">
						 <form class="form-horizontal" method="post" action="<?php echo base_url();?>bank_deposit/bankdonlineeposit_edit?id=<?php echo $id;?>&sdate=<?php echo $this->input->get('sdate');?>&edate=<?php echo $this->input->get('edate');?>&l_id=<?php echo $this->input->get('l_id');?>" name="savingdata" onsubmit="return validate()">
							<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
								<div class="col-md-4">
								<div class="col-md-4">
									<label class="control-label"><b>Date</b></label>
									</div>
									<div class="col-sm-8">
									<label class="control-label"><?php echo date('d-m-Y', strtotime($bd[0]->date));?></label>
										
										<?php echo form_error('date','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="dateerror" style="color: red;"></div>
									</div>
									
								</div>
								<div class="col-md-4">
								<div class="col-md-4">
									<label class="control-label"><b>Name</b></label>
									</div>
									<div class="col-sm-8">
									<label class="control-label"><?php echo ucfirst($name);?></label>
										
										<?php echo form_error('date','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="dateerror" style="color: red;"></div>
									</div>
									
								</div>
								<div class="col-md-4">
								<div class="col-md-4">
									<label class="control-label"><b>Location</b></label>
									</div>
									<div class="col-sm-8">
									<label class="control-label"><?php echo $bd[0]->l_name;?></label>
										
										<?php echo form_error('l_name','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="l_name_error" style="color: red;"></div>
									</div>
									
								</div>
										
								<div class="col-md-12" style="margin-top: 15px;">
								<div class="col-md-2">
									<label class="control-label"><b>Invoice no</b></label>
									</div>
								<div class="col-sm-4">
								<input  id="invoice_no" type="text" class="form-control1 "  placeholder="Invoice No" name="invoice_no" value="<?php echo $bd[0]->invoice_no;?>">
										<?php echo form_error('invoice_no','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="invoice_no_error" style="color: red;"></div>
                                      
                                   	</div>
									</div>
									<div class="col-md-12" style="margin-top: 15px;">
								<div class="col-md-2">
									<label class="control-label"><b> Amount</b></label>
									</div>
								<div class="col-sm-4">
								<input  id="amount" type="text" class="form-control1 "  placeholder="Amount" name="amount" value="<?php echo $bd[0]->amount;?>">
								
										<?php echo form_error('amount','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="amount_error" style="color: red;"></div>
                                      
                                   	</div>
									</div>
									<div class="col-md-12" style="margin-top: 15px;">
								<div class="col-md-2">
									<label class="control-label"><b>Deposited By</b></label>
									</div>
								<div class="col-sm-4">
								<select name="deposited_by" id="deposited_by" class="form-control1 " > 
								<option value="n"<?php  if ($bd[0]->paid_by == 'n') 
                                   		{
				echo "selected";
                                   		} ?> >Cash</option>
								<option value="c" <?php  if ($bd[0]->paid_by == 'c') 
                                   		{
				echo "selected";
                                   		} ?> >Cheque</option>
								</select>
										<?php echo form_error('withdraw_amount','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="deposited_by_error" style="color: red;"></div>
                                      
                                   	</div>
									</div>
                                   	<div class="col-md-12" id="Cheque_Number" style="margin-top: 15px;">
								<div class="col-md-2" >
									<label class="control-label"><b>Cheque Number</b></label>
									</div>
								<div class="col-sm-4">
								<input  id="cheque_tras_no" type="text" class="form-control1 "  placeholder="Cheque No" name="cheque_tras_no" value="<?php echo $bd[0]->cheque_tras_no;?>">
								
										<?php echo form_error('cheque_no','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="chequeerror" style="color: red;"></div>
                                      
                                   	</div>
									</div>
									<div class="col-md-12" id="bank_name_s" style="margin-top: 15px;">
								<div class="col-md-2" >
									<label class="control-label"><b>Bank Name</b></label>
									</div>
								<div class="col-sm-4">
								<input  id="bank_name" type="text" class="form-control1 "  placeholder="Bank Name" name="bank_name" value="<?php echo $bd[0]->bank_name;?>">
								
										<?php echo form_error('bank_name','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="bank_name_error" style="color: red;"></div>
                                      
                                   	</div>
									</div>
									
                                   <br>
								   <div>
								

								</div>
                            <div class="form-group" class="col-md-12" style="
    padding-top:  10px;
    padding-right: 15px;
" >
							<br>
									<div class="col-sm-8 col-sm-offset-2" style="
    padding-top:  10px;
    padding-right: 15px;
">
										<button style="
    padding-top:  10px;
    padding-right: 15px;
" class="btn-success btn" type="submit" name="submit">Update</button>
<a href="#" onclick="window.history.back();">Back</a>
									</div>
								</div>
</div>
								
								</form>
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
<script>
		
   
    $('#bank_name_s').hide(); 
    $('#deposited_by').change(function(){
        if($('#deposited_by').val() == 'c') {
            $('#bank_name_s').show(); 
           
        } else {
            $('#bank_name_s').hide(); 
			
        } 
    });

$(document).ready(function(){ 

	if($('#deposited_by').val() == 'c') {
            
			
            $('#bank_name_s').show(); 
        } else {
            
			
			$('#bank_name_s').hide(); 
        } 
    


	$("#invoice_no").blur(function(){
		 var invoice_no = $("#invoice_no").val();
                            if(invoice_no == ""){
         $("#invoice_no_error").html("Invoice No is required.");
                      }
                      else{
							     $("#invoice_no_error").html('');
                            }
    }
					);
	$("#bank_name").blur(function(){
		 var bank_name = $("#bank_name").val();
                            if(bank_name == ""){
         $("#bank_name_error").html("Bank Name is required.");
                      }
                      else{
							     $("#bank_name_error").html('');
                            }
    }
					);
	
	$("#withdraw_amount").blur(function(){
		 var withdraw_amount = $("#withdraw_amount").val();
                            if(withdraw_amount == ""){
         $("#withdraw_amount_error").html("Withdraw Amount is required.");
                      }
                      else{
							     $("#withdraw_amount_error").html('');
                            }
    }
					);
	
	$("#deposited_by").blur(function(){
		 var deposited_by = $("#deposited_by").val();
                            if(deposited_by == ""){
         $(deposited_by_error).html("Deposited by is required.");
                      }
                      else{
							     $("#deposited_by_error").html('');
                            }
    }
					);
	
	$("#cheque").blur(function(){
		 var chq = $("#cheque").val();
                            if(chq == ""){
         $("#chequeerror").html("Cheque Number is required.");
                      }
                      else{
							     $("#chequeerror").html('');
                            }
    }
					);


});	
function validate(){
        var invoice_no = document.forms["savingdata"]["invoice_no"].value;
        var amount = document.forms["savingdata"]["amount"].value;
        var deposited_by = document.forms["savingdata"]["deposited_by"].value;
        var cheque_tras_no = document.forms["savingdata"]["cheque_tras_no"].value;
        var temp = 0;
       if(invoice_no == ""){
           $("#invoice_no_error").html("Invoice No is required.");
            temp++;
        }
        if(amount == ""){
           $("#amount_error").html("Amount is required.");
            temp++;
        }
        if(deposited_by == ""){
        $(deposited_by_error).html("Deposited by is required.");
            temp++;
        }
		 if(cheque_tras_no == ""){
            $("#chequeerror").html("Cheque Tras Number is required.");
            temp++;
        }
		if(deposited_by == 'c'){
			if(bank_name == ""){
            $("#bank_name_error").html("Bank Name is required.");
            temp++;
        }
		}
       
      
        
        if(temp != 0){
        			 return false;     
        }
    }
	</script>
