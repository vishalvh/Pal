
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
					<h3 class="blank1">Edit Company Daily Maintain Edit</h3>
						<div class="tab-content">


						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>company_daily_maintain/update/<?php echo $detail->id; ?>/<?php  echo $this->uri->segment('4'); ?>" name="savingdata" onsubmit="return validate()">
							<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Location</label>
									<div class="col-sm-8">
										<select name="sel_loc" id="location" class="form-control1">
										<option value="">Select Location</option>
										<?php foreach ($r->result() as $row) { ?>
											<option value="<?php echo $row->l_id?>" <?php if($row->l_id == $detail->location_id) { echo "selected";  } ?>><?php echo $row->l_name?></option>
										<?php } ?>
										
									</select><div class="invalid-feedback" id="locationerror" style="color: red;"></div></div>
								</div>
							
							
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Titile</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="title" placeholder="Name" name="title" value="<?php echo $detail->name; ?>">
										<?php echo form_error('title' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="titleerror" style="color: red;"></div>
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

<script type="text/javascript">

	function validate(){
         var title = document.forms["savingdata"]["title"].value;
         var location = document.forms["savingdata"]["location"].value;
        var temp = 0;
		if(title == ""){
            $("#titleerror").html("Titile is required.");
            temp++;
        }
		if(location == ""){
            $("#locationerror").html("Location is required.");
            temp++;
        }
        if(temp != 0){
        			 return false;     
        }
    }
	
</script>