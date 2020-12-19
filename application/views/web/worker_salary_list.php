	
	    <!-- left side start-->
			<?php $this->load->view('web/left');?>
			<!-- left side end-->
	     
			<!-- main content start-->
			<div class="main-content">
				<!-- header-starts -->
				<?php $this->load->view('web/header');?>
			<!-- //header-ends -->
				<div id="page-wrapper">
					<form method="post" action="<?php echo base_url();?>admin/add">			
                                            <h3 class="blank1" style="margin-top: -20px;">Worker Salary List <?php echo $fdate; ?> To <?php echo $edate; ?> </h3>
											<a href="<?php echo base_url(); ?>worker_salary?sdate=<?php echo $fdate;?>&edate=<?php echo $edate;?>&l_id=<?php echo $lid; ?>&worker_id=<?php echo $worker_id; ?>" class="btn btn-primary"  >Back</a>
	 								<a href="<?php echo base_url(); ?>worker_salary/worker_salary_list_print/<?php echo $id."/".$fdate."/".$edate."/".$lid; ?>" class="btn btn-primary" target="_blank" >Print</a>
								</form>

					<h3 class="blank1"></h3>
					<br>
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
							<?php if ($this->session->flashdata('success_update')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success_update'); ?>
							   </div>
							<?php } ?>
							
							<?php if ($this->session->flashdata('check_fail')) { ?>
							   <div class="alert alert-danger alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('check_fail'); ?>
							   </div>
							<?php } ?>
						<?php
							$name = $bd[0]->UserFName;
						?>
                                        <table class="table">
                                            <tr>
                                                <td>No</td>
                                                <td>Name</td>
                                                 <td>Date</td>
                                                <td>Paid Salary</td>
                                            <td>Extra Amount</td>
                                            <td>Loan Amount</td>
                                            <td>Paid Loan Amount</td>
                                            <td>Bonus Amount</td>
                                            <td>Remark</td>
                                   <?php if($logged_company['type'] == 'c'){ ?>         <td>Action</td> <?php } ?>
                                            </tr>    
                                            
                                            <?php $cnt = 1; foreach ($bd as $salary){ ?>
                                            <tr>
                                                <td> <?php echo $cnt; ?> </td>
                                                 <td> <?php echo $salary->worker_name; ?> </td>
                                                  <td> <?php  echo date('d/m/Y', strtotime($salary->date));  ?> </td>
                                                  <td> <?php echo $salary->amount; ?> </td>
                                                   <td> <?php echo $salary->extra_amount; ?> </td>
                                                    <td> <?php echo $salary->loan_amount; ?> </td>
                                                     <td> <?php echo $salary->paid_loan_amount; ?> </td>
                                                      <td> <?php echo $salary->bonas_amount; ?> </td>
                                                      <td> <?php echo $salary->remark; ?> </td>
                                        <?php if($logged_company['type'] == 'c'){ ?>               <td>
						  <a href='<?php echo base_url(); ?>worker_salary/worker_salary_edit?id=<?php echo $salary->id; ?>&sdate=<?php echo $this->uri->segment('4')?>&edate=<?php echo $this->uri->segment('5')?>&l_id=<?php echo $this->uri->segment('6')?>&worker_id=<?php echo $this->uri->segment('7')?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                        
							<!--<a  href='<?php echo base_url(); ?>worker_salar/worker_salary_delete/<?php echo $salary->id; ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>-->        
                                        </td> <?php } ?>
                                                     
                                            </tr>
                                                <?php $cnt++; } ?>
                                        </table>
						
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

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js')?>"></script>
