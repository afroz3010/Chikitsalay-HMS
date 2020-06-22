<?php
//session_start();
require("../process.php"); 

  if(!isset($_SESSION['admin']) && $_SESSION['admin'] == ""){
     //array_push($errors, "You must login/register first");
    //echo "Not Allowed";
     header('location:adminlogin.php');
     exit;
  }
 
?>
<?php
      $PatientName="%%";
      $DOA="%%";
      $DOD="%%";
      if(isset($_POST['InPatientSearch'])){
        $PatientName="%".$_POST['SearchNameOrID']."%";
        $DOA="%".$_POST['SearchDOA']."%";
        $DOD="%".$_POST['SearchDOD']."%";
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
          <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>  
         <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> 
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
                  <a class="navbar-brand" href="#">WebSiteName</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav">
                    <li><a href="admin.php">User Managment</a></li>
                    <li><a href="outpatientlist.php">OutPatient Records</a></li>
                    <li class="active"><a href="inpatientlist.php">InPatient Records</a></li>
                    <li><a href="adminbulletin.php">Bulletin</a></li>
                  </ul>
                  
                  <ul class="nav navbar-nav navbar-right">
                  <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['admin']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
                </div>
              </div>
          </nav>
          <!--Active Patient Details -->
        <h2 id="active-heading">InPatient Records</h2>
        <hr>
            <!-- Cold Start -->
          <form method="POST" action="inpatientlist.php">
            <div class="container-fluid">
                <div class=" row">
                      <div class="col-md-1">
                      <label for="name">Name or PatientID:</label>
                      </div>
                        <div class="col-md-2">
                            <input type="text" id="SearchNameOrID" class="form-control" name="SearchNameOrID" placeholder="Name or Patient ID" >
                          </div>
                          
                          <div class=" col-md-2">
                          <label for="name">Date Of Admission:</label>
                          </div>
                          <div class="col-md-2">
                          
                            <input type="text" class="form-control" id="SearchDOA"  name="SearchDOA">
                          </div> 
                          <div class="col-md-2">
                          <label for="name">Date Of Discharge:</label>
                          </div>
                          <div class="  col-md-2">
                          
                            <input type="text" class="form-control" id="SearchDOD"  name="SearchDOD">
                          </div> 
                          <div class="col-md-1">
                              <button  type="submit" name="InPatientSearch" class="btn btn-success align-self-center mx-auto">Search</button>   
                          </div>
                    </div>
              </div>
              </form>
            <!-- Cold Ends -->

        <hr>
        
        <div class="container-fluid">

          <form action="inpatientdata.php" method="post">
              <table class="table tab table-hover table-bordered table-responsive">
                  <thead>
                  <tr>
                      <th>S.No</th>
                      <th>Patient Name</th>
                      <th>Patient ID</th>
                      <th>DOA</th>
                      <th>DOD</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php  
                    include "../dbconnection.php";
                    $sql="SELECT PatientName,inpatienttable.PatientID,inpatienttable.DOA,inpatienttable.DOD FROM patients,inpatienttable where patients.PatientID=inpatienttable.PatientID AND (patients.PatientID LIKE '".$PatientName."' OR patients.PatientName LIKE '".$PatientName."') AND inpatienttable.DOA LIKE '".$DOA."' AND inpatienttable.DOD LIKE '".$DOD."' ORDER BY DOA DESC";
                    $result = $conn->query($sql);
                    $count=1;
                    if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                    ?>
                       <input type="hidden" name=<?php echo "PatientID".$count; ?> value=<?php echo $row['PatientID'];  ?> >
                        <input type="hidden" name=<?php echo "DOA".$count; ?> value=<?php echo $row['DOA'];  ?> >
                        <input type="hidden" name=<?php echo "DOD".$count; ?> value=<?php echo $row['DOD'];  ?> >
                      <?php
                      if($row['DOD']=="9999-12-31"){
                        echo   "<tr><td>".$count."</td><td>".$row["PatientName"]."</td><td>".$row["PatientID"]."</td><td>".$row["DOA"]."</td><td>"."ACTIVE"."</td>";
                        ?>
                            <td><button  type='submit' name='InPatientView' value=<?php echo $count; ?> class='btn btn-success align-self-center mx-auto'>View</button>&nbsp&nbsp<button  type='submit' name='InPatientDelete' value=<?php echo $count; ?> onclick="return confirm('Are you sure, you want to delete?');" class='btn btn-danger align-self-center mx-auto'>Delete</button></td></tr>
                        <?php
                      }
                      else{
                        echo   "<tr><td>".$count."</td><td>".$row["PatientName"]."</td><td>".$row["PatientID"]."</td><td>".$row["DOA"]."</td><td>".$row["DOD"]."</td>";
                        ?>
                            <td><button  type='submit' name='InPatientView' value=<?php echo $count; ?> class='btn btn-success align-self-center mx-auto'>View</button>&nbsp&nbsp<button  type='submit' name='InPatientDelete' value=<?php echo $count; ?> onclick="return confirm('Are you sure, you want to delete?');" class='btn btn-danger align-self-center mx-auto'>Delete</button></td></tr>
                        <?php
                      }
                        $count++;
                      }
                      } else {
                          echo "No results";
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
        <script>
                        $('#SearchDOA').datepicker({
              
                             dateFormat: 'yy-mm-dd'
                        });
                        $('#SearchDOD').datepicker({
              
              dateFormat: 'yy-mm-dd'
         });
                    </script>  
        </html> 