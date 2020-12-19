<?php $this->load->view('web/left'); ?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/css/jquery.mCustomScrollbar.min.css" type='text/css' />
<style>
    .title-h1 {
        display: inline-block;
        width: 100%;
    }

    .title-h1 h3 {
        margin: 0;
        padding: 15px 0;
        color: #27cce4;
        padding-top: 0;
    }


    .bdr .table tr>th,
    .bdr td,
    .bdr th {
        border: 1px solid #eee !important;
    }
</style>

<script type='text/javascript'>
    $(document).ready(function () {
        $("#start_date").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "2017:n",
            maxDate:new Date(),
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
            maxDate:new Date(),
        });
    });
</script>
<style>
    .dataTables_filter {
        display: none;
    }
</style>
<div class="main-content">
    <?php $this->load->view('web/header'); ?>
    <div id="page-wrapper">
        <form method="post" action="<?php echo base_url(); ?>admin/add">			
            <h3 class="blank1" style="margin-top: -20px;">Oil stock Report</h3>
        </form>
        <h3 class="blank1"></h3>
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

        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="get" action="" name="savingdata" >

                    <div class="form-group col-sm-12">
                        <hr>
                       
                        <div class="col-sm-2">
                           <select name="lid" id="location" class="form-control1">
                            <option value="">Select Location</option>
                            <?php
                            foreach ($r->result() as $row) {
                                ?>
                                <option value="<?php echo $row->l_id ?>" <?php if($row->l_id == $l_id) { echo "selected"; }  ?> ><?php echo $row->l_name; ?></option>
                                <?php
                            }
                            ?>

                        </select>
                            <div class="invalid-feedback" id="locationerror" style="color: red;"></div>
                        </div>
                        <div class="col-md-2">
                        <input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php if (isset($sdate) != NULL) {
                                echo     date("d-m-Y", strtotime($sdate));
                            } ?>" />
                        <span class="error" id="sdateerror"></span>
                    </div>
					<div class="col-md-2">
                        <input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="<?php if (isset($edate) != NULL) {
                                echo     date("d-m-Y", strtotime($edate));
                            } ?>" />
                        <span class="error" id="sdateerror"></span>
                    </div>
                        <div class="col-sm-2">
						<input type="submit"  class="btn btn-primary"  value="search">
						<?php if(in_array("oil_stock_report_print",$this->data['user_permission_list'])){ ?>
						<a <?php if($l_id == "") { echo "disabled"; } ?> href="<?php echo base_url();?>oil_packet/pdf_check_oil_stock?lid=<?php echo $l_id;?>&sdate=<?php echo $sdate;?>&edate=<?php echo $edate;?>"class="btn btn-primary" target="_blank"> Print</a>
                        <?php } ?>
						</div>
                        <hr>
                    </div>
                </form>
            </div>
        </div>


        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="title-h1">
                    <h3>Oil Stock Report</h3>
                </div>
                <div class="over-scroll js-scroll bdr">
                    <table class="table">
							<thead>
							<td>Name</td>
							<td>Stock</td>
							<?php for($i=$sdate; strtotime($edate) >= strtotime($i);$i = date('Y-m-d', strtotime($i . ' +1 day'))){ ?>
							<td nowrap style="color:red;"><?php echo date('d',strtotime($i)); ?></td>
							<?php } ?>
							<td>Stock</td>
							</thead>
							<tbody>
								<?php
$olisellingtotalday =array();
$startstock = 0;
								foreach ($startoilstock as $oil_data){ ?>
								
								<tr>
									<td nowrap><?php if($_GET['debug'] == '1'){ echo $oil_data->id."=>"; } echo $oil_data->packet_type ?></td>
									<td><?php echo $ssoil[$oil_data->id]; $startstock = $startstock+$ssoil[$oil_data->id]; ?></td>
									<?php for($i=$sdate; strtotime($edate) >= strtotime($i);$i = date('Y-m-d', strtotime($i . ' +1 day'))){ ?>
									<td data-toggle="tooltip" title=" <?php echo $oil_data->packet_type ?> <?=date('d/m/Y', strtotime($i))?>" >
									<?php 
										if(isset($oilsellingparday[$i][$oil_data->id])) { 
										echo $oilsellingparday[$i][$oil_data->id];
										$olisellingtotalday[$i] = $olisellingtotalday[$i] + $oilsellingparday[$i][$oil_data->id];
										}else{ echo '0'; } 
									?></td>
									<?php } ?>
									<td >
									<?php foreach($endoilstock as $estok){
										if($estok->id == $oil_data->id){
											$endstock = $endstock + $estok->stock;
											echo $estok->stock;
										}
									}?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
							 <thead>
							<td>Total</td>
							<td><?php echo $startstock; ?></td>
							<?php for($i=$sdate; strtotime($edate) >= strtotime($i);$i = date('Y-m-d', strtotime($i . ' +1 day'))){ ?>
							<td nowrap><?php if(isset($olisellingtotalday[$i])) { echo $olisellingtotalday[$i]; }else{ echo '0'; }?></td>
							<?php } ?>
							<td><?php echo $endstock; ?></td>
							</thead>
							</table>

                </div>
                <hr>
                                         
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
<script src="<?php echo base_url(); ?>assets1/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
                                    (function ($) {
                                        $(window).on("load", function () {
                                            $(".bdr").mCustomScrollbar({
                                                axis: "x",
                                                advanced: {
                                                    autoExpandHorizontalScroll: true
                                                }
                                            });
                                        });
                                    })(jQuery);

                                    function Submitdata()
                                    {
                                        var url = '<?php echo base_url(); ?>daily_reports_new/print_pdf?sdate=<?php echo date("d-m-Y", strtotime($sdate)); ?>&edate=<?php echo date("d-m-Y", strtotime($edate)); ?>&location=<?php echo $location; ?>';
                                        //document.forms['savingdata'].submit();
										window.open(url, '_blank');

                                    }
                                    function SubmitForm()
                                    {

                                        document.forms['savingdata'].action = '<?php echo base_url(); ?>daily_reports_new_jun/index';
                                        document.forms['savingdata'].submit();

                                    }
                                    var target = 'http://stackoverflow.com';
                                    $.ajax({
                                        url: "https://api.linkpreview.net",
                                        dataType: 'jsonp',
                                        data: {q: target, key: '5b7a690849f50a7e969da8871cf7bfd1ba51828b82361'},
                                        success: function (response) {
                                            console.log(response);
                                        }
                                    });
</script>

</body>

</html>