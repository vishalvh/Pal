<!-- Page Heading -->

<div class="content-wrapper">
          <section class="content-header">
            <h1>
              Add Expenses
              <small></small>
            </h1>
            <ol class="breadcrumb">
				<li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>admin_expenses"><i class="fa fa-users"></i>Expenses</a></li>
              <li class="active">Add Expenses</li>
            </ol>
          </section>
          <section class="content">
          	<div class="row">
          		<div class="col-md-12">
              <div class="box box-primary">
                <!-- form start -->
                <form role="form" action="<?php echo base_url(); ?>admin_expenses/insert" method="post" name="savingdata" onsubmit="return validate()" id="savingdata" enctype="multipart/form-data">
					
                  <div class="box-body">
                    <div class="col-md-6">
						
						<div class="form-group">
                      <label for="exampleInputFile">Name</label><span style="color:red">*</span>
                      <input type="text" id="Adminname" name="name" class="form-control"  value="<?php echo set_value('name'); ?>" >
                      <?php echo form_error('name', '<div class="error" style="color:red;">', '</div>'); ?> 
                       <div class="invalid-feedback" style="color:red;" id="adminnameerror"></div>
                    </div>
                    
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
					  <div class="col-md-6">
                    <button class="btn btn-primary" type="submit">ADD</button>
                  </div>
					</div>
					
                </form>
              </div><!-- /.box -->

            </div>
          	</div>
			 </section>
<script>
function validate(){
	var Adminname = document.forms["savingdata"]["name"].value;
	var temp = 0;
	if(Adminname == ""){
		$("#adminnameerror").html("Name is required.");
		temp++;
	}
	if(temp != 0){
		return false;     
	}else{
		return true;     
	}
}
</script>