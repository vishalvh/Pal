<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Admin Users List
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>admin_master/admin_list"><i class="fa fa-users"></i>Admin</a></li>
            <li class="active">Admin Users List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Admin Users List</h3>

                        <a style="float:right;" href='<?php echo base_url(); ?>admin_master' class="btn btn-primary btn-sm" ><i class="fa fa-plus-circle" ></i><strong > Add</strong></a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="widget">
                            <?php if (isset($success) != NULL) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $success['0']; ?>
                                </div>
                            <?php } ?>

                        </div>

                        <div class="tableclass">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Profile Picture</th>
                                        <th>Admin Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$cnt = 1;
foreach ($query as $row) {
    ?>

                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><img src="<?php echo base_url(); ?>upload/<?php echo $row['profile_pic']; ?>" alt="Profile Pic" style="width:50px; height:40px;"/>
                                            </td>
                                            <td><?php echo ucwords($row['AdminName']); ?></td>
                                            <td><?php echo $row['AdminEmail']; ?></td>
                                            <td>
                                                <!--<a href='<?php echo base_url(); ?>admin_master/admin_edit/<?php echo $row['id']; ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>-->

                                                <a  href='<?php echo base_url(); ?>admin_master/admin_delete/<?php echo $row['id']; ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
                                            </td>
                                        </tr>
    <?php $cnt++;
} ?>

                                </tbody>
                            </table>
                        </div>
                        <div style="text-align:right;" class="box-tools">
                            <ul class="pagination pagination-sm no-margin pull-right">
<?php echo $links; ?>
                            </ul>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->