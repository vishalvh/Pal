	
<!-- left side start-->
<?php $this->load->view('web/left'); ?>
<!-- left side end-->

<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">


        <div class="page-header">
            <h3 class="blank1 pull-left" style="">Message List</h3>
            <?php if(in_array("send_message",$this->data['user_permission_list'])){ ?>
			<a href="<?php echo base_url(); ?>message_master/add" class="btn btn-primary pull-right" style=""><i class="fa fa-plus"></i> Add</a>
			<?php } ?>
        </div>

        <form action="" id="savingdata" method="">			
            <br>
            <div class="cal-md-12">

                <!-- Select Location -->
                <div class="col-md-2">

                    <select name="location" id="location" class="form-control1">
                        <option value="">Select Location</option>
                        <?php
                        foreach ($this->data['all_location_list'] as $row) {
                            ?>
                            <option value="<?php echo $row->l_id ?>"><?php echo $row->l_name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="error" id="locatione_error"></span>
                </div>
				<div class="col-md-2">

                    <select name="type" id="type" class="form-control1">
										<option value="">Select User</option>
										<option value="Customer">Customer</option>
										<option value="Worker">Worker</option>
										<option value="Employee">Employee</option>
										</select>
                </div>
				<div class="col-md-2">
					<input type="text" class="form-control1" id="mobile">
				</div>
				<div class="col-md-2">
                <input type="button" onClick="search();" class="btn btn-primary"  value="search">
</div>
<div class="col-md-2">
Message Balance : <?php $balance = file_get_contents("https://gateway.leewaysoftech.com/creditapi.php?username=paloil&password=Nik@65L"); print_r($balance); ?>
</div>
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
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Number</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Sending Date</th>
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
<?php $this->load->view('web/footer'); ?>
<!--footer section end-->

<!-- main content end-->
</section>

<script src="<?php echo base_url(); ?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(); ?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets1/js/bootstrap.min.js"></script>
</body>
</html>

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript">
function search() {
	$("#table").dataTable().fnDestroy();
$lid = $('#location').val();
$type = $('#type').val();
$mobile = $('#mobile').val();
	table = $('#table').DataTable({
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		"bInfo": false,
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "<?php echo site_url('message_master/ajax_list?location=') ?>" + $lid+"&type="+$type+"&mobile="+$mobile,
			"type": "POST"
		},
		//Set column definition initialisation properties.
		"columnDefs": [
			{
				"targets": [0], //first column / numbering column
				"orderable": false, //set not orderable
			},
		],
	});
}
search();
</script>