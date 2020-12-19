<!-- Page Heading -->
 <script>
			
$(document).ready(function(){ 
	$("#Adminname").blur(function(){
		 var fname = $("#Adminname").val();
        if(fname == ""){
          $("#adminnameerror").html('Pump Name is  required.');
			
			document.getElementById("#adminnameerror").style.borderColor="#FF0000"
                      }else{
						  var alpha = /^[a-zA-Z\d\s]+$/i;
			if(alpha.test(fname)) {
				$("#adminnameerror").html('');
} else {
$("#adminnameerror").html('Name must have only alpha characters');
}
}
    });
	
	$("#type").blur(function(){
		 var mobile = $("#type").val();
        if(mobile == ""){
          $("#mobileerror").html("Type is required.");
                      }else{
						  $("#mobileerror").html('');
					  }
    }
					);
});	
function validate(){
         var Adminname = document.forms["savingdata"]["Adminname"].value;
       var country = document.forms["savingdata"]["country"].value;
        var temp = 0;
       
        if(Adminname == ""){
            $("#adminnameerror").html("Pump Name is required.");
            temp++;
        }
	if(country == ""){
            $("#countryerror").html("Country  Name is required.");
            temp++;
        }
	 	if(country == ""){
            $("#passworderror").html("Type is required.");
            temp++;
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
<div class="content-wrapper">
<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
          <section class="content-header">
            <h1>
              Edit Company
              <small></small>
            </h1>
            <ol class="breadcrumb">
				<li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>Company/company_list"><i class="fa fa-users"></i>Company List</a></li>
              <li class="active">Edit Company</li>
          
            </ol>
          </section>
          <section class="content">
          	<div class="row">
          		<div class="col-md-12">
             
              <div class="box box-primary">
                <p class="help-block" style="color:red;"><?php if(isset($error)){
                echo $error;
                	} ?></p>
                	
                <!-- form start -->
                <form role="form" action="<?php echo base_url(); ?>Company/company_update/<?php echo $id;?>" method="post" name="savingdata" onsubmit="return validate()" id="savingdata" enctype="multipart/form-data">
					       <?php
                  //print_r($r);
                 ?>
                 <input type="hidden" name="id" value="<?php echo $this->uri->segment('3');?>">
                  <div class="box-body">
                    <div class="col-md-6">
						        <!-- Company name -->
						        <div class="form-group">
                      <label for="exampleInputFile"> Company Name</label><span style="color:red">*</span>
                      <input type="text" id="companyname"  name="companyname" class="form-control"value="<?php echo $company[0]->name;?>" >
                      <?php echo form_error('companyname', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="comapnynameerror"></div>
                    </div>
                    <!-- Mobile Number -->
                    <div class="form-group">
                      <label for="exampleInputFile"> Mobile Number</label><span style="color:red">*</span>
                      <input type="text" id="mobile"  name="mobile" class="form-control"value="<?php echo $company[0]->mobile;?>">
                      <?php echo form_error('mobile', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="mobileerror"></div>
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                      <label for="exampleInputFile"> Email</label><span style="color:red">*</span>
                      <input type="text" id="email"  name="email" class="form-control" value="<?php echo $company[0]->email;?>">
                      <?php echo form_error('email', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="emailerror"></div>
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                      <label for="exampleInputFile">Password</label><span style="color:red">*</span>
                      <input type="password" id="password"  name="password" class="form-control" value="<?php echo $company[0]->password;?>">
                      <?php echo form_error('password', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="passworderror"></div>
                    </div>
                    
                 
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
					  <div class="col-md-6">
                    <button class="btn btn-primary" type="submit">Update</button>
                  </div>
					</div>
					
                </form>
              </div><!-- /.box -->
					<script>
      
$(document).ready(function(){ 

  $("#companyname").blur(function(){
     var c_name = $("#companyname").val();
                            if(c_name == ""){
         $("#comapnynameerror").html("Company Name is required.");
                      }
                      else{
                   $("#comapnynameerror").html('');
                            }
    }
          );
  $("#mobile").blur(function(){
     var mobile = $("#mobile").val();
                            if(mobile == ""){
         $("#mobileerror").html("Mobile Number is required.");
                      }
                      else{
                   $("#mobileerror").html('');
                            }
    }
          );
  $("#email").blur(function(){
     var email = $("#email").val();
                            if(email == ""){
         $("#emailerror").html("Email Id is required.");
                      }else{
                                        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                    if (filter.test(email)) {
                                              $("#emailerror").html('');
                                         }else{
                                            
                        $("#emailerror").html('Email is not valid.');
                                         }
            }
    }
          );
  $("#password").blur(function(){
     var password = $("#password").val();
    
                            if(password == ""){
         $("#passworderror").html(" Password is required.");
                      }else{
                    
                                              $("#passworderror").html('');
                                         
            }
    }
          );

  

}); 
function validate(){
         var c_name = document.forms["savingdata"]["companyname"].value;
         var mobile = document.forms["savingdata"]["mobile"].value;
         var email = document.forms["savingdata"]["email"].value;
         var password = document.forms["savingdata"]["password"].value;
         
       
        var temp = 0;
       if(c_name == ""){
            $("#comapnynameerror").html("Company Name is required.");
            temp++;
        }if(mobile == ""){
            $("#mobileerror").html("Mobile Number is required.");
            temp++;
        }
        if(email == ""){
            $("#emailerror").html("Email id  is required.");
            temp++;
        }
  if(password == ""){
            $("#passworderror").html(" Password is required.");
            temp++;
        }

    
        if(temp != 0){
               return false;     
        }
    }
  </script>
            </div>
          	</div>
			 </section>
			   