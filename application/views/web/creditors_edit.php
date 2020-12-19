
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
					<h3 class="blank1">Edit Creditors</h3>
						<div class="tab-content">


						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>creditors/update/<?php echo $detail->id; ?>/<?php  echo $this->uri->segment('4'); ?>" name="savingdata" onsubmit="return validate()">
								
                                                            <div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Location Name</label>
									<div class="col-sm-8">
                                                                            <select name="l_id" id="l_id" class="form-control1">
                                                                                 <option value="" >  Select Location </option>
                                                                                <?php foreach ($location_list as $loc){ ?>
                                                                                <option value="<?php echo $loc_id =  $loc->l_id; ?>" <?php if($loc_id == $detail->location_id){ echo "selected"; } ?>  >  <?php echo $loc->l_name; ?> </option>
                                                                                <?php } ?> 
                                                                            </select>
										<?php echo form_error('l_id' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>										
                                                                                <div class="invalid-feedback" id="location_error" style="color: red;"></div>
									</div>
								</div>	
                                                            <div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Creditors Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="creditorsname" placeholder="Creditors Name" name="creditorsname" value="<?php echo $detail->name; ?>">
										<?php echo form_error('creditorsname' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="creditorsname_error" style="color: red;"></div>
									</div>
								</div>	
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update</button>
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
function validate(){
    $(".invalid-feedback").html("");
         var title = document.forms["savingdata"]["creditorsname"].value;
          var l_id = document.forms["savingdata"]["l_id"].value;
         
        var temp = 0;
		if(title == ""){
            $("#creditorsname_error").html("Creditors Name is required.");
            temp++;
        }
        if(l_id == ""){
            $("#location_error").html("Location is required.");
            temp++;
        }
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	</script>