	
	<script type='text/javascript'>
        $(document).ready(function(){
			var d = new Date();
    		var n = d.getFullYear();
       
           $( "#datepicker1" ).datepicker({
          changeMonth: true,
          changeYear: true,
          yearRange: "1918:n",
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
          yearRange: "1918:n",
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
        <style>
		.dataTables_filter {
display: none; 
}</style> 
	   
	    <!-- left side start-->
			<?php $this->load->view('web/left');?>
			<!-- left side end-->
	    
			<!-- main content start-->
			<div class="main-content">
				<!-- header-starts -->
				<?php $this->load->view('web/header');?>
			<!-- //header-ends -->
				<div id="page-wrapper">
								
<div class="page-header">
									<h3 class="blank1 pull-left" style="">Inventory Report</h3>
										
									</div>
					

							<form method="post" action="<?php echo base_url();?>admin/add">			
								
	 							
							
					 <div class="cal-md-12">
							<div class="col-md-2">
							
								<input type="text" id="start_date"  readonly class="form-control start_date" name="date1" placeholder="Start Date" value="<?php if(isset($date1) != NULL){ echo $date1; } ?>" />
								
							</div>
							<div class="col-md-2">
							
								<input type="text" id="end_date"  readonly class="form-control end_date" name="date2" placeholder="End Date" value="<?php if(isset($date2) != NULL){ echo $date2; } ?>" />
								
							</div>
							<!-- Select Location -->
							<div class="col-md-2">
							
							<select name="location" id="location" class="form-control location">
							<option value="">Select Location</option> 
							<?php
								$cnt = 1;
								foreach ($location as $raw) 
								{
    							?>

  									<option  value="<?php echo $raw['l_id']; ?>" <?php if(isset($location) != NULL)
  									{ 
  										if($id == $location)
  										{
											echo "selected";
										} 
									} ?>><?php echo $raw['l_name']; ?></option>
  							<?php } ?>
							</select>
							</div>
							<!-- Select Employee Name -->
							<div class="col-md-2">
							
							<select name="Employeename" id="Employeename" class="form-control">
							<option value="">Select Employee </option> 
							<?php
								$cnt = 1;
								foreach ($Employee as $row) 
								{
    							?>
  									<option  value="<?php $id = $row['id']; echo $row['id']; ?>" <?php if(isset($Employeename) != NULL)
  									{ 
  										if($id == $Employeename )
  										{
											echo "selected";
										} 
									} ?>><?php echo $row['UserFName']; ?></option>
  							<?php } ?>
							</select>
							</div>

							 <input type="button" onClick="search();" class="btn btn-primary"  value="search">
							 <input type="reset" class="btn btn-primary"  value="reset">
							 <br>
							 <br></div>
							</form>


						 <div class="xs tabls">
							<div class="bs-example4" data-example-id="contextual-table">
							
								
							
							<table class="" id="table">
							  <thead>
								  <th>Sr No</th>
								  <th>Date</th>
								  <th>Username</th>
								  <th>Location</th>
								  <th>Petrol invoicenumber</th>
								  <th>Petrol fuelamount</th>
								  <th>Petrol taxamount</th>
								  <th>Petrol paymenttype</th>
								  <th>Petrol chequenumber</th>
								  <th>Petrol paidamount</th>
								  <th>Petrol quantity</th>
								  <th>Petrol tankerreading</th>
								  
								  <th>Disel invoicenumber</th>
								  <th>Disel fuelamount</th>
								  <th>Disel taxamount</th>
								  <th>Disel paymenttype</th>
								  <th>Disel chequenumber</th>
								  <th>Disel paidamount</th>
								  <th>Disel quantity</th>
								  <th>Disel tankerreading</th>
								  
								  <th>oil type</th>
								  <th>oil quantity</th>
								  <th>oil amount</th>
								  <th>Action</th>
								  

							  </thead>
							  <tbody>
								
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
 
var table;
 
 var query = "";
	function search(query){
		$Employeename = $('#Employeename').val();	
		$Product = $('#Product').val();	
		$ConeType = $('#ConeType').val();	
		$Packaging = $('#Packaging').val();	
		$pb = $('#pb').val();	
		var $fdate = $('.start_date').val();
		var $tdate = $('.end_date').val();
		var $location = $('.location').val();	
//		 var $tdate = new Date(toDate).toDateString("yyyy-MM-dd");
//		var $tdate = new Date(toDate).toDateString("yyyy-mm-dd");
		$("#table").dataTable().fnDestroy();
//		alert(query);
			$('#table').DataTable({ 
				"processing": true,
				"serverSide": true,
				"order": [],
				 "scrollX": true,
				
				
				
				"ajax": {
					"url": "<?php echo site_url('Inventory/ajax_list?employeename=')?>"+$Employeename+"&fdate="+$fdate+"&tdate="+$tdate+"&location="+$location,
					"type": "POST"
				},
				"columnDefs": [
				{ 
					"targets": [ 0,3,5 ], 
					"orderable": false,
				},
				],
			});
		}

$(document).ready(function() {
 	
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "scrollX": true,
        
        "bFilter": false,
        "bInfo": false,
 		
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Inventory/ajax_list?employeename=')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
});</script>