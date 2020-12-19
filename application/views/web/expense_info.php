
	<script type='text/javascript'>
      
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
								<h3 class="blank1" style="margin-top: -20px;">Expense Report Info</h3>
	 								
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
							$name = $expense[0]->UserFName;
							
						?>
						<form class="form-horizontal" method="post" action="<?php echo base_url();?>expense/expense_info?id=<?php echo $this->input->get('id'); ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>&exp_name=<?php echo $this->input->get('exp_name'); ?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
						 <div class="md tabls">
							<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
								<div class="col-md-4">
									<label class="control-label"><b>Date</b></label>
									<div class="">
                                        
										<input type="text" id="start_date"  readonly class="form-control start_date" name="date" placeholder="Date" value="<?php echo date('d-m-Y', strtotime($expense[0]->date));?>" />
										<div class="invalid-feedback" id="start_date_error" style="color: red;"></div>
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Type</b></label>
									<div class="">
                                        <select id="type" name="type" class="form-control">
										<?php foreach($type_list as $type){ ?>
										  <option value="<?php echo $type['id'] ?>" <?php if($expense[0]->expense_id == $type['id'] ) echo"selected"  ?>><?php echo $type['exps_name']; ?></option>
										<?php } ?>
										  </select>
										  <div class="invalid-feedback" id="start_date_error" style="color: red;"></div>
                                   	</div>
								</div>	
								<div class="col-md-4">
									<label class="control-label"><b>Amount</b></label>
									<div class="">
                                        <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" value="<?php echo $expense[0]->amount;?>" />
										
										 <div class="invalid-feedback" id="amounterror" style="color: red;"></div>
                                   	</div>
								</div>	
								<div class="col-md-4">
									<label class="control-label"><b>Reson</b></label>
									<div class="">
                                        <input type="text" class="form-control" name="reson" id="reson" placeholder="Reson" value="<?php echo $expense[0]->reson;?>" />
										<div class="invalid-feedback" id="resonerror" style="color: red;"></div>
                                   	</div>
								</div>	
								<div class="col-md-4">
									<label class="control-label"><b>Type</b></label>
									<div class="">
                                        <select class="form-control" name="expensetype" id="expensetype">
										<option value=""> Select</option>
										<option value="bank" <?php if($expense[0]->expense_type == 'bank') { echo 'selected'; }?>> Bank </option>
										<option value="cash " <?php if($expense[0]->expense_type == 'cash ') { echo 'selected'; }?> > Cash  </option>
										</select>
										
										<div class="invalid-feedback" id="expensetypeerror" style="color: red;"></div>
                                   	</div>
								</div>	
								<div class="col-md-4" style="padding-top: 24px;">
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update</button>
										<a href="<?php echo base_url('/')?>expense?sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>&exp_name=<?php echo $this->input->get('exp_name'); ?>">Back</a>
									</div>
								</div>
								</div>
								
						   </div>
						</div>
						
				<!-- switches -->
			<div class="switches">
				</form>
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
			
$(document).ready(function(){ 

	$("#start_date").blur(function(){
		 var loc = $("#start_date").val();
                            if(loc == ""){
         $("#start_date_error").html("Start date is required.");
                      }
                      else{
							     $("#start_date_error").html('');
                            }
    }
					);

	$("#address").blur(function(){
		 var add = $("#address").val();
                            if(add == ""){
         $("#addresserror").html("Address is required.");
                      }
                      else{
							     $("#addresserror").html('');
                            }
    }
					);

	$("#mobile").blur(function(){
		 var mob = $("#mobile").val();
                            if(mob == ""){
         $("#mobileerror").html("Phone Number is required.");
                      }
                      else{
							     $("#mobileerror").html('');
                            }
    }
					);
	
});	
function validate(){
         var amount = document.forms["savingdata"]["amount"].value;
         var reson = document.forms["savingdata"]["reson"].value;
         var expensetype = document.forms["savingdata"]["expensetype"].value;
  
         var temp = 0;
       if(amount == ""){
            $("#amounterror").html("amount is required.");
            temp++;
        }
        if(reson == ""){
            $("#resonerror").html("reson is required.");
            temp++;
        }
		if(expensetype == ""){
            $("#expensetypeerror").html("Expense type is required.");
            temp++;
        }
        if(temp != 0){
        			 return false;     
        }
    }
	</script>