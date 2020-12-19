<script>
			
$(document).ready(function(){ 
	$("#DieselReading").blur(function(){
		 var fname = $("#DieselReading").val();
        if(fname == ""){
          $("#adminnameerror").html(' Diesel Reading is  required.');
			
			document.getElementById("#adminnameerror").style.borderColor="#FF0000"
                      }else{				  
				$("#adminnameerror").html('');
}
    });
	$("#PatrolReading").blur(function(){
		 var fname = $("#PatrolReading").val();
        if(fname == ""){
          $("#PatrolReadingerror").html(' Patrol Reading is  required.');
			
                      }else{				  
				$("#PatrolReadingerror").html('');
}
    });
	$("#TotalAmount").blur(function(){
		 var fname = $("#TotalAmount").val();
        if(fname == ""){
          $("#TotalAmounterror").html('Total Amount is  required.');
			
                      }else{				  
				$("#TotalAmounterror").html('');
}
    });
	$("#meterReading").blur(function(){
		 var fname = $("#meterReading").val();
        if(fname == ""){
          $("#meterReadingerror").html('Meter Reading is  required.');
			
                      }else{				  
				$("#meterReadingerror").html('');
}
    });
	$("#TotalCash").blur(function(){
		 var fname = $("#TotalCash").val();
        if(fname == ""){
          $("#TotalCasherror").html('Total Cash is  required.');
			
                      }else{				  
				$("#TotalCasherror").html('');
}
    });
	$("#TotalCredit").blur(function(){
		 var fname = $("#TotalCredit").val();
        if(fname == ""){
          $("#TotalCrediterror").html('Total Credit is  required.');
			
                      }else{				  
				$("#TotalCrediterror").html('');
}
    });
	$("#TotalExpenses").blur(function(){
		 var fname = $("#TotalExpenses").val();
        if(fname == ""){
          $("#TotalExpensesterror").html('Total Expenses is  required.');
			
                      }else{				  
				$("#TotalExpensesterror").html('');
}
    });
//	$("#Pdetails").blur(function(){
//		 var fname = $("#Pdetails").val();
//        if(fname == ""){
//          $("#Pdetailserror").html('Pump details is  required.');
//			
//                      }else{				  
//				$("#Pdetailserror").html('');
//}
//    });
});	
function validate(){
         var DieselReading = document.forms["savingdata"]["DieselReading"].value;
        var PatrolReading = document.forms["savingdata"]["PatrolReading"].value;
        var TotalAmount = document.forms["savingdata"]["TotalAmount"].value;
        var AdminGender = document.forms["savingdata"]["meterReading"].value;
        var oldpassword = document.forms["savingdata"]["TotalCash"].value;
        var AdminPassword = document.forms["savingdata"]["TotalCredit"].value;
        var cpassword = document.forms["savingdata"]["TotalExpenses"].value;
        var Pdetails = document.forms["savingdata"]["Pdetails"].value;
        //var password = document.forms["savingdata"]["password"].value;
        var temp = 0;
       
        if(DieselReading == ""){
            $("#adminnameerror").html(" Diesel Reading is required.");
            temp++;
        }
	 	if(PatrolReading == ""){
            $("#PatrolReadingerror").html("Patrol Reading is required.");
            temp++;
        }if(TotalAmount == ""){
            $("#TotalAmounterror").html("Total Amount is required.");
            temp++;
        }
	
        if(temp != 0){
        			 return false;     
        }
    }
	
	</script>
    <div class="content-wrapper"><!-- Page Heading -->
<section class="content-header">
    <h1>
        Reading Details
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
                <form role="form" action="<?php echo base_url(); ?>Reading_master/update_details/<?php echo $id ?>" method="post" enctype="multipart/form-data" method="post" name="savingdata" onsubmit="return validate()" id="savingdata" enctype="multipart/form-data">

                    <div class="box-body">
                        <div class="col-md-12">
                            <?php if ($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php } ?>
                            <?php  //echo $this->session->flashdata('success'); ?>
                            <div class="col-md-6">
