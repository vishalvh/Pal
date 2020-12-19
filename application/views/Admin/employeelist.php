
<style type="text/css">
    .cus-btn{
        padding: 0;
    }
    .cus-btn .btn{
        padding: 6px 8px;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
                Employee List
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Employee list</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <form method="post" action="">
                            <br>
                            <div class="cal-md-12">
                                
                                <!-- Select Company -->
                                <div class="col-md-2">

                                    <select name="company" id="company" class="form-control company">
                                        <option value="0">Select Company</option>
                                        <?php

                                    $cnt = 1;
                                    foreach ($company as $raw) 
                                    {
                                      ?>

                                        <option value="<?php echo $raw['id']; ?>"><?php echo $raw['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!-- Select Location -->
                                <div class="col-md-2">

                                    <select name="location" id="location" class="form-control location">
                                        <option value="0">Select Location</option>
                                        <?php

                $cnt = 1;
                foreach ($location as $raw) 
                {
                  ?>

                                        <option
                                            value="<?php echo $raw['l_id']; ?>"
                                            ><?php echo $raw['l_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!-- Select Employee Name -->
                                
                                <div class="col-md-2 cus-btn" >
                                    <input type="button" onClick="search();" class="btn  btn-success"  value="Search">
                                     <input type="reset" value="Reset" class="btn  btn-danger">
                                    
                                </div>
                               
                            </div>
                        </form>

                        
                            
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
                        <div class="tableclass">
                   <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <!--<th>SrNo</th>-->
                                        <th>Company Name</th>
                                        <th>Location Name</th>
                                        <th>Employee Name</th>
                                        <th>Employee Email</th>
                                        <th>Mobile Number</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody> </tbody>
                            </table>
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

function search(query) {
       
        $company = $('#company').val();
        $location = $('#location').val();
        var $location = $('.location').val();
        // var $tdate = new Date(toDate).toDateString("yyyy-MM-dd");    var $tdate = new
        // Date(toDate).toDateString("yyyy-mm-dd");
        $("#table")
            .dataTable()
            .fnDestroy();
        //    alert(query);
        $('#table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "scrollX": true,
            "bFilter": false,
            "bInfo": false,

            "ajax": {
                "url": "<?php echo site_url('Employee/ajax_list?company=')?>" +
                        $company + "&location=" + $location,
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [
                        0, 3, 5
                    ],
                    "orderable": false
                }
            ]
        });
    }
 
$(document).ready(function() {
 	
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "bFilter": false,
        "bInfo": false,
 		
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Employee/ajax_list?extra=')?>",
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
 
});


$(document).ready(function () {
        $("#company").on('change', function () {
            var cid = $('#company').val();

            $.ajax({
                type: "POST",
                data: {
                    'cid': cid
                },
                url: "<?php echo base_url() ; ?>Inwardreport/location",
                success: function (response) {
                    var obj = JSON.parse(response);

                    $("#location").empty();
                    $("#location").append($(
                        '<option value=' + 0 + '>Select Location</option>'
                    ));
                    for (var i = 0; i < obj.length; i++) {
                        $("#location").append($(
                            '<option value=' + obj[i].l_id + '>' + obj[i].l_name + '</option>'
                        ));

                    }
                }
            });

        });
    });
</script>