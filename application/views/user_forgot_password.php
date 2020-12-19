<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Forgot</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.4 -->
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo base_url(); ?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="register-page">
        <div class="register-box">
            
            <div class="register-box-body">
                <div class="register-logo">
                <a href="<?php echo base_url(); ?>"><b>Demo</b></a>
            </div>
            <?php if ($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('fail')) { ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('fail'); ?>
                                </div>
                            <?php } ?> 
                <p class="login-box-msg">Forgot Password</p>
                 <form action="" method="post" id="registration_data">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="UserEmail" id="email"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <div class="invalid-feedback" id="emailerror"></div>
                    </div>
                    <div class="form-group has-feedback">
                            <button type="button" onclick="validate();" class="btn btn-primary btn-block btn-flat">Forgot Password</button>
                        </div><!-- /.col -->
                    
                </form>       

                

                <a href="<?php echo base_url(); ?>" class="text-center">I already have a membership</a>
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->

        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        
        <script>function validate(){
        var email = $("#email").val();
        var temp =0;
        if(email == ""){
            $("#emailerror").html("Email is required.");
            temp++;
        }else if (checkemail(email) == false) {
            $("#emailerror").html('Invalid email.');
            temp++;
        }
        if(temp == 0){
            $.ajax({
            url: "<?php echo base_url(); ?>registration/check_email_only",
            data: {email: email},
            type: 'get',
            success: function (response) {
                if(response==1){
                    var data = new FormData($('#registration_data')[0]);
                    $.ajax({
                        url: "<?php echo base_url(); ?>login/forgot_pass_data",
                        data: data,
                        type: 'post',
                        mimeType: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (response) {
                            if(response == 1){
                                    location.reload();
                            }
                        }
                    });
                }else{
                    $("#emailerror").html("Email is Not exist.");
                    temp++;
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
    </body>
</html>