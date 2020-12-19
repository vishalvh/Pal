<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer List
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Customers list</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Customers List</h3>
<!--                        <a style="float:right;" href='<?= base_url() ?>company_master/company_csv' class="btn btn-primary btn-sm" data-toggle="modal"  data-target=""><strong > Export</strong></a>-->

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="widget">
                            <?php if (isset($success) != NULL) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $success['0']; ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('successf')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('successf'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('failf')) { ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('failf'); ?>
                                </div>
                            <?php } ?>   
                        </div>

                        <?php $attributes = array('class' => 'form-horizontal', 'method' => 'get', 'role' => 'form'); ?>

                      

                        <br>
                        <div class="tableclass">
                   <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <!--<th>SrNo</th>-->
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Email</th>
										<th>Gender</th>
										<th>State</th>
                                        <th>Country</th>
                                        <th>Status</th>
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
                                            <td><a href="<?php echo base_url(); ?>company_master/view_company/<?php echo $row['id']; ?>"><?php echo ucwords($row['UserFName'].' '.$row['UserLName']); ?></a></td>
                                            <td><?php echo ucwords('+'.$row['phone_code'].$row['UserMNumber']); ?></td>
                                            <td><?php echo ucwords($row['UserEmail']); ?></td>
																						 <td><?php echo ucwords(($row['UserGender']=='1')?"Male":"Female"); ?></td>
											 <td><?php echo ucwords($row['name']); ?></td>
											 
											  <td><?php echo ucwords($row['state_name']); ?></td>
                                            </td>
                                            <td><?php if ($row['Active'] == "0") { ?> <small class="label bg-red">Pending</small> <?php
                                            } else {

                                                if ($row['Active'] == "1") {
                                                    ?> <a href="javascript:voied(0);" ><small class="label bg-blue">Active</small> </a><?php } else {
            ?> <a href="javascript:voied(0);"><small class="label  bg-green">Waiting for Email Verification</small></a> <?php }
                            }
    ?></td>
                                            <td>
                                                <a href='<?php echo base_url(); ?>company_master/company_edit/<?php echo $row['id']; ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                <a  href='<?php echo base_url(); ?>company_master/company_delete/<?php echo $row['id']; ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
                                            </td>
                                        </tr>
    <?php $cnt++;
}
?>
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
            <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="H4">Doctor list</h4>
                        </div>
                        <div class="modal-body"> 
<?php $attributes = array('class' => 'form-horizontal', 'method' => 'POST'); ?>
<?php
echo form_open_multipart('company_master/importcompany', $attributes);
$validate_array1 = array("imageform", "admin_add_email", "admin_add_password", "admin_add_type");
?>
                            <div class="box-body form-group">

                                <label>Upload</label>
                                <input type="file" name="company_file" class="form-controll">
                                <div style='color:red;' id='admin_name_add_alert'></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="model_close" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <input type="submit" id="add_admin_submit" name="add_menu" class="btn btn-primary" value="Add"/>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
