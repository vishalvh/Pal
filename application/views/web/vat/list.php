<!-- left side start-->
<?php $this->load->view('web/left'); ?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
        <!--<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>-->
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<script type='text/javascript'>
    $(document).ready(function () {
        var d = new Date();
        var n = d.getFullYear();

        $("#datepicker1").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "2017:n",
            dateFormat: "yy-mm-dd",
            defaultDate: 'today',
            maxDate: 'today',
            onSelect: function () {
                var end_date = $('#datepicker2');
                var minDate = $(this).datepicker('getDate');
                end_date.datepicker('option', 'minDate', minDate);
            }
        });
        $("#datepicker2").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "2017:n",
            dateFormat: "yy-mm-dd",
            defaultDate: 'today',
            maxDate: 'today'
        });


    });
    $(document).ready(function () {
        $("#start_date").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "2017:n",
             maxDate: 'today',
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
			yearRange: "2017:n",
            maxDate: new Date()
        });
    });

</script> 
<!-- left side end-->

<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">

        <div class="page-header">
            <h3 class="blank1 pull-left" style="">Vat List</h3>
            <?php if ($logged_company['type'] == 'c') { ?>			
                <!--<a href="<?php echo base_url(); ?>admin_location/add" class="btn btn-primary pull-right" style=""><i class="fa fa-plus"></i> Add</a>-->
            <?php } ?>

        </div>

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
                <div class="cal-md-12">
                    <div class="col-md-2">

                        <input type="text" id="start_date"  readonly class="form-control start_date" name="date1" placeholder="Start Date" value="<?php if (isset($date1) != NULL) {
                    echo $date1;
                } ?>" />
                        <span class="error" id="start_date_error"></span>
                    </div>
                    <div class="col-md-2">

                        <input type="text" id="end_date"  readonly class="form-control end_date" name="date2" placeholder="End Date" value="<?php if (isset($date2) != NULL) {
                    echo $date2;
                } ?>" />
                        <span class="error" id="end_date_error"></span>
                    </div>
                    <input type="button" onClick="search();" class="btn btn-primary"  value="search">

                    <br>
                    <br></div>


                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Vat %</th>
<?php if ($logged_company['type'] == 'c') { ?>  <th>Action</th> <?php } ?>
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

                                                             var table;

                                                             $(document).ready(function () {

                                                                 //datatables
                                                                 table = $('#table').DataTable({
                                                                     "processing": true, //Feature control the processing indicator.
                                                                     "serverSide": true, //Feature control DataTables' server-side processing mode.
                                                                     "order": [], //Initial no order.

                                                                     // Load data for the table's content from an Ajax source
                                                                     "ajax": {
                                                                         "url": "<?php echo site_url('vat/ajax_list?extra=') ?>",
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

                                                             });
                                                             var query = "";
                                                             function search(query) {
                                                                
                                                                 var sdate = $("#start_date").val();
                                                                 var edate = $("#end_date").val();
                                                                 $("#table").dataTable().fnDestroy();
                                                                 $('#table').DataTable({
                                                                     "processing": true,
                                                                     "serverSide": true,
                                                                     "bInfo": false,
                                                                     "order": [],
                                                                     "ajax": {
                                                                         "url": "<?php echo site_url('vat/ajax_list?sdate=') ?>"+ sdate+"&edate="+edate ,
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