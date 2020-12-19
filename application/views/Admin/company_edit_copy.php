<script>
			
$(document).ready(function(){ 
	$("#Adminname").blur(function(){
		 var fname = $("#Adminname").val();
        if(fname == ""){
          $("#adminnameerror").html(' Name is  required.');
			
			document.getElementById("#adminnameerror").style.borderColor="#FF0000"
                      }else{
						  var alpha = /^[a-zA-Z\s]+$/i;
			if(alpha.test(fname)) {
				$("#adminnameerror").html('');
} else {
$("#adminnameerror").html('Name must have only alpha characters');
}
}
    });
	$("#AdminEmail").blur(function(){
		 var email = $("#AdminEmail").val();
                            if(email == ""){
         $("#AdminEmailerror").html("Email Id is required.");
                      }else{
                                        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
										if (filter.test(email)) {
                                              $("#AdminEmailerror").html('');
                                         }else{
                                            
											  $("#AdminEmailerror").html('email is not valid.');
                                         }
					  }
    }
					);
	$("#mobile").blur(function(){
		 var mobile = $("#mobile").val();
        if(mobile == ""){
          $("#mobileerror").html("Mobile is required.");
                      }else{
						  $("#mobileerror").html('');
					  }
    }
					);
	$("#password").blur(function(){
		 var password = $("#password").val();
        if(password == ""){
         $("#passworderror").html("Password is required.");
                      }else{
						  $("#passworderror").html('');
					  }
    }
					);
	$("#oldpassword").blur(function(){
		 var oldpassword= $("#oldpassword").val();
		 var AdminPassword2= $("#AdminPassword2").val();
        if(oldpassword == ""){
         $("#oldpassworderror").html("Password is required.");
                      }else{
						  if(oldpassword == AdminPassword2 ){
						  $("#oldpassworderror").html('');
						  }else{
							   $("#oldpassworderror").html("old password is not right.");
						  }
					  }
    }
					);
	$("#AdminPassword3").blur(function(){
		 var oldpassword= $("#AdminPassword3").val();
        if(oldpassword == ""){
         $("#passworderror").html("Password is required.");
                      }else{
						  if(oldpassword.length > 5) { 
			 							$("#passworderror").html('');
                                         }else{
                                            
											  $("#passworderror").html('Password length minimum is 6.');
											 
                                         }
						  
						  
					  }
    }
					);
	$("#cpassword").blur(function(){
		 var password = $("#AdminPassword3").val();
		//alert(password);
		
		 var cpassword = $("#cpassword").val();
		//alert(cpassword);
        if(cpassword == ""){
         $("#cpassworderror").html("Confirm password is required.");
                      }else{
						  if(password == cpassword){
							  $("#cpassworderror").html('');
						  }else{
							   $("#cpassworderror").html("Confirm password is not match.");
						  }

					  }
    }
					);
});	
function validate(){
         var Adminname = document.forms["savingdata"]["Adminname"].value;
        var AdminEmail = document.forms["savingdata"]["AdminEmail"].value;
        var mobile = document.forms["savingdata"]["mobile"].value;
        var AdminGender = document.forms["savingdata"]["AdminGender"].value;
        var oldpassword = document.forms["savingdata"]["oldpassword"].value;
        var AdminPassword = document.forms["savingdata"]["AdminPassword3"].value;
        var cpassword = document.forms["savingdata"]["cpassword"].value;
        var AdminPassword2 = document.forms["savingdata"]["AdminPassword2"].value;
        //var password = document.forms["savingdata"]["password"].value;
        var temp = 0;
       
        if(Adminname == ""){
            $("#adminnameerror").html(" Name is required.");
            temp++;
        }
	 	if(AdminEmail == ""){
            $("#AdminEmailerror").html("Email is required.");
            temp++;
        }if(mobile == ""){
            $("#passworderror").html("Mobile Number is required.");
            temp++;
        }if(AdminEmail != ""){
            var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
										if (filter.test(AdminEmail)) {
                                              $("#AdminEmailerror").html('');
                                         }else{
                                             temp++;
											  $("#AdminEmailerror").html('Email is not valid.');
                                         }
           
        }
	 if($("#trm"). prop("checked") == true){
		 if(oldpassword == ""){
            $("#oldpassworderror").html("password is required.");
            temp++;
        }if(AdminPassword == ""){
            $("#passworderror").html("password is required.");
            temp++;
        }
		// alert(AdminPassword.length);
		 if(AdminPassword != ""){
		 if(AdminPassword.length > 5) { 
			 
                                         }else{
                                            
											  $("#passworderror").html('Password length minimum is 6.');
											  temp++;
                                         }
		 }
		 if(cpassword != AdminPassword ){
            $("#cpassworderror").html("Confirm password is not match .");
            temp++;
        }
		 
	 }
        if(temp != 0){
        			 return false;     
        }
    }
	function chackchecked(){
        if($("#trm"). prop("checked") == false){
            $(".passdiv").hide();
        }else{
            $(".passdiv").show();
        }
    }
	</script>
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
                <form role="form" action="<?php echo base_url(); ?>company_master/company_edit/<?php echo $id ?>" method="post" enctype="multipart/form-data" method="post" name="savingdata" onsubmit="return validate()" id="savingdata" enctype="multipart/form-data">

                    <div class="box-body">
                        <div class="col-md-12">
                            <?php if ($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php } ?>
                            <?php //print_r($query);  ?>
                            <div class="col-md-6">

                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile"> Name</label><span style="color:red">*</span>
                                    <input type="text" id="Adminname"  name="AdminName" class="form-control"  value="<?= $query->AdminName ?>" >
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    <div class="invalid-feedback" style="color:red;" id="adminnameerror"></div>
                                </div>
                                
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Email</label><span style="color:red">*</span>
                                    <input type="email" class="form-control" placeholder="Email" name="AdminEmail" id="AdminEmail" value="<?= $query->AdminEmail ?>"/>
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    <div class="invalid-feedback" style="color:red;" id="AdminEmailerror"></div>
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
                    <input type="text" class="form-control"  placeholder="Mobile" name="AdminMNumber" id="mobile" value="<?= $query->AdminMNumber ?>">
                  </div>
                                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                    <div class="invalid-feedback" style="color:red;" id="mobileerror"></div>
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
                                    <input type="password" id="oldpassword"  name="oldpassword" class="form-control"  value="">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                               <div class="invalid-feedback" style="color:red;" id="oldpassworderror"></div>
                                </div>
                                <div class="form-group has-feedback passdiv" style="display: none;">
                                    <label for="exampleInputFile">New password</label><span style="color:red">*</span>
                                    <input type="password"  id="AdminPassword3" name="AdminPassword" class="form-control"  value="" >
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                   <div class="invalid-feedback" style="color:red;" id="passworderror"></div>
                                </div>
                                <div class="form-group has-feedback passdiv" style="display: none;">
                                    <label for="exampleInputFile">Retype password</label><span style="color:red">*</span>
                                    <input type="password"  name="Password" class="form-control"  value="" id="cpassword">
                                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                                 <div class="invalid-feedback" style="color:red;" id="cpassworderror"></div>
                                    <input type="hidden" name="id" value="<?= $query->id ?>"/>
                                     <input type="hidden" name="AdminPassword" id="AdminPassword2" value="<?= $query->AdminPassword ?>"/>
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

