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
</style>
<script type='text/javascript'>
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
								<h3 class="blank1" style="margin-top: -20px;">Tanker Variation Report</h3>
	 								
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

							<form action="" id="savingdata" method="get">			
								
	 							
								

				
					<br>
					 <div class="cal-md-12">
							<div class="col-md-2">
							
								<input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php if(isset($sdate) != NULL){ echo $sdate; } ?>" />
								<span class="error" id="start_date_error"></span>
							</div>
							<div class="col-md-2">
							
								<input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="<?php if(isset($edate) != NULL){ echo $edate; } ?>" />
								<span class="error" id="end_date_error"></span>
							</div>
							<!-- Select Location -->
							<div class="col-md-2">
							
							<select name="location" id="location" class="form-control location">
							<option value="">Select Location </option> 
							<?php $cnt = 1; foreach ($location_list as $raw)  { ?>
  									<option  value="<?php echo $raw['l_id']; ?>" <?php if($location == $raw['l_id']){ echo "selected"; } ?>><?php echo $raw['l_name']; ?></option>
  							<?php } ?>
							</select>
										<span class="error" id="locatione_error"></span>
							</div>
							
							 <input type="submit"  class="btn btn-primary"  value="search">
							 <?php if(in_array("tanker_variation_report_print",$this->data['user_permission_list'])){ ?>
							   <a class="btn btn-primary"  href="<?php echo base_url();?>tankor_entory_report/pdf/?sdate=<?php echo $sdate;?>&edate=<?php echo $edate;?>&location=<?php echo $location;?>" formtarget="_blank">Print</a>
							 <?php } ?>
							 <br>
							 <br></div>
							</form>
						 <div class="">
						<?php foreach($result as $list){ ?>	
						
						<div> <hr><h1>Date : <?php echo date('d-m-Y',strtotime($list->date));?><hr>
						</div>
						<div class="col-md-6">
							<table class="table">
							  <thead>
							  <tr>
								<th>Tank Name</th>
								<th>BEFOR D. DEEP</th>
								<th>BEFORE LITER</th>
								<th>AFTER D DEEP</th>
								<th>AFTER  LITER</th>
								<th>Add Stock</th>
								</tr>
							  </thead>
							  <tbody id="newdata">
							  <?php $addstock = 0; foreach($list->tankdetail as $tankdetail){ ?>
								<tr>
								<th><?php echo $tankdetail->name;?></th>
								<th><?php echo $tankdetail->befor_deep;?></th>
								<th><?php echo $tankdetail->befor_liter;?></th>
								<th><?php echo $tankdetail->after_deep;?></th>
								<th><?php echo $tankdetail->after_liter;?></th>
								<th><?php echo $add = $tankdetail->after_liter-$tankdetail->befor_liter; $addstock = $addstock+$add; ?></th>
								</tr>
							  <?php } ?>
							  <tr>
							  <th colspan='5'>Add stock</th>
							  <th><?php echo $addstock; ?></th>
							  </tr>
							  </tbody>
							</table>
							</div>
							<div class="col-md-6">
							<table class="table">
							  <thead>
							  <tr>
								<th>Name</th>
								<th>BEFORE MITER READING</th>
								<th>AFTER METER READING</th>
								<th>TOTAL SALE</th>
								</tr>
							  </thead>
							  <tbody id="newdata">
							  <?php $totalselling = 0; foreach($list->meterdetail as $meterdetail){ ?>
								<tr>
								<th><?php echo $meterdetail->name;?></th>
								<th><?php echo $meterdetail->befor_meter;?></th>
								<th><?php echo $meterdetail->after_meter;?></th>
								<th><?php echo $meterdetail->selling; $totalselling = $totalselling+$meterdetail->selling;?></th>
								</tr>
								<?php } ?>
								<tr>
								<th colspan ='3'> Total Selling </th>
								<th><?php echo $totalselling; ?></th>
								</tr>
							  </tbody>
							</table>
							</div>
							<div class="col-md-12">
							<table class="table">
							<thead>
							<tr>
							<th>BUYING LITER</th>
							<th>ADD STOCK</th>
							<th>TOTAL SALES</th>
							<th>OVER SHORT</th>
							</tr>
							</thead>
							<tr>
							<th><?php echo $list->buying_liter; ?></th>
							<th><?php echo $addstock;?></th>
							<th><?php echo $totalselling;?></th>
							<th><?php echo (($addstock+$totalselling)-$list->buying_liter); ?></th>
							</tr>
							</table>
							</div>
							
							<?php } ?>
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