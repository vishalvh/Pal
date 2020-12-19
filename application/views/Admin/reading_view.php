<style>
	.no-margin{
		list-style: none;
	}
</style>
	  <link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
		  <script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
        <script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
		
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reading List
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Reading list</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Reading List</h3>
<!--                            <a style="float:right;" href="<?php echo base_url(); ?>Pump_master" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i><strong> Add</strong></a>-->
<!--                        <a style="float:right;" href='<?= base_url() ?>company_master/company_csv' class="btn btn-primary btn-sm" data-toggle="modal"  data-target=""><strong > Export</strong></a>-->

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="widget">
                            <?php if (isset($success) != NULL) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $success['0']; ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('successf')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('successf'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('failf')) { ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('failf'); ?>
                                </div>
                            <?php } ?>   
                        </div>
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
                        <?php $attributes = array('class' => 'form-horizontal', 'method' => 'get', 'role' => 'form'); ?>

                              <?php echo form_open('reading_master/reading_list', $attributes); ?>
                             
							<div class="col-md-3">
								<input type="text" id="start_date"  readonly class="form-control" name="date1" placeholder="Start Date" value="<?php if(isset($date1) != NULL){ echo $date1; } ?>" />
								
							</div>
							<div class="col-md-3">
								<input type="text" id="end_date"  readonly class="form-control" name="date2" placeholder="End Date" value="<?php if(isset($date2) != NULL){ echo $date2; } ?>" />
								
							</div>
<div class="col-md-3">
							<select name="Employeename" class="form-control">
							<option value="">Select Employee </option> 
							<?php
$cnt = 1;
//print_r($category);
foreach ($Employee as $row) {
	//print_r($row);
    ?>
    
  <option  value="<?php $id = $row['id']; echo $row['id']; ?>" <?php if(isset($Employeename) != NULL){ if($id == $Employeename ) {
		echo "selected";
	} } ?>><?php echo $row['AdminName']; ?></option>
  <?php } ?>
</select>
		</div>				
							
<input type="submit" value="Search" class="btn btn-primary btn-md">
					
							<a href='<?php echo base_url(); ?>reading_master/reading_list' class="btn btn-primary btn-md" >Reset</a> 
                              </form>
                        <br>
                        <div class="tableclass">
                   <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Created at</th>
                                        <!--<th>SrNo</th>-->
<!--
                                        <th>Pump Name</th>
                                        <th>Employee Name</th>
-->
                                        <th>Patrol Reading</th>
                                        
                                        <th>Diesel Reading</th>
                                        <th>Meter Reading</th>
                                        <th>Total Cash</th>
                                        <th>Total Credit</th>
                                        <th>Total Expenses</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                        
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
<?php
$cnt = 1;
//print_r($category);
foreach ($query as $row) {
	//print_r($row);
    ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                             <td><?php echo $row['DATE']; ?></td>
                                            <!--<td><?php echo $row['UserId']; ?></td>-->
                                          
                                            <td><?php echo $row['PatrolReading']; ?></td>
                                            <td><?php echo $row['DieselReading']; ?></td>
                                            <td><?php echo $row['meterReading']; ?></td>
                                            <td><?php echo $row['TotalCash']; ?></td>
                                            <td><?php echo $row['TotalCredit']; ?></td>
                                            <td><?php echo $row['TotalExpenses']; ?></td>
                                            <td><?php echo $row['TotalAmount']; ?></td>
                                           <td>
                                                <a href='<?php echo base_url(); ?>reading_master/reading_list_details/<?php echo $row['id']; ?>' data-toggle="tooltip" data-original-title="view More"><i class="fa fa-info"></i></a> 
                                                <a href='<?php echo base_url(); ?>reading_master/update_details/<?php echo $row['id']; ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>   
                                            </td>
                                           
                                           
                                        </tr>
    <?php $cnt++;
}
?>
                                </tbody>
                            </table>
                        </div>
                       <div style="text-align:right;" class="box-tools">
					<ul class="pagination-sm no-margin pull-right">
					<li><?php echo $links;?></li>
						</ul>
				</div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="H4">Doctor list</h4>
                        </div>
                        <div class="modal-body"> 
<?php $attributes = array('class' => 'form-horizontal', 'method' => 'POST'); ?>
<?php
echo form_open_multipart('company_master/importcompany', $attributes);
$validate_array1 = array("imageform", "admin_add_email", "admin_add_password", "admin_add_type");
?>
                            <div class="box-body form-group">

                                <label>Upload</label>
                                <input type="file" name="company_file" class="form-controll">
                                <div style='color:red;' id='admin_name_add_alert'></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="model_close" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <input type="submit" id="add_admin_submit" name="add_menu" class="btn btn-primary" value="Add"/>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
