<?php
//session_start();
require("../process.php"); 

  if(!isset($_SESSION['receptionist']) && $_SESSION['receptionist'] == ""){
     //array_push($errors, "You must login/register first");
    //echo "Not Allowed";
     header('location:../index.php');
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
                    <a class="navbar-brand" href="receptionisthome.php">WebSiteName</a>
                    </div>
                
                    <ul class="nav navbar-nav navbar-right">
                    <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['receptionist']; ?></span></a></li>
                        <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                    </ul>
              </div>
          </nav>


        <?php
                
                if(isset($_POST['patientSubmit'])){
                  include '../dbconnection.php';
                  date_default_timezone_set("Asia/Kolkata");
                  $status="ACTIVE";
                  $address=$_POST['hno'].",".$_POST['village'].",".$_POST['city'].",".$_POST['state'].",".$_POST['pincode'];
                  $currentDate=date("Y-m-d");
                  $currentTime=date("H:i:s");
                  $sql='SELECT count(*) FROM patients where DOA ='."'".$currentDate."'";
                  $result = $conn->query($sql);
                  $count = mysqli_fetch_assoc($result)['count(*)'];
                  $patientID=strval((date("Ymd")."0000")+$count+1);
                  $stmt = $conn->prepare("INSERT INTO patients (PatientID, PatientName, Age,Sex, RailwayEmployee, RailwayEmployeeID,AadharNumber, GovtID, MobileNumber, Address, DOA, TOA, Status) VALUES (?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?, ?)");
                  $stmt->bind_param("sssssssssssss",$patientID,$_POST['patientname'],$_POST['age'],$_POST['sex'],$_POST['remp'],$_POST['rempid'],$_POST['adharnumber'],$_POST['govtid'],$_POST['mbl'],$address,$currentDate,$currentTime,$status);
                  if($stmt->execute()){
                        $stmt = $conn->prepare("INSERT INTO patientcheckup (PatientID, DOC,TOC) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss",$patientID,$currentDate,$currentTime);
                        if($stmt->execute()){
                        
                          }
                          else{
                            echo $stmt->error;
                          }
                    unset($_POST['patientSubmit']);
                ?>
                <!-- Patient Details -->
                <div class="container-fluid">
                    <form class="form-horizontal" method="post" action="receptionisthome.php">
                        <div class="container-fluid text-center">
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">Name:</label>
                                <div class="col-md-4    ">
                                    <!-- <input type="text" class="form-control" id="patientname" name="patientname" placeholder="Enter Patient Full Name" required> -->
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['patientname']."'";  ?> >
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">Patient ID:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$patientID."'";  ?> >
                                    <!-- <input type="text" class="form-control" id="pid"  name="pid" placeholder="Enter Patient ID" value=> -->
                                </div>
                                <!-- <div >
                                    <input type="submit" name="generateID" class="btn btn-success" value="Generate">
                                </div> -->
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                            <label class="control-label col-sm-2" for="number">Age</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['age']."'";  ?> >
                            </div>    
                            </div>

                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="name">SEX:</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['sex']."'";  ?> >
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="name">Mobile:</label>
                                <div class="col-sm-4  col-xs-8">
                                    <!-- <input class="form-control" type="text" name="mbl" placeholder="Mobile Number"> -->
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['mbl']."'";  ?> >
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="number">Adhaar ID:</label>
                                <div class="col-sm-4 col-xs-8">
                                    <!-- <input class="form-control" type="text" id="adhar" name="adharnumber" autocomplete="off" placeholder="Adhaar Number"> -->
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['adharnumber']."'";  ?> >
                                    <!-- <input type="text" size="20" autocomplete="off" class="form-control" id="number" /> -->
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="number">Any Govt ID:</label>
                                <div class="col-sm-4 col-xs-8">
                                    <!-- <input class="form-control" type="text" id="govtid" name="govtid" autocomplete="off" placeholder="Govt Id"> -->
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['govtid']."'";  ?> >
                                    <!-- <input type="text" size="20" autocomplete="off" class="form-control" id="number" /> -->
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="name">Railway Employee:</label>
                                <div class="col-md-4">
                                     <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['remp']."'";  ?> >
                                </div>
                            </div>
                            <div id="rail" class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="number">Enter ID:</label>
                                <div class="col-sm-4 col-xs-8">
                                    <!-- <input class="form-control" type="number" name="rempid" placeholder="Employee ID"> -->
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['rempid']."'";  ?> >
                                </div>
                            </div>
                            
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4">
                                    <span class="address">Address:- </span>
                                    </div>
                                </div> -->
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">H-No:</label>
                                <div class="col-sm-4">
                                    <!-- <input type="text" class="form-control"  name="hno" placeholder="House Number"> -->
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['hno']."'";  ?>>
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">Village</label>
                                <div class="col-sm-4">
                                    <!-- <input type="text" class="form-control"  name="village" placeholder="Village Name"> -->
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['village']."'";  ?>>
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">City</label>
                                <div class="col-sm-4">
                                    <!-- <input type="text" class="form-control"  name="city" placeholder="Enter City"> -->
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['city']."'";  ?> >
                                </div>
                                <label class="control-label col-sm-1" for="number">State</label>
                                <div class="col-sm-3 col-md-4">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['state']."'";  ?>>
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">Postal Code</label>
                                <div class="col-sm-4">
                                    <!-- <input type="text" class="form-control"  name="pincode" placeholder="Pin Code"> -->
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$_POST['pincode']."'";  ?>>
                                </div>
                            </div>
                            <div class=" text-center align-self-center mx-auto">
                                <input type="submit" name="Home" class="btn btn-success "  value="Home">
                            </div>
                            <br>       
                    </form>

              



            </div>
        </div>
        <!-- Patient Details End -->
                  

                  <?php
                  }
                  else{
                    echo "Data not upadated";
                    echo $stmt->error;
                  }
                  $conn -> close();
                }
                              
?>
                <script>
                if ( window.history.replaceState ) {
                window.history.replaceState( null, null, 'receptionisthome.php' );
                }
                </script>
            </body>
            </html>