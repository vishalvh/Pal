<style type="text/css">
    .cus-btn{
        padding: 0;
    }
    .cus-btn .btn{
        padding: 6px 8px;
    }
</style>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
      <script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
        <script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
    
  <script type='text/javascript'>
        $(document).ready(function(){
      var d = new Date();
        var n = d.getFullYear();
       
           $( "#datepicker1" ).datepicker({
          changeMonth: true,
          changeYear: true,
          yearRange: "1918:n",
          dateFormat: "yy-mm-dd",
             defaultDate: 'today',
         maxDate:'today',
           onSelect: function () {
               var end_date = $('#datepicker2');
               var minDate = $(this).datepicker('getDate');
               end_date.datepicker('option', 'minDate', minDate);
           }
        });
      $( "#datepicker2" ).datepicker({
        
          changeMonth: true,
          changeYear: true,
          yearRange: "1918:n",
          dateFormat: "yy-mm-dd",
             defaultDate: 'today',
         maxDate:'today'
        });


        });
$(document).ready(function () {
       $("#start_date").datepicker({
           dateFormat: "dd-mm-yy",
        changeMonth: true,
          changeYear: true,
       yearRange: "1918:n",
      
           onSelect: function () {
               var end_date = $('#end_date');
         
               var minDate = $(this).datepicker('getDate');
         
               end_date.datepicker('option', 'minDate', minDate);
           }
       });
       $('#end_date').datepicker({
           dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
       });
   });

        </script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
                Expense Report
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">expense report</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                       <form method="post" action="<?php echo base_url(); ?>admin_expense/exportCSV">  
            <br>
           <div class="cal-md-12">
              <div class="col-md-2">
              
                <input type="text" id="start_date"  readonly class="form-control start_date" name="date1" placeholder="Start Date" value="<?php if(isset($date1) != NULL){ echo $date1; } ?>" />
                
              </div>
              <div class="col-md-2">
              
                <input type="text" id="end_date"  readonly class="form-control end_date" name="date2" placeholder="End Date" value="<?php if(isset($date2) != NULL){ echo $date2; } ?>" />
                
              </div>
              <!-- Select Company -->
              <div class="col-md-2">
              
              <select name="company" id="company" class="form-control company">
              <option value="0">Select Company</option> 
              <?php

                $cnt = 1;
                foreach ($company as $raw) 
                {
                  ?>

                    <option  value="<?php echo $raw['id']; ?>"><?php echo $raw['name']; ?></option>
                <?php } ?>
              </select>
              </div>
              <!-- Select Location -->
              <div class="col-md-2">
              
              <select name="location" id="location" class="form-control location">
              <option value="0">Select Location</option> 
              <?php

                $cnt = 1;
                foreach ($location as $raw) 
                {
                  ?>

                    <option  value="<?php echo $raw['l_id']; ?>" <?php if(isset($location) != NULL)
                    { 
                      if($id == $location)
                      {
                      echo "selected";
                    } 
                  } ?>><?php echo $raw['l_name']; ?></option>
                <?php } ?>
              </select>
              </div>
              <!-- Select Employee Name -->
              <div class="col-md-2">
              
              <select name="Employeename" id="Employeename" class="form-control">
              <option value="0">Select Employee </option> 
              <?php
                $cnt = 1;
                foreach ($Employee as $row) 
                {
                  ?>
                    <option  value="<?php $id = $row['id']; echo $row['id']; ?>" <?php if(isset($Employeename) != NULL)
                    { 
                      if($id == $Employeename )
                      {
                      echo "selected";
                    } 
                  } ?>><?php echo $row['UserFName']; ?></option>
                <?php } ?>
              </select>
              </div>
              <div class="col-md-2 cus-btn" >
                  <input type="button" onClick="search();" class="btn  btn-success"  value="Search">
                  <input type="reset" value="Reset" class="btn  btn-danger">
                  <button class="btn btn-primary" type="submit" formtarget="_blank" onclick='javascript: return SubmitForm()'><i class="fa fa-print"></i></button>
              </div>
               </div>
              </form>

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="widget">
                            <?php if (isset($success) != NULL) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $success['0']; ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('fail')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('fail'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('successf')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('successf'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('failf')) { ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <?php echo $this->session->flashdata('failf'); ?>
                                </div>
                            <?php } ?>   
						</div>
                        <div class="tableclass">
                   <table id="table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th>Sr No</th>
                                  <th>Date</th>
                                  <th>Company Name</th>
                                  <th>Username</th>
                                  <th>Location</th>
                                  <th>Total</th>
                                  <th>Action</th>
 
                                </tr>
                                </thead>
                                <tbody> </tbody>
                            </table>
                        </div>
                        
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript">
 
var table;

var query = "";
  function search(query){
    $Employeename = $('#Employeename').val(); 
    $company = $('#company').val(); 
    $location = $('#location').val(); 
    $Packaging = $('#Packaging').val(); 
    $pb = $('#pb').val(); 
    var $fdate = $('.start_date').val();
    var $tdate = $('.end_date').val();
    var $location = $('.location').val(); 
//     var $tdate = new Date(toDate).toDateString("yyyy-MM-dd");
//    var $tdate = new Date(toDate).toDateString("yyyy-mm-dd");
    $("#table").dataTable().fnDestroy();
//    alert(query);
      $('#table').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],
         "scrollX": true,
        
        
        
        "ajax": {
          "url": "<?php echo site_url('admin_expense/ajax_list?employeename=')?>"+$Employeename+"&fdate="+$fdate+"&tdate="+$tdate+"&location="+$location+"&company="+$company,
          "type": "POST"
        },
        "columnDefs": [
        { 
          "targets": [ 0,3,5 ], 
          "orderable": false,
        },
        ],
      });
    }
 
