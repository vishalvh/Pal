<!DOCTYPE HTML>
<?php if($this->session->userdata('logged_company')['type'] == 'c'){
			$sesid = $this->session->userdata('logged_company')['id'];
			$this->data['all_location_list'] = $this->user_login->get_all_location($sesid);
			$this->data['user_permission_list'] = $this->user_login->getAllPermission();
		}else{
			$sesid = $this->session->userdata('logged_company')['u_id'];
			$this->data['all_location_list'] = $this->user_login->get_location($sesid);
			$this->data['user_permission_list'] = $this->user_login->getUserPermission($sesid);
		}
		?>
<html>
    <head>
        <title>PAl Oil</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>/assets/img/icon/18.png">
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url(); ?>assets1/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <!-- Custom CSS -->
        <link href="<?php echo base_url(); ?>assets1/css/style.css" rel='stylesheet' type='text/css' />
        <!-- Graph CSS -->
        <link href="<?php echo base_url(); ?>assets1/css/font-awesome.css" rel="stylesheet"> 
        <!-- jQuery -->
        <!-- lined-icons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets1/css/icon-font.min.css" type='text/css' />
        <!-- //lined-icons -->
        <!-- chart -->
        <script src="<?php echo base_url(); ?>assets1/js/Chart.js"></script>
        <!-- //chart --> 
        <!--animate-->
        <link href="<?php echo base_url(); ?>assets1/css/animate.css" rel="stylesheet" type="text/css" media="all">
        <script src="<?php echo base_url(); ?>assets1/js/wow.min.js"></script>
        <link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
        <script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
        <script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>

        <!--//end-animate-->
        <!----webfonts--->
        <link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
        <!---//webfonts---> 
        <!-- Meters graphs -->
        <script src="<?php echo base_url(); ?>assets1/js/jquery-1.10.2.min.js"></script>
        <!-- Placed js at the end of the document so the pages load faster -->
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>/assets/img/icon/18.png">
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url(); ?>assets1/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <!-- Custom CSS -->
        <link href="<?php echo base_url(); ?>assets1/css/style.css" rel='stylesheet' type='text/css' />
        <!-- Graph CSS -->
        <!--<link href="<?php echo base_url(); ?>assets1/css/font-awesome.css" rel="stylesheet">--> 
        <link href="<?php echo base_url(); ?>assets1/css/font-awesome.min.css" rel="stylesheet"> 
        <!-- jQuery -->
        <!-- lined-icons -->
        <!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/css/icon-font.min.css" type='text/css' />-->
        <!-- //lined-icons -->
        <!-- chart -->
        <script src="<?php echo base_url(); ?>assets1/js/Chart.js"></script>
        <!-- //chart -->
        <!--animate-->
        <link href="<?php echo base_url(); ?>assets1/css/animate.css" rel="stylesheet" type="text/css" media="all">
        <script src="<?php echo base_url(); ?>assets1/js/wow.min.js"></script>

        <!--//end-animate-->
        <!----webfonts--->
        <!--<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>-->
        <!---//webfonts---> 
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <!--<link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->


        <!-- Meters graphs -->
<!--	<script src="<?php echo base_url(); ?>assets1/js/jquery-1.10.2.min.js"></script>-->
        <!-- Placed js at the end of the document so the pages load faster -->
<!--	<script src="<?php echo base_url(); ?>assets1/jQuery/jQuery-2.1.4.min.js"></script>-->

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <div class="modal2" id="arrowLoader" style="display: none;"></div>
        <script>
            $("#arrowLoader").show();</script>
    <style>
        .modal2{ 
            background: rgba(0, 0, 0, 0.5) url("http://tasktrigger.com/assets/small-loading.gif") no-repeat scroll 50% 50%; 
            height: 100%; 
            left: 0; 
            position: fixed; 
            top: 0; 
            width: 100%; 
            z-index: 100000; 
        }
    </style>
</head> 

