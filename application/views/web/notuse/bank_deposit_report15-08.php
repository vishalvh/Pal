<?php $this->load->view('web/left');?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>	
	
        <style>
		.dataTables_filter {
display: none; 
}</style> 
	   
	    <!-- left side start-->
			
			<!-- left side end-->
	    
			<!-- main content start-->
			<div class="main-content">
				<!-- header-starts -->
				<?php $this->load->view('web/header');?>
			<!-- //header-ends -->
				<div id="page-wrapper">
					<form method="post" action="<?php echo base_url();?>admin/add">			
								<h3 class="blank1" style="margin-top: -20px;">Bank Report</h3>
	 								
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

							<form method="" target="_blank" action="" id="savingdata">			
								
	 							
								

				
					<br>
					 <div class="cal-md-12">
							<div class="col-md-2">
							
								<input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="" />
								<span class="error" id="sdateerror"></span>
							</div>
							<div class="col-md-2">
							
								<input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="" />
								<span class="error" id="edateerror"></span>
							</div>
							<!-- Select Location -->
							<div class="col-md-2">
							
							<select name="lid" id="location" class="form-control location">
							<option value="">Select Location</option> 
							<?php

								$cnt = 1;
								foreach ($location as $raw) 
								{
    							?>

  									<option  value="<?php echo $raw['l_id']; ?>"><?php echo $raw['l_name']; ?></option>
  							<?php } ?>
							</select>
							<span class="error" id="locationerror"></span>
							</div>
							<!-- Select Employee Name -->
							

							 <input type="button" onClick="search();" class="btn btn-primary"  value="search">
							 <input type="button" onClick="printpdf();" class="btn btn-primary"  value="Print">
							 <br>
							 <br></div>
							</form>


						 <div class="xs tabls">
							<div class="bs-example4" data-example-id="contextual-table">
							
								
							
							<table class="table">
							  <thead>
							  <tr>
								  <th>Sr No</th>
								  <th>Date</th>
								  <th>Deposit Amount</th>
								  <th>Cheque Amount</th>
								  <th>Cheque Number</th>
								  <th>Withdraw Amount</th>
								  
								  <th>Withdraw Transection Number</th>
                                                                  <th>Card Amount</th>
                                                                  <th>Batch No</th>
								  <th>Action</th>
								  </tr>
							  </thead>
							  <tbody id="newdata">
								
							  </tbody>
							</table>
							
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


<script type="text/javascript">
 function printpdf(){
	 $(".error").html("");
		var $fdate = $('#start_date').val();
		var $tdate = $('#end_date').val();
		var $location = $('#location').val();	
		var temp = 0;
		if($fdate == ""){
			temp++;
			$("#sdateerror").html('Required!');
		}
		if($tdate == ""){
			temp++;
			$("#edateerror").html('Required!');
		}
		if($location == ""){
			temp++;
			$("#locationerror").html('Required!');
		}
		if(temp==0){
    
        document.forms['savingdata'].action='<?php echo site_url()?>bank_deposit/print_report';
        document.forms['savingdata'].submit();
		}else{
			return false
		}
    
 }
 
var table;
 
 var query = "";
	function search(){
		 $(".error").html("");
		var $fdate = $('#start_date').val();
		var $tdate = $('#end_date').val();
		var $location = $('#location').val();	
		var temp = 0;
		if($fdate == ""){
			temp++;
			$("#sdateerror").html('Required!');
		}
		if($tdate == ""){
			temp++;
			$("#edateerror").html('Required!');
		}
		if($location == ""){
			temp++;
			$("#locationerror").html('Required!');
		}
		if(temp==0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>bank_deposit/reportlist",
				data: {'lid': $location,'sdate':$fdate,'edate':$tdate}, // serializes the form's elements.
				success: function (data)
				{
					$("#newdata").html(data);
				}
			});
		}
		
		}
</script>
<script type='text/javascript'>
      
$(document).ready(function () {
       $("#start_date").datepicker({
           dateFormat: "dd-mm-yy",
		   	changeMonth: true,
          changeYear: true,
		   yearRange: "1918:n",
		  
           onSelect: function () {
               var end_date = $('#end_date');
			   
               var minDate = $(this).datepicker('getDate');
			   
               end_date.datepicker('option', 'minDate', minDate);
           }
       });
       $('#end_date').datepicker({
           dateFormat: "dd-mm-yy",
		   	changeMonth: true,
		    changeYear: true,
       });
   });

        </script> 