$(document).ready(function() {
 	
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "scrollX": true,
        "bFilter": false,
        "bInfo": false,
 		
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin_expense/ajax_list?extra=')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
});
$(document).ready(function() {
  $("#company").on('change',function(){
    var cid = $('#company').val();


$.ajax({
type: "POST",
data: {'cid':cid },
url: "<?php echo base_url() ; ?>Inwardreport/location",
success: function (response) {
var obj = JSON.parse(response);

$("#location").empty();
$("#location").append(
$('<option value='+0+'>Select Location</option>')
);
for(var i=0; i<obj.length;i++){
$("#location").append(
$('<option value='+obj[i].l_id+'>'+obj[i].l_name+'</option>')
);

}
}
});

});
});


$(document).ready(function() {
  $("#company").on('change',function(){
    var cid = $('#company').val();
    

$.ajax({
type: "POST",
data: {'cid':cid },
url: "<?php echo base_url() ; ?>Inwardreport/employee",
success: function (response) {
var obj = JSON.parse(response);
$("#Employeename").empty();
$("#Employeename").append(
$('<option value='+0+'>Select Employee</option>')
);
for(var i=0; i<obj.length;i++){
$("#Employeename").append(
$('<option value='+obj[i].id+'>'+obj[i].UserFName+'</option>')
);


}
}
});

});
});

$(document).ready(function() {
  $("#location").on('change',function(){
    var lid = $('#location').val();
    var cid = $('#company').val();
    if(lid == 0 )
    {
        $.ajax({
type: "POST",
data: {'cid':cid },
url: "<?php echo base_url() ; ?>Inwardreport/employee",
success: function (response) {
var obj = JSON.parse(response);
$("#Employeename").empty();
$("#Employeename").append(
$('<option>Select Employee</option>')
);
for(var i=0; i<obj.length;i++){
$("#Employeename").append(
$('<option value='+obj[i].id+'>'+obj[i].UserFName+'</option>')
);


}
}
});
    }
    else
    {

$.ajax({
type: "POST",
data: {'lid':lid },
url: "<?php echo base_url() ; ?>Inwardreport/loc_employee",
success: function (response) {
var obj = JSON.parse(response);

  


$("#Employeename").empty();
$("#Employeename").append(
$('<option>Select Employee</option>')
);
for(var i=0; i<obj.length;i++){
$("#Employeename").append(
$('<option value='+obj[i].id+'>'+obj[i].UserFName+'</option>')
);

}
}
});
}
});
});


</script>