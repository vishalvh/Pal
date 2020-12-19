<?php $this->load->view('web/left'); ?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>	
<style>
    .dataTables_filter {
        display: none; 
    }
</style> 
<!-- left side start-->
<!-- left side end-->
<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <form method="post" action="<?php echo base_url(); ?>admin/add">			
            <h3 class="blank1" style="margin-top: -20px;">Company Report</h3>
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
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
				<div class="title-h1">
					<h3 style="text-align:  center;">Deposit By Card</h3>
				</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Batch Number</th>
                            <?php if($logged_company['type'] == 'c'){ ?>   <th>Action</th> <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
						<?php if($depositbycard){ $i = 1; foreach($depositbycard as $deposit){ ?>
						<tr>
                            <td><?php echo  $i; ?> </td>   
                            <td> <?php echo date('d-m-Y', strtotime($deposit->date)) ?></td>
                            <td><?php echo  $deposit->amount; ?> </td>
                            <td><?php echo  $deposit->batch_no; ?> </td>
							<?php if($logged_company['type'] == 'c'){ ?>     
								<td>
									<a href='<?php echo base_url(); ?>company_report/card_deposit_edit/<?php echo $deposit->id; ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
									<a  href='<?php echo base_url(); ?>company_report/card_deposit_delete/<?php echo $deposit->id; ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
								</td> 
							<?php } ?>
						</tr>
						<?php $i++; } 
							}else{ ?>
						<tr> 
							<td colspan="4" style="text-align:  center;">Data Not Found</td>
						</tr>
						<?php } ?>
					</tbody>
                </table>
            </div>
        </div>
        <div class="xs tabls">
			<div class="bs-example4" data-example-id="contextual-table">
				<div class="title-h1">
					<h3 style="text-align:  center;">Transfer Online</h3>
				</div>
                <table class="table">
					<thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Transaction Number</th>
							<?php if($logged_company['type'] == 'c'){ ?><th>Action</th ><?php } ?>
                        </tr>
                    </thead>
                    <tbody>
					<?php if($transonline){ $i = 1; foreach($transonline as $online){ ?>
						<tr>
							<td><?php echo  $i; ?> </td>   
                            <td> <?php echo date('d-m-Y', strtotime($online->date)) ?></td>
                            <td><?php echo  $online->amount; ?> </td>
                            <td><?php echo  $online->cheque_tras_no; ?> </td>
							<?php if($logged_company['type'] == 'c'){ ?>
							<td>
								<a href='<?php echo base_url(); ?>company_report/online_transection_edit/<?php echo $online->id; ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                <a  href='<?php echo base_url(); ?>company_report/online_transection_delete/<?php echo $online->id; ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
							</td>  
							<?php } ?>
						</tr>
					<?php $i++; } 
						}else{ ?>
						<tr> 
							<td colspan="5" style="text-align:  center;">Data Not Found</td>
						</tr>
					<?php } ?>    
                    </tbody>
                </table>
            </div>
        </div>
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
				<div class="title-h1">
					<h3 style="text-align:  center;">Purchase Amount</h3>
				</div>
				<table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Petrol Amount</th>
                            <th>Diesel Amount</th>
							<?php if($logged_company['type'] == 'c'){ ?>
								<th>Action</th>
							<?php } ?>
                        </tr>
                    </thead>
                    <tbody>
					<?php if($purchaseamount){ $i = 1; foreach($purchaseamount as $card){ ?>
						<tr>
                            <td><?php echo  $i; ?> </td>   
                            <td> <?php echo date('d-m-Y', strtotime($card->date)) ?></td>
                            <td><?php echo  $card->p_total_amount; ?> </td>
                            <td><?php echo  $card->d_total_amount; ?> </td>
							<?php if($logged_company['type'] == 'c'){ ?>
							<td>
								<a href='<?php echo base_url(); ?>company_report/purches_amount_edit?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate');?>&edate=<?php echo $this->input->get('edate');?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
								<!--<a  href='<?php echo base_url(); ?>company_report/purches_amount_delete/<?php echo $card->id; ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>  -->      
							</td>
							<?php } ?>
						</tr>
					<?php $i++; } 
						}else{ ?>
						<tr>
							<td colspan="5" style="text-align:  center;">Data Not Found</td>
						</tr>
					<?php } ?>     
                    </tbody>
                </table>
            </div>
        </div>
		
		
		<div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
				<div class="title-h1">
					<h3 style="text-align:  center;">Company Credit</h3>
				</div>
				<table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Amount</th>
							<?php if($logged_company['type'] == 'c'){ ?>
								<th>Action</th>
							<?php } ?>
                        </tr>
                    </thead>
                    <tbody>
					<?php if($company_credit_debit){ $i = 1; foreach($company_credit_debit as $card){ 
					if($card->type == 'c'){
					?>
						<tr>
                            <td><?php echo  $i; ?> </td>   
                            <td> <?php echo date('d-m-Y', strtotime($card->date)) ?></td>
                            <td><?php echo  $card->amount; ?> </td>
							<?php if($logged_company['type'] == 'c'){ ?>
							<td>
								<a href='<?php echo base_url(); ?>company_report/edit_credit_debit?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate');?>&edate=<?php echo $this->input->get('edate');?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
								<a  href='<?php echo base_url(); ?>company_report/edit_credit_delete/<?php echo $card->id; ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>
							</td>
							<?php } ?>
						</tr>
					<?php $i++; }  }
					if($i == '1'){ ?>
						
						<tr>
							<td colspan="3" style="text-align:  center;">Data Not Found</td>
						</tr>
				<?php 	}
					
						}else{ ?>
						<tr>
							<td colspan="3" style="text-align:  center;">Data Not Found</td>
						</tr>
					<?php } ?>     
                    </tbody>
                </table>
            </div>
        </div>
		
		
		<div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
				<div class="title-h1">
					<h3 style="text-align:  center;">Company Credit By Customer</h3>
				</div>
				<table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Amount</th>
							<?php if($logged_company['type'] == 'c'){ ?>
								<th>Action</th>
							<?php } ?>
                        </tr>
                    </thead>
                    <tbody>
					<?php if($company_credit_by_customer){ $i = 1; foreach($company_credit_by_customer as $card){ 
					?>
						<tr>
                            <td><?php echo  $i; ?> </td>   
                            <td> <?php echo date('d-m-Y', strtotime($card->date)) ?></td>
                            <td><?php echo  $card->amount; ?> </td>
							<?php if($logged_company['type'] == 'c'){ ?>
							<td>
								<a href='<?php echo base_url(); ?>company_report/company_credit_by_customer_edit?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate');?>&edate=<?php echo $this->input->get('edate');?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
								<a  href='<?php echo base_url(); ?>company_report/company_credit_by_customer_delete?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate');?>&edate=<?php echo $this->input->get('edate');?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>
							</td>
							<?php } ?>
						</tr>
					<?php $i++;   }
					if($i == '1'){ ?>
						
						<tr>
							<td colspan="3" style="text-align:  center;">Data Not Found</td>
						</tr>
				<?php 	}
					
						}else{ ?>
						<tr>
							<td colspan="3" style="text-align:  center;">Data Not Found</td>
						</tr>
					<?php } ?>     
                    </tbody>
                </table>
            </div>
        </div>
		
		<div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
				<div class="title-h1">
					<h3 style="text-align:  center;">Company Debit</h3>
				</div>
				<table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Amount</th>
							<?php if($logged_company['type'] == 'c'){ ?>
								<th>Action</th>
							<?php } ?>
                        </tr>
                    </thead>
                    <tbody>
					<?php if($company_credit_debit){ $i = 1; foreach($company_credit_debit as $card){ 
					if($card->type == 'd'){
					?>
						<tr>
                            <td><?php echo  $i; ?> </td>   
                            <td> <?php echo date('d-m-Y', strtotime($card->date)) ?></td>
                            <td><?php echo  $card->amount; ?> </td>
							<?php if($logged_company['type'] == 'c'){ ?>
							<td>
								<a href='<?php echo base_url(); ?>company_report/edit_credit_debit?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate');?>&edate=<?php echo $this->input->get('edate');?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
								<a  href='<?php echo base_url(); ?>company_report/edit_credit_delete/<?php echo $card->id; ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>
							</td>
							<?php } ?>
						</tr>
					<?php $i++; }  }
					if($i == '1'){ ?>
						
						<tr>
							<td colspan="3" style="text-align:  center;">Data Not Found</td>
						</tr>
				<?php 	}
					
						}else{ ?>
						<tr>
							<td colspan="3" style="text-align:  center;">Data Not Found</td>
						</tr>
					<?php } ?>     
                    </tbody>
                </table>
            </div>
        </div>
		
		
		
		
		
		
		
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