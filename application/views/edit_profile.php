
<div id="breadcrumbs-wrapper">
<!-- Search for small screen -->
	<div class="header-search-wrapper grey hide-on-large-only">
		<i class="mdi-action-search active"></i>
		<input type="text" placeholder="Explore Materialize" class="header-search-input z-depth-2" name="Search">
	</div>
	<div class="container">
		<div class="row">
			<div class="col s12 m12 l12">
				<h5 class="breadcrumbs-title">Update Profile</h5>
				<ol class="breadcrumbs">
					<li><a href="<?= base_url() ?>clientmaster/home">Dashboard</a></li>
					<li class="active">Edit Profile</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="section">
		<div class="col s12 m12 l12">
			<div class="card-panel">
				<p style="color:red;"><?php if(isset($error)){
				echo $error;
				} ?></p>
				<h4 class="header2">Edit Profile</h4>
				<div class="row">
					<form role="form" action="<?php echo base_url(); ?>clientmaster/profileUpdate" method="post" enctype="multipart/form-data" class="col s12">
						<div class="row">
							<div class="col s12 m12 l8">
								<img src="<?php echo base_url(); ?>upload/<?php echo $query->profile_pic; ?>" alt="Profile Pic" style="width:250px;"/>
								<div class="file-field input-field">
									<div class="btn">
										<span>File</span>
											<input type="file"  name="userfile">     
									</div>
									<div class="file-path-wrapper">
										<input type="text" class="file-path validate valid">
									</div>
								</div>
								<input type="hidden" name="id" class="validate" value="<?php echo $query->id ?>">
								<input type="hidden" name="email1" class="validate" value="<?php echo $query->email ?>">
							<div class="input-field">
								<input type="text" name="email" class="validate" value="<?php echo $query->email ?>">
								<label for="input-text" class="">Email<span style="color:red;">*</span></label>
								<span style="color:red;"><?php echo form_error('email'); ?></span>
							</div>
							<div class="input-field">
								<input type="text" name="company_name" class="validate"  value="<?php echo $query->company_name; ?>">
								<label for="input-text" class="">Company Name <span style="color:red;">*</span></label>
								<span style="color:red;"><?php echo form_error('company_name'); ?></span>
							</div>
														<div class="input-field">
								<input type="text" name="address" class="validate" min="0" value="<?php echo $query->address ?>"  >
								<label for="input-text" class="">Address<span style="color:red;">*</span></label>
								<span style="color:red;"><?php echo form_error('address'); ?></span>
							</div>
							
					<div class="input-field">
								<input type="text" name="city" class="validate" min="0" value="<?php echo $query->city; ?>"  >
								<label for="input-text" class="">City<span style="color:red;">*</span></label>
								<span style="color:red;"><?php echo form_error('city'); ?></span>
							</div>
								<div class="input-field">
								<input type="text" name="state" class="validate" min="0" value="<?php echo $query->state; ?>"  >
								<label for="input-text" class="">State<span style="color:red;">*</span></label>
								<span style="color:red;"><?php echo form_error('state'); ?></span>
							</div>
								<div class="input-field">
								<input type="text" name="postcode" class="validate" min="0" value="<?php echo $query->postcode; ?>"  >
								<label for="input-text" class="">Post code<span style="color:red;">*</span></label>
								<span style="color:red;"><?php echo form_error('postcode'); ?></span>
							</div>
								<div class="input-field">
								<input type="text" name="phone" class="validate" min="0" value="<?php echo $query->phone; ?>"  >
								<label for="input-text" class="">Phone<span style="color:red;">*</span></label>
								<span style="color:red;"><?php echo form_error('phone'); ?></span>
							</div>
	
							
							</div>
						</div>
						<div class="input-field">
						<button class="btn btn-primary" type="submit">Submit</button>
						</div>
						</div>
					
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
 $("#filled-in-box").change(function() {
	var ischecked= $(this).is(':checked');
	if(!ischecked) { 
	  $("#change_div").hide(1000);
	} else { 
	  $("#change_div").show(1000);
	}
}); 
</script>