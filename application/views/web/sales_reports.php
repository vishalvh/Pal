<?php $this->load->view('web/left'); ?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
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

    .over-scroll,
    .bdr {
        display: inline-block;
        width: 100%;
        overflow-x: scroll;
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
            maxDate: new Date(),
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
            maxDate: new Date(),
        });
    });
</script>
<style>
    .dataTables_filter {
        display: none;
    }
</style>
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <div class="page-header">
            <h3 class="blank1 pull-left" style="">Sales Report</h3>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="get" action="<?php echo base_url(); ?>sales_reports/index" name="savingdata" onsubmit="return validate()">

                    <div class="form-group col-sm-12">
                        <hr>
                        <div class="col-md-2">
                            <input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php echo date("d-m-Y", strtotime($sdate)); ?>" />
                            <span class="error" id="sdateerror"></span>
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="<?php echo date("d-m-Y", strtotime($edate)); ?>" />
                            <span class="error" id="edateerror"></span>
                        </div>
                        <div class="col-sm-2">
                            <select name="location" id="location" class="form-control1">
                                <option value="">Select Location</option>
                                <?php
                                foreach ($location_list->result() as $row) {
                                    ?>
                                    <option value="<?php echo $row->l_id; ?>" <?php if ($location == $row->l_id) {
                                    echo "selected";
                                } ?>><?php echo $row->l_name ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback" id="locationerror" style="color: red;"></div>
                        </div>
                        <div class="col-sm-2">
                            <input type="submit" name="search"  class="btn-success btn" value="Search" name="search">
							<?php if(in_array("sales_report_print",$this->data['user_permission_list'])){ ?>
                            <a href="<?php base_url(); ?>print_report?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&location_id=<?php echo $location; ?>" target="_blank" class="btn-success btn" <?php if ($this->input->get('location') == "") {
                                    echo "Disabled";
                                } ?>>Print</a>
							<?php } ?>
                        </div>
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2">
                        </div>
                        <hr>
                    </div>
                </form>
            </div>
        </div>


        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="title-h1">
                    <h3>Report</h3>
                </div>
                <div class="over-scroll bdr">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Selling In Liter</th>
                                <th>Diesel Selling</th>
                                <th>Selling In Liter</th>
                                <th>Petrol Selling</th>
                                <th>Oil In Liter</th>
                                <th>Oil Selling</th>
                                <th>Total Selling</th>
                                <th>Sales on Cash</th>
                                <th>Sales on Card</th>
                                <th>Sales on Rewards card</th>
                                <th>Sales on Wallet</th>
                                <th>Sales on <!--Debit-->Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $dtotaldsellingprice = 0;

                            $ptotaldsellingprice = 0;
                            $oil_reading = 0;
                            $oilqty = 0;
                            $totalselling = 0;
                            $totalcash = 0;
                            $totalcard = 0;
                            $totalioc = 0;
                            $totalcredit = 0;
                            $totalextracash_fule = 0;
                            foreach ($report as $r) {
                                ?>
                                <tr>
                                    <td>
    <?php echo date('d/m/Y', strtotime($r['date'])); ?>
                                    </td>
                                    <td>
                                        <?php echo amountfun($r['d_total_selling']);
                                        $dtotaldselling = $dtotaldselling + $r['d_total_selling']; ?>
                                    </td>
                                    <td>
    <?php echo amountfun($r['d_total_selling'] * $r['dis_price']); //echo "(".$r['dis_price'].")"; 
    $dtotaldsellingprice = $dtotaldsellingprice + round($r['d_total_selling'] * $r['dis_price'], 2);
    ?>
                                    </td>
                                    <td>
                                        <?php echo amountfun($r['p_total_selling']);
                                        $ptotaldselling = $ptotaldselling + $r['p_total_selling']; ?>
                                    </td>
                                    <td>
                                        <?php echo amountfun($r['p_total_selling'] * $r['pet_price']); //echo "(".$r['pet_price'].")"; 
                                        $ptotaldsellingprice = $ptotaldsellingprice + round($r['p_total_selling'] * $r['pet_price'], 2);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $cnt = 0;
                                        foreach ($final_oil_report[$r['date']] as $final_oil_reportdate) {
                                            $pval = 0;
                                            if ($final_oil_reportdate->p_type == 'ml') {
                                                $pval = ($final_oil_reportdate->p_qty * $final_oil_reportdate->Reading) / 1000;
                                            }
                                            if ($final_oil_reportdate->p_type == 'ltr') {
                                                $pval = ($final_oil_reportdate->p_qty * $final_oil_reportdate->Reading);
                                            }
//	echo $pval."<br>";
                                            $cnt = $cnt + $pval;
                                            // if($cnt == 0){
                                            // echo $final_oil_reportdate->packet_type." => ".$final_oil_reportdate->Reading;
                                            // }else{
                                            // echo "<br>".$final_oil_reportdate->packet_type." => ".$final_oil_reportdate->Reading;	
                                            // }
                                            // $cnt++;
                                        }
										
										echo amountfun($cnt);
                                        $oilqty = $oilqty + $cnt;
                                        //echo "<pre>"; print_r($final_oil_report[$r['date']]); echo "</pre>"; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo amountfun($r['oil_reading']);
                                        $oil_reading = $oil_reading + $r['oil_reading']; ?>
                                    </td>
                                    <td>
    <?php $tselling = round($r['d_total_selling'] * $r['dis_price'], 2) + round($r['p_total_selling'] * $r['pet_price'], 2) + round($r['oil_reading'], 2);
	
	echo amountfun($tselling);
    $totalselling = $totalselling + $tselling;
    ?>
                                    </td>
                                    <td>
                                        <?php echo amountfun($r['cash_on_hand']); 
                                        $totalcash = $totalcash + round($r['cash_on_hand'], 2); ?>
                                    </td>
                                    <td>
   <span style="color: #27cce4;font-weight: bold;" onClick="open_sales_data_model('<?php echo $r['id'] ?>');"><?php echo amountfun($r['totalcard_fule']); ?></span> 
   <input type="hidden" id="sales_on_card_data_<?php echo $r['id'] ?>" value="<?php print_r($r['sales_on_card_data']); ?>" >
        <?php
    $totalcard = $totalcard + round($r['totalcard_fule'], 2); ?>
                                    </td>
                                    <td>
                                <?php echo amountfun($r['totalioc_fule']);
                                $totalioc = $totalioc + round($r['totalioc_fule'], 2); ?>
                                    </td>
                                    <td>
                                <?php echo amountfun($r['totalextracash_fule']);
                                $totalextracash_fule = $totalextracash_fule + round($r['totalextracash_fule'], 2); ?>
                                    </td>
                                    <td>
    <?php echo amountfun($r['totalcredit_fule']);
    $totalcredit = $totalcredit + round($r['totalcredit_fule'], 2); ?>
                                    </td>

                                </tr>
                                        <?php
                                        $p_dstock = $r['dstock'];
                                        $p_d_total_selling = $r['d_total_selling'];
                                        $p_d_quantity = $r['d_quantity'];
                                        $p_pstock = $r['pstock'];
                                        $p_p_total_selling = $r['p_total_selling'];
                                        $p_p_quantity = $r['p_quantity'];
                                        $cnt++;
                                    }
                                    ?>
                            <tr>
                                <td>Total</td>
                                <td>
                                    <?php echo amountfun($dtotaldselling); ?>
                                </td>
                                <td>
                                    <?php echo amountfun($dtotaldsellingprice); ?>
                                </td>
                                <td>
                                    <?php echo amountfun($ptotaldselling); ?>
                                </td>
                                <td>
                                    <?php echo amountfun($ptotaldsellingprice); ?>
                                </td>
                                <td>
                                    <?php echo amountfun($oilqty); ?>
                                </td>
                                <td>
                                    <?php echo amountfun($oil_reading); ?>
                                </td>
                                <td>
                                    <?php echo amountfun($totalselling); ?>
                                </td>

                                <td>
<?php echo amountfun($totalcash); ?>
                                </td>
                                <td>
<?php echo amountfun($totalcard); ?>
                                </td>
                                <td>
<?php echo amountfun($totalioc); ?>
                                </td>
                                <td>
<?php echo amountfun($totalextracash_fule); ?>
                                </td>
                                <td>
<?php echo amountfun($totalcredit); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
<div id="sales_on_card_data" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
            <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">*</button>
        <h3 id="myModalLabel">Sales on Card Data</h3>
    </div>
    <div class="modal-body">
        
            <table class="table" >

            <thead>
            <td>Date</td>
            <td>Amount</td>
            <td>remark</td>
            </thead>
            <tbody id="sales_on_card_data_add">
                
            </tbody>
        </table> 
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      
    </div>
</div></div></div>
          
</html>

<script>
    function open_sales_data_model($id){
//        alert($id);
 $("#sales_on_card_data_add").html("");
        var sales_on_card_data = $("#sales_on_card_data_"+$id).val();
       $("#sales_on_card_data_add").append(sales_on_card_data);
        $("#sales_on_card_data").modal("show");
       
//        console.log(sales_on_card_data);
    }
</script>
<script>
                            function validate() {
                                $(".error").html("");
                                var $fdate = $('#start_date').val();
                                var $tdate = $('#end_date').val(); 
                                var $location = $('#location').val();
                                var temp = 0;
                                if ($fdate == "") {
                                    temp++;
                                    $("#sdateerror").html('Required!');
                                }
                                if ($tdate == "") {
                                    temp++;
                                    $("#edateerror").html('Required!');
                                }
                                if ($location == "") {
                                    temp++;
                                    $("#locationerror").html('Required!');
                                }
                                if (temp != 0) {
                                    return false
                                }

                            }
</script>