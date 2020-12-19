				<?php $this->load->view('web/left');?>
				<div class="main-content">
					<?php $this->load->view('web/header');?>
					<style>
					.col-md-4{
						border: 1px solid #000;
					}
					.col-md-4 .heading{
						border: 0.5px solid #000;
					}
					</style>
					<div id="page-wrapper">
						<div class="page-header">
							<h3 class="blank1 pull-left" style="">Tank Chart</h3>
						</div>
						<div class="xs tabls demo">
							<div class="bs-example4" data-example-id="contextual-table">
							<?php if($logged_company['type'] == 'c'){ ?>
							
							
							<?php if($logged_company['type'] == 'c'){ ?>
								<input type="hidden" id="tank_chart_add" value="<?php echo base_url(); ?>tank_list/add_update_chart/<?php echo $this->uri->segment(3); ?>">
								<div class="form-group col-md-12">
									<label for="reading">Reading: <input type="text" name="reading" id="reading" onkeydown="if (event.keyCode == 13){ submit(); }" value="" required></label>
									<label for="volume">Volume: <input type="text" name="volume" id="volume" onkeydown="if (event.keyCode == 13){ submit(); }" value="" required></label>
									<a type="button" class="btn btn-primary" onclick="submit();">Save</a>
								</div>
							<?php } ?>
							
							<form action="" method="post">
								
								<input type="hidden" id="tank_chart_add" value="<?php echo base_url(); ?>tank_list/add_update_chart/<?php echo $this->uri->segment(3); ?>">
								<div class="form-group col-md-12">
								
								<label>Dia</label>
								<input type="text" name="dia" value="<?php if(isset($dia)){ echo $dia; }elseif(isset($get_main_data->dia)){ echo $get_main_data->dia; }?>">
								<span style="color:red"><?php echo form_error('dia'); ?></span>
								
								<label>Length</label>
								<input type="text" name="length" value="<?php if(isset($length)){ echo $length; }elseif(isset($get_main_data->length)){ echo $get_main_data->length; } ?>">
								<span style="color:red"><?php echo form_error('length'); ?></span>
								
								<label>Dip Changes Start</label>
								<input type="text" name="dchange" value="<?php if(isset($dchange)){ echo $dchange; }elseif(isset($get_main_data->dip_change_start)){ echo $get_main_data->dip_change_start; } ?>">
								<span style="color:red"><?php echo form_error('dchange'); ?></span>
								
								<label>Dip Changes End</label>
								<input type="text" name="dchangeend" value="<?php if(isset($dchangeend)){ echo $dchangeend; }elseif(isset($get_main_data->dip_change_end)){ echo $get_main_data->dip_change_end; }?>">
								<span style="color:red"><?php echo form_error('dchangeend'); ?></span>
								
								<input type="submit"  class="btn btn-primary"  value="Submit" name="save">
								<input type="submit"  class="btn btn-primary"  value="Preview" name="Preview">
								</div>
							</form>
							<?php } ?>
								<?php if ($this->session->flashdata('success')) { ?>
								<div class="alert alert-success alert-dixsissable">
								   <button aria-hidden="true" data-dixsiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success'); ?>
								</div>
								<?php } ?>
								<?php if ($this->session->flashdata('fail')) { ?>
								<div class="alert alert-success alert-dixsissable">
								   <button aria-hidden="true" data-dixsiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('fail'); ?>
								</div>
								<?php } ?>
								<?php if ($this->session->flashdata('success_update')) { ?>
								<div class="alert alert-success alert-dixsissable">
								   <button aria-hidden="true" data-dixsiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success_update'); ?>
								</div>
								<?php } ?>
								<?php if ($this->session->flashdata('check_fail')) { ?>
								<div class="alert alert-danger alert-dixsissable">
								   <button aria-hidden="true" data-dixsiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('check_fail'); ?>
								</div>
								<?php } ?>
								<?php $j=sizeof($get_all_data)/3; ?>
								<div class="row" id="here">
									<div class="col-md-4">
										<div class="row heading">
											<div class="col-xs-1">
												Sr No
											</div>
											<div class="col-xs-3">
												Tank Name
											</div>
											<div class="col-xs-3">
												Tank Reading
											</div>
											<div class="col-xs-3">
												Tank Volume
											</div>
											<?php if(!isset($Preview)){ ?>
											<div class="col-xs-2">
												Action
											</div>
											<?php } ?>
										</div>
										<?php $i=1; foreach($get_all_data as $t){ if($i <= $j){ ?>
										<div class="row">
											<div class="col-xs-1">
												<?php echo $i; ?>
											</div>
											<div class="col-xs-3">
												<?php echo $get_tank_data->tank_name; ?>
											</div>
											<div class="col-xs-3">
												<?php echo $t->reading; ?>
											</div>
											<div class="col-xs-3">
												<?php echo $t->volume; ?>
											</div>
											<?php if(!isset($Preview)){ ?>
											<div class="col-xs-2">
												<a href='#' onclick='edit("<?php echo $t->id; ?>","<?php echo $t->reading; ?>","<?php echo $t->volume; ?>")'><i class='fa fa-edit'></i></a>
												<a href='<?php echo base_url(); ?>tank_list/chartdelete/<?php echo $t->id; ?>/<?php echo $this->uri->segment(3); ?>' onclick='return confirm("Are you sure you want to remove this data?");'><i class='fa fa-trash-o'></i></a>
											</div>
											<?php } ?>
										</div>
										<?php }$i++; } ?>
									</div>
									<div class="col-md-4">
										<div class="row heading">
											<div class="col-xs-1">
												Sr No
											</div>
											<div class="col-xs-3">
												Tank Name
											</div>
											<div class="col-xs-3">
												Tank Reading
											</div>
											<div class="col-xs-3">
												Tank Volume
											</div>
											<?php if(!isset($Preview)){ ?>
											<div class="col-xs-2">
												Action
											</div>
											<?php } ?>
										</div>
										<?php $i=1; foreach($get_all_data as $t){ if($i <= $j*2 && $i > $j){ ?>
										<div class="row">
											<div class="col-xs-1">
												<?php echo $i; ?>
											</div>
											<div class="col-xs-3">
												<?php echo $get_tank_data->tank_name; ?>
											</div>
											<div class="col-xs-3">
												<?php echo $t->reading; ?>
											</div>
											<div class="col-xs-3">
												<?php echo $t->volume; ?>
											</div>
											<?php if(!isset($Preview)){ ?>
											<div class="col-xs-2">
												<a href='#' onclick='edit("<?php echo $t->id; ?>","<?php echo $t->reading; ?>","<?php echo $t->volume; ?>")'><i class='fa fa-edit'></i></a>
												<a href='<?php echo base_url(); ?>tank_list/chartdelete/<?php echo $t->id; ?>/<?php echo $this->uri->segment(3); ?>' onclick='return confirm("Are you sure you want to remove this data?");'><i class='fa fa-trash-o'></i></a>
											</div>
											<?php } ?>
										</div>
										<?php }$i++; } ?>
									</div>
									<div class="col-md-4">
										<div class="row heading">
											<div class="col-xs-1">
												Sr No
											</div>
											<div class="col-xs-3">
												Tank Name
											</div>
											<div class="col-xs-3">
												Tank Reading
											</div>
											<div class="col-xs-3">
												Tank Volume
											</div>
											<?php if(!isset($Preview)){ ?>
											<div class="col-xs-2">
												Action
											</div>
											<?php } ?>
										</div>
										<?php $i=1; foreach($get_all_data as $t){ if($i > $j*2){ ?>
										<div class="row">
											<div class="col-xs-1">
												<?php echo $i; ?>
											</div>
											<div class="col-xs-3">
												<?php echo $get_tank_data->tank_name; ?>
											</div>
											<div class="col-xs-3">
												<?php echo $t->reading; ?>
											</div>
											<div class="col-xs-3">
												<?php echo $t->volume; ?>
											</div>
											<?php if(!isset($Preview)){ ?>
											<div class="col-xs-2">
												<a href='#' onclick='edit("<?php echo $t->id; ?>","<?php echo $t->reading; ?>","<?php echo $t->volume; ?>")'><i class='fa fa-edit'></i></a>
												<a href='<?php echo base_url(); ?>tank_list/chartdelete/<?php echo $t->id; ?>/<?php echo $this->uri->segment(3); ?>' onclick='return confirm("Are you sure you want to remove this data?");'><i class='fa fa-trash-o'></i></a>
											</div>
											<?php } ?>
										</div>
										<?php }$i++; } ?>
									</div>
								</div>
								
								
									
								<?php /*if($get_all_data){ ?>
									<table border="1" style="border-collapse: collapse; width:100%" >
										<thead>
											<tr>
												<th>Sr No</th>
												<th>Tank Name</th>
												<th>Tank Reading</th>
												<th>Tank Volume</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 0; foreach($get_all_data as $row){ ?>
											<tr>
												<td><?=++$i?></td>
												<td><?=$get_main_data->tank_name?></td>
												<td><?=$row->tank_reading?></td>
												<td><?=$row->tank_volume?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								<?php } */ ?>
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
// var table;
// $(document).ready(function(){
    // table = $('#table').DataTable({ 
        // "processing": true,
        // "serverSide": true,
        // "order": [],
        // "bInfo" :false,
        // "ajax": {
            // "url": "<?php echo site_url()?>/tank_list/ajax_list1/<?php echo $this->uri->segment(3); ?>?extra=",
            // "type": "POST"
        // },
        // "columnDefs": [
        // { 
            // "targets": [ 0 ],
            // "orderable": false,
        // },
        // ],
    // });
