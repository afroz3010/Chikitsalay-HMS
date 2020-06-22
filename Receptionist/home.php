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
                      </form>
                  <ul class="nav navbar-nav navbar-right">
                  <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['receptionist']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
                
              </div>
          </nav>
        <!-- Patient Details -->
        <div class="container-fluid">
              <form class="form-horizontal" method="post" action="viewpatient.php">
                  <div class="container-fluid text-center">
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">Name:</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="patientname" name="patientname" placeholder="Enter Patient Full Name" required>
                          </div>
                      </div>
                      <!-- <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">Patient ID:</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" id="pid"  name="pid" placeholder="Enter Patient ID" value=>
                          </div>
                          <div >
                              <input type="submit" name="generateID" class="btn btn-success" value="Generate">
                          </div>
                      </div> -->
                      <div class="form-group center-align col-md-offset-5">
                      <label class="control-label col-sm-2" for="number">Age</label>
                          <div class="col-sm-1">
                            <select class="form-control" id="age" name="age">
                              <?php
                              for($x=1;$x<=100;$x++)
                                echo "<option>$x</option>";
                              ?>
                            </select>
                          </div>
                      </div>

                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="name">SEX:</label>
                          <div class="col-sm-2 col-xs-6 col-md-offset-0 ml-3">
                            <label class="radio-inline">
                              <input type="radio" name="sex" value="MALE" checked>Male
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="sex" value="FEMALE">Female
                            </label>  
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="name">Mobile:</label>
                          <div class="col-sm-4  col-xs-8">
                            <input class="form-control" type="text" name="mbl" placeholder="Mobile Number" required>
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="number">Adhaar ID:</label>
                          <div class="col-sm-4 col-xs-8">
                            <input class="form-control" type="text" id="adhar" name="adharnumber" autocomplete="off" placeholder="Adhaar Number">
                            <!-- <input type="text" size="20" autocomplete="off" class="form-control" id="number" /> -->
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="number">Any Govt ID:</label>
                          <div class="col-sm-4 col-xs-8">
                            <input class="form-control" type="text" id="govtid" name="govtid" autocomplete="off" placeholder="Govt Id">
                            <!-- <input type="text" size="20" autocomplete="off" class="form-control" id="number" /> -->
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="name">Railway Employee:</label>
                          <div class="col-sm-2 col-xs-6">
                            <label class="radio-inline">
                              <input type="radio" id="remp1" name="remp" value="Yes" onclick="displayRadioValue()" >Yes
                            </label>
                            <label class="radio-inline">
                              <input type="radio" id="remp2" name="remp" value="No" onclick="displayRadioValue()" checked>No
                            </label>
                          </div>
                      </div>
                      <div id="rail" class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2 col-xs-4" for="number">Enter ID:</label>
                          <div class="col-sm-4 col-xs-8">
                            <input class="form-control" type="number" name="rempid" placeholder="Employee ID">
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
                            <input type="text" class="form-control"  name="hno" placeholder="House Number">
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">Village</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control"  name="village" placeholder="Village Name">
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">City</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control"  name="city" placeholder="Enter City">
                          </div>
                          <label class="control-label col-sm-1" for="number">State</label>
                          <div class="col-sm-3">
                            <select class="form-control" id="state" name="state">
                              <?php
                              $state=array("Maharashtra","Andhra Pradesh","Arunachal Pradesh","Assam","Bihar","Chhattisgarh","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and Kashmir","Jharkhand","Karnataka","Kerala","Madhya Pradesh","Manipur","Meghalaya","Mizoram","Nagaland","Odisha","Punjab","Rajasthan","Sikkim","Tamil Nadu","Telangana","Tripura","Uttarakhand","Uttar Pradesh","West Bengal","Andaman and Nicobar Islands","Chandigarh","Dadra and Nagar Haveli","Daman and Diu","Delhi","Lakshadweep","Puducherry");      
                              foreach($state as $value){
                                echo "<option>$value</option>";
                              }
                              ?>
                            </select>
                          </div>
                      </div>
                      <div class="form-group center-align col-md-offset-5">
                          <label class="control-label col-sm-2" for="name">Postal Code</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control"  name="pincode" placeholder="Pin Code" required>
                          </div>
                      </div>
                      <div class=" text-center align-self-center mx-auto">
                        <input type="submit" name="patientSubmit" onclick="return confirm('Are you sure, you want to make the patient visit?');" class="btn btn-success "  value="Submit ">
                      </div>
                      <br>       
              </form>

              



            </div>
        </div>
        <!-- Patient Details End -->

        <script>
            var el = document.getElementById('receptionistDelete');

            el.addEventListener('submit', function(){
                return confirm('Are you sure want to perform the action?');
            }, false);
      </script>
        
        </body>
        </html> 
      