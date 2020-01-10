<!--A Design by W3layouts 
    Author: W3layout
    Author URL: http://w3layouts.com
    License: Creative Commons Attribution 3.0 Unported
    License URL: http://creativecommons.org/licenses/by/3.0/
    -->
    <!DOCTYPE html>
    <html>
    <head>
    <title>Login Restoran</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <!--theme-style-->
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />  
    <link href="assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" media="all" />  

    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!--fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!--//fonts-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.min.js"></script>

    <script src="assets/plugin/bootbox/bootbox.js"></script>

    <!--script-->
    </head>
    <body> 
    <?php
        session_start();
        // print_r($_SESSION);
        if(isset($_SESSION['petugas_id'])){
            header('location:public_html');
        }else{
            
        }
    ?>
        <!--header-->
    <img src="assets/images/bg-cafe.jpg" class="bg-cafe">
      <div class="container">
            <div class="row" style="margin-top: 10%;">
                <div class="col-md-4 col-md-offset-4">
                    <!-- <h1 class="login-text">Pojok Coffee</h1>
                    <h4 class="login-text">Sistem Informasi</h5> -->
                    <div class="login-panel panel panel-default re-style">
                        <!-- <div class="panel-heading re-style" style="background: rgba(0,0,0,0.5);">
                            <h1 class="login-text">Pojok Coffee</h1>
                            <h4 class="login-text">Sistem Informasi</h5>
                        </div> -->
                        <div class="panel-body">
                            <h1 class="login-text">Pojok Coffee</h1>
                            <h4 class="login-text" style="margin-bottom: 30px;">Sistem Informasi</h5>
                            <form role="form" method="POST" id="myForm" action="login.php?a=login">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control re-style" placeholder="username" name="user" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control re-style" placeholder="password" name="pass" type="password" value="">
                                    </div>
                                    
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" class="btn btn-lg btn-success btn-login btn-block" value="LOGIN" onclick="login();">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
    <script type="text/javascript">
        function login(){

          var validator = $( "#myForm" ).validate();
          if(validator.form()){
            var data = $('#myForm').serialize();
            // $.post('url', data);
            var api = "admin/fasilitas/post";
            
            $.post(api, data).done(function( data ) {
              // if (data == "1"){
              //   bootbox.alert("Data fasilitas berhasil disimpan.", function(){
              //     location.reload();
              //   })
              // }else{
              //   bootbox.alert("Gagal menyimpan data.");
              // }   
            });
            console.log(base_url);
          }
        }
    </script>
    </html>