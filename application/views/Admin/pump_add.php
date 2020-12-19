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
        var type = document.forms["savingdata"]["type"].value;
        var temp = 0;
       
        if(Adminname == ""){
            $("#adminnameerror").html("Pump Name is required.");
            temp++;
        }
	 	if(type == ""){
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
              Add Pump
              <small></small>
            </h1>
            <ol class="breadcrumb">
				<li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>Pump_master/pump_list"><i class="fa fa-users"></i>Pump</a></li>
              <li class="active">Add Pump</li>
          
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
                <form role="form" action="<?php echo base_url(); ?>Pump_master" method="post" name="savingdata" onsubmit="return validate()" id="savingdata" enctype="multipart/form-data">
					
                  <div class="box-body">
                    <div class="col-md-6">
						
						<div class="form-group">
                      <label for="exampleInputFile"> Pump Name</label><span style="color:red">*</span>
                      <input type="text" id="Adminname"  name="Adminname" class="form-control"  value="<?php echo set_value('username'); ?>" >
                      <?php echo form_error('Adminname', '<div class="error" style="color:red;">', '</div>'); ?>
                      <div class="invalid-feedback" style="color:red;" id="adminnameerror"></div>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputFile">Type</label><span style="color:red">*</span>
                      <select class="form-control" id="type" name="type" >
                       <option value="P">Patrol</option>
                       <option value="D">Diesel</option> </select>
                       <div class="invalid-feedback" style="color:red;" id="mobileerror"></div>
                    </div>
                 
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
			 