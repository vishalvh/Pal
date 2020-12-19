<script>
			
$(document).ready(function(){ 
	$("#AdminName").blur(function(){
		 var fname = $("#AdminName").val();
        if(fname == ""){
          $("#adminnameerror").html('Employee Name is  required.');
			
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
});	
function validate(){
         var Adminname = document.forms["savingdata"]["AdminName"].value;
	//alert(Adminname);
        var AdminEmail = document.forms["savingdata"]["AdminEmail"].value;
        var mobile = document.forms["savingdata"]["mobile"].value;
       // var password = document.forms["savingdata"]["password"].value;
        var temp = 0;
       
        if(Adminname == ""){
            $("#adminnameerror").html("Employee Name is required.");
            temp++;
        }
	 	if(AdminEmail == ""){
            $("#AdminEmailerror").html("Email Id is required.");
            temp++;
        }
//	if(password == ""){
//            $("#mobileerror").html("Password is required.");
//            temp++;
//        }
	if(mobile == ""){
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
        if(temp != 0){
        			 return false;     
        }
    }
	</script>
	<script language=Javascript>
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
&& (charCode < 48 || charCode > 57))
	  
 return false;

  return true;
}

</script>
  <script  type="text/javascript">
 $(document).ready(function () {
 $("#showHide").click(function () {
 if ($("#password").attr("type")=="password") {
 $("#password").attr("type", "text");
 }
 else{
 $("#password").attr("type", "password");
 }
 
 });
 });
</script>
    <div class="content-wrapper"><!-- Page Heading -->
<section class="content-header">
    <h1>
         Edit Employee
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        
        <li class="active">Edit Employee</li>
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
                    <form role="form" action="<?php echo base_url(); ?>company_master/user_edit/<?php echo $id ?>" method="post" name="savingdata" onsubmit="return validate()" id="savingdata" enctype="multipart/form-data" >

                        <div class="box-body">
                            <div class="col-md-12">
                                <?php if ($this->session->flashdata('success')) { ?>
                                    <div class="alert alert-success alert-dismissable">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <?php echo $this->session->flashdata('success'); ?>
                                    </div>
                                <?php } ?>
                                <div class="col-md-6">
								<?php //print_r($query);  ?>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputFile">Employee Name</label><span style="color:red">*</span>
                                        <input type="text" id="AdminName"  name="AdminName" class="form-control"  value="<?= $query->AdminName ?>" id="fname">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        <div class="invalid-feedback" style="color:red;" id="adminnameerror"></div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputFile">Email</label><span style="color:red">*</span>
                                        <input type="email" id="AdminEmail" class="form-control" placeholder="Email" name="AdminEmail" id="email" value="<?= $query->AdminEmail ?>"/>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                         <div class="invalid-feedback" style="color:red;" id="AdminEmailerror"></div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputFile">Gender</label><span style="color:red">*</span>
                                        <input type="radio" class="" name="AdminGender" <?php
                                        if ($query->AdminGender == '1') {
                                            echo 'checked';
                                        }
                                        ?> value="1"/> Male
                                        <input type="radio" class="" name="UserGender" <?php
                                        if ($query->AdminGender == '2') {
                                            echo 'checked';
                                        }
                                        ?> value="2" /> Female

                                    </div>

                                    
                                   
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputFile">Mobile</label><span style="color:red">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="country-code">+91</span>
                                            <input type="text" class="form-control" id="mobile" name="AdminMNumber"  value="<?= $query->AdminMNumber ?>">
                                        </div>
                                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                           <div class="invalid-feedback" style="color:red;" id="mobileerror"></div>
                                        <input type="hidden" value="<?= $query->id ?>"/>
                                    </div>
<!--	
                                    <div class="form-group">
							<label>Password</label><span style="color:red">*</span>
                      <input type="password" id="password"  name="Adminpassword" id="password" value="<?= $query->AdminPassword ?>" class="form-control" >
                      <div class="invalid-feedback" style="color:red;" id="passworderror"></div>
							<input type="checkbox" id="showHide"> Show Password
                    </div>
-->
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <div class="col-md-6">
                                <button class="btn btn-primary" type="submit" >Update</button>
                            </div>
                        </div>

                    </form>
                </div>
<!-- /.box -->
        </div>
    </div>
</section>

