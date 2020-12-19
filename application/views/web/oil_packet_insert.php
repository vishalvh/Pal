<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

    <!-- left side start-->
		<?php $this->load->view('web/left');?>
		<!-- left side end-->
    
		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<?php $this->load->view('web/header');?>
		<!-- //header-ends -->
			<div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Add oil packet</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>oil_packet/insert" name="savingdata" onsubmit="return validate()">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="pump" placeholder="Oil packet name" name="pump" value="<?php echo set_value('pump');?>">
										<?php echo form_error('pump' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="pumperror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Type (ml,ltr)</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="packet_type" placeholder="Oil packet type" name="packet_type" value="<?php echo set_value('packet_type');?>">
										<?php echo form_error('packet_type' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="packet_typeerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Quantity</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="packet_qty" placeholder="Oil packet quantity" name="packet_qty" value="<?php echo set_value('packet_qty');?>">
										<?php echo form_error('packet_qty' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="packet_qtyeerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Sell Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="packet_value" placeholder="Oil packet buy price" name="packet_value" value="<?php echo set_value('packet_value');?>">
										<?php echo form_error('packet_value' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="packet_valueerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Buy Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="spacket_value" placeholder="Oil packet sell price" name="spacket_value" value="<?php echo set_value('spacket_value');?>">
										<?php echo form_error('packet_value' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="spacket_valueerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Location</label>
									<div class="col-sm-8">
										<select name="sel_loc" id="location" class="form-control1">
										<option value="">Select Location</option>
										<?php 

											foreach ($r->result() as $row) {
												?>
													<option value="<?php echo $row->l_id?>"><?php echo $row->l_name?></option>
												<?php
											}
										?>
										
									</select><div class="invalid-feedback" id="locationerror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Packet Type</label>
									<div class="col-sm-8">
										<select name="sel_p_type" id="ptype" class="form-control1">
										<option value="">Select Packet Type</option>
										<option value="ltr">Ltr</option>
										<option value="ml">Ml</option>
										<option value="kg">Kg</option>
									</select><div class="invalid-feedback" id="ptypeerror" style="color: red;"></div></div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Add</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					
					
  
						
				</div>
			<!-- switches -->
		<div class="switches">
			
		</div>
		<!-- //switches -->
						</div>
			<!--body wrapper start-->
			</div>
			 <!--body wrapper end-->
		</div>
        <!--footer section start-->
			<?php $this->load->view('web/footer');?>
        <!--footer section end-->

      <!-- main content end-->
   </section>
  
<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
</body>
</html>

<script>
			
$(document).ready(function(){ 

	$("#pump").blur(function(){
		var pump = $("#pump").val();
		if(pump == ""){
			$("#pumperror").html("Name is required.");
		}else{
			$("#pumperror").html('');
		}
    }
	);

	$("#packet_type").blur(function(){
		var pumptype = $("#packet_type").val();
		if(pumptype == ""){
			$("#packet_typeerror").html("Oil type is required.");
		}else{
			$("#packet_typeerror").html('');
		}
    });

	$("#location").blur(function(){
		var loc = $("#location").val();
		if(loc == ""){
			$("#locationerror").html("Select location.");
		}else{
			$("#locationerror").html('');
		}
    });
	$("#packet_value").blur(function(){
		var loc = $("#packet_value").val();
		if(loc == ""){
			$("#packet_valueerror").html("Oil Buy value is required.");
		}else{
			$("#packet_valueerror").html('');
		}
    });
	$("#spacket_value").blur(function(){
		var loc = $("#spacket_value").val();
		if(loc == ""){
			$("#spacket_valueerror").html("Oil Sell value is required.");
		}else{
			$("#spacket_valueerror").html('');
		}
    });
	
});	
function validate(){
         var pump = document.forms["savingdata"]["pump"].value;
         var pumptype = document.forms["savingdata"]["packet_type"].value;
         var location = document.forms["savingdata"]["location"].value;
         
		 var packet_value = document.forms["savingdata"]["packet_value"].value;
		 var spacket_value = document.forms["savingdata"]["spacket_value"].value;
         var pumptype = document.forms["savingdata"]["packet_type"].value;
       var sel_p_type = document.forms["savingdata"]["sel_p_type"].value;
       var packet_qty = document.forms["savingdata"]["packet_qty"].value;
        var temp = 0;
       if(packet_qty == ""){
            $("#packet_qtyeerror").html("Packet Quantity is required.");
            temp++;
        }
       if(sel_p_type == ""){
            $("#ptypeerror").html("Packet Type is required.");
            temp++;
        }
		if(pump == ""){
            $("#pumperror").html("Name is required.");
            temp++;
        }
        if(pumptype == ""){
            $("#packet_typeerror").html("Oil type is required.");
            temp++;
        }
		if(packet_value == ""){
            $("#packet_valueerror").html("Oil Buy value is required.");
            temp++;
        }
		if(spacket_value == ""){
            $("#spacket_valueerror").html("Oil Sell value is required.");
            temp++;
        }
        if(location == ""){
            $("#locationerror").html("Select Location.");
            temp++;
        }
		
		
        if(temp != 0){
        			 return false;     
        }
    }
	</script>