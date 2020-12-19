<!-- Page Heading -->
 <script>
			
$(document).ready(function(){ 
	$("#Adminname").blur(function(){
		 var fname = $("#Adminname").val();
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
         var Adminname = document.forms["savingdata"]["Adminname"].value;
        var AdminEmail = document.forms["savingdata"]["AdminEmail"].value;
        var mobile = document.forms["savingdata"]["mobile"].value;
        var password = document.forms["savingdata"]["password"].value;
        var temp = 0;
       
        if(Adminname == ""){
            $("#adminnameerror").html("Employee Name is required.");
            temp++;
        }
	 	if(AdminEmail == ""){
            $("#AdminEmailerror").html("Email Id is required.");
            temp++;
        }if(password == ""){
            $("#mobileerror").html("Password is required.");
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
        if(temp != 0){
        			 return false;     
        }
    }
	</script>
	
<div class="content-wrapper">
<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
          <section class="content-header">
            <h1>
              Add Employee
              <small></small>
            </h1>
            <ol class="breadcrumb">
				<li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>Company_master/company_list"><i class="fa fa-users"></i>Employee</a></li>
              <li class="active">Add Employee</li>
          
            </ol>
          </section>
          <section class="content">
          	<div class="row">
          		<div class="col-md-12">
             
              <div class="box box-primary">

                <!-- form start -->
                <form role="form" action="<?php echo base_url(); ?>Company_master" method="post" name="savingdata" onsubmit="return validate()" id="savingdata" enctype="multipart/form-data">
					
                  <div class="box-body">
                    <div class="col-md-6">
						
						<div class="form-group">
                      <label for="exampleInputFile"> Employee Name</label><span style="color:red">*</span>
                      <input type="text" id="Adminname"  name="Adminname" class="form-control"  value="<?php echo set_value('Adminname'); ?>" >
                      <div class="invalid-feedback" style="color:red;" id="adminnameerror"></div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile">Email</label><span style="color:red">*</span>
                      <input type="text"  id="AdminEmail" name="Adminemail" class="form-control" value="<?php echo set_value('Adminemail'); ?>" >
                       <div class="invalid-feedback" style="color:red;" id="AdminEmailerror"></div>
                       <?php echo form_error('Adminemail', '<div class="error" style="color:red;">', '</div>'); ?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile">Mobile</label><span style="color:red">*</span>
                      <input type="text"onkeypress="return isNumberKey(event)"  maxlength="10" id="mobile" name="AdminMnumber" class="form-control" value="<?php echo set_value('AdminMnumber'); ?>" >
                       <div class="invalid-feedback" style="color:red;" id="mobileerror"></div>
                    </div>
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
                    <div class="form-group">
							<label>Password</label><span style="color:red">*</span>
                      <input type="password" id="password"  name="Adminpassword" id="password" class="form-control"  value="<?php echo set_value('Adminpassword'); ?>">
                      <div class="invalid-feedback" style="color:red;" id="passworderror" ></div>
							<input type="checkbox" id="showHide"> Show Password
                    </div>
<!--
					<div class="form-group">
                      <label for="exampleInputFile">Profile Picture</label>
                      <input type="file" id="exampleInputFile" name="logo">
                      
                    </div>	
-->
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
					  <div class="col-md-6">
                    <button class="btn btn-primary" type="submit">ADD</button>
                  </div>
					</div>
					
                </form>
              </div><!-- /.box -->
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
            </div>
          	</div>
			 </section>
			 