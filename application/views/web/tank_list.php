				<?php $this->load->view('web/left');?>
				<div class="main-content">
					<?php $this->load->view('web/header');?>
					<div id="page-wrapper">
						<div class="page-header">
							<h3 class="blank1 pull-left" style="">Tank List</h3>
							<?php if(in_array("tank_add",$this->data['user_permission_list'])){ ?>
							<a href="<?php echo base_url();?>tank_list/add" class="btn btn-primary pull-right" style=""><i class="fa fa-plus"></i> Add</a>
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
										<th>Tank Name</th>
										<th>Tank Type</th>
										<th>Tank Location</th>
										<th>Fuel Type</th>
										<th>Status</th>
										<?php if(in_array("tank_action",$this->data['user_permission_list'])){ ?>
										<th>Action</th>
										<?php  } ?>
									</tr>
									</thead>
									<tbody>
									<?php $i=1; foreach($tanks as $t){ ?>
									<tr>
										<th><?php echo $i; ?></th>
										<th><a href='<?php echo base_url(); ?>tank_list/chart/<?php echo $t->id; ?>'><?php echo ucwords($t->tank_name); ?></a></th>
										<th><?php echo $t->tank_type; ?></th>
										<th><?php echo $t->l_name; ?></th>
										<?php if($logged_company['type'] == 'c'){ ?>
										<th>
										<a href='<?php echo base_url(); ?>tank_list/edit/<?php echo $t->id; ?>'><i class='fa fa-edit'></i></a>
										<a href='<?php echo base_url(); ?>tank_list/delete/<?php echo $t->id; ?>' onclick='return confirm("Are you sure you want to remove this data?");'><i class='fa fa-trash-o'></i></a>
										</th>
										<?php  } ?>
									</tr>
									<?php $i++; }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php $this->load->view('web/footer');?>
	</section>
<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
<script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript">
var table;
$(document).ready(function(){
    $lid = $('#location').val();
    table = $('#table').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],
        "bInfo" :false,
        "ajax": {
            "url": "<?php echo site_url('tank_list/ajax_list?extra=')?>"+$lid,
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ 0,5 ],
            "orderable": false,
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
                                                                         "url": "<?php echo site_url('tank_list/ajax_list?extra=')?>" + $lid,
                                                                         "type": "POST"
                                                                     },
                                                                     "columnDefs": [
                                                                         {
                                                                             "targets": [ 0,5 ],
                                                                             "orderable": false,
                                                                         },
                                                                     ],
                                                                 });
                                                             }
</script>
</body>
</html>