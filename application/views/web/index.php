<style>
/*    div#curve_chart svg>defs+g>rect+text+rect+text,div#curve_chart svg>defs+g>rect+text+rect {
    display: none;
}
div#columnchart_material svg>defs+g>rect+text+rect+text,div#columnchart_material svg>defs+g>rect+text+rect {
    display: none;
}*/
</style>
    <!-- left side start-->
	
		<?php $this->load->view('web/left');?>
		<!-- left side end-->
    
		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<?php  $this->load->view('web/header');?>
                        
                        
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			
			<script type="text/javascript">
          
google.charts.load('current', {'packages':['corechart']});
//Chart.defaults.global.legend.display = false;
//  Chart.defaults.global.tooltips.enabled = false;
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([
		['<?php echo ' ';  ?>', 'Previous selling ', 'Current selling'],
		<?php foreach ($final_chart as $chart){ ?>
			['<?php echo $chart["month"]; ?>',<?php echo $chart["pre_p_selling"]; ?>,<?php echo $chart["p_selling"]; ?>],
		<?php } ?>
	]);
        interactivityEnabled: false
	var options = {
		chart: {
			title: 'MS(Petrol)',
//			subtitle: 'Sales, Expenses, and Profit: ',
		},
		bars: 'vertical',
		vAxis: {format: 'decimal'},
              legend: {position: 'none'}


	};
        
//	var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
//	chart.draw(data, options);
        var chart = new google.charts.Bar(document.getElementById('curve_chart'));
	chart.draw(data, google.charts.Bar.convertOptions(options));
}
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawAnthonyChart);
function drawAnthonyChart() {
	var data = google.visualization.arrayToDataTable([
		['<?php echo ' ';  ?>', 'Previous selling ', 'Current selling'],
		<?php foreach ($final_chart as $chart){ ?>
			['<?php echo $chart["month"]; ?>',<?php echo $chart["pre_d_selling"]; ?>,<?php echo $chart["d_selling"]; ?>],
		<?php } ?>
	]);
	var options = {
		chart: {
			title: 'HSD(Diesel)',
//			subtitle: 'Sales, Expenses, and Profit:',
		},
		bars: 'vertical',
		vAxis: {format: 'decimal'},
                legend: {position: 'none'}
        
	};
	var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
	chart.draw(data, google.charts.Bar.convertOptions(options));
}
	  </script>
		<!-- //header-ends -->
		<div id="page-wrapper">
			<h3 class="blank1"></h3>
			<div class="xs tabls">
				
					<div class="col-md-12">
                                            <div class="col-md-12">
                                            <div class="col-md-2">
							
							<select name="location" id="location" class="form-control location" onchange="get_report(this.value);">
							<option value="">Select Location </option> 
							<?php $cnt = 1; foreach ($location as $raw)  { ?>
  									<option  value="<?php echo $raw->l_id; ?>" <?php if($lid == $raw->l_id){ echo "selected"; } ?>><?php echo $raw->l_name; ?></option>
  							<?php } ?>
							</select>
										<span class="error" id="locatione_error"></span>
							</div>
                                                <div class="col-md-6">
                                                    <span> <i class="fa fa-circle-o" style="color:rgb(219, 68, 55)"></i>  Current selling <i class="fa fa-circle-o" style="color:rgb(66, 133, 244)"></i> Previous selling  </span>
                                                </div>
							</div>
					<div class="col-md-6">
						<div id="curve_chart" style="width: 900px; height: 500px"></div>
					</div>
					<div class="col-md-6">
						<div id="columnchart_material" style="width: 800px; height: 500px;"></div>
					</div>
					</div>
				
			</div>
			<!-- switches -->
			<div class="switches">
			</div>
			<!-- //switches -->
		</div>
		
			 <!--body wrapper end-->
		</div>
        <!--footer section start-->
			<?php $this->load->view('web/footer');?>
        <!--footer section end-->

      <!-- main content end-->
   </section>
  
<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
   <script>
   function get_report(id){
      //alert(id);
     var url = '<?php echo base_url();?>/main/dashboard?l_id='+id;
     //alert(url);
        window.location.replace(url);     }
   </script>
</body>
</html>