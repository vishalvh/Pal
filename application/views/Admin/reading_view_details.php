
    <div class="content-wrapper"><!-- Page Heading -->
<section class="content-header">
    <h1>
        Reading Details
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        
        <li class="active"> Reading Details</li>
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
                   
                    

                      
                            <form class="form-horizontal" method="post" id="form" enctype="multipart/form-data" action="http://localhost/quart/public/admin/project/edit-save/2">
                                <div class="box-body" id="parent-form-area">
                                   <div class="col-md-6">
                                    <div class="form-group header-group-0 " id="form-group-name" style="">
                                        <label class="control-label col-sm-3">DATE</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?= $query[0]['DATE'] ?></p>
                                        </div> 
                                    </div>
                                    
                                    <div class="form-group header-group-0 " id="form-group-name" style="">
                                        <label class="control-label col-sm-3">Diesel Reading</label>
                                        <div class="col-sm-9">
                                          <p class="form-control-static"><?= $query[0]['DieselReading'] ?></p>
                                        </div> 
                                    </div>
                                    <div class="form-group header-group-0 " id="form-group-description" style="">
                                        <label class="control-label col-sm-3">Patrol Reading</label>             
                                        <div class="col-sm-9">
                                            <p name="description" class="form-control-static"><?= $query[0]['PatrolReading']  ?></p>  
                                        </div>               
                                    </div>
                                    <div class="form-group header-group-0 " id="form-group-description" style="">
                                        <label class="control-label col-sm-3">Meter Reading</label>             
                                        <div class="col-sm-9">
                                            <p name="description" class="form-control-static"><?= $query[0]['meterReading']  ?></p>  
                                        </div>               
                                    </div>
                                    <div class="form-group header-group-0 " id="form-group-description" style="">
                                        <label class="control-label col-sm-3">Total Amount</label>             
                                        <div class="col-sm-9">
                                            <p name="description" class="form-control-static"><?= $query[0]['TotalAmount']  ?></p>  
                                        </div>               
                                    </div>
                                    <div class="form-group header-group-0 " id="form-group-description" style="">
                                        <label class="control-label col-sm-3">Total Cash</label>             
                                        <div class="col-sm-9">
                                            <p name="description" class="form-control-static"><?= $query[0]['TotalCash']  ?></p>  
                                        </div>               
                                    </div>
                                    <div class="form-group header-group-0 " id="form-group-description" style="">
                                        <label class="control-label col-sm-3">Total Credit</label>             
                                        <div class="col-sm-9">
                                            <p name="description" class="form-control-static"><?= $query[0]['TotalCredit']  ?></p>  
                                        </div>               
                                    </div>
                                    <div class="form-group header-group-0 " id="form-group-description" style="">
                                        <label class="control-label col-sm-3">Total Expenses</label>             
                                        <div class="col-sm-9">
                                            <p name="description" class="form-control-static"><?= $query[0]['TotalExpenses']  ?></p>  
                                        </div>               
                                    </div>
								</div>
                                    <div class="col-md-6">
        <?php  //print_r($details); ?>                   
       <?php  foreach($details as $row ) {?>
                              <div class="form-group header-group-0 " id="form-group-description" style="">
                                        <label class="control-label col-sm-3"><?php echo $row['name']; ?></label>             
                                        <div class="col-sm-9">
                                            <p name="description" class="form-control-static"><?php echo $row['Reading']; ?></p>  
                                        </div>               
                                    </div>
	                          
                                <?php } ?>
                            </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- form start -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>

