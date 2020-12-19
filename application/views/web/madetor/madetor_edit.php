
<!-- left side start-->
<?php $this->load->view('web/left'); ?>
<!-- left side end-->

<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <div class="graphs">
            <h3 class="blank1">Edit Madetor</h3>
            <div class="tab-content">


                <div class="tab-pane active" id="horizontal-form">
                    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>madetor/update/<?php echo $detail->id; ?>/<?php  echo $this->uri->segment('4'); ?>" name="savingdata" onsubmit="return validate()">
                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label">Madetor Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" id="madetorsname" placeholder="Madetor Name" name="madetorname" value="<?php echo $detail->name; ?>">
                                <?php echo form_error('madetorname', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                <div class="invalid-feedback" id="madetorsname_error" style="color: red;"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label">Email Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" id="emailid" placeholder="Email id" name="emailid" value="<?php echo $detail->email; ?>">
                                
                                <div class="invalid-feedback" id="emailid_error" style="color: red;"><?php echo form_error('emailid', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label">Mobile No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" id="mobileno" placeholder="Mobile No" name="mobileno" value="<?php echo $detail->mobile; ?>">
                                <?php echo form_error('mobileno', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                <div class="invalid-feedback" id="mobileno_error" style="color: red;"></div>
                            </div>
                        </div>
                        <div class="form-group" >
                             <label for="focusedinput" class="col-sm-2 control-label" ></label>
                             
                            <div class="col-sm-8">
 <input type="checkbox" id="trm" name="change_pass" value="1" onchange="chackchecked();"  > Change Password
                            </div>
                        </div>
                        <div class="form-group passdiv" style="display: none;">
                            <label for="focusedinput" class="col-sm-2 control-label" >Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control1" id="password" placeholder="Password" name="password" value="<?php echo $detail->password; ?>">
                                <?php echo form_error('password', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">', '</div>'); ?>
                                <input type="checkbox" id="showHide"> Show Password
                                <div class="invalid-feedback" id="password_error" style="color: red;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label">Location</label>
                           
                            <div class="col-sm-8">
                                <select id="location" multiple="multiple" name="location[]">
                                    <?php foreach ($location_list as $location) { ?>   
                                    <option value="<?php echo $l_id = $location->l_id ?>" <?php foreach ($slected_list as $s_list){ $lid =$s_list->l_id;  if($lid == $l_id){ echo "selected"; } } ?> ><?php echo $location->l_name ?></option>
                                    <?php } ?>
                                </select> 
                                <div class="invalid-feedback" id="location_error" style="color: red;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="hidden" name="id" value="<?php echo $detail->id; ?>">
                                <button class="btn-success btn" type="submit" name="submit">Update</button>
                                <a href = "<?php echo base_url('madetor/updatepermission/'.$detail->id);?>" class="btn-success btn" >Set Permission</a>
                            </div>
                        </div>
                        <div class="form-group">
                         <label>
                                   
                                </label>
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
<?php $this->load->view('web/footer'); ?>
<!--footer section end-->

<!-- main content end-->
</section>

<script src="<?php echo base_url(); ?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(); ?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets1/js/bootstrap.min.js"></script>
</body>
</html>

<script src="<?php echo base_url(); ?>assets1/js/bootstrap-multiselect.js"></script>
<link href="<?php echo base_url(); ?>assets1/css/bootstrap-multiselect.css" rel='stylesheet' type='text/css' />
<script  type="text/javascript">
    function chackchecked(){
        if($("#trm"). prop("checked") == false){
            $(".passdiv").hide();
        }else{
            $(".passdiv").show();
        }
    }
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
<script>
                        function validate() {
                            $(".invalid-feedback").html("");
                            var madetorsname = document.forms["savingdata"]["madetorsname"].value;
                            var emailid = document.forms["savingdata"]["emailid"].value;
                            var mobileno = document.forms["savingdata"]["mobileno"].value;
                            var password = document.forms["savingdata"]["password"].value;
                             var location = document.forms["savingdata"]["location"].value;


                            var temp = 0;
                            if (madetorsname == "") {
                                $("#madetorsname_error").html("Madetor Name is required.");
                                temp++;
                            }
                            if (emailid == "") {
                                $("#emailid_error").html("Email Id is required.");
                                temp++;
                            }
                            var email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                            var number = /^(\+|-)?\d+$/;
                            if (emailid != "") {
                                if (!email.test(emailid)) {
                                     temp++;
                                    $("#emailid_error").html("Email Id is not valid.");
                                }
                            }
                            if (mobileno != "") {
                                if (!number.test(mobileno)) {
                                     temp++;
                                    $("#mobileno_error").html("Mobile no is  not valid.");
                                }
                            }
                            if (mobileno == "") {
                                $("#mobileno_error").html("Mobile No is required.");
                                temp++;
                            }
                            if (password == "") {
                                $("#password_error").html("Password is required.");
                                temp++;
                            }
                              if (location == "") {
                                $("#location_error").html("Location is required.");
                                temp++;
                            }

                            if (temp != 0) {
                                return false;
                            }
                        }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#location').multiselect();
    });
</script>