// });
function edit(id,reading,volume){
	$("#tank_chart_add").val("<?php echo base_url(); ?>tank_list/add_update_chart/<?php echo $this->uri->segment(3); ?>/"+id);
	$("#reading").val(reading);
	$("#volume").val(volume);
	$( "div.demo" ).scrollTop( 300 );
}
function submit(){
	
	$reading = $("#reading").val();
	$volume = $("#volume").val();
	$action = $("#tank_chart_add").val();
	if($reading != "" && $volume != ""){
		$("#arrowLoader").show();
	$.ajax({
		url: $action,
		method: "POST",
		data: { reading: $reading, volume: $volume  },
		success: function(response){
			$("#arrowLoader").hide();
			if(response != ""){
				$("#here").html("");
				$("#here").append(response);
				$("#tank_chart_add").val("<?php echo base_url(); ?>tank_list/add_update_chart/<?php echo $this->uri->segment(3); ?>");
				$("#reading").val("");
				$("#volume").val("");
				$("#reading").focus();
			}else{
				alert("Try Again!!");
				$("#reading").focus();
			}
		}
	})
}
}
function reset(){
	$("#tank_chart_add").val("<?php echo base_url(); ?>tank_list/add_update_chart/<?php echo $this->uri->segment(3); ?>");
}
$(document).ready(function(){
	$(".close").click(function(){
		$(this).parent().hide();
	});
});
</script>
</body>
</html>