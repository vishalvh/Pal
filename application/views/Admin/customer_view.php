<div class="content-wrapper"><!-- Page Heading -->
    <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <section class="content-header">
        <h1>View Customer Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">View Customer</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <p class="help-block" style="color:red;"><?php
                        if (isset($error)) {
                            echo $error;
                        }
                        ?></p>
                   
                    

                      
                            <form class="form-horizontal" method="post" id="form" enctype="multipart/form-data" action="http://localhost/quart/public/admin/project/edit-save/2">
                                <div class="box-body" id="parent-form-area">
                                    <div class="form-group header-group-0 " id="form-group-name" style="">
                                        <label class="control-label col-sm-2">First Name</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?php echo $user['0']['AdminName']; ?></p>
                                        </div> 
                                    </div>
                                    
                                    <div class="form-group header-group-0 " id="form-group-name" style="">
                                        <label class="control-label col-sm-2">Email</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?php echo $user['0']['AdminEmail']; ?></p>
                                        </div> 
                                    </div>
                                    <div class="form-group header-group-0 " id="form-group-name" style="">
                                        <label class="control-label col-sm-2">Gender</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?php if ($user['0']['AdminGender'] == '1') {
                            echo "Male";
                        } else {
                            echo "Female";
                        } ?></p>
                                        </div> 

                                    </div>
                                    				

                                    
                                    <div class="form-group header-group-0 " id="form-group-description" style="">
                                        <label class="control-label col-sm-2">Mobile</label>             
                                        <div class="col-sm-9">
                                            <p name="description" class="form-control-static"><?php echo $user['0']['AdminMNumber']; ?></p>  
                                        </div>               
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- form start -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
