<?php $this->load->view('web/left'); ?>
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>design/js/jquery-3.0.0.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>	

<style>
    .dataTables_filter {
        display: none; 
    }</style> 

<!-- left side start-->

<!-- left side end-->

<!-- main content start-->
<div class="main-content">
    <!-- header-starts -->
    <?php $this->load->view('web/header'); ?>
    <!-- //header-ends -->
    <div id="page-wrapper">
        <form method="post" action="<?php echo base_url(); ?>admin/add">			
            <h3 class="blank1" style="margin-top: -20px;">Bank Report</h3><a href="<?php echo base_url('/');?>bank_deposit?sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>">Back</a>

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

        <!--							<form method="" target="_blank" action="" id="savingdata">			
                                                                        
                                                                        
                                                                        
        
                                        
                                                <br>
                                                 <div class="cal-md-12">
                                                                <div class="col-md-2">
                                                                
                                                                        <input type="text" id="start_date"  readonly class="form-control start_date" name="sdate" placeholder="Start Date" value="" />
                                                                        <span class="error" id="sdateerror"></span>
                                                                </div>
                                                                <div class="col-md-2">
                                                                
                                                                        <input type="text" id="end_date"  readonly class="form-control end_date" name="edate" placeholder="End Date" value="" />
                                                                        <span class="error" id="edateerror"></span>
                                                                </div>
                                                                 Select Location 
                                                                <div class="col-md-2">
                                                                
                                                                <select name="lid" id="location" class="form-control location">
                                                                <option value="">Select Location</option> 
        <?php
        $cnt = 1;
        foreach ($location as $raw) {
            ?>
            
                                                                                    <option  value="<?php echo $raw['l_id']; ?>"><?php echo $raw['l_name']; ?></option>
<?php } ?>
                                                                </select>
                                                                <span class="error" id="locationerror"></span>
                                                                </div>
                                                                 Select Employee Name 
                                                                
        
                                                                 <input type="button" onClick="search();" class="btn btn-primary"  value="search">
                                                                 <input type="button" onClick="printpdf();" class="btn btn-primary"  value="Print">
                                                                 <br>
                                                                 <br></div>
                                                                </form>-->

       
        <div class="xs tabls">
 
            <div class="bs-example4" data-example-id="contextual-table">

<div class="title-h1">
            <h3 style="text-align:  center;">Bank Deposit</h3>
        </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th> Name </th>
                            <th>Deposit Amount</th>
                            <th>Cheque Amount</th>

                            <!--<th>Withdraw Amount</th>-->

