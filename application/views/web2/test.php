<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css"> 
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#submit").click(function(){
                    var name = $("#name").val();
                    var email = $("#email").val();
                    var pass = $("#pass").val();
                    
                    
                    if(name===""|| email===""|| pass===""){
                        alert("All fields are mandatory!!!");
                        return false;   
                    }
                $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('');?>index.php/main/insert",
                    //data: data
                    data: { name: name, email: email, pass: pass }
                })
                .done(function( msg ) 
                {
                    alert( "Data Saved: " + msg );
                });
                });

            $("#cpass").change(function(){
                var pass = $("#pass").val(), 
                c_pass = $("#cpass").val();
                
            return true;
            });
            });
        </script>
        <style>
            .page-header {
                background-color:  #404040;
                color: whitesmoke;
                text-align: center;
            } 
        </style>
    </head>

    <body>
        <form method="post" id="register_form">
            <div class="container">
                <div class="col-sm-8 col-sm-offset-2"><br>
                    <div class="page-header"><h1><i>Registration Form</i></h1></div>
                    <div class="form-group">
                        <label>Name</label><input type="text" class="form-control" id="name" name="name" required/>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label><input type="text" class="form-control" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Enter valid email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label><input type="password" class="form-control" id = "pass" name="pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    </div>
                    
                    <input type="submit" id="submit" class="btn btn-primary btn-block"/>
                </div>
            </div>
        </form>
    </body>
</html>