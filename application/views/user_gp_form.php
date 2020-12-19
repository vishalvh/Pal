<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Set Password</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.4 -->
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo base_url(); ?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?php echo base_url(); ?>login">Demo</a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Reset Password</p>
                <?= validation_errors('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>'); ?>
                <?php $attributes = array('method' => 'post','id'=>'registration_data'); ?>
                <?php echo form_open('administrator/get_password/index'.$code, $attributes); ?>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password" id="pass"/>
                    
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <div class="invalid-feedback" id="passworderror"></div>
                </div>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="passconf" id="cpass"/>

                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <div class="invalid-feedback" id="cpasserror"></div>
                </div>



                <div class="row">
                    <div class="col-xs-8">    

                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <input type="button" onclick="validate();" class="btn btn-primary btn-block btn-flat" name="Submit" value="Submit">
                    </div><!-- /.col -->
                </div>
                </form>


            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script>
            function validate(){
        var password = $("#pass").val();
        var cpassword = $("#cpass").val();
        $(".invalid-feedback").html('');
        var temp = 0;
        if(cpassword == ""){
            $("#cpasserror").html("Retype password is required.");
            temp++;
        }
        if(password == ""){
            $("#passworderror").html("Password is required.");
            temp++;
        }else{
            if(password<5){
                $("#passworderror").html('Password must be at least five characters long!');
                temp++;
            }else if(cpassword != password){
                    $("#passworderror").html('Password and confirm password does not match!');
                    $("#cpassworderror").html('Password and confirm password does not match!');
                    temp++;
            }
        }
        var rs = '<?php echo $code; ?>';
        if(temp == 0){
                var data = new FormData($('#registration_data')[0]);
                $.ajax({
                    url: "<?php echo base_url(); ?>login/set_password/"+rs,
                    data: data,
                    type: 'post',
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        if(response == 1){
                                location.reload();
                        }else{
                            location.replace("<?php echo base_url();?>login");
                        }
                    }
                });
            }
            
        }
        
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>