<!--<th>Withdraw Transection Number</th>-->
                            <!--<th>Card Amount</th>-->
                            <!--<th>Batch No</th>-->
                            <?php if($logged_company['type'] == 'c'){ ?>   <th>Action</th> <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                     <?php // print_r($list); ?>
<?php if(!empty($list) || !empty($list2) ){ $i = 1; foreach($list as $deposit){ ?>
                           <tr>
                            <td><?php echo  $i; ?> </td>    
                            <td> <?php echo date('d-m-Y', strtotime($deposit->date)) ?></td>
                             <td> <?php echo  $deposit->name; ?> </td>
                            <td><?php echo  $deposit->deposit_amount; ?> </td>
                            <td><?php echo  "0.00"; ?> </td>
                           <?php if($logged_company['type'] == 'c'){ ?>     <td>
						  <a href='<?php echo base_url(); ?>bank_deposit/bankdeposit_edit_online?id=<?php echo $deposit->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                        
							<a  href='<?php echo base_url(); ?>bank_deposit/bankdeposit_delete?id=<?php echo $deposit->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
                           </td> <?php } ?>
                                           </tr>
<?php $i++; }  foreach($list2 as $deposit2){ 
?>
<tr>
                            <td><?php echo  $i; ?> </td>    
                            <td> <?php echo date('d-m-Y', strtotime($deposit2->date)) ?></td>
                             <td> <?php echo  $deposit2->name; ?> </td>
                            <td><?php echo  "0.00"; ?> </td>
                            <td><?php echo  $deposit2->famount; ?> </td>
                           <?php if($logged_company['type'] == 'c'){ ?>     <td>
						  <a href='<?php echo base_url(); ?>bank_deposit/bankdeposit_edit_cradit?id=<?php echo $deposit2->bankdeposit_id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                        
							<a  href='<?php echo base_url(); ?>bank_deposit/bankdeposit_edit_cradit?id=<?php echo $deposit2->bankdeposit_id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
                           </td> <?php } ?>
                                           </tr>


<?php }  }else{ ?>
                       <tr> <td colspan="5" style="text-align:  center;">Data Not Found</td></tr>                     
<?php } ?>
                        
                    </tbody>
                </table>

            </div>
            
        </div>
        <div class="xs tabls">
 
            <div class="bs-example4" data-example-id="contextual-table">

<div class="title-h1">
            <h3 style="text-align:  center;">On line Withdrawal</h3>
        </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th> Name </th>
                            <th>Amount</th>
                            <th>Cheque Tras No</th>

                            <!--<th>Withdraw Amount</th>-->

<!--<th>Withdraw Transection Number</th>-->
                            <!--<th>Card Amount</th>-->
                            <!--<th>Batch No</th>-->
                       <?php if($logged_company['type'] == 'c'){ ?>      <th>Action</th ><?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                     <?php // print_r($list); ?>
<?php if($onlinelist){ $i = 1; foreach($onlinelist as $online){ if($online->paid_by != 'cs'){ ?>
                           <tr>
                            <td><?php echo  $i; ?> </td>   
                            <td> <?php echo date('d-m-Y', strtotime($online->date)) ?></td>
                            <td> <?php  echo  $online->user_name; ?> - <?php echo $online->bank_name; ?>  </td>
                            <td><?php echo  $online->amount; ?> </td>
                            <td><?php echo  $online->cheque_tras_no; ?> </td>
                          
                           <?php if($logged_company['type'] == 'c'){ ?>      <td>
						  <a href='<?php echo base_url(); ?>bank_deposit/bankdonlineeposit_edit?id=<?php echo $online->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                        
							<a  href='<?php echo base_url(); ?>bank_deposit/bankdonlineeposit_delete?id=<?php echo $online->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
						  </td> > <?php } ?>
                                           </tr>
<?php $i++; } } }else{ ?>
                                          <tr> <td colspan="5" style="text-align:  center;">Data Not Found</td></tr>    
<?php } ?>    
                    </tbody>
                </table>

            </div>
            
        </div>
        <div class="xs tabls">
 
            <div class="bs-example4" data-example-id="contextual-table">

<div class="title-h1">
            <h3 style="text-align:  center;">Card Deposit</h3>
        </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Batch No</th>

                            <!--<th>Withdraw Amount</th>-->

<!--<th>Withdraw Transection Number</th>-->
                            <!--<th>Card Amount</th>-->
                            <!--<th>Batch No</th>-->
                   <?php if($logged_company['type'] == 'c'){ ?>           <th>Action</th> <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                     <?php // print_r($list); ?>
                        
<?php if($creadit_dabit_list){ $i = 1; foreach($creadit_dabit_list as $card){ ?>
                           <tr>
                            <td><?php echo  $i; ?> </td>   
                            <td> <?php echo date('d-m-Y', strtotime($card->date)) ?></td>
                            <td><?php echo  $card->card_amount; ?> </td>
                            <td><?php echo  $card->batch_no; ?> </td>
                          <?php if($logged_company['type'] == 'c'){ ?>   <td>
						  <a href='<?php echo base_url(); ?>bank_deposit/bank_card_payment_edit?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                        
							<a  href='<?php echo base_url(); ?>bank_deposit/bank_card_payment_delete?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
						  </td>  <?php } ?>
                                           </tr>
<?php $i++; } }else{ ?>
                                           <tr> <td colspan="5" style="text-align:  center;">Data Not Found</td></tr>                     
<?php } ?>     
                    </tbody>
                </table>

            </div>
            
        </div>
		<div class="xs tabls">
 
            <div class="bs-example4" data-example-id="contextual-table">

<div class="title-h1">
            <h3 style="text-align:  center;">Extra wallet</h3>
        </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Wallet</th>
                   <?php if($logged_company['type'] == 'c'){ ?>           <th>Action</th> <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                     <?php // print_r($list); ?>
                        
<?php  $i = 1; foreach($wallet_list as $card){ ?>
                           <tr>
                            <td><?php echo  $i; ?> </td>   
                            <td> <?php echo date('d-m-Y', strtotime($card->date)) ?></td>
                            <td><?php echo  $card->amount; ?> </td>
                            <td><?php echo  $card->batch_no; ?> </td>
                          <?php if($logged_company['type'] == 'c'){ ?>   <td>
						  <a href='<?php echo base_url(); ?>bank_deposit/wallet_payment_edit?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                        
							<a  href='<?php echo base_url(); ?>bank_deposit/wallet_payment_delete?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
						  </td>  <?php } ?>
                                           </tr>
<?php $i++; } ?>     
                    </tbody>
                </table>

            </div>
            
        </div>
		<div class="xs tabls">
			<div class="bs-example4" data-example-id="contextual-table">
				<div class="title-h1">
					<h3 style="text-align:  center;">Petty Cash Transaction</h3>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>Sr No</th>
							<th>Name</th>
							<th>Date</th>
							<th>Deposit Amount</th>
							<th>Withdrawal Amount</th>
							<?php if($logged_company['type'] == 'c'){ ?>           <th>Action</th> <?php } ?>
						</tr>
					</thead>
					<tbody>
					<?php  $i = 1; foreach($get_petty_cash_tasection_list as $card){ ?>
						<tr>
							<td><?php echo  $i; ?> </td>   
							<td><?php echo  $card->name; ?> </td>
							<td> <?php echo date('d-m-Y', strtotime($card->date)) ?></td>
							<td><?php if($card->type == 'd'){ echo  $card->amount; }?> </td>
							<td><?php if($card->type == 'c'){ echo  $card->amount; }?> </td>
							<?php if($logged_company['type'] == 'c'){ ?>   <td>
							<a href='<?php echo base_url(); ?>bank_deposit/petty_cash_edit?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
							<a  href='<?php echo base_url(); ?>bank_deposit/petty_cash_delete?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
							</td>  <?php } ?>
						</tr>
					<?php $i++; } ?>     
					</tbody>
				</table>
			</div>
		</div>
		
		
		
		<div class="xs tabls">
			<div class="bs-example4" data-example-id="contextual-table">
				<div class="title-h1">
					<h3 style="text-align:  center;">On line Cash withdrawal</h3>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>Sr No</th>
							<th>Date</th>
							<th>Name</th>
							<th>Amount</th>
							<th>Resone</th>
							<?php if($logged_company['type'] == 'c'){ ?>           <th>Action</th> <?php } ?>
						</tr>
					</thead>
					<tbody>
					<?php  $i = 1; foreach($online_bank_expance as $card){ ?>
						<tr>
							<td><?php echo  $i; ?> </td>   
							<td> <?php echo date('d-m-Y', strtotime($card->date)) ?></td>
							<td> <?php  echo  $card->user_name; ?>  </td>
							<td><?php echo  $card->amount; ?> </td>
							
							<td><?php echo  $card->bank_name; ?> </td>
							<?php if($logged_company['type'] == 'c'){ ?>   <td>
							<a href='<?php echo base_url(); ?>bank_deposit/expanses_online_edit?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
							<a  href='<?php echo base_url(); ?>bank_deposit/expanses_online_delete?id=<?php echo $card->id; ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&l_id=<?php echo $this->input->get('l_id'); ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
							</td>  <?php } ?>
						</tr>
					<?php $i++; } ?>     
					</tbody>
				</table>
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

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js') ?>"></script>


<script type="text/javascript">
    function printpdf() {
        $(".error").html("");
        var $fdate = $('#start_date').val();
        var $tdate = $('#end_date').val();
        var $location = $('#location').val();
        var temp = 0;
        if ($fdate == "") {
            temp++;
            $("#sdateerror").html('Required!');
        }
        if ($tdate == "") {
            temp++;
            $("#edateerror").html('Required!');
        }
        if ($location == "") {
            temp++;
            $("#locationerror").html('Required!');
        }
        if (temp == 0) {

            document.forms['savingdata'].action = '<?php echo site_url() ?>bank_deposit/print_report';
            document.forms['savingdata'].submit();
        } else {
            return false
        }

    }

    var table;

    var query = "";
    function search() {
        $(".error").html("");
        var $fdate = $('#start_date').val();
        var $tdate = $('#end_date').val();
        var $location = $('#location').val();
        var temp = 0;
        if ($fdate == "") {
            temp++;
            $("#sdateerror").html('Required!');
        }
        if ($tdate == "") {
            temp++;
            $("#edateerror").html('Required!');
        }
        if ($location == "") {
            temp++;
            $("#locationerror").html('Required!');
        }
        if (temp == 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>bank_deposit/reportlist",
                data: {'lid': $location, 'sdate': $fdate, 'edate': $tdate}, // serializes the form's elements.
                success: function (data)
                {
                    $("#newdata").html(data);
                }
            });
        }

    }
</script>
<script type='text/javascript'>

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