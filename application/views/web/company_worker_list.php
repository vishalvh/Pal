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
									<h3 class="blank1 pull-left" style="">Worker List</h3>
                                                         
									</div>
								

<form action="" id="savingdata" method="">			
            <br>
            <div class="cal-md-12">

                <!-- Select Location -->
                <div class="col-md-2">

                    <select name="location" id="location" class="form-control1">
                        <option value="">Select Location</option>
                        <?php
                        foreach ($r->result() as $row) {
                            ?>
                            <option value="<?php echo $row->l_id ?>"<?php if($row->l_id == $this->uri->segment('3') ){ echo "selected" ;} ?>><?php echo $row->l_name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="error" id="locatione_error"></span>
                </div>
                <input type="button" onClick="search();" class="btn btn-primary"  value="search">
<?php if(in_array("worker_add",$this->data['user_permission_list'])){ ?>
<a href="<?php echo base_url();?>company_worker/add" class="btn btn-primary" style=""><i class="fa fa-plus"></i> Add</a>
<?php } ?>
<?php if(in_array("worker_monthly_salary",$this->data['user_permission_list'])){ ?>
<a href="<?php echo base_url();?>company_worker/view_salary" class="btn btn-primary" style=""><i class="fa fa-plus"></i> Salary</a>
<?php } ?>
                <br>
                <br></div>
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
							
								
							
							<table class="table" id="table">
							  <thead>
								<tr>
								  <th>Sr No</th>
								  <th>Code</th>
								  <th>Name</th>
								  <th>Phone Number</th>
								  <th>Location</th>
								  <th>Shift</th>
                                  <?php if(in_array("worker_action",$this->data['user_permission_list'])){ ?>
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

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript">
 
var table;
 
$(document).ready(function() {
 	
    //datatables
    $lid = $('#location').val();
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "bInfo" :false,
 		
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('company_worker/ajax_list?extra=')?>"+$lid,
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

  var query = "";
                    function search(query) {

                        $lid = $('#location').val();
//                                                                alert($lid);
                        $("#table").dataTable().fnDestroy();
                        $('#table').DataTable({
                            "processing": true,
                            "serverSide": true,
                            "bInfo": false,
                            "order": [],

                            "ajax": {
                                "url": "<?php echo site_url('company_worker/ajax_list?extra=')?>" + $lid,
                                "type": "POST"
                            },
                            "columnDefs": [
                                {
                                   "targets": [0],
                                    "orderable": false,
                                },
                            ],
                        });
                    }

</script>