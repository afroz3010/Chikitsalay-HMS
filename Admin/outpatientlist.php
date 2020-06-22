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
      $DOC="%%";
      if(isset($_POST['OutPatientSearch'])){
        $PatientName="%".$_POST['SearchNameOrID']."%";
        $DOC="%".$_POST['SearchDate']."%";
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
                  <a class="navbar-brand" href="admin.php">WebSiteName</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav">
                    <li><a href="admin.php">User Managment</a></li>
                    <li class="active"><a href="outpatientlist.php">OutPatient Records</a></li>
                    <li>
                      <a href="inpatientlist.php">InPatient Records</a>
                    </li>
                    <li>
                      <a href="adminbulletin.php">Bulletin</a>
                    </li>
                  </ul>
                  
                  <ul class="nav navbar-nav navbar-right">
                  <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['admin']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
                </div>
              </div>
          </nav>
          <!--Active Patient Details -->
        <h2 id="active-heading">OutPatient Records</h2>
        <hr>
            <!-- Cold Start -->
          <form method="POST" class="form-inline" action="outpatientlist.php">
            <div class="container">
                <div class=" row">
                      <div class="form-group col-md-6">
                      <label for="name">Name or PatientID:</label>
                            <input type="text" id="SearchNameOrID" class="form-control"  name="SearchNameOrID" placeholder="Name or Patient ID" size="50">
                          </div>
                          
                          <div class="form-group col-md-5">
                          <label for="name"> Date:</label>
                            <input type="text" class="form-control" id="SearchDate"  name="SearchDate" size="50">
                          </div> 
                          <div class="form-group col-md-1">
                              <button  type="submit" name="OutPatientSearch" class="btn btn-success align-self-center mx-auto">Search</button>   
                          </div>
                    </div>
              </div>
              </form>
            <!-- Cold Ends -->

        <hr>
        
        <div class="container-fluid">

          <form action="outpatientdata.php" method="post">
              <table class="table tab table-hover table-bordered table-responsive">
                  <thead>
                  <tr>
                      <th>S.No</th>
                      <th>Patient Name</th>
                      <th>Patient ID</th>
                      <th>DOC</th>
                      <th>TOC</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php  
                    include "../dbconnection.php";
                    $sql="SELECT PatientName,patientcheckup.PatientID,DOC,TOC FROM patients,patientcheckup where patientcheckup.InPatient='No' AND patients.PatientID=patientcheckup.PatientID AND(patients.PatientID LIKE '".$PatientName."' OR patients.PatientName LIKE '".$PatientName."') AND patientcheckup.DOC LIKE '".$DOC."' ORDER BY DOC DESC";
                    $result = $conn->query($sql);
                    $count=1;
                    if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                    ?>
                        <input type="hidden" name=<?php echo "PatientID".$count; ?> value=<?php echo $row['PatientID'];  ?> >
                        <input type="hidden" name=<?php echo "DOC".$count; ?> value=<?php echo $row['DOC'];  ?> >
                        <input type="hidden" name=<?php echo "TOC".$count; ?> value=<?php echo $row['TOC'];  ?> >

                      <?php
                        echo   "<tr><td>".$count."</td><td>".$row["PatientName"]."</td><td>".$row["PatientID"]."</td><td>".$row["DOC"]."</td><td>".$row["TOC"]."</td>";
                        ?>
                        <td><button  type='submit' name='OutPatientView' value=<?php echo $count; ?> class='btn btn-success align-self-center mx-auto'>View</button>&nbsp&nbsp<button  type='submit' name='OutPatientDelete' value=<?php echo $count; ?> onclick="return confirm('Are you sure, you want to delete?');" class='btn btn-danger align-self-center mx-auto'>Delete</button></td></tr>
                        <?php
                        $count++;
                      }
                      } else {
                          echo "0 results";
                      }
                      $conn -> close();

                      // conn.close();
                  ?>
                </tbody>
            </table>
            </form>
        </div>
        <script>
                        $('#SearchDate').datepicker({
              
                             dateFormat: 'yy-mm-dd'
                        });
                    </script>  
        <!-- Patient Details End -->
        </body>
        </html> 