
			<?php $this->load->view('web/left');?>
			<!-- left side end-->
	    
			<!-- main content start-->
			<div class="main-content">
				<!-- header-starts -->
				<?php $this->load->view('web/header');?>
			<!-- //header-ends -->
				<div id="page-wrapper">
					
								<form method="post" action="<?php echo base_url();?>admin/add">			
								<h3 class="blank1" style="margin-top: -20px;">Customer List</h3>
	 								
								</form>

						 <div class="xs tabls">
							<div class="bs-example4" data-example-id="contextual-table">
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
							<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Location</label>
									<div class="col-sm-8">
										<select name="location" id="location" class="form-control1" onchange = "search()">
										<option value="">Select Location</option>
										<?php
                        foreach ($r as $row) {
                            ?>
                            <option value="<?php echo $row->l_id ?>"<?php if($row->l_id == $this->uri->segment('3') ){ echo "selected" ;} ?>><?php echo $row->l_name ?></option>
                            <?php
                        }
                        ?>
										
									</select><div class="invalid-feedback" id="locationerror" style="color: red;"></div>
									</div>
									<div class="col-sm-2">
									<?php if(in_array("customer_add",$this->data['user_permission_list'])){ ?>
									<a href="<?php echo base_url();?>manage_customer/add" class="btn btn-primary pull-right" style=""><i class="fa fa-plus"></i> Add</a>
									<?php } ?>
									</div>
								</div>
								
							
							<table class="table" id="table">
							  <thead>
								<tr>
								  <th>Sr No</th>
								  <th>Customer Name</th>
								  <th>Adress</th>
								  <th>Phone Number</th>
								  <th>Cheque Number</th>
								  <th>Bank Name</th>
								  <th>Personal Guarantor Name</th>
								  <th>Active</th>
								  <th>Status</th>
								  <?php if(in_array("customer_add",$this->data['user_permission_list'])){ ?>
								  <th>Action</th>
								  <?php } ?>
								</tr>
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
<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
 
var table;
 
$(document).ready(function() {
 	var location = $("#location").val();
    //datatables
     $lid = $('#location').val();
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "bInfo" :false,
		
 		
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('manage_customer/ajax_list?extra=')?>"+$lid,
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
 
});

function search(){
	$("#table").dataTable().fnDestroy();
var location = $("#location").val();
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "bInfo" :false,
		
 		
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('manage_customer/ajax_list?extra=')?>"+location,
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0,7,8 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
}
</script>
