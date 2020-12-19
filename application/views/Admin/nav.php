
<header class="main-header"> 
    <a href="<?php echo base_url('Userhome') ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>Shree Hari</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Shree Hari</b></span>
        </a>
    <nav class="navbar navbar-static-top">
 
            <div class="navbar-header">
     
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

      
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="<?php echo base_url(); ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?php echo ucfirst($logged_in["AdminName"]); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="<?php echo base_url(); ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                            <p>
                                <?php echo ucfirst($logged_in["AdminName"]); ?>
                            </p>
                        </li>
                        <li class="user-footer">
  <div class="pull-left">
                      <a href="<?php echo base_url('Userhome/profile')?>" class="btn btn-default btn-flat">Profile</a>
                    </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url(); ?>Userhome/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-custom-menu -->

    </nav>
</header>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('dist/img/user2-160x160.jpg')?>" class="img-circle" alt="<?php echo ucfirst($logged_in["AdminName"]); ?>" />
            </div>
             
            <div class="pull-left info">
                <p><?php echo ucfirst($logged_in["AdminName"]); ?></p>

            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            
<li class="treeview ">
              <a href="<?php echo base_url('Userhome'); ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
              </a>
             
            </li>
            <li class="treeview ">
              <a href="<?php echo base_url('company/company_list'); ?>">
                <i class="fa fa-user"></i> <span>Company List</span> 
              </a>
             
            </li>
            <li class="treeview ">
              <a href="<?php echo base_url('employee'); ?>">
                <i class="fa fa-user"></i> <span>Employee List</span> 
              </a>
            </li>
            
            <li class="treeview ">
              <a href="<?php echo base_url('location'); ?>">
                <i class="fa fa-user"></i> <span>Location List</span> 
              </a>
            </li>
            <li class="treeview ">
              <a href="<?php echo base_url('pumplist_admin'); ?>">
                <i class="fa fa-user"></i> <span>Pump List</span> 
              </a>
             
            </li>
            <li class="treeview ">
              <a href="<?php echo base_url('admin_expenses'); ?>">
                <i class="fa fa-user"></i> <span>Expences List</span> 
              </a>
             
            </li>
            <li class="treeview ">
              <a href="<?php echo base_url('admin_workes'); ?>">
                <i class="fa fa-user"></i> <span>Workers</span> 
              </a>
             
            </li>

            <li class="treeview">
                <a href="#"><i class="fa fa-files-o"></i> <span>Reports</span>
                    <span class="pull-right-container">
                        <i class=""></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="">
                    <li class="treeview ">
                        <a href="<?php echo base_url('Inwardreport'); ?>">
                            <i class="fa fa-user"></i> <span>Inward Report</span> 
                        </a>
             
                    </li>
                    <li class="treeview ">
                      <a href="<?php echo base_url('admin_readingreport'); ?>">
                        <i class="fa fa-user"></i> <span>Reading  Report</span> 
                      </a>
                    </li>
                    <li class="treeview ">
                      <a href="<?php echo base_url('admin_bankdeposit'); ?>">
                        <i class="fa fa-user"></i> <span>Bank Deposit Report</span> 
                      </a>
                     
                    </li>
                    <li class="treeview ">
                      <a href="<?php echo base_url('admin_expense'); ?>">
                        <i class="fa fa-user"></i> <span>Expense Report</span> 
                      </a>
                     
                    </li>
                    <li class="treeview ">
                      <a href="<?php echo base_url('admin_onlinetransaction'); ?>">
                        <i class="fa fa-user"></i> <span>Online Transaction Report</span> 
                      </a>
                     
                    </li>
                    <li class="treeview ">
                      <a href="<?php echo base_url('admin_creditdebit'); ?>">
                        <i class="fa fa-user"></i> <span>Credit Debit Report</span> 
                      </a>
                     
                    </li>
                </ul>
            </li>

             
<!--
            <li class="treeview">
                <a href="<?php echo base_url('Userhome/query') ?>">
                    <i class="fa fa-edit"></i> <span>Submit Query</span>
                  
                </a>

            </li>
-->

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>


  
    

  <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Submit Your Query </h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <?php $attributes = array('class' => 'form-horizontal', 'method' => 'get', 'role' => 'form', 'id' => 'registration_data'); ?>

                        <?php echo form_open('Userhome/query_add', $attributes); ?>


                        <div class="form-group">
                            <label for="title">Subject <span class="required-text">(Required)</span></label>
                            <input type="text" class="form-control" name="title" placeholder="Subject" value="" id="title"  />
                            <div class="invalid-feedback" id="titleerror"></div>
                        </div>

                        <div class="form-group">
                            <label for="detail">Your Message <span class="required-text">(Required)</span></label>
                            <textarea class="form-control" name="description" placeholder="Your Message" id="detail"></textarea>
                            <div class="invalid-feedback" id="detailerror"></div>
                        </div>








                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" value="Submit" class="btn btn-primary btn-md" onclick="add_query();">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>

        </div>
    </div>
 