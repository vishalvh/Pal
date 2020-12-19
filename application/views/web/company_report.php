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
				<h3 class="blank1 pull-left" style="">Company Report</h3>
			</div>
            <form method="get" action="<?php echo base_url();?>company_report/print_report_pdf" id="pdffrom" target="_blank">			
				<div class="cal-md-12">
					<div class="col-md-2">
					<input type="hidden" name="location" value="<?php echo $this->input->get('location'); ?>">
						<input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php echo $this->input->get('sdate'); ?>" />
						<span class="error" id="sdateerror"></span>
					</div>
					<div class="col-md-2">
						<input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="<?php echo $this->input->get('edate'); ?>" />
						<span class="error" id="edateerror"></span>
					</div>
					<input type="button" onClick="search();" class="btn btn-primary"  value="Preview">
					<?php if(in_array("company_report_print",$this->data['user_permission_list'])){ ?>
					<input type="button" onClick="printdata();" class="btn btn-primary"  value="Print">
					<?php } ?>
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
									<th>Deposit By Card</th>
									<th>Transfer Online</th>
									<th>Purchase Amount</th>
									<th>Credit Amount</th>
									<th>Debit Amount</th>
									<th>Customer Credit</th>
									<?php if(in_array("company_report_action",$this->data['user_permission_list'])){ ?>
									<th>Action</th>
									<?php } ?>
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
	var edate = $("#end_date").val();
	var lid = '<?php echo $this->input->get("location");?>';
	var temp = 0;
	$(".error").html('');
	if(sdate == ""){
		temp++;
		$("#sdateerror").html('Required!');
	}
	if(edate == ""){
		temp++;
		$("#edateerror").html('Required!');
	}
	if(temp==0){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>company_report/company_report_list",
			data: {'lid': lid,'sdate':sdate,'edate':edate}, // serializes the form's elements.
			success: function (data)
			{
				$("#newdata").html(data);
			}
		});
	}
}
function printdata(){
	var sdate = $("#start_date").val();
	var edate = $("#end_date").val();
	var lid = '<?php echo $this->input->get("location");?>';
	var temp = 0;
	$(".error").html('');
	if(sdate == ""){
		temp++;
		$("#sdateerror").html('Required!');
	}
	if(edate == ""){
		temp++;
		$("#edateerror").html('Required!');
	}
	if(temp==0){
		$("#pdffrom").submit();
	}
}
<?php if($this->input->get('sdate') !="" ){ ?>
search();
<?php } ?>
</script>
</body>

</html>