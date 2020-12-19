<div class="content-wrapper"><!-- Page Heading -->
    <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <section class="content-header">
        <h1>
            Edit Customer
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            
            <li class="active">Edit Customer</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <p class="help-block" style="color:red;"><?php
                        if (isset($error)) {
                            echo $error;
                        }
                        ?></p>

                    <!-- form start -->
                    <form role="form" action="<?php echo base_url(); ?>company_master/company_edit/<?php echo $id ?>" method="post" enctype="multipart/form-data" id="ProfileForm">

                        <div class="box-body">
                            <div class="col-md-12">
                                <?php if ($this->session->flashdata('success')) { ?>
                                    <div class="alert alert-success alert-dismissable">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <?php echo $this->session->flashdata('success'); ?>
                                    </div>
                                <?php } ?>
                                <div class="col-md-6">

                                    <div class="form-group has-feedback">
                                        <label for="exampleInputFile">First Name</label><span style="color:red">*</span>
                                        <input type="text"  name="UserFName" class="form-control"  value="<?= $query->UserFName ?>" id="fname">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        <div class="invalid-feedback" id="fnameerror"></div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputFile">Last Name</label><span style="color:red">*</span>
                                        <input type="text"  name="UserLName" class="form-control"  value="<?= $query->UserLName ?>" id="lname">
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        <div class="invalid-feedback" id="lnameerror"></div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputFile">Email</label><span style="color:red">*</span>
                                        <input type="email" class="form-control" placeholder="Email" name="UserEmail" id="email" value="<?= $query->UserEmail ?>"/>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        <div class="invalid-feedback" id="emailerror"></div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputFile">Gender</label><span style="color:red">*</span>
                                        <input type="radio" class="" name="UserGender" <?php
                                        if ($query->UserGender == '1') {
                                            echo 'checked';
                                        }
                                        ?> value="1"/> Male
                                        <input type="radio" class="" name="UserGender" <?php
                                        if ($query->UserGender == '2') {
                                            echo 'checked';
                                        }
                                        ?> value="2" /> Female

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Country</label><span style="color:red">*</span>
                                        <select style="padding:6px 12px;" class="form-control" name="UserCountry" id="country" onchange="getState();">
                                            <option value="">Select</option>
                                            <?php $phone_code=''; foreach ($country_list as $val) { ?>
                                                <option  countrycode="<?php echo $val['phone_code']; ?>"  value="<?php echo $val['id']; ?>" <?php
                                                if ($val['id'] == $query->UserCountry) {
                                                    echo "selected"; $phone_code=$val['phone_code'];
                                                }
                                                ?>><?php echo $val['name']; ?></option>
                                                     <?php } ?>              
                                        </select>
                                        <?php echo form_error('UserCountry', '<div class="error" style="color:red;">', '</div>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">State</label><span style="color:red">*</span>
                                        <select style="padding:6px 12px;" class="form-control" name="UserState" id="state" >
                                            <option value="">Select State</option>
                                            <?php foreach ($state_list as $val) { ?>
                                                <option value="<?php echo $val['id']; ?>" <?php
                                                if ($val['id'] == $query->UserState) {
                                                    echo "selected";
                                                }
                                                ?>><?php echo $val['state_name']; ?></option>
                                                    <?php } ?> 
                                        </select>
                                        <div class="invalid-feedback" id="stateerror"></div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputFile">Mobile</label><span style="color:red">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="country-code">+<?php echo  $phone_code; ?></span>
                                            <input type="text" class="form-control"  placeholder="Mobile (Required)" name="UserMNumber" id="mobile" value="<?= $query->UserMNumber ?>">
                                        </div>
                                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                        <div class="invalid-feedback" id="mobileerror"></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <div class="col-md-6">
                                <button class="btn btn-primary" type="button" onclick="validateForm();">Update</button>
                            </div>
                        </div>

                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
    <script type="text/javascript">
        function getState() {
            var country_id = $('#country').val();



            if (country_id != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>registration/getState",
                    type: "POST",
                    data: {id: country_id},
                    success: function (data) {
                        if (data != '') {
                            $('#state').html(data);
                        } else {
                            $('#state').html('<option value="">Select State</option>');
                        }
                    }
                });

            } else {
                $('#state').html('<option value="">Select State</option>');
            }
            var country_code = $("option[value=" + country_id + "]", $('#country')).attr('countrycode');
            $('#country-code').html("+" + country_code);
        }
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });

    </script>
    <script>function validateForm() {
            var fname = $("#fname").val();
            var lname = $("#lname").val();
            var email = $("#email").val();
            var mobile = $("#mobile").val();
            var country = $("#country").val();
            var state = $("#state").val();
            var gender = $("input[name='UserGender']:checked").val();

            $(".invalid-feedback").html('');
            var temp = 0;
            if (fname == "") {
                $("#fnameerror").html("Frist name is required.");
                temp++;
            }
            if (gender == null) {
                $("#gendererror").html("Gender is required.");
                temp++;
            }
            if (country == "") {
                $("#countryerror").html("Country is required.");
                temp++;
            }
            if (state == "") {
                $("#stateerror").html("State is required.");
                temp++;
            }
            if (lname == "") {
                $("#lnameerror").html("Last name is required.");
                temp++;
            }
            if (email == "") {
                $("#emailerror").html("Email is required.");
                temp++;
            } else if (checkemail(email) == false) {
                $("#emailerror").html('Invalid email.');
                temp++;
            }
            if (mobile == "") {
                $("#mobileerror").html("Mobile is required.");
                temp++;
            } else if (checkmobile(mobile) == false) {
                $("#mobileerror").html('Invalid mobile number.');
                temp++;
            }
            var id = '<?php echo $id ?>';
            if (temp == 0) {
                $.ajax({
                    url: "<?php echo base_url(); ?>registration/check_email_edit",
                    data: {email: email, id: id},
                    type: 'get',
                    success: function (response) {
                        if (response == 0) {
                            var data = new FormData($('#ProfileForm')[0]);
                            $.ajax({
                                url: "<?php echo base_url(); ?>registration/registration_data_update",
                                data: data,
                                type: 'post',
                                mimeType: "multipart/form-data",
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function (response) {
                                    if (response == 1) {
                                        location.reload();
                                    }
                                }
                            });
                        } else {
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