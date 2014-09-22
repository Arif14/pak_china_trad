<?php 
  session_start();

  session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	  <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

   
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body id="login_bg">

    <div class="container" >

      <form class="form-signin" role="form" method="post" action="./dashboard.php?side_active=0">
        <h2 class="form-signin-heading beige_color" >Please sign in</h2>
        <?php 
            
            if(isset($_GET["login"])){
               echo  '<h4 class="bg-danger">Wrong username or password</h4>';
            }       

        ?>
       <div class="form-group">
        <input type="text" name="username" class="form-control" placeholder="username" required autofocus>
       </div>
       <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
       </div>
        <div class="checkbox">
          <label class="beige_color">
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>