<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Easy Admin Panel an Admin Panel Category Flat Bootstrap Responsive Website Template | Home :: w3layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="<?php echo base_url();?>assets1/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo base_url();?>assets1/css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="<?php echo base_url();?>assets1/css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<!-- lined-icons -->
<link rel="stylesheet" href="<?php echo base_url();?>assets1/css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
<!-- chart -->
<script src="<?php echo base_url();?>assets1/js/Chart.js"></script>
<!-- //chart -->
<!--animate-->
<link href="<?php echo base_url();?>assets1/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="<?php echo base_url();?>assets1/js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!----webfonts--->
<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<!---//webfonts---> 
 <!-- Meters graphs -->
<script src="<?php echo base_url();?>assets1/js/jquery-1.10.2.min.js"></script>
<!-- Placed js at the end of the document so the pages load faster -->

</head> 
   
 <body class="sticky-header left-side-collapsed">
    <section>	
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
					<h3 class="blank1">Edit Expense</h3>
						<div class="tab-content">


						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>company_expense/update/<?php echo $detail->id; ?>" name="savingdata" onsubmit="return validate()">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Titile</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="title" placeholder="Name" name="title" value="<?php echo $detail->exps_name; ?>">
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
         
        var temp = 0;
		if(title == ""){
            $("#titleerror").html("Titile is required.");
            temp++;
        }
        if(temp != 0){
        			 return false;     
        }
    }
	
</script>