<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
                Credit Debit Info
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Credit Debit info</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        
                            <a style="float:right;" href="<?php echo base_url(); ?>Company/company_add" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i><strong> Add</strong></a>
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
                          <?php
              $name = $cd[0]->UserFName;
            ?>
             <div class="xs tabls">
              <div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
                <div class="col-sm-4">
                  <label class="control-label"><b>Date</b></label>
                  <div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo date('d-m-Y', strtotime($cd[0]->date));?></p>
                                    </div>
                </div>
                <div class="col-sm-4">
                  <label class="control-label"><b>Name</b></label>
                  <div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo ucfirst($name);?></p>
                                    </div>
                </div>  
                <div class="col-sm-4">
                  <label class="control-label"><b>Location</b></label>
                  <div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo $cd[0]->l_name;?></p>
                                    </div>
                </div>    
                <div class="col-md-12" style="margin-top: 15px;">
                                    <label class="control-label"><b>Customer Name</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->name;?></p>
                                    </div>
                                    <?php
                                        if ($cd[0]->payment_type == 'c') 
                                        {
                                            $payment_type = "Credit";
                                        }
                                        if ($cd[0]->payment_type == 'd') 
                                        {
                                            $payment_type = "Debit";
                                        }
                                    ?>
                                    <label class="control-label"><b>Payment Type</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $payment_type;?></p>
                                    </div>
                                    
                                    <label class="control-label"><b>Bill Number</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->bill_no;?></p>
                                    </div>
                                    
                                   <label class="control-label"><b>Vehicle Number</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->vehicle_no;?></p>
                                    </div>
                                    <?php
                                        if ($cd[0]->fuel_type == 'p') 
                                        {
                                            $fuel_type = "Petrol";
                                        }
                                        if ($cd[0]->fuel_type == 'd') 
                                        {
                                            $fuel_type = "Disel";
                                        }
                                        if ($cd[0]->fuel_type == 'o') 
                                        {
                                            $fuel_type = "Oil";
                                        }
                                    ?>
                                    <label class="control-label"><b>Fuel Type</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $fuel_type;?></p>
                                    </div>

                                    <label class="control-label"><b>Amount</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->amount;?></p>
                                    </div>

                                    <label class="control-label"><b>Quantity</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $cd[0]->quantity;?></p>
                                    </div>

                                </div>
                

                
               </div>
            </div>

                        
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
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