<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Aldridge</title>
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
        <a href="<?php echo base_url(); ?>index2.html">Aldridge</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
      
      <p style="color:red">
			<?php if(isset($error)){
				echo $error;
				}?>      
      </p>
        <p class="login-box-msg"></p>
		 
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
                    
        <form action="<?php echo base_url(); ?>index.php/RegistrationAdmin/Forgot_password" method="post">
          <div class="form-group has-feedback">
           <h1>Mail Will Be Sent Check Your Inbox</h1>
          </div>
          
          <div class="row">
            <div class="col-xs-8">    
                                 
            </div><!-- /.col -->
            <!-- /.col -->
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
