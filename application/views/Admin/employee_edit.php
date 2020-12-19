<!-- Page Heading -->
 <script>
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
              Edit Employee
              <small></small>
            </h1>
            <ol class="breadcrumb">
				<li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>employee"><i class="fa fa-users"></i>Employee List</a></li>
              <li class="active">Edit Employee</li>
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
                <form role="form" action="<?php echo base_url(); ?>employee/edit/<?php echo $empdetail[0]['id'];?>" method="post" name="savingdata" onsubmit="return validate()" id="savingdata" enctype="multipart/form-data">
                 <input type="hidden" name="id" value="<?php echo $empdetail[0]['id'];?>">
				 
                  <div class="box-body">
                    <div class="col-md-6">
					<div class="form-group">
                      <label for="exampleInputFile"> Company List</label><span style="color:red">*</span>
                      <select class="form-control" name="company" id="company">
					  <option value="">Select Company</option>
					  <?php foreach($company as $companydetail){?>
					  <option value="<?php echo $companydetail['id'];?>" <?php if($companydetail['id']==$empdetail[0]['company_id']){ echo "selected"; } ?> ><?php echo $companydetail['name'];?></option>
					  <?php } ?>
					  </select>
                      <?php echo form_error('company', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="comapnynameerror"></div>
                    </div>
					<div class="form-group">
                      <label for="exampleInputFile">location List</label><span style="color:red">*</span>
                      <select class="form-control" name="location" id="location">
					  <option value="">Select Location</option>
					  <?php foreach($location as $locationdetail){?>
					  <option value="<?php echo $locationdetail['l_id'];?>" <?php if($locationdetail['l_id']==$empdetail[0]['l_id']){ echo "selected"; } ?> ><?php echo $locationdetail['l_name'];?></option>
					  <?php } ?>
					  </select>
                      <?php echo form_error('location', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="locationerror"></div>
                    </div>
					<div class="form-group">
                      <label for="exampleInputFile">Name</label><span style="color:red">*</span>
                      <input type="text" id="name"  name="name" class="form-control" value="<?php echo $empdetail[0]['UserFName'];?>" >
                      <?php echo form_error('name', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="nameerror"></div>
                    </div>
					<div class="form-group">
                      <label for="exampleInputFile">Email</label><span style="color:red">*</span>
                      <input type="text" id="email"  name="email" class="form-control"value="<?php echo $empdetail[0]['UserEmail'];?>" >
                      <?php echo form_error('email', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="nameerror"></div>
                    </div>
                    <!-- Mobile Number -->
                    <div class="form-group">
                      <label for="exampleInputFile"> Mobile</label><span style="color:red">*</span>
                      <input type="text" id="mobile"  name="mobile" class="form-control"value="<?php echo $empdetail[0]['UserMNumber'];?>">
                      <?php echo form_error('mobile', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="mobileerror"></div>
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
	$(document).ready(function () {
        $("#company").on('change', function () {
            var cid = $('#company').val();

            $.ajax({
                type: "POST",
                data: {
                    'cid': cid
                },
                url: "<?php echo base_url() ; ?>Inwardreport/location",
                success: function (response) {
                    var obj = JSON.parse(response);

                    $("#location").empty();
                    $("#location").append($(
                        '<option value="">Select Location</option>'
                    ));
                    for (var i = 0; i < obj.length; i++) {
                        $("#location").append($(
                            '<option value=' + obj[i].l_id + '>' + obj[i].l_name + '</option>'
                        ));

                    }
                }
            });

        });
    });
  </script>
            </div>
          	</div>
			 </section>
			   