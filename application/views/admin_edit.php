<!-- Page Heading -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
          <section class="content-header">
            <h1>
              Edit Admin
              <small></small>
            </h1>
            <ol class="breadcrumb">
             <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>admin_master/admin_list"><i class="fa fa-users"></i>Admin</a></li>
              <li class="active">Edit Admin</li>
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
                <?php $attributes = array('class' => '', 'method' => 'post', 'role' => 'form'); ?>

                    <?php echo form_open_multipart('admin_master/admin_edit/' . $id, $attributes); ?>
                    <input type="hidden" name="id" value="<?= $id ?>"/>
                      <div class="box-body">
                    <div class="col-md-6">
						
                            <?php if (isset($unsuccess) != NULL) { ?>
                                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $unsuccess['0']; ?>
                                </div>
                            <?php } ?>
                        
					
				
						<?= validation_errors('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>', '</div>'); ?>

                    <div class="form-group">
                      <label for="exampleInputFile">Admin Name</label><span style="color:red">*</span>
                     <?php //print_r($query); ?>
                      <input type="text"  name="username" class="form-control" value="<?php echo $query[0]['AdminName']; ?>">
                      
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile">Email</label><span style="color:red">*</span>
                      <input type="email"  name="email" class="form-control" value="<?php echo $query[0]['AdminEmail']; ?>">
                      
                    </div>
                    <div class="form-group">
					<label for="exampleInputFile">Password</label><span style="color:red">*</span>
                      <input type="password"  name="password" id="password" class="form-control" value="<?php echo $query[0]['AdminPassword']; ?>">
						<input type="checkbox" id="showHide"> Show Password
                    </div>
					<div class="form-group">
								<img src="<?php echo base_url(); ?>upload/<?php echo $query[0]['profile_pic']; ?>" alt="Profile Pic" style="width:200px; height:150px"/>
								<input type="file" id="exampleInputFile" name="userfile">                    
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
			 