<?php $this->load->view('web/left');?>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets1/css/jquery.mCustomScrollbar.min.css" type='text/css' />
			<!-- main content start-->
			<div class="main-content">
				<!-- header-starts -->
				<?php $this->load->view('web/header');?>
			<!-- //header-ends -->
				<div id="page-wrapper"> 
					<form method="post" action="<?php echo base_url();?>admin/add">			
								<h3 class="blank1" style="margin-top: -20px;">Salary Report</h3>
								</form>
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
							
								<input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php echo $sdate; ?>" />
								<span class="error" id="sdateerror"></span>
							</div>
							<div class="col-md-2">
							
								<input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="<?php echo $edate; ?>" />
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

  									<option  value="<?php echo $raw['l_id']; ?>" <?php if($raw['l_id'] == $l_id){ echo "selected"; }?>><?php echo $raw['l_name']; ?></option>
  							<?php } ?>
							</select>
							<span class="error" id="locationerror"></span>
							</div>
                                                        <div class="col-md-2">
							
							<select name="worker_id" id="worker_id" class="form-control location">
							<option value=''>All Worker</option> 
							<?php $cnt = 1; foreach ($worker_list as $raw) { ?>
								<option  value="<?php echo $raw['id']; ?>" <?php if($raw['id'] == $worker_id){ echo "selected"; }?>> <?php echo $raw['name']; ?></option>
  							<?php  } ?>
							</select>
							<span class="error" id="locationerror"></span>
							</div>
							<!-- Select Employee Name -->
							

							 <input type="button" onClick="search();" class="btn btn-primary"  value="search">
							 <?php if(in_array("salary_report_print",$this->data['user_permission_list'])){ ?>
							 <input type="button" onClick="printpdf();" class="btn btn-primary"  value="Print">
							 <?php } ?>
							 <br>
							 <br></div>
							</form>


						 <div class="xs tabls">
							<div class="bs-example4" data-example-id="contextual-table">
							
								
							<div class="over-scroll bdr">
							<table class="table">
							  <thead>
							  <tr>
								  <th>Sr No</th>
								  <th>Name</th>
								  <th>Salary</th>
								  <th>Bonus</th>
								  <th>Extra Pay</th>
								  <th>Paid Salary</th>
								  <th>Paid Loan</th>
								  <th>Total</th>
								  <th>Advance</th>
								  <th>Past Loan</th>
								  <th>Total Loan</th>
								  <th>Remaining Loan</th>
								  <?php if(in_array("salary_report_action",$this->data['user_permission_list'])){ ?>
                                                                  <th>Action</th>
								  <?php } ?>
							  </tr>
							  </thead>
							  <tbody id="newdata">
								
							  </tbody>
							</table>
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
    <script src="<?php echo base_url();?>assets1/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
        (function($) {
            $(window).on("load", function() {
                $(".bdr").mCustomScrollbar({
                    axis: "x",
                    advanced: {
                        autoExpandHorizontalScroll: true
                    }
                });              
            });
        })(jQuery);
 function printpdf(){
		var $fdate = $('#start_date').val();
		var $tdate = $('#end_date').val();
		var $location = $('#location').val();	
		var temp = 0;
		if($fdate == ""){
			temp++;
			$("#sdateerror").html('Required!');
		}
		else{
			$("#sdateerror").html('');	
		}
		if($tdate == ""){
			temp++;
			$("#edateerror").html('Required!');
		}
		else{
			$("#edateerror").html('');	
		}
		if($location == ""){
			temp++;
			$("#locationerror").html('Required!');
		}
		else{
			$("#locationerror").html('');	
		}
		if(temp==0){
    
        document.forms['savingdata'].action='<?php echo site_url()?>worker_salary/print_report';
        document.forms['savingdata'].submit();
		}else{
			return false
		}
    
 }
 
var table;
 
 var query = "";
	function search(){
		var $fdate = $('#start_date').val();
		var $tdate = $('#end_date').val();
		var $location = $('#location').val();
                var $worker_id = $('#worker_id').val();	
		var temp = 0;
		if($fdate == ""){
			temp++;
			$("#sdateerror").html('Required!');
		}
		else{
			$("#sdateerror").html('');
		}
		if($tdate == ""){
			temp++;
			$("#edateerror").html('Required!');
		}
		else{
			$("#edateerror").html('');	
		}

		if($location == ""){
			temp++;
			$("#locationerror").html('Required!');
		}
		else{
			$("#locationerror").html('');	
		}
		if(temp==0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>worker_salary/reportlist",
				data: {'lid': $location,'sdate':$fdate,'edate':$tdate,'worker_id':$worker_id}, // serializes the form's elements.
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
		   yearRange: "2017:n",
		  maxDate: new Date(),
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
			yearRange: "2017:n",
		    maxDate: new Date(),
       });
   }); 

        </script> 
        <script  type="text/javascript">
 $("#location").on('change',function(){
     $("#worker_id").empty();
     
           var where = { "id" : $("#location").val() };
           $.ajax({
               type: 'POST',
               data: { where: where }, 
               url: "<?php echo site_url(); ?>worker_salary/worker_list",
          success: function(data) {
                   $("#worker_id").empty();
                   $("#worker_id").html("<option value=''>All Worker</option> ");
                   var worker = JSON.parse(data);
                   for(var i=0; i<worker.length;i++){
                       $("#worker_id").append(
                           $('<option value="'+worker[i].id+'">'+worker[i].name+'</option> ')
                       );
                   }
               }
           });
       });
	   <?php if($this->input->get('l_id')){?>
	   search();
	   <?php } ?>
</script>