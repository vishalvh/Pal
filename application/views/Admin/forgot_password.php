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
                
                <a href="<?php echo base_url(); ?>"><b>Shree Hari</b></a>
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
                 <form action="<?php echo base_url(); ?>login/forgot_pass_data/" method="post"  name="savingdata" onsubmit="return validate()" id="savingdata">
                    <div class="form-group has-feedback">
                        <input type="text" id="AdminEmail" class="form-control" placeholder="Email" name="UserEmail" />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      <div class="invalid-feedback" style="color:red;" id="AdminEmailerror"></div>
                    </div>
                    <div class="form-group has-feedback">
                            <button type="submit"  class="btn btn-primary btn-block btn-flat">Forgot Password</button>
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
        
        <script>
			
$(document).ready(function(){ 

	$("#AdminEmail").blur(function(){
		 var email = $("#AdminEmail").val();
                            if(email == ""){
         $("#AdminEmailerror").html("Email Id is required.");
                      }else{
                                        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
										if (filter.test(email)) {
                                              $("#AdminEmailerror").html('');
                                         }else{
                                            
											  $("#AdminEmailerror").html('Email is not valid.');
                                         }
					  }
    }
					);
});	
function validate(){
         var AdminEmail = document.forms["savingdata"]["AdminEmail"].value;
       
        var temp = 0;
       
        if(AdminEmail == ""){
            $("#AdminEmailerror").html("Email  id is required.");
            temp++;
        }
	 	if(AdminEmail != ""){
            var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
										if (filter.test(AdminEmail)) {
                                              $("#AdminEmailerror").html('');
                                         }else{
                                             temp++;
											  $("#AdminEmailerror").html('Email is not valid.');
                                         }
           
        }
        if(temp != 0){
        			 return false;     
        }
    }
	</script>
    </body>
</html>