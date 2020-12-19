<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registration</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.4 -->
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->

        <link href="<?php echo base_url(); ?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="register-page">
        <div class="register-box">
            
            <div class="register-box-body">
                <div class="register-logo">
                <a href="<?php echo base_url(); ?>"><b>Demo</b></a>
            </div>
            <?php if ($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php } ?>
                <p class="login-box-msg">Register a new membership</p>
                 <form action="" method="post" id="registration_data">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="First name (Required)" name="UserFName" id="fname"/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <div class="invalid-feedback" id="fnameerror"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Last name (Required)" name="UserLName" id="lname"/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <div class="invalid-feedback" id="lnameerror"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email (Required)"  name="UserEmail" id="email"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <div class="invalid-feedback" id="emailerror"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" onkeyup="checkPassword()" placeholder="Password (Required)" name="UserPassword" id="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <div class="invalid-feedback" id="passworderror"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" onchange="checkConfirmPassword()"   placeholder="Confirm password (Required)" name="cpassword" id="cpassword"/>
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        <div class="invalid-feedback" id="cpassworderror"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="radio" class="form-control" name="UserGender" value="1"/> Male
                        <input type="radio" class="form-control" name="UserGender" value="2" /> Female
                        <div class="invalid-feedback" id="gendererror"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <select style="padding:6px 12px;" class="form-control" name="UserCountry" id="country" onchange="getState();">
                            <option value="">Choose Country (Required)</option>
                            <?php foreach ($country_list as $val) { ?>
                                <option countrycode="<?php echo $val['phone_code']; ?>" value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                            <?php } ?>              
                        </select>
                        <div class="invalid-feedback" id="countryerror"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <select style="padding:6px 12px;" class="form-control" name="UserState" id="state" >
                            <option value="">Choose State (Required) </option>

                        </select>
                        <div class="invalid-feedback" id="stateerror"></div>
                    </div>
                    <div class="form-group has-feedback">
                   
                        <div class="input-group">
                    <span class="input-group-addon" id="country-code">+</span>
                    <input type="text" class="form-control"  placeholder="Mobile (Required)" name="UserMNumber" id="mobile">
                  </div>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        <div class="invalid-feedback" id="mobileerror"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">    
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" id="trm"> I agree to the <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal">terms & condition</a>
                                </label>
                                <div class="invalid-feedback" id="trmerror"></div>
                            </div>                        
                        </div><!-- /.col -->
                        <div class="col-xs-12">
                            <button type="button" onclick="validate();" class="btn btn-primary btn-block btn-flat">Register</button>
                        </div><!-- /.col -->
                    </div>
                </form>       

                

                <a href="<?php echo base_url(); ?>" class="text-center">I already have a membership.</a>
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->
  <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Terms & Condition </h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                          <p>Some text in the Terms  and Condition.</p>








                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>

        </div>
    </div>
    <!-- Main content -->
        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script type="text/javascript">
                            function getState() {
                                var country_id = $('#country').val();
                                
                                  var country_code = $("option[value="+country_id+"]", $('#country')).attr('countrycode');


                                
                                $('#country-code').html("+"+country_code);
                             
                                if (country_id != '') {
                                    $.ajax({
                                        url: "<?php echo base_url(); ?>registration/getState",
                                        type: "POST",
                                        data: {id: country_id},
                                        success: function (data) {
                                            if (data != '') {
                                                $('#state').html(data);
                                            } else {
                                                $('#state').html('<option value="">Choose State</option>');
                                            }
                                        }
                                    });

                                } else {
                                    $('#state').html('<option value="">Choose State</option>');
                                }
                            }
                            $(function () {
                                $('input').iCheck({
                                    checkboxClass: 'icheckbox_square-blue',
                                    radioClass: 'iradio_square-blue',
                                    increaseArea: '20%' // optional
                                });
                            });
                            function checkPassword(){
                                        var password = $("#password").val();
                                        var cpassword = $("#cpassword").val();
                                        
                                         if(password.length<5){
                                              $("#passworderror").html('Password must be at least five characters long!');
                                         }else{
                                             $("#passworderror").html('');
                                         }
                                         
                                        if(password!=cpassword){
                                         $("#cpassword").val("");   
                                        }
                                        
                                
                                
                            }
                            
                            function checkConfirmPassword(){
                                  var password = $("#password").val();
                                        var cpassword = $("#cpassword").val();
                                        
                                        
                                        if(password!=cpassword){
                                             $("#cpassworderror").html('Password and confirm password does not match!');
                                        }else{
                                                $("#cpassworderror").html('');
                                        }
                            }
        </script>
        <script>function validate(){
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var mobile = $("#mobile").val();
        var password = $("#password").val();
        var cpassword = $("#cpassword").val();
        var country = $("#country").val();
        var state = $("#state").val();
        var gender = $("input[name='UserGender']:checked").val();
        
        $(".invalid-feedback").html('');
        var temp = 0;
        if(fname == ""){
            $("#fnameerror").html("Frist name is required.");
            temp++;
        }
        if(gender == null){
            $("#gendererror").html("Gender is required.");
            temp++;
        }
        if(country == ""){
            $("#countryerror").html("Country is required.");
            temp++;
        }
        if(state == ""){
            $("#stateerror").html("State is required.");
            temp++;
        }
        if(lname == ""){
            $("#lnameerror").html("Last name is required.");
            temp++;
        }
        if(email == ""){
            $("#emailerror").html("Email is required.");
            temp++;
        }else if (checkemail(email) == false) {
            $("#emailerror").html('Invalid email.');
            temp++;
        }
        if($("#trm"). prop("checked") == false){
            $("#trmerror").html("Terms condition is required.");
            temp++;
        }
        if(mobile == ""){
            $("#mobileerror").html("Mobile is required.");
            temp++;
        }else if (checkmobile(mobile) == false) {
            $("#mobileerror").html('Invalid mobile number.');
            temp++;
        }
        if(cpassword == ""){
            $("#cpasserror").html("Retype password is required.");
            temp++;
        }
        if(password == ""){
            $("#passworderror").html("Password is required.");
            temp++;
        }else{
            if(password.length<5){
                $("#passworderror").html('Password must be at least five characters long!');
                temp++;
            }else if(cpassword != password){
                  
                    $("#cpassworderror").html('Password and confirm password does not match!');
                    temp++;
            }
        }
        if(temp == 0){
            $.ajax({
            url: "<?php echo base_url(); ?>registration/check_email",
            data: {email: email},
            type: 'get',
            success: function (response) {
                if(response==0){
                    var data = new FormData($('#registration_data')[0]);
                    $.ajax({
                        url: "<?php echo base_url(); ?>registration/registration_data",
                        data: data,
                        type: 'post',
                        mimeType: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (response) {
                            if(response == 1){
                                    location.reload();
                            }
                        }
                    });
                }else{
                    $("#emailerror").html("Email is already use.");
                    temp++;
                }
            }
            });
        }
    }
    function checkemail(mail) {
	var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	if (filter.test(mail)) {
		return true;
	} else {
		return false;
	}
}
function checkmobile(mobile) {
	var filter = /^[0-9-+]+$/;
	var pattern = /^\d{10,11}$/;
	if (filter.test(mobile)) {
		if (pattern.test(mobile)) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
    </script>
    </body>
</html>