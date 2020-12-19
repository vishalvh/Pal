	
<?php $this->load->view('web/left'); ?>
<div class="main-content">
    <?php $this->load->view('web/header'); ?>
    <div id="page-wrapper">

        <div class="page-header">
            <h3 class="blank1 pull-left" style="">Oil Packet Order  List</h3>
            </div>
        <form action="<?=base_url()?>oil_packet/set_order_stock" id="savingdata" method="get">			
            <br>
            <div class="cal-md-12">

                <!-- Select Location -->
                <div class="col-md-2">

                    <select name="location" id="location" class="form-control1" name="location">
                        <option value="">Select Location</option>
                        <?php
                        
                        foreach ($r->result() as $row) {
                            ?>
                            <option value="<?php echo $row->l_id ?>"<?php if($row->l_id == $this->input->get('location') ){ echo "selected" ;} ?>><?php echo $row->l_name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="error" id="locatione_error"></span>
                </div>
                <input type="submit"  class="btn btn-primary"  value="search">
                <br>
                <br></div>
        </form>
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
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
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Oil packet Name</th>
                            <th>Location</th>
                            <th>Type</th>
                            
                        </tr>
                      </thead>  
                    
                    
                    <tbody class="row_position">
                    <?php $count= 1; foreach($order as $key) { ?>
                        <tr id="<?= $key->id ?>" > 
                            <td><?= $count++?></td>
                            <td ><?= $key->name ?></td>
                            <td><?= $key->l_name ?></td>
                            <td><?= $key->packet_type ?></td>
                              
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <input type="hidden" name="page_order_list" id="page_order_list" />
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
<!-- <script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js') ?>"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    $( ".row_position" ).sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    });


    function updateOrder(data) {
        $.ajax({
            url:"<?=base_url()?>oil_packet/update_order",
            type:'post',
            data:{position:data},
            success:function(){
                alert('your change successfully saved');
            }
        })
    }
</script>
