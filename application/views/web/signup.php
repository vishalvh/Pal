
<html>
<head>
<title>Pal Oil Company Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="<?php echo base_url();?>assets1/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo base_url();?>assets1/css/style.css" rel='stylesheet' type='text/css' />
<link href="<?php echo base_url();?>assets1/css/bootstrap-chosen.css" rel='stylesheet' type='text/css' />
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
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<!-- Placed js at the end of the document so the pages load faster -->

</head> 
   
 <body class="sign-in-up login-page register-page">
    <section>
			<div id="page-wrapper" class="sign-in-wrapper">
				<div class="graphs">
					<div class="sign-in-form">
						
						<div class="signin">
						   <div class="sign-in-form-top">
							<p><span>Sign</span> <a href="">Up</a></p>
						</div>
							
							<form method="post" action="<?php echo base_url();?>main/login_validation" onsubmit="return validate()" name="savingdata">
							
							<div class="log-input">
								<div class="log-input-center">
								   <input placeholder="Organization Name"  type="text" class="user" name="organization" value="" />
								  
								   <div class="invalid-feedback"  style="color: red;"></div>
								</div>
								
							</div>
							
							<div class="log-input">
								<div class="log-input-center">
								    <input placeholder="Email Id"  type="text" class="user" name="" value="" />
								  
								   <div class="invalid-feedback"  style="color: red;"></div>
								</div>
								
							</div>
							<div class="log-input">
								<div class="log-input-center">
								    <input placeholder="Password"  type="text" class="user" name="" value="" />
								  
								   <div class="invalid-feedback"  style="color: red;"></div>
								</div>
								
							</div>
							<div class="log-input">
								<div class="log-input-center">
								    <input placeholder="Confirm Password"  type="text" class="user" name="" value="" />
								  
								   <div class="invalid-feedback"  style="color: red;"></div>
								</div>
								
							</div>
							
							<div class="log-input">
								<div class="log-input-center">
								    <input placeholder="Contact Person"  type="text" class="user" name="" value="" />
								  
								   <div class="invalid-feedback"  style="color: red;"></div>
								</div>
								
							</div>
							<div class="log-input">
								<div class="log-input-center">
								    <input placeholder="Contact Number"  type="text" class="user" name="" value="" />
								  
								   <div class="invalid-feedback"  style="color: red;"></div>
								</div>
								
							</div>
							<div class="log-input-center">
							  <div class="number">
							   <div class="select_style" id="shdsd">
									<select>
										<option>India</option>
										<option>India</option>
										<option>India</option>
										<option>India</option>
									</select>
								</div>
								<input placeholder="Contact Number"  type="text" class="user" name="" value="" />
							  </div>
							</div>
							<div class="log-input">
								<div class="log-input-center">
								   <textarea placeholder="Address" class="user"></textarea>
								  
								   <div class="invalid-feedback"  style="color: red;"></div>
								</div>
								
							</div>
							<div class="log-input regstr">
								
								<span>You have already member please <a class='' href="#">Login</a></span>
								
							</div>
							<input class="center-block" type="submit" name="submit" value="Sign up">
						</form>	 
						</div>
						
					</div>
				</div>
			</div>
		
	</section>
	<script>


$.fn.ulSelect = function(){
  var ul = $(this);

  if (!ul.hasClass('zg-ul-select')) {
    ul.addClass('zg-ul-select');
  }
  // SVG arrow
  var arrow = '<svg id="ul-arrow" xmlns="http://www.w3.org/2000/svg" version="1.1" width="15" height="15" viewBox="0 0 32 32"><line stroke-width="1" x1="" y1="" x2="" y2="" stroke="#449FDB" opacity=""/><path d="M4.131 8.962c-0.434-0.429-1.134-0.429-1.566 0-0.432 0.427-0.432 1.122 0 1.55l12.653 12.528c0.434 0.429 1.133 0.429 1.566 0l12.653-12.528c0.432-0.429 0.434-1.122 0-1.55s-1.136-0.429-1.566-0.002l-11.87 11.426-11.869-11.424z" fill="#111"/></svg>';
  $('li:first-of-type', this).addClass('active').append(arrow);
  $(this).on('click', 'li', function(event){
    
    // Remove div#selected if it exists
    if ($('#selected--zg-ul-select').length) {
      $('#selected--zg-ul-select').remove();
    }
    ul.before('<div id="selected--zg-ul-select">');
    var selected = $('#selected--zg-ul-select');
    $('li #ul-arrow', ul).remove();
    ul.toggleClass('active');
    // Remove active class from any <li> that has it...
    ul.children().removeClass('active');
    // And add the class to the <li> that gets clicked
    $(this).toggleClass('active');

    var selectedText = $(this).text();
    if (ul.hasClass('active')) {
      selected.text(selectedText).addClass('active').append(arrow);
    }
    else {
      selected.text('').removeClass('active'); 
      $('li.active', ul).append(arrow);
    }
    });
    
    // Close the faux select menu when clicking outside it 
    $(document).on('click', function(event){
    if($('ul.zg-ul-select').length) {
     if(!$('ul.zg-ul-select').has(event.target).length == 0) {
      return;
    }
    else {
      $('ul.zg-ul-select').removeClass('active');
      $('#selected--zg-ul-select').removeClass('active').text('');
      $('#ul-arrow').remove();
      $('ul.zg-ul-select li.active').append(arrow);
    } 
    }
    });
  }

// Run
$('#be-select').ulSelect();
	</script>
<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
</body>
</html>

