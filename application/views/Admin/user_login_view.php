<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Shri Hari</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

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
      <!-- /.login-logo -->
      <div class="login-box-body">
      <div class="login-logo">
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
      <p style="color:red">
			<?php if(isset($error)){
				echo $error;
				}?>      
      </p>
        <p class="login-box-msg">Sign in to start your session</p>
		 
		  <?php  if(isset($getmsg) != NULL){ ?>
		  
                                        <div class="alert alert-success">
                                        <?php echo $getmsg[0]; ?>
                                        </div> 
					 				<?php } ?>
 <?php  if(isset($getmsg1) != NULL){ ?>
                                        <div class="alert alert-danger">
                                        <?php echo $getmsg1[0]; ?>
                                        </div> 
					 				<?php } ?>
					 <?= validation_errors('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>'); ?>
                    
        <form action="<?php echo base_url(); ?>Login/verify_login" method="post" name="savingdata" onsubmit="return validate()" id="savingdata">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="AdminEmail" placeholder="Email" name="email" value="<?php echo set_value('email'); ?>"/>
            
            
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <div class="invalid-feedback" id="AdminEmailerror"></div>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="password" class="form-control" placeholder="Password" name="password"/>

            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <div class="invalid-feedback" id="cpasserror"></div>
          </div>
          <div class="row">
         
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                <a class='pull-right' href="<?php echo base_url(); ?>Login/forgot_password">I forgot my password</a><br>
            </div><!-- /.col -->
          </div>
           
<!--
        <div class="col-xs-12 text-center">
          </br>
            <b>------- OR -------</b>
          </br>  </br>
         <a class="btn btn-block  btn-warning" href="<?php echo base_url(); ?>registration">Create New Account</a><br>
         
         </div> /.login-box-body 
-->
         <div style="clear:both"></div>
        </form>
       
       
       </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
          </div>
        </form>
       

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
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
	$("#password").blur(function(){
		 var email = $("#password").val();
		
                            if(email == ""){
         $("#cpasserror").html(" Password is required.");
                      }else{
										
                                              $("#cpasserror").html('');
                                         
					  }
    }
					);
});	
function validate(){
         var AdminEmail = document.forms["savingdata"]["AdminEmail"].value;
         var cpass = document.forms["savingdata"]["password"].value;
       
        var temp = 0;
       
        if(AdminEmail == ""){
            $("#AdminEmailerror").html("Email id  is required.");
            temp++;
        }
	if(cpass == ""){
            $("#cpasserror").html(" Password is required.");
            temp++;
        }
	
		
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	</script>
  </body>
</html>
