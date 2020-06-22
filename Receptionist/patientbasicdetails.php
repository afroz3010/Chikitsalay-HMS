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
                <div class="collapse navbar-collapse" id="myNavbar">
                  
                
                        
                  <ul class="nav navbar-nav navbar-right">
                  <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['receptionist']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
                </div>
              </div>
          </nav>
        <?php

            if(isset($_POST['ViewPatient'])){
                include "../dbconnection.php";
                $sql="select * from patients where PatientID="."'".$_POST['ViewPatient']."'";
                $result = $conn->query($sql);
                if($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $address=explode(",",$row['Address']);
        ?>
                    <!-- Patient Details -->
                <div class="container-fluid">
                    <form class="form-horizontal" method="post" action="oldpatientstatusoldpatientedit.php">
                        <div class="container-fluid text-center">
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">Name:</label>
                                <div class="col-md-4    ">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$row['PatientName']."'";  ?> >
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">Patient ID:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="PID" readonly value=<?php echo "'".$row['PatientID']."'";  ?> >
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                            <label class="control-label col-sm-2" for="number">Age</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" readonly value=<?php echo "'".$row['Age']."'";  ?> >
                            </div>    
                            </div>

                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="name">SEX:</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$row['Sex']."'";  ?> >
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="name">Mobile:</label>
                                <div class="col-sm-4  col-xs-8">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$row['MobileNumber']."'";  ?> >
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="number">Adhaar ID:</label>
                                <div class="col-sm-4 col-xs-8">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$row['AadharNumber']."'";  ?> >
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="number">Any Govt ID:</label>
                                <div class="col-sm-4 col-xs-8">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$row['GovtID']."'";  ?> >
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="name">Railway Employee:</label>
                                <div class="col-md-4">
                                     <input type="text" class="form-control" readonly value=<?php echo "'".$row['RailwayEmployee']."'";  ?> >
                                </div>
                            </div>
                        <?php
                        if($row['RailwayEmployee']=='Yes'){
                        ?>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2 col-xs-4" for="number">Employee ID:</label>
                                <div class="col-sm-4 col-xs-8">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$row['RailwayEmployeeID']."'";  ?> >
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">H-No:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$address[0]."'";  ?>>
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">Village</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$address[1]."'";  ?>>
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">City</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$address[2]."'";  ?> >
                                </div>
                                <label class="control-label col-sm-1" for="number">State</label>
                                <div class="col-sm-3 col-md-4">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$address[3]."'";  ?>>
                                </div>
                            </div>
                            <div class="form-group center-align col-md-offset-5">
                                <label class="control-label col-sm-2" for="name">Postal Code</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" readonly value=<?php echo "'".$address[4]."'";  ?>>
                                </div>
                            </div>
                            <?php
                              if($row['Status']=='ACTIVE'){
                            ?>
                              <div class="form-group text-center center-align col-md-offset-5">
                              <h3 class="control-label text-center col-sm-7">Patient already Active</h3>
                              </div>
                              <div class=" text-center form-group align-self-center mx-auto">
                                <input type="submit" name="ReceptionistHome" class="btn btn-success"  value="Home">
                              </div>
                            <?php
                              } 
                              else if($row['Status']=='INPATIENT'){
                            ?>
                              <div class="form-group text-center center-align col-md-offset-5">
                              <h3 class="control-label text-center col-sm-7">Patient is Admitted</h3>
                              </div>
                              <div class=" text-center form-group align-self-center mx-auto">
                                <input type="submit" name="ReceptionistHome" class="btn btn-success"  value="Home">
                              </div>
                            <?php
                              }
                              else{
                            ?>
                            <div class=" text-center form-group align-self-center mx-auto">
                                <input type="submit" name="Revisit" class="btn btn-success" onclick="return confirm('Are you sure, you want to make the patient revisit?');"  value="Revisit" <?php if($row['Status']!='CLOSED') echo 'disabled';?>>
                            </div>
                            <?php
                              }
                              ?>
                            <br>       
                    </form>

              



            </div>
        </div>
        <!-- Patient Details End -->

        <?php
                }
                $conn -> close();
            }
            if(isset($_POST['EditPatient'])){
                include "../dbconnection.php";
                $sql="select * from patients where PatientID="."'".$_POST['EditPatient']."'";
                $result = $conn->query($sql);
                if($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $address=explode(",",$row['Address']);
        ?>

                    <!-- Patient Details -->
        <div class="container-fluid">
              <form class="form-horizontal" method="post" action="oldpatientstatusoldpatientedit.php">
                  <div class="container-fluid text-center">
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">Name:</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="patientname" name="patientname" placeholder="Patient Name" value=<?php echo "'".$row['PatientName']."'"?> required>
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">Patient ID:</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" id="pid" readonly  name="PatientID" value=<?php echo "'".$row['PatientID']."'" ?> >
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                      <label class="control-label col-sm-2" for="number">Age</label>
                          <div class="col-sm-1">
                            <select class="form-control" id="age" name="age" >
                              <?php
                              for($x=1;$x<=100;$x++)
                                if($row['Age']==$x)
                                    echo "<option selected>".$x."</option>";
                                else
                                    echo "<option>".$x."</option>";
                              ?>
                            </select>
                          </div>
                      </div>

                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="name">SEX:</label>
                          <div class="col-sm-2 col-xs-6 col-md-offset-0 ml-3">
                            <label class="radio-inline">
                              <input type="radio" name="sex" value="MALE" <?php if($row['Sex']=='MALE') echo "checked"; ?>>Male
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="sex" value="FEMALE" <?php if($row['Sex']=='FEMALE') echo "checked"; ?>>Female
                            </label>  
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="name">Mobile:</label>
                          <div class="col-sm-4  col-xs-8">
                            <input class="form-control" type="text" name="mbl" placeholder="Mobile Number" value=<?php echo $row['MobileNumber']?> >
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="number">Adhaar ID:</label>
                          <div class="col-sm-4 col-xs-8">
                            <input class="form-control" type="text" id="adhar" name="adharnumber" autocomplete="off" placeholder="Adhaar Number" value=<?php echo $row['AadharNumber']?>>
                            <!-- <input type="text" size="20" autocomplete="off" class="form-control" id="number" /> -->
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="number">Any Govt ID:</label>
                          <div class="col-sm-4 col-xs-8">
                            <input class="form-control" type="text" id="govtid" name="govtid" autocomplete="off" placeholder="Govt Id" value=<?php echo $row['GovtID']?> >
                            <!-- <input type="text" size="20" autocomplete="off" class="form-control" id="number" /> -->
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="name">Railway Employee:</label>
                          <div class="col-sm-2 col-xs-6">
                            <label class="radio-inline">
                              <input type="radio" id="remp1edit" name="remp" value="Yes" onclick="displayRadioValueEdit()"  <?php if($row['RailwayEmployee']=='Yes') echo 'checked'; ?> >Yes
                            </label>
                            <label class="radio-inline">
                              <input type="radio" id="remp2edit" name="remp" value="No" onclick="displayRadioValueEdit()" <?php if($row['RailwayEmployee']=='No') echo 'checked' ?>>No
                            </label>
                          </div>
                      </div>

                      

                        <div id="railedit" class="form-group center-align col-md-offset-5">
                            <label class="control-label col-sm-2 col-xs-4" for="number">Enter ID:</label>
                            <div class="col-sm-4 col-xs-8">
                                <input class="form-control" type="number" name="rempidedit" placeholder="Employee ID" value=<?php echo $row['RailwayEmployeeID'] ?> >
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
                            <input type="text" class="form-control"  name="hno" placeholder="House Number" value=<?php echo $address[0] ?> >
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">Village</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control"  name="village" placeholder="Village Name" value=<?php echo $address[1] ?> >
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">City</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control"  name="city" placeholder="Enter City" value=<?php echo $address[2] ?> >
                          </div>
                          <label class="control-label col-sm-1" for="number">State</label>
                          <div class="col-sm-3">
                            <select class="form-control" id="state" name="state">
                              <?php
                              $state=array("Andhra Pradesh","Arunachal Pradesh","Assam","Bihar","Chhattisgarh","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and Kashmir","Jharkhand","Karnataka","Kerala","Madhya Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Odisha","Punjab","Rajasthan","Sikkim","Tamil Nadu","Telangana","Tripura","Uttarakhand","Uttar Pradesh","West Bengal","Andaman and Nicobar Islands","Chandigarh","Dadra and Nagar Haveli","Daman and Diu","Delhi","Lakshadweep","Puducherry");     
                              foreach($state as $value){
                                  if($address[3]==$value)
                                    echo "<option selected>".$value."</option>";
                                  else
                                  echo "<option>".$value."</option>";
                              }
                              ?>
                            </select>
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">Postal Code</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control"  name="pincode" placeholder="Pin Code" value=<?php echo $address[4] ?> >
                          </div>
                      </div>
                      <div class=" text-center align-self-center mx-auto">
                        <input type="submit" name="UpdatePatient" class="btn btn-success "  value="Update">
                      </div>
                      <br>       
              </form>

              



            </div>
        </div>
        <!-- Patient Details End -->









        <?php


                }
                $conn -> close();
            }
            
        ?>

















    </body>
</html>