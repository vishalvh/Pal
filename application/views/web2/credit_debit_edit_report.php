<?php
	$start_date = $this->uri->segment('4');
	$end_date =  $this->uri->segment('5');
	$location_id = $this->uri->segment('6');
	$customer_id = $this->uri->segment('7');
?>
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
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
   <script type='text/javascript'>
    $(document).ready(function() {
        var d = new Date();
        var n = d.getFullYear();

        $("#datepicker1").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "1918:n",
            dateFormat: "yy-mm-dd",
            defaultDate: 'today',
            maxDate: 'today',
            onSelect: function() {
                var date = $('#datepicker2');
                var minDate = $(this).datepicker('getDate');
                date.datepicker('option', 'minDate', minDate);
            }
        });
        $("#datepicker2").datepicker({

            changeMonth: true,
            changeYear: true,
            yearRange: "1918:n",
            dateFormat: "yy-mm-dd",
            defaultDate: 'today',
            maxDate: 'today'
        });


    });
    $(document).ready(function() {
        $("#start_date").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1918:n",

            onSelect: function() {
                var date = $('#date');

                var minDate = $(this).datepicker('getDate');

                date.datepicker('option', 'minDate', minDate);
            }
        });
        $('#date').datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
        });
    });
</script>
 <body class="sticky-header left-side-collapsed"  onload="initMap()">
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
					<h3 class="blank1">Update Data</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>credit_debit/update/<?php echo $query[0]->id;?>/<?php echo $start_date?>/<?php echo $end_date?>/<?php echo $location_id?>/<?php echo $customer_id?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">

								<!-- <div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" id="date" name="date" value="<?php echo $query[0]->date?>">
										<div class="invalid-feedback" id="dateerror" style="color: red;"></div>
									</div>
								</div> -->
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input type="text" id="date"  readonly class="form-control end_date" name="date" placeholder="Date" value="<?php echo date('d-m-Y',strtotime($query[0]->date))?>" />
										<div class="invalid-feedback" id="dateerror" style="color: red;"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Payment type<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<select name="type" id="type" class="form-control1" onchange="p_type()">
											<option value="">Select type</option>
											<option value="c" 
											<?php 
											if ($query[0]->payment_type == "c") 
											{
												echo "selected";
											}
											?>
											>Credit</option>
											<option value="d" 
											<?php 
											if ($query[0]->payment_type == "d") 
											{
												echo "selected";
											}
											?>
											>Debit</option>
										</select>
										<div class="invalid-feedback" id="typeerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group" id="payment_type">
									<label for="focusedinput" class="col-sm-2 control-label">Transaction type<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<select name="ptype" id="ptype" class="form-control1">
											<option value="">Select type</option>
											<option value="cs"
											<?php 
											if ($query[0]->transaction_type == "cs") 
											{
												echo "selected";
											}
											?>
											>Cash</option>
											<option value="c"
											<?php 
											if ($query[0]->transaction_type == "c") 
											{
												echo "selected";
											}
											?>
											>Cheque</option>
											<option value="n"
											<?php 
											if ($query[0]->transaction_type == "n") 
											{
												echo "selected";
											}
											?>
											>Netbanking</option>
										</select>
										<div class="invalid-feedback" id="ttypeerror" style="color: red;"></div>
									</div>
								</div>
								

								<div class="form-group" id="bill_no12">
									<label for="focusedinput" class="col-sm-2 control-label">Bill No<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input placeholder="Bill No" type="text" class="form-control1" id="bill_no" name="bill_no" value="<?= $query[0]->bill_no?>">
										<div class="invalid-feedback" id="bill_noerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Amount<span style="color: red">*</span></label>
									<div class="col-sm-8">
										<input type="text" placeholder="Amount" class="form-control1" id="amount" name="amount" value="<?= $query[0]->amount?>">
										<div class="invalid-feedback" id="amounterror" style="color: red;"></div>
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
         var date = document.forms["savingdata"]["date"].value;
         var type = document.forms["savingdata"]["type"].value;
         var type1 = $("#type").val();
         var amount = document.forms["savingdata"]["amount"].value;
         var ptype = document.forms["savingdata"]["ptype"].value;
     	 var bill_no = document.forms["savingdata"]["bill_no"].value;
         var temp = 0;
       if(date == ""){
            $("#dateerror").html("Date is required.");
            temp++;
        }
        else
        {
        	$("#dateerror").html("");
        }
        if(type == ""){
            $("#typeerror").html("Select atleast one option.");
            temp++;
        }
        else
        {
        	$("#typeerror").html("");
        }
        if (type1 == "d") {
	        if(ptype == ""){
	            $("#ttypeerror").html("Select atleast one option.");
	            temp++;
	        }
	        else
	        {
	        	$("#ttypeerror").html("");
	        }
	    }
        if(amount == ""){
            $("#amounterror").html("Amount is required.");
            temp++;
        }
        else{
        	$("#amounterror").html("");
        }
        if (type1 == "c") {
        if(bill_no == ""){
            $("#bill_noerror").html("Bill number is required.");
            temp++;
        }
        else{
        	$("#bill_noerror").html("");
        }
    }
		
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			var type = $("#type").val();
			if (type == "d") {
				$("#payment_type").show();
			}else{
				$("#payment_type").hide();
			}

			if (type == "d") {
				$("#bill_no12").hide();
			}else{
				$("#bill_no12").show();
			}
		});
		function p_type()
		{
			var type = $("#type").val();
			
			if (type == "d") {
				$("#payment_type").show();
			}else{
				$("#payment_type").hide();
			}

			if (type == "d") {
				$("#bill_no12").hide();
			}else{
				$("#bill_no12").show();
			} 	
		}
		
	</script>