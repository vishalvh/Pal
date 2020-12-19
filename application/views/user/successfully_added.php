<!DOCTYPE html>
<html>
    <head>
		<title>Lockafella-Security</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,500,700,600,800' rel='stylesheet' type='text/css'>
		 <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        
        <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <link href="css/flexslider.css" rel="stylesheet">



      
        <link  rel="stylesheet" href="css/style.css">
        <link  rel="stylesheet" href="css/responsive.css">
		
		<style>
			.section-checkout{margin-bottom:35px;}
			.phase-title.current h1 {color: white; border:none !important;
							padding-top:10px;padding-bottom:10px !important;}
			.mainlogin{border:3px solid #FFBB00;}
			.phase-title{background:#FFBB00;}
			.form-padding{padding:20px 30px;}
			.inpadding input{padding:8px 15px;}
			.controls{display:inline-block;width:100%;padding-bottom:20px;}
			.rememberme{margin-left:15px;}
			.forget-password{margin-right:15px;}
			.btn-mar{margin-bottom:35px;}
			.cusmo-input{width:100%;}
		</style>
    


    </head>
    <body class="homepage2">



        <div class="wrapper">
            

			<section class="section-checkout">
                <div class="container">
                        <div class="mainlogin">
						<div class="phase-title current">
                          <h1>added to cart</h1>
                        </div>
						
						
						<div class="row">
						
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<form action="<?php echo base_url(); ?>registration/Forgot_password" class="form-padding col-md-offset-1 col-md-10"
						method="post">
                                   <div class="control-group">
                                   	
                                       <?php  if(isset($success) && $success!=""){
													echo $success;}?>
									   
                                      

                                        <div class="controls inpadding">
                                            <div class="form-label ">product successfully added to your cart</div>

                                         <div class="form-label "><a href="<?php echo base_url(); ?>Product/checkoutfinal">View Your Cart List</a></div>
              
                                    </div>
                                    </div>
                                    
                                    <div class="button-holder btnlogin col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center btn-mar">
                                    
                                    </div>
                        </form>
						</div>
						</div>
                    </div>
					</div>
			</section>    
        </div>


       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
       
        <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
       

        <script type="text/javascript" src="js/css_browser_selector.js"></script>

        <script type="text/javascript" src="js/twitter-bootstrap-hover-dropdown.min.js"></script>
        <script type="text/javascript" src="js/jquery.easing-1.3.js"></script>
       
        <script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
    
        <script type="text/javascript" src="js/jquery.carouFredSel-6.2.1-packed.js"></script>


        <script type="text/javascript" src="js/script.js"></script>
    </body>


</html>
