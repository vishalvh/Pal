<header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="">
            <div class="navbar-header">
              <a href="<?php echo base_url(); ?>home" class="navbar-brand">Info Gujarat</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
               <li class="active"><a href="<?php echo base_url(); ?>admin_master/admin_list">Admin <span class="sr-only">(current)</span></a></li>
          <!--      <li><a href="<?php echo base_url(); ?>user_master/all">User</a></li>
				   <li><a href="<?php echo base_url(); ?>gov_master/all">Company</a></li>
                --><li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo base_url(); ?>category_master/category_list">Category</a></li>
					  <li class="divider"></li>
                    <!--<li><a href="<?php echo base_url(); ?>subcategory_master/subcategory_list">Subcategory</a></li>
					  <li class="divider"></li>-->
<!--                    <li><a href="<?php echo base_url(); ?>location_master/location_list">Location</a></li>
						<li class="divider"></li>-->
                    <li><a href="<?php echo base_url(); ?>company_master/company_list">Doctor</a></li>
                    <li class="divider"></li>
                     <li><a href="<?php echo base_url(); ?>area_master/area_list">Area List</a></li>
			<li class="divider"></li>
                     <li><a href="<?php echo base_url(); ?>specialist_master/specialist_list">Specialist List</a></li>
                     <li class="divider"></li>
                     <li><a href="<?php echo base_url(); ?>Contact_us_master/Contact_us_list">Contact Us List</a></li>
			<li class="divider"></li>
	    <li><a href="<?php echo base_url(); ?>qualification_master/qualification_list">Qualification List</a></li>
	    <li class="divider"></li>
		    <li><a href='javascript:void(0)' data-toggle="modal"  data-target="#importlogo">Logo Upload</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Advertise<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo base_url(); ?>advertise_master/home_page" >Home Advertise</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url(); ?>advertise_master/category_page" >Category Advertise</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url(); ?>advertise_master/reg_page" >Registration Advertise</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url(); ?>admin_master/remove_all_data" onclick="return confirm('Are you sure you want to remove all data?');">Delete Data</a></li>
		  </ul>
                </li>
               <li class="active"><a href="<?php echo base_url(); ?>company_master/database_backup" data-toggle="modal"  data-target="">Data Base Backup <span class="sr-only">(current)</span></a></li>

              </ul>
              <?php /*<form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                  <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                </div>
              </form>   */ ?>                       
            </div><!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- Messages: style can be found in dropdown.less-->
                  

                  
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <img src="<?php echo base_url(); ?>upload/<?php echo $login_data["profile_pic"]; ?>" class="user-image" alt="User Image"/>
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><?php
										                         
                          echo ucfirst($logged_in["AdminName"]); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                        <img src="<?php echo base_url(); ?>upload/<?php echo $login_data["profile_pic"]; ?>" class="img-circle" alt="User Image" />
                        <p>
                         <?php
									     echo ucfirst($login_data["name"]); ?>
                        </p>
                      </li>
                      <!-- Menu Body -->
                      
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="<?php echo base_url(); ?>user/" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                          <a href="<?php echo base_url(); ?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="">
<div class="modal fade" id="importlogo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="H4">Company Logo</h4>
                    </div>
                    <div class="modal-body"> 
                        <?php $attributes = array('class' => 'form-horizontal', 'method' => 'POST'); ?>
                        <?php
                        echo form_open_multipart('company_master/importcompanylogo', $attributes);
                        $validate_array1 = array("imageform", "admin_add_email", "admin_add_password", "admin_add_type");
                        ?>
                        <div class="box-body form-group">
						
                            <label>Upload</label>
<input type="file" class="" name="userfile[]" multiple>
                            <div style='color:red;' id='admin_name_add_alert'></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="model_close" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <input type="submit" id="add_admin_submit" name="add_menu" class="btn btn-primary" value="Add"/>
                            
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
