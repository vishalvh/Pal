<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
                Bankdeposit Info
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Bankdeposit info</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                       
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
              $name = $bd[0]->UserFName;
            ?>
             <div class="xs tabls">
              <div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
                <div class="col-sm-4">
                  <label class="control-label"><b>Date</b></label>
                  <div class="">
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo date('d-m-Y', strtotime($bd[0]->date));?></p>
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
                                        <p class="form-control-static" style="margin-left: 55px;margin-top: -32px;"><?php echo $bd[0]->l_name;?></p>
                                    </div>
                </div>    
                <div class="col-md-12" style="margin-top: 15px;">
                                    <label class="control-label"><b>Deposit Amount</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $bd[0]->deposit_amount;?></p>
                                    </div>
                                    
                                    <label class="control-label"><b>Withdraw Amount</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $bd[0]->withdraw_amount;?></p>
                                    </div>
                                    <?php
                                        if ($bd[0]->deposited_by == 'n') 
                                        {
                                            $deposited_by = "cash";
                                        }
                                        if ($bd[0]->deposited_by == 'c') 
                                        {
                                            $deposited_by = "Cheque";
                                        }
                                    ?>
                                    <label class="control-label"><b>Deposited By</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $deposited_by;?></p>
                                    </div>
                                    
                                   <label class="control-label"><b>Cheque Number</b></label>
                                    <div class="">
                                        <p class="form-control-static"><?php echo $bd[0]->cheque_no;?></p>
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