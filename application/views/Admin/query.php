<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Your Queries
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Userhome"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Query</li>
        </ol>
    </section>
     <!-- Main content -->
    <section class="content">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Query List</h3>
                        <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">Create a new query</button>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <div class="tableclass">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 1;
                                    foreach ($query as $row) {
                                        ?>

                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td><?php echo date('d M Y -  h:i A  ',strtotime( $row['created_at'])) ?></td>
                                            <td>
                                                <a  href='<?php echo base_url(); ?>Userhome/query_delete/<?php echo $row['id']; ?>' data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are you sure you want to remove this data?');"><i class="fa fa-trash-o"></i></a>        
                                            </td>
                                        </tr>
                                        <?php
                                        $cnt++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
    function add_query() {
        var title = $('#title').val();
        var detail = $('#detail').val();
        $(".invalid-feedback").html('');
        var temp = 0;
        if (title == "") {
            $("#titleerror").html("Subject is required.");
            temp++;
        }
        if (detail == "") {
            $("#detailerror").html("Message is required.");
            temp++;
        }
        if (temp == 0) {
            var data = new FormData($('#registration_data')[0]);
            $.ajax({
                url: "<?php echo base_url(); ?>userhome/query_add",
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
        }
    }
</script>