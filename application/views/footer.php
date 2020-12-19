</div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
           
          </div>
          <strong>Copyright &copy; 2018 <a href="">Demo</a>.</strong> All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo base_url(); ?>plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>dist/js/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/admin.js" type="text/javascript"></script>

    <!-- Bootstrap 3.3.2 JS -->
    
    <!-- InputMask -->
 
    <script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
		
  
   
    
    
    <!-- FastClick -->
   
    <!-- AdminLTE App -->
 
    <!-- AdminLTE for demo purposes -->
   
    <!-- Page script -->
    <script type="text/javascript">
      $(function () {
        //Datemask dd/mm/yyyy
       $("#datemask"). inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
       
		  $("[data-mask]"). inputmask();

        
      });
    </script>
    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
     <script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": false,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": false,
          "bAutoWidth": false
        });
      });
      
    </script>
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
  </body>
</html>
