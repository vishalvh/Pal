<style type="text/css">
    .box.box-primary{
        display: inline-block;
        width: 100%;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
                Readingreport Info
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">readingreport info</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <p class="help-block" style="color:red;"><?php
                        if (isset($error)) {
                            echo $error;
                        }
                        ?></p>
                            <?php
                                    if ($query[0]['shift'] == '1') 
                                    {
                                        $shift = "Day";
                                    }
                                    if ($query[0]['shift'] == '2') 
                                    {
                                        $shift = "Night";
                                    }
                                    if ($query[0]['shift'] == '3') 
                                    {
                                        $shift = "24 hours";
                                    }
                                ?>
                                
                                <div class="col-md-4">
                                    <label class="control-label"><b>Date</b></label>
                                    <div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo date('d-m-Y', strtotime($query[0]['date']));?></p>
                                    </div>
                                    <label class="control-label"><b>Shift</b></label>
                                    <div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo $shift;?></p>
                                    </div>

                                    <div class="col-md-6" >
                                    
                                    <div class="col-md-12">
                                            <p class="form-control-static" style="overflow: hidden;white-space: nowrap;margin-left: -25px;">General Information</p>
                                    </div>

                                    <label class="control-label"><b>Disel Reading</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $query[0]['DieselReading'];?></p>
                                    </div>
                                    <label class="control-label"><b>Petrol Reading</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $query[0]['PatrolReading'];?></p>
                                    </div>
                                    <label class="control-label"><b>Meter Reading</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $query[0]['meterReading'];?></p>
                                    </div>
                                    <label class="control-label"><b>Total Amount</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $query[0]['TotalAmount'];?></p>
                                    </div>
                                    <label class="control-label"><b>Total cash</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $query[0]['TotalCash'];?></p>
                                    </div>
                                    <label class="control-label"><b>Total Credit</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $query[0]['TotalCredit'];?></p>
                                    </div>
                                    <label class="control-label"><b>Total Expense</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $query[0]['TotalExpenses'];?></p>
                                    </div>
                                    <label class="control-label"><b>Disel Deep Reading</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $query[0]['disel_deep_reding'];?></p>
                                    </div>
                                    <label class="control-label"><b>Petrol Deep Reading</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $query[0]['petrol_deep_reding'];?></p>
                                    </div>
                                </div>
                            
                                
                                </div>
                                <?php
                                    $name =$query[0]['UserFName'];
                                ?>
                                <div class="col-md-4">
                                    <label class="control-label"><b>Name</b></label>
                                    <div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo ucfirst($name);?></p>
                                    </div>
                                    <label class="control-label"><b></b></label>
                                    <div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"></p>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="col-sm-12">

                                            <p class="form-control-static" style="overflow: hidden;white-space: nowrap;margin-left: -25px;"> Pump Information</p>
                                        </div> 
                          
       <?php  foreach($details as $row ) {?>
                              <div class="form-group header-group-0 " id="form-group-description" style="">
                                        <label class="control-label"><b><?php echo $row['name']; ?></b></label>
                                        <div class="">
                                            <p class="form-control-static"><?php echo $row['Reading']; ?></p>
                                        </div>
                                                       
                                    </div>
                              
                                <?php } ?>
                            </div>
                                </div>  
                                <div class="col-md-4">
                                    <label class="control-label"><b>Location</b></label>
                                    <div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo $query[0]['l_name'];?></p>
                                    </div>
                                </div>

                        </div>
                    </div>
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript">
 
var table;
 
$(document).ready(function() {
 	
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "scrollX": true,
 		
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Inwardreport/ajax_list?extra=')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
});</script>  