<h1>
        Reading Details
        <small></small>
    </h1>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile"> DATE</label><span style="color:red">*</span>
                                    <input type="text"  readonly  class="form-control"  value="<?= $query[0]['DATE'] ?>" >
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                </div>
                                
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Diesel Reading</label><span style="color:red">*</span>
                                    <input type="text" onkeypress="return isNumberKey(event)"  class="form-control" placeholder="Diesel Reading" name="DieselReading" id="DieselReading" value="<?= $query[0]['DieselReading'] ?>"/>
                                   
                                    <div class="invalid-feedback" style="color:red;" id="adminnameerror"></div>
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
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">PatrolReading</label><span style="color:red">*</span>    
                 				    	<input type="text" onkeypress="return isNumberKey(event)"  class="form-control"  placeholder="Patrol Reading" name="PatrolReading" id="PatrolReading" value="<?= $query[0]['PatrolReading']  ?>">
                                    
                                    <div class="invalid-feedback" style="color:red;" id="PatrolReadingerror"></div>
                                </div>
                                 <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Meter Reading</label><span style="color:red">*</span>
                 				    	<input type="text" onkeypress="return isNumberKey(event)"  class="form-control"  placeholder="Meter Reading" name="meterReading" id="meterReading" value="<?= $query[0]['meterReading']  ?>">
                                    
                                    <div class="invalid-feedback" style="color:red;" id="meterReadingerror"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Total Amount</label><span style="color:red">*</span>
                 				    	<input type="text" onkeypress="return isNumberKey(event)"  class="form-control"  placeholder="Total Amount" name="TotalAmount" id="TotalAmount" value="<?= $query[0]['TotalAmount']  ?>">
                                   
                                    <div class="invalid-feedback" style="color:red;" id="TotalAmounterror"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Total Cash</label><span style="color:red">*</span>
                 				    	<input type="text" onkeypress="return isNumberKey(event)"  class="form-control"  placeholder="Total Cash" name="TotalCash" id="TotalCash" value="<?= $query[0]['TotalCash']  ?>">
                                  
                                    <div class="invalid-feedback" style="color:red;" id="TotalCasherror"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Total Credit</label><span style="color:red">*</span>
                 				    	<input type="text" onkeypress="return isNumberKey(event)"  class="form-control"  placeholder="Total Credit" name="TotalCredit" id="TotalCredit" value="<?= $query[0]['TotalCredit']  ?>">
                                  
                                    <div class="invalid-feedback" style="color:red;" id="TotalCrediterror"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputFile">Total Expenses</label><span style="color:red">*</span>
                 				    	<input type="text" onkeypress="return isNumberKey(event)"  class="form-control"  placeholder="Total Expenses" name="TotalExpenses" id="TotalExpenses" value="<?= $query[0]['TotalExpenses']  ?>">
                                 
                                    <div class="invalid-feedback" style="color:red;" id="TotalExpensesterror"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <h1>
        Pump Details
        <small></small>
    </h1>
        <?php  //print_r($details); ?>                   
       <?php  foreach($details as $row ) {?>
	                            <div class="form-group has-feedback passdiv" >
                                    <label for="exampleInputFile"><?php echo $row['name'];  $id = $row['name']; ?></label>
                                    <input type="text" onkeypress="return isNumberKey(event)"  id="Pdetails"  name="Pdetails[]" class="form-control"  value="<?php echo $row['Reading']; ?>">

                                  <input type="hidden"  name="id[]" class="form-control"  value="<?php echo $row['pid']; ?>">
                                  <input type="hidden"  name="pid[]" class="form-control"  value="<?php echo $row['id']; ?>">
                                  <input type="hidden"  name="type[]" class="form-control"  value="<?php echo $row['type']; ?>">
                               <div class="invalid-feedback" style="color:red;" id="oldpassworderror"></div>
                                </div>
                                <?php } ?>
                                 <div class="invalid-feedback" style="color:red;" id="Pdetailserror"></div>
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

