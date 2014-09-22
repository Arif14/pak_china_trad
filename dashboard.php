<?php 

  include('./helper/login.php'); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../favicon.ico">

  <title>Dashboard</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/dashboard.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>



  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>

      <?php 
      
      include("./helper/helper_functions.php"); 

      $conn =& db_connect_header(); 
      
      ?>      

      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">

        <div class="container-fluid">
         <div class="navbar-header">
          <a class="navbar-brand" href="#">Pak-China e-Trading</a>
        </div>
        <div  class="collapse navbar-collapse">
         <ul class="nav navbar-nav navbar-right">
           <li><a href="./signin.php">Log Out</a></li>                 
         </ul>
       </div>

     </div>
   </nav>


   <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 sidebar">
        <ul class="nav nav-sidebar">
          <?php 
          
          include("./helper/dashboard_side_bar.php");


          $type =  $_SESSION["type"];

          //if($id != -1){
          // $type = getOfficeType($_SESSION["type"],$conn);


                     //  echo strcmp(strval($type),"sub_office") . "<br/>";
        //  echo "<h1> {$type} </h1>";

          if($type == 'head_office'){
               sidebar_headOffice();
          }else if($type == 'sub_office'){
               sidebar_subOffice();
           }else if($type == 'admin'){
               sidebar_adminPanel();
           }


        ?>
      </ul>
    </div>
    <div class="col-md-10 col-md-offset-2 main">

    </div>
  </div>
</div>
</div>

<?php db_connect_footer($conn); ?>
</body>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>



</html>