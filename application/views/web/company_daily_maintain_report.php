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
				<h3 class="blank1 pull-left" style="">Company Maintain</h3>
			</div>
            <form method="get" action="<?php echo base_url();?>company_daily_maintain_report" id="pdffrom">			
				<div class="cal-md-12">
					<div class="col-md-2">
						<input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="<?php echo $this->input->get('sdate'); ?>" />
						<span class="error" id="sdateerror"></span>
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
					<input type="submit"  class="btn btn-primary"  value="Preview">
					<a href="<?php base_url();?>company_daily_maintain_report/print_pdf?location_id=<?php echo $location?>&date=<?php echo $sdate; ?>"  class="btn btn-primary" target="_blank">Print</a>
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
									<th>Title</th>
									<th>Result</th>
									<th>Remark</th>
								</tr>
							</thead>
							<tbody>
							<?
							$cnt=0;
							foreach($reports as $detail){ ?>
								<tr>
									<td><?php echo ++$cnt; ?></td>
									<td><?php echo $detail->name; ?></td>
									<td><?php echo $detail->report; ?></td>
									<td><?php echo $detail->remark; ?></td>
								</tr>
							<?php }
							?>
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
	   yearRange: "2018:n",
	  maxDate:new Date(),
   });
});
</script>
</body>

</html>