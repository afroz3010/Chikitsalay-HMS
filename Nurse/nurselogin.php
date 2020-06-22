<!DOCTYPE html>
<html lang="en">
<head>
  <title>Chikitsalay</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php include '../header.php';?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="">WebSiteName</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      
      <ul class="nav navbar-nav navbar-right">
      <li><a href="../index.php"><span class="glyphicon glyphicon-log-in"></span> Receptionist  Login</a></li>
        <li><a href="../Doctor/doctorlogin.php"><span class="glyphicon glyphicon-log-in"></span> Doctor Login</a></li>
        <li><a href="../Admin/adminlogin.php"><span class="glyphicon glyphicon-log-in"></span> Admin Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <form class="form-horizontal" method="post" action="../process.php">
        <div id="div_login">
            <h1> Nurse Login</h1>
            <div>
                <input type="text" class="textbox" id="txt_uname" name="uname" placeholder="Username" />
            </div>
            <div>
                <input type="password" class="textbox" id="txt_pwd" name="pwd" placeholder="Password"/>
            </div>
            <div>
             <div class="text-center">   
                <button  type="submit" name="nurseLogin" value="Submit" class="btn btn-success align-self-center mx-auto">Log In</button>
             </div>   
            </div>
        </div>
    </form>
</div>
<br><br><br><br><br><br><br>
<?php
include '../footer.php';
?>

</body>
</html>
