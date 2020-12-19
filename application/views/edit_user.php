<!-- Page Heading -->
<div class="content-wrapper">
<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<section class="content-header">
    <h1>
        Edit Profile
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('home') ?>"><i class="fa fa-user"></i>Dashboard</a></li>
        <li class="active">Edit Profile1</li>
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
                <div class="box-body">
                        <?php if (isset($success) != NULL) { ?>
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $success['0']; ?>
                        </div>
<?php } ?>

                </div>
                <!-- form start -->
                <form role="form" action="<?php echo base_url(); ?>user" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="col-md-3">
                            <img src="<?php echo base_url(); ?>upload/<?php echo $user->profile_pic; ?>" alt="Profile Pic" style="width:220px;"/>
                            <input type="file" id="exampleInputFile" name="userfile">                    
                        </div>
                        <div class="col-md-6">
<?= validation_errors('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>', '</div>'); ?>
                            <div class="form-group">
                                <label for="exampleInputFile">Name <span>(Required)</span></label>
                                <input type="text"  name="username" class="form-control" value="<?php echo $user->AdminName; ?>">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Email</label>
                                <input readonly type="email"  name="email" class="form-control" value="<?php echo $user->AdminEmail; ?>">

                            </div>

                            <div class="form-group">
                                <input type="checkbox"  name="chng_pwd" class="minimal" value="1" onclick="checkchecked()" id="chngPwd"> Change Password                    
                            </div>
                            <div class="form-group" style="display:none;" id="change_div">
                                <label for="exampleInputFile">Password</label>
                                <input type="password"  name="passwordn" id="password" class="form-control" value="" autocomplete="off"/>
                               
                            </div>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div><!-- /.box -->
            <script  type="text/javascript">
                $(document).ready(function () {
                    $("#showHide").click(function () {
                        if ($("#password").attr("type") == "password") {
                            $("#password").attr("type", "text");
                        } else {
                            $("#password").attr("type", "password");
                        }

                    });
                });
                 function checkchecked(){
					  $("#password").val("");
        if($("#chngPwd"). prop("checked") == false){
            $("#change_div").hide();
        }else{
            $("#change_div").show();
        }
    }
            </script>



        </div>
    </div>
</section>
