
<header class="main-header"> 
    <a href="<?php echo base_url('home') ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Demo</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Demo</b></span>
    </a>
    <nav class="navbar navbar-static-top">

        <div class="navbar-header">


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
                        <img src="<?php echo base_url(); ?><?php if ($logged_in["profile_pic"] == "") {
    echo "dist/img/user2-160x160.jpg";
} else {
    echo "upload/" . $logged_in["profile_pic"];
} ?>" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?php echo ucfirst($logged_in["UserFName"]); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="<?php echo base_url(); ?><?php if ($logged_in["profile_pic"] == "") {
    echo "dist/img/user2-160x160.jpg";
} else {
    echo "upload/" . $logged_in["profile_pic"];
} ?>" class="img-circle" alt="User Image" />
                            <p>
<?php echo ucfirst($logged_in["UserFName"]); ?>
                            </p>
                        </li>
                </li>
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="<?php echo base_url(); ?>user/" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="<?php echo base_url(); ?>LoginAdmin/logout" class="btn btn-default btn-flat">Sign out</a>
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
                <img src="<?php echo base_url(); ?><?php if ($logged_in["profile_pic"] == "") {
    echo "dist/img/user2-160x160.jpg";
} else {
    echo "upload/" . $logged_in["profile_pic"];
} ?>" class="img-circle" alt="<?php echo ucfirst($logged_in["UserFName"]); ?>" />
            </div>

            <div class="pull-left info">
                <p><?php echo ucfirst($logged_in["UserFName"]); ?></p>

            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>


            <li class="treeview ">
                <a href="<?php echo base_url('home'); ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
                </a>

            </li>
            <li class="treeview ">
                <a href="<?php echo base_url('admin_master/admin_list'); ?>">
                    <i class="fa fa-users"></i> <span>Admin List</span> 
                </a>

            </li>
            <li class="treeview">
                <a href="<?php echo base_url('company_master/company_list') ?>">
                    <i class="fa fa-user"></i> <span> Customer List</span>

                </a>

            </li>
            <li class="treeview">
                <a href="<?php echo base_url('queries') ?>">
                    <i class="fa fa-file"></i> <span>  Query List</span>

                </a>

            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>



