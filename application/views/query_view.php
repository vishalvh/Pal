<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Query List
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i>Dashboard</a></li>
           <li class="active">Query list</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Query List</h3>
<!--                        <a style="float:right;" href='<?= base_url() ?>company_master/company_csv' class="btn btn-primary btn-sm" data-toggle="modal"  data-target=""><strong > Export</strong></a>-->
                        
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="tableclass">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <!--<th>SrNo</th>-->
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$cnt = 1;
									//print_r($query);
foreach ($query as $row) {
    ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <!--<td><?php echo $row['srno']; ?></td>-->
                                            <td><?php echo ucwords($row['UserFName']." ".$row['UserLName']); ?></td>
                                            <td><?php echo ucwords($row['title']); $title = $row['title']; $detail = $row['description']; ?></td>
                                            <td><?php $cdate =date('d M Y - h:i A',strtotime($row['created_at']));  echo date('d M Y - h:i A',strtotime($row['created_at'])); ?></td>
                                            <td>
											    <a href="#" data-toggle="modal" onclick="change_data('<?php echo $title; ?>','<?php echo $detail; ?>','<?php echo $cdate; ?>');" data-target="#myModal">View More</a>
                                            </td>
                                        </tr>
    <?php $cnt++;
} ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Query Detail</h4>
        </div>
        <div class="modal-body">
          <div class="form-group has-feedback">
                        <label><u>Subject</u></label><br>
						<p id="lbltitle">Title</p>
                    </div>
					<div class="form-group has-feedback">
                        <label><u>Message</u></label><br>
						<p id="lblquery">Query</p>
                    </div>
					<div class="form-group has-feedback">
                        <label><u>Date</u></label><br>
						<p id="lbldate">Query</p>
                    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <script>
  function change_data(t,d,dt){
	  $('#lbltitle').html(t);
	  $('#lblquery').html(d);
	  $('#lbldate').html(dt);
  }
  </script>