<body>
    <section>	
        <div class="main-menu">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                        
                        </button>
                        <a class="navbar-brand" href="<?php echo base_url(); ?>main/dashboard"><h4><span>Pal</span>Oil</h4></a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">     
                        <ul class="nav navbar-nav list_ul">

                                <li class="dropdown active">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="lnr lnr-database"></i>
                                        <span>Master</span><i class="lnr lnr-chevron-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <?php if(in_array("location_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>admin_location">Location List</a> </li>
									<?php } ?>
									<?php if(in_array("employee_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>admin">Employee List</a> </li>
									<?php } ?>
									<?php if(in_array("worker_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>company_worker">Worker</a> </li>
									<?php } ?>
									<?php if(in_array("expense_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>company_expense">Expense</a> </li>
									<?php } ?>
									<?php if(in_array("tank_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>tank_list">Tank List</a> </li>
									<?php } ?>
									<?php if(in_array("pump_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>admin_pump">Pump List</a> </li>
									<?php } ?>
									<?php if(in_array("oil_packet_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>oil_packet">Oil Packet List</a> </li>
									<?php } ?>
									<?php if(in_array("customer_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>manage_customer">Manage Customer</a> </li>
									<?php } ?>
									<?php if(in_array("creditors_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>creditors">Creditors</a> </li>
									<?php } ?>
									<?php if(in_array("wallet_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>wallet">Wallet</a> </li>
									<?php } ?>
									<?php if(in_array("moderator_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>madetor">Moderator</a> </li>
									<?php } ?>
									<?php if(in_array("reset_pump_list",$this->data['user_permission_list'])){ ?>
                                        <li><a href="<?php echo base_url(); ?>reset_pump">Reset Pump</a> </li>
									<?php } ?>
									<?php if(in_array("sales_vat_list",$this->data['user_permission_list'])){ ?>
                                       <li><a href="<?php echo base_url(); ?>vat">Sales Vat</a> </li>
									<?php } ?>
									<?php if(in_array("card_list",$this->data['user_permission_list'])){ ?>
                                       <li><a href="<?php echo base_url(); ?>Saving_card">Card</a> </li>
									<?php } ?>
									<?php if(in_array("daily_maintain_list",$this->data['user_permission_list'])){ ?>
									   <li><a href="<?php echo base_url(); ?>company_daily_maintain">Maintain</a> </li>
									<?php } ?>
									<?php if(in_array("message",$this->data['user_permission_list'])){ ?>
									   <li><a href="<?php echo base_url(); ?>message_master">Message</a> </li>
									<?php } ?>
                                    </ul>
                                </li>
                           
<!--                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="lnr lnr-list"></i>
                                    <span>Reports</span><i class="lnr lnr-chevron-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url(); ?>expense">Expense Report</a> </li>
                                    <li><a href="<?php echo base_url(); ?>sales_reports">Sales Report</a> </li>
                                   <li><a href="<?php echo base_url(); ?>bank_deposit">Bank Report</a> </li>
                                    <li><a href="<?php echo base_url(); ?>worker_salary">Salary Report</a> </li>
                                </ul> 
                            </li>-->
<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="lnr lnr-list"></i>
								<span>Reports</span><i class="lnr lnr-chevron-down"></i></a>
								<ul class="dropdown-menu">
								<?php if(in_array("expense_report",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>expense">Expense Report</a> </li>
								<?php } ?>
								<?php if(in_array("daily_report",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>daily_reports_new">Daily Report</a> </li>
								<?php } ?>
								<?php if(in_array("sales_report",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>sales_reports">Sales Report</a> </li>
								<?php } ?>
								<?php if(in_array("bank_report",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>bank_deposit">Bank Report</a> </li>
								<?php } ?>
								<?php if(in_array("salary_report",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>worker_salary">Salary Report</a> </li>
								<?php } ?>
								<?php if(in_array("daily_cash_report",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>daily_cash_report">Daily cash Report</a> </li>
								<?php } ?>
								<?php if(in_array("dsr_report",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>MS_DSH_sales_reports">DSR Report</a> </li>
								<?php } ?>
								<?php if(in_array("oil_stock_report",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>oil_packet/check_oil_stock">Oil Stock Report</a> </li>
								<?php } ?>
								<?php if(in_array("inventory_report",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>daily_reports_new_jun/inventoryreport">Inventory Report</a> </li>
								<?php } ?>
								<?php if(in_array("company_daily_maintain",$this->data['user_permission_list'])){ ?>
									 <li><a href="<?php echo base_url();?>company_daily_maintain_report">Company daily maintain report</a> </li>
								<?php } ?>
								<?php if(in_array("company_daily_density_report",$this->data['user_permission_list'])){ ?>
								 <li><a href="<?php echo base_url();?>company_daily_density_report">Density record report</a> </li>
								<?php } ?>
								<?php if(in_array("company_tank_daily_density_report",$this->data['user_permission_list'])){ ?>
								 <li><a href="<?php echo base_url();?>company_daily_tank_density_report">TT retention sample record</a> </li>
								<?php } ?>
								<?php if(in_array("tanker_variation_report",$this->data['user_permission_list'])){ ?>
								 <li><a href="<?php echo base_url();?>tankor_entory_report">Tanker Variation Report</a> </li>
								<?php } ?>
								<?php if(in_array("profit_lost_report",$this->data['user_permission_list'])){ ?>
								 <li><a href="<?php echo base_url(); ?>daily_reports_new_jun/profit_loss_report">Profit Lost Report</a> </li>
								 <?php } ?>
								</ul> 
						</li>
                            
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="lnr lnr-list"></i>
                                    <span>Invoice</span><i class="lnr lnr-chevron-down"></i></a>
                                <ul class="dropdown-menu">
								<?php if(in_array("invoice_report",$this->data['user_permission_list'])){ ?>		
									<li><a href="<?php echo base_url(); ?>credit_debit">Invoice</a> </li>
                                <?php } ?>
								<?php if(in_array("daily_invoice_report",$this->data['user_permission_list'])){ ?>
									<li><a href="<?php echo base_url(); ?>daily_invoice">Daily Invoice</a> </li>
                                <?php } ?>
								<?php if(in_array("credit_debit_report",$this->data['user_permission_list'])){ ?>    
									<li><a href="<?php echo base_url();?>credit_debit/report">Credit Debit</a> </li> 
								<?php } ?>	
                                </ul> 
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="lnr lnr-list"></i>
                                    <span>Petty Cash</span><i class="lnr lnr-chevron-down"></i></a>
									<ul class="dropdown-menu">
                                    <?php if(in_array("petty_cash_member_list",$this->data['user_permission_list'])){ ?>
                                     <li><a href="<?php echo base_url(); ?>petty_cash_member">Petty Cash Member</a> </li>
                                     <?php } ?>
									<?php if(in_array("petty_cash_report",$this->data['user_permission_list'])){ ?>
                                    <li><a href="<?php echo base_url(); ?>petty_cash_report">Petty Cash Report</a> </li>
                                    <?php } ?>
                                </ul> 
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="lnr lnr-list"></i>
                                    <span>Saving</span><i class="lnr lnr-chevron-down"></i></a>
                                <ul class="dropdown-menu">
                                     <?php if(in_array("saving_member_list",$this->data['user_permission_list'])){ ?>
                                     <li><a href="<?php echo base_url(); ?>saving_member">Saving member</a> </li>
                                     <?php } ?>
									 <?php if(in_array("saving_member_report",$this->data['user_permission_list'])){ ?>
                                    <li><a href="<?php echo base_url();?>saving_member_report">Saving report</a> </li>
									<?php } ?>
                                    
                                </ul> 
                            </li>
							<?php if(in_array("stock_patrak_report",$this->data['user_permission_list'])){ ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="lnr lnr-list"></i>
                                    <span>Stock Patrak</span><i class="lnr lnr-chevron-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url(); ?>stock_patrak">Stock Patrak</a> </li>
                                </ul> 
                            </li>
							<?php } ?>
							
							<?php if(in_array("company_report",$this->data['user_permission_list'])){ ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="lnr lnr-list"></i>
                                    <span>Company Report</span><i class="lnr lnr-chevron-down"></i></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($this->data['all_location_list'] as $location_lists) { ?>
                                        <li><a href="<?php echo base_url(); ?>company_report?location=<? echo $location_lists->l_id; ?>"><?php echo $location_lists->l_name; ?></a> </li>
                                    <?php } ?>
                                </ul>
                            </li>
							<?php } ?>

                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown profile_details_drop">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <div class="profile_img">	
                                            <!--<span style="background:url(images/1.jpg) no-repeat center"> </span>--> 
                                        <div class="user-name cpm">
                                            <p><?php echo $logged_company["name"]; ?><span>Company</span><i class="lnr lnr-chevron-down"></i></p>
                                        </div>
                                        <!--<i class="lnr lnr-chevron-down"></i>
                                        <i class="lnr lnr-chevron-up"></i>-->
                                        <div class="clearfix"></div>	
                                    </div>	
                                </a>
                                <ul class="dropdown-menu drp-mnu">


                                    <li> <a href="<?php echo base_url() ?>admin/change_pass"><i class="fa fa-cog"></i>Change Password</a> </li> 
                                    <li> <a href="<?php echo base_url() ?>admin/update_profile"><i class="fa fa-user"></i>Profile</a> </li> 
                                    <li> <a href="<?php echo base_url(); ?>main/logout"><i class="fa fa-sign-out"></i> Logout</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
