
<!-- left side start-->
<?php $this->load->view('web/left'); ?>

<!-- left side end-->
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/css/jquery.mCustomScrollbar.min.css" type='text/css' />
<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <div class="graphs">
            <h3 class="blank1">view salary</h3>
            <form action="<?php echo base_url(); ?>company_worker/view_salary" id="savingdata" method="get" >			
                <br>
                <div class="cal-md-12">

                    <!-- Select Location -->
                    <div class="col-md-2">

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
                        <span class="error" id="locatione_error"></span>
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="start_date"  readonly class="form-control start_date" name="date" placeholder="Start Date" value="<?php if (isset($date) != NULL) {
                                echo     date("d-m-Y", strtotime($date));
                            } ?>" />
                        <span class="error" id="sdateerror"></span>
                    </div>
                    <input type="button"  class="btn btn-primary"  value="search" onclick="search();">

                    <br>
                    <br></div>
            </form>
            <div id="page-wrapper">
                <div class="graphs">

                    <div class="tab-content">
                        <div class="tab-pane active" id="horizontal-form">
                            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>company_worker/update_salary/<?php echo $l_id; ?>/<?php echo $date; ?>" name="savingdata" onsubmit="return validate()">
                                <table class="table">
                                    <thead>
                                    <td>Name</td>
                                    <td>Salary</td>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($salarylist as $oil_data){ ?>
										<?php if($_GET['debug'] != '1'){ ?>
                                        <tr>
                                            <td><?php echo $oil_data->name; ?></td>
                                            
                                            <td>
											<input type="text" value="<?php echo $oil_data->workermonthlysalary; ?>" class="form-control" name="worker_salary[<?php echo $oil_data->id;?>]">
											</td>
                                            
                                        </tr>
										<?php }else{ ?>
										<tr>
                                            <td><?php echo $oil_data->packet_type ?></td>
											<td><?php echo $oil_data->new_p_qty; ?></td>
                                            <td>
											<?php echo $oil_data->stock; ?>
											</td>
                                            <td><?php echo $oil_data->bay_price; ?></td>
                                            <td><?php echo $oil_data->sel_price ?></td>
                                            
                                        </tr>
                                    
										<?php } ?>
<?php } ?>
                                    </tbody>
                                     <?php if(empty($salarylist)){ ?>
                                     <tr>
                                         <td style="text-align: center;" colspan="4" >No data Found </td>
                                            
                                        </tr>
                                     <?php } ?>
                                    </table>
                                <?php if(!empty($salarylist)){ ?>
                                <div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">update</button>
									</div>
								</div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
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

<script>
                                $("#start_date").datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                    yearRange: "1918:n",
                                    dateFormat: "dd-mm-yy",
                                    defaultDate: 'today',
                                    maxDate:'today',
									minDate: new Date(2018, 01, 01),
                                    onSelect: function () {
                                        var end_date = $('#datepicker2');
                                        var minDate = $(this).datepicker('getDate');
                                        end_date.datepicker('option', 'minDate', minDate);
                                    }
                                });
                                function search() {
                                    var sdate = $("#start_date").val();
                                    var lid = $("#location").val();
                                    var temp = 0;
                                    $(".error").html('');
                                    if (sdate == "") {
                                        temp++;
                                        $("#sdateerror").html('Required!');
                                    }
                                    if (lid == "") {
                                        temp++;
                                        $("#locatione_error").html('Required!');
                                    }
                                    if (temp == 0) {
										$("#savingdata").submit();
                                    }
                                }
</script>