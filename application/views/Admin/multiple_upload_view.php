<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 well">
            <?php echo form_open_multipart('Upload_controller/upload');?>
                <legend>Select Files to Upload:</legend>
                <div class="form-group">
                    <input name="usr_files[]" type="file" multiple="" />
                    <span class="text-danger"><?php if (isset($error)) { echo $error; } ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="Upload" class="btn btn-primary btn-block"/>
                </div>
            <?php echo form_close(); ?>
            <?php if (isset($success_msg)) { echo $success_msg; } ?>
        </div>
    </div>
</div>