
    <div class="content-wrapper"><!-- Page Heading -->
<section class="content-header">
    <h1>
        Profile Edit
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        
        <li class="active">Edit Profile</li>
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

                <!-- form start -->
                <form role="form" action="<?php echo base_url(); ?>company_master/company_edit/<?php echo $id ?>" method="post" enctype="multipart/form-data" id="profileForm">

                    <div class="box-body">
                        <div class="col-md-12">
                            <?php if ($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php } ?>
                            <div class="col-md-6">

                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile"> Name</label><span style="color:red">*</span>
                                    <input type="text"  name="AdminName" class="form-control"  value="<?= $query->AdminName ?>" id="AdminName">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    <div class="invalid-feedback" id="lnameerror"></div>
                                </div>
                                
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Email</label><span style="color:red">*</span>
                                    <input type="email" class="form-control" placeholder="Email" name="AdminEmail" id="AdminEmail" value="<?= $query->AdminEmail ?>"/>
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    <div class="invalid-feedback" id="emailerror"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Gender</label><span style="color:red">*</span>
                                    <input type="radio" class="" name="AdminGender" <?php if ($query->AdminGender == '1') { echo 'checked'; } ?> value="1"/> Male
                                    <input type="radio" class="" name="AdminGender" <?php if ($query->AdminGender == '2') { echo 'checked'; } ?> value="2" /> Female
                                    <div class="invalid-feedback" id="gendererror"></div>
                                </div>
                                 
                                
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Mobile</label><span style="color:red">*</span>
                                    <div class="input-group">
                    <span class="input-group-addon" id="country-code">+91</span>
                    <input type="text" class="form-control"  placeholder="Mobile" name="AdminMNumber" id="AdminMNumber" value="<?= $query->AdminMNumber ?>">
                  </div>
                                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                    <div class="invalid-feedback" id="mobileerror"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                               
                                <div class="form-group has-feedback">
                                <label>
                                    <input type="checkbox" id="trm" name="change_pass" value="1" onchange="chackchecked();"> Change Password
                                </label>
                            </div> 
                                <div class="form-group has-feedback passdiv" style="display: none;">
                                    <label for="exampleInputFile">Current Password</label><span style="color:red">*</span>
                                    <input type="password"  name="" class="form-control"  value="" id="cpass">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    <div class="invalid-feedback" id="cpasserror"></div>
                                </div>
                                <div class="form-group has-feedback passdiv" style="display: none;">
                                    <label for="exampleInputFile">New password</label><span style="color:red">*</span>
                                    <input type="password"  name="UserPassword" class="form-control"  value="" id="pass">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    <div class="invalid-feedback" id="passerror"></div>
                                </div>
                                <div class="form-group has-feedback passdiv" style="display: none;">
                                    <label for="exampleInputFile">Retype password</label><span style="color:red">*</span>
                                    <input type="password"  name="" class="form-control"  value="" id="npass">
                                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                                    <div class="invalid-feedback" id="npasserror"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-md-6">
                            <button class="btn btn-primary" type="submit" >Update</button>
                        </div>
                    </div>

                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<script>
    function chackchecked(){
        if($("#trm"). prop("checked") == false){
            $(".passdiv").hide();
        }else{
            $(".passdiv").show();
        }
    }
    function validateform() {
       
        var AdminName = $("#AdminName").val();
        var AdminEmail = $("#AdminEmail").val();
        var mobile = $("#AdminMNumber").val();
        
        var gender = $("input[name='AdminGender']:checked").val();
        $(".invalid-feedback").html('');
        
        if($("#trm"). prop("checked") == false){
            var passval = 1;
        }else{
            var passval = 0;
        }
        
        var temp = 0;
        var npass = $("#npass").val();
        var pass = $("#pass").val();
        var cpass = $("#cpass").val();

        if(passval == 0 ){
            if(cpass == ""){
                $("#cpasserror").html("Current password is required.");
                temp++;
            }
            if(pass == ""){
                $("#passerror").html("New password is required.");
                temp++;
            }
            if(npass == ""){
                $("#npasserror").html("Retype password is required.");
                temp++;
            }else{
                if(pass<5){
                    $("#passerror").html('Password must be at least five characters long!');
                    temp++;
                }else if(pass != npass){
                        $("#passerror").html('Password and confirm password does not match!');
                        $("#npasserror").html('Password and confirm password does not match!');
                        temp++;
                }
            }
        }


        
        
      
        if (gender == null) {
            $("#gendererror").html("Gender is required.");
            temp++;
        }
       
        
        if (AdminName == "") {
            $("#lnameerror").html("Last name is required.");
            temp++;
        }
        if (AdminEmail == "") {
            $("#emailerror").html("Email is required.");
            temp++;
        } else if (checkemail(email) == false) {
            $("#emailerror").html('Invalid email.');
            temp++;
        }
        if (mobile == "") {
            $("#mobileerror").html("Mobile is required.");
            temp++;
        } else if (checkmobile(mobile) == false) {
            $("#mobileerror").html('Invalid mobile number.');
            temp++;
        }
        var id = '<?php echo $id ?>';
        if (temp == 0) {
            $.ajax({
                url: "<?php echo base_url(); ?>registration/check_email_edit_user",
                data: {email: email,id:id,passval:passval,pass:cpass},
                type: 'get',
                success: function (response) {
                    if (response == 0) {
                        var data = new FormData($('#profileForm')[0]);
                        $.ajax({
                            url: "<?php echo base_url(); ?>registration/registration_data_update_user",
                            data: data,
                            type: 'post',
                            mimeType: "multipart/form-data",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (response) {
                                if (response == 1) {
                                    location.reload();
                                }
                            }
                        });
                    } else {
                    if(response == 1){
                        $("#emailerror").html("Email is already use.");
                        temp++;
                    }else{
                        $("#cpasserror").html("Current password is wrong.");
                        temp++;
                    }
                    }
                }
            });
        }
    }
    function checkemail(mail) {
        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if (filter.test(mail)) {
            return true;
        } else {
            return false;
        }
    }
    function checkmobile(mobile) {
        var filter = /^[0-9-+]+$/;
        var pattern = /^\d{10,11}$/;
        if (filter.test(mobile)) {
            if (pattern.test(mobile)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
</script>