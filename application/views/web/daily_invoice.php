<?php $this->load->view('web/left');?>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets1/css/jquery.mCustomScrollbar.min.css" type='text/css' />
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
        <!-- main content start-->
        <div class="main-content">
            <!-- header-starts -->
            <?php $this->load->view('web/header');?>
            <!-- //header-ends -->
            <div id="page-wrapper">
                <div class="page-header">
                    <h3 class="blank1 pull-left" style="">Daily Invoice</h3>
                </div>
                
<form method="get" action="<?php echo base_url();?>daily_invoice/print_invoice_pdf" id="pdffrom" target="_blank">			
	<div class="cal-md-12">
		<div class="col-md-2">
			<input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php if(isset($date1) != NULL){ echo $date1; } ?>" />
			<span class="error" id="sdateerror"></span>
		</div>
		<div class="col-md-2">
			<select name="lid" id="location" class="form-control location" onchange="getcust(this.value);" >
				<option value="">Select Location</option> 
				<?php foreach ($location_list->result() as $row) { ?>
					<option value="<?php echo $row->l_id; ?>" <?php if($location == $row->l_id){ echo "selected"; }?>><?php echo $row->l_name?></option>
				<?php } ?>
			</select>
			<span class="error" id="locationerror"></span>
		</div>
		<input type="button" onClick="search();" class="btn btn-primary"  value="Preview">
		<?php if(in_array("daily_invoice_report_print",$this->data['user_permission_list'])){ ?>
		<input type="button" onClick="printdata();" class="btn btn-primary"  value="Print">
		<?php } ?>
	<br>
	<br>
	</div>
</form>
                <div class="xs tabls">
                    <div class="bs-example4" data-example-id="contextual-table">
                        <div class="title-h1">
                            <h3>Report</h3>
                        </div>
                        <div class="over-scroll bdr">
                            <table class="table">
                                <thead>
                                    <tr>
										<th>Sr no.</th>
                                        <th>Date</th>
										<th>Name</th>
										<th>Ltr</th>
                                        <th>Today Paid</th>
                                        <th>Today Due</th>
										<th>Past Due</th>
                                        <th>Total Due</th>
                                    </tr>
                                </thead>
                                <tbody id="newdata">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- switches -->
            </div>
        </div>
        </div>
        <?php $this->load->view('web/footer');?>
    </section>
    <script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
    <script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets1/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
	$( "#start_date" ).datepicker({
          changeMonth: true,
          changeYear: true,
          yearRange: "2017:n",
          dateFormat: "dd-mm-yy",
             defaultDate: 'today',
             maxDate:new Date(),
			     onSelect: function () {
               var end_date = $('#datepicker2');
               var minDate = $(this).datepicker('getDate');
               end_date.datepicker('option', 'minDate', minDate);
           }
        });
        (function($) {
            $(window).on("load", function() {
                $(".bdr").mCustomScrollbar({
                    axis: "x",
                    advanced: {
                        autoExpandHorizontalScroll: true
                    }
                });              
            });
        })(jQuery);
	function search(){
		var sdate = $("#start_date").val();
		var lid = $("#location").val();
		var temp = 0;
		$(".error").html('');
		if(sdate == ""){
			temp++;
			$("#sdateerror").html('Required!');
		}
		if(lid == ""){
			temp++;
			$("#locationerror").html('Required!');
		}
		if(temp==0){
			 $("#arrowLoader").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>daily_invoice/invocelist",
				data: {'lid': lid,'sdate':sdate}, // serializes the form's elements.
				success: function (data)
				{
					$("#newdata").html(data);
					 $("#arrowLoader").hide();
				}
			});
		}
	}
	function printdata(){
		var sdate = $("#start_date").val();
		var lid = $("#location").val();
		var temp = 0;
		$(".error").html('');
		if(sdate == ""){
			temp++;
			$("#sdateerror").html('Required!');
		}
		if(lid == ""){
			temp++;
			$("#locationerror").html('Required!');
		}
		if(temp==0){
			$("#pdffrom").submit();
		}
	}
	</script>
</body>

</html>