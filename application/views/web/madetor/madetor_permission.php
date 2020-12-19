
<!-- left side start-->
<?php $this->load->view('web/left'); ?>
<!-- left side end-->

<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header');
//print_r($this->data['user_permission_list']); die;
	?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <div class="graphs">
            <h3 class="blank1">Permission Madetor</h3>
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>madetor/savepermission/<?php echo $id; ?>" name="savingdata" onsubmit="return validate()">
<?php foreach($allpermissionlist as $key=>$permissionlist){ ?>
<hr>
<div class="form-group col-sm-12"><h3><?php echo $key; ?></h3></div>
<hr>
<?php foreach($permissionlist as $list){
	?>
	<div class="form-group col-sm-2">
		<label for="focusedinput" class="control-label"> <input type="checkbox" name="permission[]" <?php if(in_array($list->key,$getUserPermission)){ ?>checked<?php } ?> value=<?php echo $list->key; ?>> <?php echo $list->value?></label>		
	</div>
<?php } } ?>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button class="btn-success btn col-sm-2" type="submit" name="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- switches -->
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
<script src="<?php echo base_url(); ?>assets1/js/bootstrap-multiselect.js"></script>
<link href="<?php echo base_url(); ?>assets1/css/bootstrap-multiselect.css" rel='stylesheet' type='text/css' />
<script src="<?php echo base_url(); ?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets1/js/bootstrap.min.js"></script>
</body>
</html>
<script  type="text/javascript">
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