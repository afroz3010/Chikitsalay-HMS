<?php
//session_start();
require("../process.php"); 
  if(!isset($_SESSION['nurse']) && $_SESSION['nurse'] == ""){
     //array_push($errors, "You must login/register first");
    //echo "Not Allowed";
     header('location:nurselogin.php');
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
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
          <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
          <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
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
                  <a class="navbar-brand" href="nurse.php">WebSiteName</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="nurse.php">InPatient Records</a></li>
                  </ul>    
                  
                  <ul class="nav navbar-nav navbar-right">
                  <li><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['nurse']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
              </div>
          </nav>
            <!--InPatient Details -->
            <h2 id="active-heading">InPatient Records</h2>
            <hr>
            <!-- Active InPatient Records -->

                <div class="container-fluid">

                <form action="inpatientchart.php" method="post">
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
                          $sql='SELECT PatientName,PatientID FROM patients where Status="INPATIENT"';
                          $result = $conn->query($sql);
                          if ($result->num_rows > 0) {
                            // output data of each row
                            $count=1;
                            while($row = $result->fetch_assoc()){
                                  echo   "<tr><td>".$count."</td><td>".$row["PatientName"]."</td><td>".$row["PatientID"]."</td><td><button  type='submit' name='patientChart' value=".$row['PatientID']." class='btn btn-success align-self-center mx-auto'>Edit</button></td></tr>";
                                  $count++;
                                }
                            } else {
                                echo "0 inpatients";
                            }
                            $conn -> close();
                            // conn.close();
                        ?>
                      </tbody>
                  </table>
                  </form>
                </div>
        
        <!--Active Patient Details End -->
        
        </body>
        </html>