<?php
//session_start();
require("../process.php"); 

  if(!isset($_SESSION['doctor']) && $_SESSION['doctor'] == ""){
     //array_push($errors, "You must login/register first");
    //echo "Not Allowed";
     header('location:doctorlogin.php');
     exit;
  }
 
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <title>Chikitsalay</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
          <link rel="stylesheet" href="../style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
    
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
          <script src="../val.js"></script>
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
                  <a class="navbar-brand" href="doctor.php">WebSiteName</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="doctor.php">Active Patient Records</a></li>
                    <li>
                      <a href="inpatientrecord.php">In Patient Records</a>
                    </li>
                    <li><a href="bulletin.php">Bulletin</a></li>
                  </ul>
                  
                  <ul class="nav navbar-nav navbar-right">
                  <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['doctor']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
                </div>
              </div>
          </nav>
        <!--Active Patient Details -->
        <h2 id="active-heading">Active Patient Records</h2>
        <hr>
        
        <div class="container-fluid">

          <form action="activepatients.php" method="post">
              <table class="table tab table-hover table-bordered table-responsive">
                  <thead>
                  <tr>
                      <th>S.No</th>
                      <th>Patient Name</th>
                      <th>Patient ID</th>
                      <th>Diagnose</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php  
                    include "../dbconnection.php";
                    $sql='SELECT * FROM patients where Status="ACTIVE"';
                    $result = $conn->query($sql);
                    $count=1;
                    if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                        
                        echo "<input type='hidden' name=PatientID".$count." value=".$row['PatientID'].">";
                        echo "<input type='hidden' name=DOC".$count." value=".$row['DOA'].">";
                        echo "<input type='hidden' name=TOC".$count." value=".$row['TOA'].">";
                        echo   "<tr><td>".$count."</td><td>".$row["PatientName"]."</td><td>".$row["PatientID"]."</td><td><button  type='submit' name='patientDiagnose' value=".$count." class='btn btn-success align-self-center mx-auto'>CheckUP</button></td></tr>";
                        $count++;
                      }
                      } else {
                          echo "No results found";
                      }
                      $conn -> close();
                      // conn.close();
                  ?>
                </tbody>
            </table>
            </form>
        </div>
            
        <!-- Patient Details End -->
        </body>
        </html> 