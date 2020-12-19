<?php $this->load->view('web/left');?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
		  <script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
        <script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
	
	<style>
        .title-h1 {
            display: inline-block;
            width: 100%;
        }

        .title-h1 h3 {
            margin: 0;
            padding: 15px 0;
            color: #27cce4;
            padding-top: 0;
        }

        .over-scroll,
        .bdr {
            display: inline-block;
            width: 100%;
            overflow-x: scroll;
        }

        .bdr .table tr>th,
        .bdr td,
        .bdr th {
            border: 1px solid #eee !important;
        }
    </style><script type='text/javascript'>
        $(document).ready(function(){
			var d = new Date();
    		var n = d.getFullYear();
       
           $( "#datepicker1" ).datepicker({
          changeMonth: true,
          changeYear: true,
          yearRange: "2017:n",
          dateFormat: "yy-mm-dd",
             defaultDate: 'today',
			   maxDate:'today',
			     onSelect: function () {
               var end_date = $('#datepicker2');
               var minDate = $(this).datepicker('getDate');
               end_date.datepicker('option', 'minDate', minDate);
           }
        });
			$( "#datepicker2" ).datepicker({
				
          changeMonth: true,
          changeYear: true,
          yearRange: "2017:n",
          dateFormat: "yy-mm-dd",
             defaultDate: 'today',
			   maxDate:'today'
        });


        });
$(document).ready(function () {
       $("#start_date").datepicker({
           dateFormat: "dd-mm-yy",
		   	changeMonth: true,
          changeYear: true,
		   yearRange: "2017:n",
		  maxDate:new Date(),
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
		    maxDate:new Date(),
       });
   });

        </script> 
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
					<form  >			
								<h3 class="blank1" style="margin-top: -20px;">Saving Report</h3>
	 								
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

							<form action="" id="savingdata" method="">			
								
	 							
								

				
					<br>
					 <div class="cal-md-12">
							<div class="col-md-2">
							
								<input type="text" id="start_date"  readonly class="form-control start_date" name="date1" placeholder="Start Date" value="<?php if(isset($date1) != NULL){ echo $date1; } ?>" />
								<span class="error" id="start_date_error"></span>
							</div>
							<div class="col-md-2">
							
								<input type="text" id="end_date"  readonly class="form-control end_date" name="date2" placeholder="End Date" value="<?php if(isset($date2) != NULL){ echo $date2; } ?>" />
								<span class="error" id="end_date_error"></span>
							</div>
							<!-- Select Location -->
							<div class="col-md-2">
							
							<select name="location" id="location" class="form-control location" onchange="get_member(this.value);">
							<option value="">Select Location </option> 
							<?php
								$cnt = 1;
								foreach ($location as $raw) 
								{
    							?>

  									<option  value="<?php echo $raw['l_id']; ?>" <?php if($lid == $raw['l_id']){ echo "selected"; } ?>><?php echo $raw['l_name']; ?></option>
  							<?php } ?>
							</select>
										<span class="error" id="locatione_error"></span>
							</div>
							<!-- Select Employee Name -->
							<div class="col-md-2">
							
							<select name="Employeename" id="Employeename" class="form-control">
							<option value="">Select Member </option> 
							
							</select>
							</div> 

							 <input type="button" onClick="search();" class="btn btn-primary"  value="search">
							 <?php if(in_array("saving_member_report_print",$this->data['user_permission_list'])){ ?>
							   <button class="btn btn-primary" formtarget="_blank"  onClick="Submitdata();" type="button" >Print</button>
							 <?php } ?>
							 <br>
							 <br></div>
							</form>


						 <div class="xs tabls">
							<div class="bs-example4" data-example-id="contextual-table">
							
								
							
							<table class="table">
							  <thead>
								<th>Sr No</th>
								<th>Member Name</th>
								<th>Date</th>
								<th>Amount</th>
								<?php if(in_array("saving_member_report_action",$this->data['user_permission_list'])){ ?>
								<th>Action</th>
								<?php } ?>
								  

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
function get_member(lid){
	 var customer_id = "<?php echo $member_id?>";
        
		if(lid==""){
				$("#Employeename").html('<option value="">Select Customer </option> ');
		}else{
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>saving_member_report/member_list/"+customer_id,
				data: {"lid": lid}, // serializes the form's elements.
				success: function (data)
				{
					$("#Employeename").html(data);
				}
			});
		}
}
 	function Submitdata()
{
		var sdate = $("#start_date").val();
		var edate = $("#end_date").val();
		var lid = $("#location").val();
		var lid = $("#location").val();
		var temp = 0;
		if(sdate == ""){
			$("#start_date_error").html('Required!');
			temp++;
		}
		else
		{
			$("#start_date_error").html('');
		}
		if(edate == ""){
			$("#end_date_error").html('Required!');
			temp++;
		}
		else
		{
			$("#end_date_error").html('');
		}
		if(lid == ""){
			$("#locatione_error").html('Required!');
			temp++;
		}
		else
		{
			$("#locatione_error").html('');
		}
//		 var $tdate = new Date(toDate).toDateString("yyyy-MM-dd");
//		var $tdate = new Date(toDate).toDateString("yyyy-mm-dd");

		if(temp==0){
        document.forms['savingdata'].action='<?php echo site_url()?>saving_member_report/print_pdf';
		$("#savingdata").attr("target","_blank");
        document.forms['savingdata'].submit();
		}else{
			return false
		}
}
	function search(){	
		var sdate = $("#start_date").val();
		var edate = $("#end_date").val();
		var lid = $("#location").val();
		var member_id = $("#Employeename").val();
		var temp = 0;
		if(sdate == ""){
			$("#start_date_error").html('Required!');
			temp++;
		}
		else {
			$("#start_date_error").html('');
		}
		
		if(edate == ""){
			$("#end_date_error").html('Required!');
			temp++;
		}
		else {
			$("#end_date_error").html('');
		}
		if(lid == ""){
			$("#locatione_error").html('Required!');
			temp++;
		}
		else {
			$("#locatione_error").html('');
		}
//		 var $tdate = new Date(toDate).toDateString("yyyy-MM-dd");
//		var $tdate = new Date(toDate).toDateString("yyyy-mm-dd");

		if(temp==0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>saving_member_report/reportlist",
				data: {'lid': lid,'sdate':sdate,'edate':edate,'member_id':member_id}, // serializes the form's elements.
				success: function (data)
				{
					//alert($data);
					$("#newdata").html(data);
				}
			});
		}	
		}
		<?php if($lid != ""){ ?>
		get_member(<?php echo $lid; ?>);
		setTimeout(function(){
  search(); 
}, 1000);
		 
		<?php } ?>
</script>