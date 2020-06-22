<?php
//session_start();
require("../process.php"); 

  if(!isset($_SESSION['doctor']) || $_SESSION['doctor'] == ""){
     //array_push($errors, "You must login/register first");
    //echo "Not Allowed";
     header(' location:doctorlogin.php');
     exit;
  }
 
?>



<head>
         
      
 <title>Chikitsalay</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
          <link  rel="stylesheet" href="../style.css">
        <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
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
                    <li><a href="doctor.php">Active Patient Records</a></li>
                    
                    <li> <a href="inpatientrecord.php">In Patient Records</a></li>
                    <li class="active"> <a  href="bulletin.php">Bulletin</a></li>
                  </ul>
                  
                  <ul class="nav navbar-nav navbar-right">
                  <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['doctor']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
                </div>
              </div>
          </nav>
          <div class="container">
                <div class="row">
                    <form action="" class="form-inline" method="post">
	                        <div class="form-group col-md-5">
	                            <label>From</label>
	                                <div class='input-group date' id='datetimepicker6'>
	                                    <input type='text' name="FromDateTime" class="form-control" required size="45"/>
	                                    <span class="input-group-addon">
	                                        <span class="glyphicon glyphicon-calendar"></span>
	                                    </span>
	      
	                                </div>
	                        </div>
	                         <div class="form-group col-md-5">
	                            <label>To</label>
	                                <div class='input-group date' id='datetimepicker7'>
	                                    <input type='text' name="ToDateTime" class="form-control" required size="45" />
	                                    <span class="input-group-addon">
	                                        <span class="glyphicon glyphicon-calendar"></span>
	                                    </span>
	                                </div>
	                           
	                        </div>
	                       
	                        <div class="text-center col-md-2">
	                            <input  type="submit" name="Bulletin" value="Submit" class="btn btn-success align-self-center mx-auto" >
	                        </div>
                    </form>
                
                </div>
            </div>


            <?php
                if(isset($_POST['Bulletin'])){
                    
                    include "../dbconnection.php";
                    $FromDateTime=$_POST['FromDateTime'].":00";
                    $ToDateTime=$_POST['ToDateTime'].":00";
                    $sql="SELECT * FROM patients p1,patientcheckup p2 where p1.PatientID=p2.PatientID AND p2.InPatient='No' AND TimeDiff('".$FromDateTime."',concat(DOC,' ',TOC))<=0 AND TimeDiff(concat(DOC,' ',TOC),'".$ToDateTime."')<=0 ORDER BY DOC,TOC ASC";
                    $result = $conn->query($sql);
                ?>    
                    <div class="container">
                        <div class="text-center">
                        <?php  echo '<h3>OutPatients From:<b>'.$FromDateTime.'</b> To: <b>'.$ToDateTime.'</b></h3>'?> 
                        </div>
                    </div>
                    <form action="bulletindownload.php" target="_blank" method="post">
                    <input type="hidden" name="FromDate" value=<?php echo "'".$FromDateTime."'" ?>>
                    <input type="hidden" name="ToDate" value=<?php echo "'".$ToDateTime."'" ?>>
                    <?php        
                    if ($result->num_rows > 0) {
                    ?>
                        <table class="table tab table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Patient Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Aadhar No</th>
                                <th>Mobile Number</th>
                                <th>Address</th>
                                <th>Date and Time of CheckUp</th>
                                <th>Patient Condition</th>
                                <th>Covid Status</th>
                                <th>Plan</th>
                            </tr>
                            </thead>
                            <tbody>

                    <?php
                        $count=1;
                        while($row = $result->fetch_assoc()){
                        // echo $row['PatientName'],$row['DOC'];

                                    echo   "<tr><td>".$count."</td><td>".$row["PatientName"]."</td><td>".$row["Age"]."</td><td>".$row["Sex"]."</td><td>".$row["AadharNumber"]."</td><td>".$row["MobileNumber"]."</td><td>".$row["Address"]."</td><td>".$row["DOC"]." ".$row['TOC']."</td><td>".$row["PatientStatus"]."</td><td>".$row["CovidStatus"]."</td><td>".$row["FollowUp"]."</td></tr>";
                                    $count++;
                        }
                    } else {
                        echo "<h4 class='text-center'>No records for OutPatients in given timings</h4>";
                    } 
                    ?>    

                            </tbody>
                        </table>
                        <hr>
                        <div class="container">
                        <div class="text-center">
                            <?php  echo '<h3>Patients Discharged From:<b>'.$FromDateTime.'</b> To: <b>'.$ToDateTime.'</b></h3>'?> 
                        </div>
                        </div>
                        
                        <?php
                            $sql="SELECT * FROM patients p1,inpatienttable p2, progresstable p3 where p1.PatientID=p2.PatientID AND p2.PatientID=p3.PatientID AND p2.DOA=p3.DOA AND TimeDiff('".$FromDateTime."',concat(DOD,' ',TOD))<=0 AND TimeDiff(concat(DOD,' ',TOD),'".$ToDateTime."')<=0 ORDER BY p2.DOA,p2.TOA ASC";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                        ?>
                            <table class="table tab table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Patient Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Aadhar No</th>
                                <th>Mobile Number</th>
                                <th>Address</th>
                                <th>Date and Time of Admission</th>
                                <th>Date and Time of Discharge</th>
                                <th>Patient Condition</th>
                                <th>Covid Status</th>
                                <th>Plan</th>
                            </tr>
                            </thead>
                            <tbody>
                        <?php        
                                $count=1;
                                while($row = $result->fetch_assoc()){
                                // echo $row['PatientName'],$row['DOC'];
        
                                echo   "<tr><td>".$count."</td><td>".$row["PatientName"]."</td><td>".$row["Age"]."</td><td>".$row["Sex"]."</td><td>".$row["AadharNumber"]."</td><td>".$row["MobileNumber"]."</td><td>".$row["Address"]."</td><td>".$row["DOA"]." ".$row['TOA']."</td><td>".$row["DOD"]." ".$row['TOD']."</td><td>".$row["PatientCondition"]."</td><td>".$row["CovidStatus"]."</td><td>".$row["Plan"]."</td></tr>";
                                            $count++;
                                }
                            } else {
                                echo "<h4 class='text-center'>No records for patients discharged in the given timings</h4>";
                            } 
                        ?>    
                            </tbody>
                        </table>

                        <hr>
                        <div class="container">
                            <div class="text-center">
                                <?php  echo '<h3>Active InPatients</h3>'?> 
                            </div>
                        </div>
                        
                        <?php
                            $sql="SELECT * FROM patients p1,inpatienttable p2, progresstable p3 where p1.PatientID=p2.PatientID AND p2.PatientID=p3.PatientID  AND p2.DOA=p3.DOA AND p2.DOD='9999-12-31' ORDER BY p2.DOA,p2.TOA ASC";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                        ?>
                            <table class="table tab table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Patient Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Aadhar No</th>
                                <th>Mobile Number</th>
                                <th>Address</th>
                                <th>Date and Time of Admission</th>
                                <th>Patient Condition</th>
                                <th>Covid Status</th>
                                <th>Plan</th>
                            </tr>
                            </thead>
                            <tbody>
                        <?php        
                                $count=1;
                                while($row = $result->fetch_assoc()){
                                // echo $row['PatientName'],$row['DOC'];
        
                                            echo   "<tr><td>".$count."</td><td>".$row["PatientName"]."</td><td>".$row["Age"]."</td><td>".$row["Sex"]."</td><td>".$row["AadharNumber"]."</td><td>".$row["MobileNumber"]."</td><td>".$row["Address"]."</td><td>".$row["DOA"]." ".$row['TOA']."</td><td>".$row["PatientCondition"]."</td><td>".$row["CovidStatus"]."</td><td>".$row["Plan"]."</td></tr>";
                                            $count++;
                                }
                            } else {
                                echo "<h4 class='text-center'>No records for Active InPatients</h4>";
                            } 
                        ?>    
                            </tbody>
                        </table>

                            <div class="text-center">
	                            <input  type="submit" name="BulletinDownload" value="Print" class="btn btn-success align-self-center mx-auto" >
	                        </div>

                        </form>

                    


                    
            <?php    
            $conn -> close();    
                }
            ?>
                

                <script type="text/javascript">
                    $(function () {
                        $('#datetimepicker6').datetimepicker(
                            {
                                format: 'YYYY-MM-DD HH:mm',
                            }
                        );
                        $('#datetimepicker7').datetimepicker({
                            format: 'YYYY-MM-DD HH:mm',
                            useCurrent: false //Important! See issue #1075
                        });
                        // $("#datetimepicker6").on("dp.change", function (e) {
                        //     $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                        // });
                        // $("#datetimepicker7").on("dp.change", function (e) {
                        //     $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                        // });
                    });
                </script>
        </body>