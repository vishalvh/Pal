<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Dashboard             
        </h1>

        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Dashboard</a></li>

        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $totaladmin; ?></div>
                                <div>Total Admin!</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>admin_master/admin_list">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- jQuery 2.1.4 -->


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {

           

           
			   var data = google.visualization.arrayToDataTable([
			    ['Element', 'No', { role: 'style' }],
			   	<?php $cnt =1; foreach ($graph as $detail ){ ?>
				[ '<?php echo $detail->dates; ?>', <?php echo $detail->num; ?>,'#b87333'],
			<?php } ?>
    
      ]);

            var options = {
                title: 'Statistics queries',
                hAxis: {
                    title: 'Time of Day',
                    
                    viewWindow: {
                        min: [7, 30, 0],
                        max: [17, 30, 0]
                    }
                },
                vAxis: {
                    title: 'No of queries'
                }
            };

            var chart = new google.visualization.ColumnChart(
                    document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>