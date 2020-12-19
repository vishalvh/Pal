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
                <a href="<?php echo base_url(); ?>login">Shree Hari</a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Reset Password</p>
                <?= validation_errors('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>'); ?>
                <?php $attributes = array('method' => 'post','id'=>'savingdata','name'=>'savingdata' ,'onsubmit' =>'return validate()'); ?>
                <?php echo form_open('Login/set_password/'.$code, $attributes); ?>
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
                <div class="form-group has-feedback">
                   
                    <input type="password" id="AdminEmail"  class="form-control" placeholder="Password" name="password" id="pass"/>
                    
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
                        <input type="submit"  class="btn btn-primary btn-block btn-flat" name="Submit" value="Submit">
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
			
$(document).ready(function(){ 

	$("#AdminEmail").blur(function(){
		 var email = $("#AdminEmail").val();
                            if(email == ""){
         $("#passworderror").html("Password  is required.");
                      }else{
                                   //alert(email.length);    
										if(email.length > 6) {
                                              $("#passworderror").html('');
                                         }else{
                                            
											  $("#passworderror").html('Password length minimum is 6.');
                                         }
					  }
    }
					);
	$("#cpass").blur(function(){
		 var email = $("#AdminEmail").val();
		 var cpass = $("#cpass").val();
                            if(email == ""){
         $("#cpasserror").html("Confirm Password is required.");
                      }else{
                                   //alert(email.length);    
										if(email == cpass) {
                                              $("#cpasserror").html('');
                                         }else{
                                            
											  $("#cpasserror").html('Confirm Password is not match.');
                                         }
					  }
    }
					);
});	
function validate(){
         var AdminEmail = document.forms["savingdata"]["AdminEmail"].value;
         var cpass = document.forms["savingdata"]["cpass"].value;
       
        var temp = 0;
       
        if(AdminEmail == ""){
            $("#passworderror").html("Password  is required.");
            temp++;
        }
	if(cpass == ""){
            $("#cpasserror").html("Confirm Password is required.");
            temp++;
        }
	if(cpass != AdminEmail ){
           $("#cpasserror").html("Confirm Password is not match.");
            temp++;
        }
			
		
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	</script>
    </body>
</html>