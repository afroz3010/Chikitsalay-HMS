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
if(isset($_POST['OutPatientDelete'])){
  $rowcount=$_POST['OutPatientDelete'];
  $PatientID=$_POST['PatientID'.$rowcount];
  $DOC= $_POST['DOC'.$rowcount];
  $TOC=$_POST['TOC'.$rowcount];
  include "../dbconnection.php";
  $stmt = $conn->prepare("DELETE FROM patientcheckup WHERE PatientID=? AND DOC=? AND TOC=?");
  $stmt->bind_param("sss", $PatientID,$DOC,$TOC);
  if($stmt->execute()){
    // echo "Deleted record";

  }
  else{
      echo "error on deleting";
  }
  $conn -> close();
  header('location:outpatientlist.php');

}
if(isset($_POST['OutPatientView'])){
  $rowcount=$_POST['OutPatientView'];
  $PatientID=$_POST['PatientID'.$rowcount];
  $DOC= $_POST['DOC'.$rowcount];
  $TOC=$_POST['TOC'.$rowcount];
    $tab=1;
}
else if(isset($_POST['ComplaintEdit'])){
  $PatientID=$_POST['PatientID'];
  $DOC=$_POST['DOC'];
  $TOC=$_POST['TOC'];
  $tab=1;
}
else if(isset($_POST['ComplaintUpdate'])){
  include "../dbconnection.php";
  $PatientID=$_POST['PatientID'];
  $DOC=$_POST['DOC'];
  $TOC=$_POST['TOC'];
  if($_POST['Cold']=='No'){
    $ColdDuration=0;
  }
  else{
    $ColdDuration=$_POST['ColdDays'];
  }
  if($_POST['Cough']=='No'){
    $CoughType="No";
    $CoughDuration=0;
  }
  else{
    $CoughType=$_POST['CoughType'];
    $CoughDuration=$_POST['CoughDays'];
  }
  if($_POST['SOB']=='No'){
    $SOBDuration=0;
  }
  else{
    $SOBDuration=$_POST['SOBDays'];
  }
  if($_POST['Fever']=='No'){
    $FeverDuration=0;
  }
  else{
    $FeverDuration=$_POST['FeverDays'];
  }
  $stmt = $conn->prepare("UPDATE patientcheckup SET Cold=?, ColdDuration=? ,     Cough =? ,     CoughType =?,     CoughDuration =?,     SOB=?  ,     SOBDuration=? ,     Fever =? ,     FeverDuration =?,     SoreThroat =? ,     TravelHistory =? ,     ContactHistory =? ,     OtherComplaints=? WHERE PatientID=? AND DOC=? AND TOC=?");
  $stmt->bind_param("sissisisisssssss", $_POST['Cold'],$ColdDuration,$_POST['Cough'],$CoughType,$CoughDuration,$_POST['SOB'],$SOBDuration,$_POST['Fever'],$FeverDuration,$_POST['SoreThroat'],$_POST['TravelHistory'],$_POST['ContactHistory'],$_POST['OtherComplaints'],$PatientID,$DOC,$TOC);
  if($stmt->execute()){
    // echo "Updated Complaints";
    $tab=1;

  }
  else{
      echo "error on updating";
  }
  $conn -> close();
  
  
}
else if(isset($_POST['ComorbiditiesEdit'])){
  $PatientID=$_POST['PatientID'];
  $DOC=$_POST['DOC'];
  $TOC=$_POST['TOC'];
  $tab=2;
}
else if(isset($_POST['ComorbiditiesUpdate'])){
  include "../dbconnection.php";
  $PatientID=$_POST['PatientID'];
  $DOC=$_POST['DOC'];
  $TOC=$_POST['TOC'];
  $stmt = $conn->prepare("UPDATE patientcheckup SET	HTN=?  ,     DM =? ,     IHD=?  ,     Asthma =? ,     CLD =? ,     Seizure =? ,     OtherComorbidities =? WHERE PatientID=? AND DOC=? AND TOC=?");
  $stmt->bind_param("ssssssssss",$_POST['htn'],$_POST['dm'],$_POST['ihdmi'],$_POST['asthmacopd'],$_POST['cld'],$_POST['seizuredisorder'],$_POST['otherComorbidities'],$PatientID,$DOC,$TOC);
  

  if($stmt->execute()){
    // echo "Updated Comorbidities";
    $tab=2;

  }
  else{
      echo "error on updating";
  }
  $conn -> close();
  
}
else if(isset($_POST['AddictionsEdit'])){
  $PatientID=$_POST['PatientID'];
  $DOC=$_POST['DOC'];
  $TOC=$_POST['TOC'];
  $tab=3;
}
else if(isset($_POST['AddictionsUpdate'])){
  include "../dbconnection.php";
  $PatientID=$_POST['PatientID'];
  $DOC=$_POST['DOC'];
  $TOC=$_POST['TOC'];
  $stmt = $conn->prepare("UPDATE patientcheckup SET	Smoking=?  ,     Alcohol =? ,     Gutka=?  ,     OtherAddictions=? WHERE PatientID=? AND DOC=? AND TOC=?");
  $stmt->bind_param("sssssss",$_POST['smoking'],$_POST['alcohol'],$_POST['gutka'],$_POST['otherAddictions'],$PatientID,$DOC,$TOC);
  

  if($stmt->execute()){
    // echo "Updated Addictions";
    $tab=3;

  }
  else{
      echo "error on updating";
  }
  $conn -> close();
  
}
else if(isset($_POST['ExaminationEdit'])){
  $PatientID=$_POST['PatientID'];
  $DOC=$_POST['DOC'];
  $TOC=$_POST['TOC'];
  $tab=4;
}
else if(isset($_POST['ExaminationUpdate'])){
  include "../dbconnection.php";
  $PatientID=$_POST['PatientID'];
  $DOC=$_POST['DOC'];
  $TOC=$_POST['TOC'];
  $stmt = $conn->prepare("UPDATE patientcheckup SET Pallor=?,Icterus=?,Clubbing=?,Cyanosis=?,Lympadenopathy=?,Edema=?,Temp=?,HR=?,BP=?,RR=?,SPO2=?,CNS=?,CVS=?,RS=?,GIT=?,OtherSystemic=?  WHERE PatientID=? AND DOC=? AND TOC=?");
    $stmt->bind_param("sssssssssssssssssss", $_POST['Pallor'],$_POST['Icterus'],$_POST['Clubbing'],$_POST['Cyanosis'],$_POST['lympadenopathy'],$_POST['Edema'],$_POST['Temp'],$_POST['HR'],$_POST['BP'],$_POST['RR'],$_POST['SPO2'],$_POST['CNS'],$_POST['CVS'],$_POST['RS'],$_POST['GIT'],$_POST['otherSystemic'],$PatientID,$DOC,$TOC);
    if($stmt->execute()){
      // echo "Updated Complaints";
      $tab=4;

    }
    else{
        echo "error on updating";
    }
    $conn -> close();
}
            
?>





<?php
if($tab==0 || $tab==1 || $tab==2 ||  $tab==3 || $tab==4 || $tab=5){
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
            <script>
           window.onload=function(){
              displayCold();
              displayCough();
              displaySOB();
              displayFever();
              displayInPatient();
              }
            </script>

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
                  <a class="navbar-brand" href="adminlogin.php">WebSiteName</a>
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
        <hr>
        <?php
         
           include "../dbconnection.php";
           $sql="SELECT PatientName FROM patients where PatientID='".$PatientID."'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            // output data of each row
            if($row = $result->fetch_assoc()){
              $PatientName=$row['PatientName'];
            }
            }
            $conn -> close();
        ?>
           <div class="container">
              <div class="row">
                <div class=" col-md-4">
                  
                  <h3>Patient Name:<?php echo " ".$PatientName; ?></h3>  
                </div>
                <div class="col-md-4 ">
                  <h3>Patient ID:<?php echo " ".$PatientID;?></h3>
                </div>
                <div class="col-md-4 ">
                  <h3>Date of Checkup:<?php echo " ".$DOC;?></h3>
                </div>
              </div>
           </div>
        
            <div class="container-fluid">
                <div class="row">
                <div class="col-md-12">
                        <div class="panel with-nav-tabs panel-primary">
                            <div class="panel-heading">
                                    <ul class="nav nav-tabs">
                                        <li class=<?php if ($tab==0) echo "active";else echo "inactive"; ?>><a href="#tab0primary" data-toggle="tab">PATIENT DETAILS</a></li>
                                        <li class=<?php if ($tab==1) echo "active";else echo "inactive"; ?>><a href="#tab1primary" data-toggle="tab">PATIENT COMPLAINTS</a></li>
                                        <li class=<?php if ($tab==2) echo "active"; else echo "inactive"; ?>><a href="#tab2primary" data-toggle="tab">COMORBIDITIES</a></li>
                                        <li class=<?php if ($tab==3) echo "active"; else echo "inactive"; ?>><a href="#tab3primary" data-toggle="tab">ADDICTIONS</a></li>
                                        <li class=<?php if ($tab==4) echo "active"; else echo"inactive"; ?>><a href="#tab4primary" data-toggle="tab">EXAMINATION</a></li>
                                        <li class=<?php if($tab==5) echo "active"; else echo "inactive"; ?>><a href="#tab5primary" data-toggle="tab">OTHERS</a></li>
                                    </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                      <div class=" <?php if ($tab==0) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab0primary">

                                          <?php
                                                include "../dbconnection.php";
                                                $sql="select * from patients where PatientID="."'".$PatientID."'";
                                                $result = $conn->query($sql);
                                                $row = $result->fetch_assoc();
                                          ?>
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
                                                          <label class="control-label col-sm-2 col-xs-4" for="number">Aadhaar ID:</label>
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
                                                          <label class="control-label col-sm-2 col-xs-4" for="name">Address:</label>
                                                          <div class="col-sm-4">
                                                              <p class="control-label col-sm-2 col-xs-4"><?php echo $row['Address'];  ?></p>
                                                              <!-- <input type="text" class="form-control" readonly value=<?php echo "'".$row['Address']."'";  ?>> -->
                                                          </div>
                                                      </div>
                                                      <br>       
                                              </form>
                                        </div>
                                    </div>
                                    <?php
                                      $sql="SELECT * FROM patientcheckup WHERE PatientID="."'".$PatientID."'"." AND DOC='".$DOC."'  AND TOC='".$TOC."'";
                                      $result = $conn->query($sql);
                                      if ($result->num_rows > 0) {
                                        // output data of each row
                                        $row = $result->fetch_assoc();
                                        } else {
                                            echo "0 results";
                                        }
                                      ?>
                                    <div class="<?php if ($tab==1) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab1primary">
                                      <?php
                                          if(isset($_POST['ComplaintEdit'])){
                                            //   echo $PatientID;
                                            //   echo $DOC;
                                      ?>
                                        <div class="container-field">
                                              <form  class="form-horizontal"  method="post" action="outpatientdata.php">
                                                  <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                  <input type="hidden" name="DOC" value=<?php echo $DOC; ?>>
                                                  <input type="hidden" name="TOC" value=<?php echo $TOC; ?>>
                                                  <!-- Cold Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Cold:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="cold1" name="Cold" value="Yes" onclick="displayCold()" <?php if($row['Cold']=='Yes') echo "checked"; ?>  >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="cold2" name="Cold" value="No" onclick="displayCold()" <?php if($row['Cold']=='No') echo "checked"; ?>>No
                                                        </label>
                                                      </div>

                                                    
                                                          <div id="displayCold">
                                                            <label class="control-label col-sm-1" for="name">Duration:</label>
                                                            <div class="col-sm-2">
                                                              <input type="text" class="form-control" id="coldDays"  name="ColdDays" placeholder="No of Days" value=<?php echo $row['ColdDuration'] ?>>
                                                            </div>    
                                                        </div>
                                                        
                                                  </div>
                                                <!-- Cold Ends -->
                                                <!-- Cough Starts -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Cough:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="cough1" name="Cough" value="Yes" onclick="displayCough()" <?php if($row['Cough']=='Yes') echo "checked"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="cough2" name="Cough" value="No" onclick="displayCough()" <?php if($row['Cough']=='No') echo "checked"; ?>>No
                                                        </label>
                                                      </div>
                                                      <div id="displayCough">
                                                        <label class="control-label col-sm-1" for="number">Type</label>
                                                        <div class="col-sm-1">
                                                          <select class="form-control" id="coughType" name="CoughType" >
                                                            <option <?php if($row['CoughType']=='Dry') echo 'selected'; ?>>Dry</option>
                                                            <option <?php if($row['CoughType']=='Expectorant') echo 'selected'; ?>>Expectorant</option>
                                                          </select>
                                                        </div>
                                                        <label class="control-label col-sm-1" for="name">Duration</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="coughDays"  name="CoughDays" placeholder="No of Days" value=<?php echo $row['CoughDuration']; ?>>
                                                        </div>    
                                                    </div>
                                                  </div>
                                                <!-- Cough ends -->
                                                <!-- SOB Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">SOB:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="sob1" name="SOB" value="Yes" onclick="displaySOB()" <?php if($row['SOB']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="sob2" name="SOB" value="No" onclick="displaySOB()" <?php if($row['SOB']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                      <div id="displaySOB">
                                                        <label class="control-label col-sm-1" for="name">Duration:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="sobDays"  name="SOBDays" placeholder="No of Days" value=<?php echo $row['SOBDuration']; ?>>
                                                        </div>    
                                                    </div>
                                                  </div>
                                                <!-- SOB Ends -->
                                                <!-- fever Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Fever:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="fever1" name="Fever" value="Yes" onclick="displayFever()" <?php if($row['Fever']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="fever2" name="Fever" value="No" onclick="displayFever()" <?php if($row['Fever']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                      <div id="displayFever">
                                                        <label class="control-label col-sm-1" for="name">Duration:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="feverDays"  name="FeverDays" placeholder="No of Days" value=<?php echo $row['FeverDuration']; ?>>
                                                        </div>    
                                                    </div>
                                                  </div>
                                                <!-- fever Ends -->
                                                <!-- Sorethroat Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Sorethroat:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                      <label class="radio-inline">
                                                          <input type="radio" id="sore1" name="SoreThroat" value="Yes"  <?php if($row['SoreThroat']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="sore2" name="SoreThroat" value="No"  <?php if($row['SoreThroat']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- Sorethroat Ends -->
                                                <!-- TravelHistory Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Travel History:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="TravelHistory" value="Yes"  <?php if($row['TravelHistory']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="TravelHistory" value="No"  <?php if($row['TravelHistory']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- TravelHistory Ends -->
                                                <!-- ContactHistory Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Contact History:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="ContactHistory" value="Yes"  <?php if($row['ContactHistory']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="ContactHistory" value="No"  <?php if($row['ContactHistory']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- ContactHistory Ends -->
                                                 <!-- otherSymptoms Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">OtherComplaints:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                          <textarea class="form-control" id="OtherComplaints" name="OtherComplaints" rows="3" column="3" ><?php echo $row['OtherComplaints']; ?></textarea>
                                                      </div>
                                                  </div>
                                                <!-- OtherSymptoms Ends -->
                                                <div class="text-center">   
                                                    <input  type="submit" name="ComplaintUpdate" value="Update" class="btn btn-success align-self-center mx-auto" >
                                                </div>
                                          </form>
                                          </div>


                                      <?php


                                          }
                                          else{
                                      ?>
                                                <div class="container-fluid">
                                      
                                              <form  class="form-horizontal"  method="post" action="outpatientdata.php">
                                                      <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                      <input type="hidden" name="DOC" value=<?php echo $DOC; ?>>
                                                      <input type="hidden" name="TOC" value=<?php echo $TOC; ?>>
                                                      <!-- Cold Start -->
                                                      <div class="form-group center-align col-md-offset-2">
                                                          <label class="control-label col-sm-2 col-xs-4" for="name">Cold:</label>
                                                          <div class="col-sm-2 col-xs-6">
                                                            <label class="radio-inline">
                                                              <input type="radio" id="cold1" name="Cold" value="Yes" onclick="displayCold()" <?php if($row['Cold']=='Yes') echo "checked"; else echo "disabled"; ?>  >Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" id="cold2" name="Cold" value="No" onclick="displayCold()" <?php if($row['Cold']=='No') echo "checked";  else echo "disabled"; ?>>No
                                                            </label>
                                                          </div>

                                                        
                                                              <div id="displayCold">
                                                                <label class="control-label col-sm-1" for="name">Duration:</label>
                                                                <div class="col-sm-2">
                                                                  <input type="text" class="form-control" id="coldDays"  name="ColdDays" readonly placeholder="No of Days" value=<?php echo $row['ColdDuration'] ?>>
                                                                </div>    
                                                            </div>
                                                            
                                                      </div>
                                                    <!-- Cold Ends -->
                                                    <!-- Cough Starts -->
                                                      <div class="form-group center-align col-md-offset-2">
                                                          <label class="control-label col-sm-2 col-xs-4" for="name">Cough:</label>
                                                          <div class="col-sm-2 col-xs-6">
                                                            <label class="radio-inline">
                                                              <input type="radio" id="cough1" name="Cough" value="Yes" onclick="displayCough()" <?php if($row['Cough']=='Yes') echo "checked"; else echo "disabled"; ?>>Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" id="cough2" name="Cough" value="No" onclick="displayCough()" <?php if($row['Cough']=='No') echo "checked"; else echo "disabled"; ?>>No
                                                            </label>
                                                          </div>
                                                          <div id="displayCough">
                                                            <label class="control-label col-sm-1" for="number">Type</label>
                                                            <div class="col-sm-1">
                                                              <select class="form-control" id="coughType" name="CoughType" disabled>
                                                                <option <?php if($row['CoughType']=='Dry') echo 'selected'; ?>>Dry</option>
                                                                <option <?php if($row['CoughType']=='Expectorant') echo 'selected'; ?>>Expectorant</option>
                                                              </select>
                                                            </div>
                                                            <label class="control-label col-sm-1" for="name">Duration</label>
                                                            <div class="col-sm-2">
                                                              <input type="text" class="form-control" id="coughDays" readonly  name="CoughDays" placeholder="No of Days" value=<?php echo $row['CoughDuration']; ?>>
                                                            </div>    
                                                        </div>
                                                      </div>
                                                    <!-- Cough ends -->
                                                    <!-- SOB Start -->
                                                      <div class="form-group center-align col-md-offset-2">
                                                          <label class="control-label col-sm-2 col-xs-4" for="name">SOB:</label>
                                                          <div class="col-sm-2 col-xs-6">
                                                            <label class="radio-inline">
                                                              <input type="radio" id="sob1" name="SOB" value="Yes" onclick="displaySOB()" <?php if($row['SOB']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" id="sob2" name="SOB" value="No" onclick="displaySOB()" <?php if($row['SOB']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                            </label>
                                                          </div>
                                                          <div id="displaySOB">
                                                            <label class="control-label col-sm-1" for="name">Duration:</label>
                                                            <div class="col-sm-2">
                                                              <input type="text" class="form-control" id="sobDays"  name="SOBDays" readonly placeholder="No of Days" value=<?php echo $row['SOBDuration']; ?>>
                                                            </div>    
                                                        </div>
                                                      </div>
                                                    <!-- SOB Ends -->
                                                    <!-- fever Start -->
                                                      <div class="form-group center-align col-md-offset-2">
                                                          <label class="control-label col-sm-2 col-xs-4" for="name">Fever:</label>
                                                          <div class="col-sm-2 col-xs-6">
                                                            <label class="radio-inline">
                                                              <input type="radio" id="fever1" name="Fever" value="Yes" onclick="displayFever()" <?php if($row['Fever']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" id="fever2" name="Fever" value="No" onclick="displayFever()" <?php if($row['Fever']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                            </label>
                                                          </div>
                                                          <div id="displayFever">
                                                            <label class="control-label col-sm-1" for="name">Duration:</label>
                                                            <div class="col-sm-2">
                                                              <input type="text" class="form-control" id="feverDays"  name="FeverDays" readonly placeholder="No of Days" value=<?php echo $row['FeverDuration']; ?>>
                                                            </div>    
                                                        </div>
                                                      </div>
                                                    <!-- fever Ends -->
                                                    <!-- Sorethroat Start -->
                                                      <div class="form-group center-align col-md-offset-2">
                                                          <label class="control-label col-sm-2 col-xs-4" for="name">Sorethroat:</label>
                                                          <div class="col-sm-2 col-xs-6">
                                                          <label class="radio-inline">
                                                              <input type="radio" id="sore1" name="SoreThroat" value="Yes"  <?php if($row['SoreThroat']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" id="sore2" name="SoreThroat" value="No"  <?php if($row['SoreThroat']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                            </label>
                                                          </div>
                                                      </div>
                                                    <!-- Sorethroat Ends -->
                                                    <!-- TravelHistory Start -->
                                                      <div class="form-group center-align col-md-offset-2">
                                                          <label class="control-label col-sm-2 col-xs-4" for="name">Travel History:</label>
                                                          <div class="col-sm-2 col-xs-6">
                                                            <label class="radio-inline">
                                                              <input type="radio" id="radioValue1" name="TravelHistory" value="Yes"  <?php if($row['TravelHistory']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" id="radioValue2" name="TravelHistory" value="No"  <?php if($row['TravelHistory']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                            </label>
                                                          </div>
                                                      </div>
                                                    <!-- TravelHistory Ends -->
                                                    <!-- ContactHistory Start -->
                                                      <div class="form-group center-align col-md-offset-2">
                                                          <label class="control-label col-sm-2 col-xs-4" for="name">Contact History:</label>
                                                          <div class="col-sm-2 col-xs-6">
                                                            <label class="radio-inline">
                                                              <input type="radio" id="radioValue1" name="ContactHistory" value="Yes"  <?php if($row['ContactHistory']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" id="radioValue2" name="ContactHistory" value="No"  <?php if($row['ContactHistory']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                            </label>
                                                          </div>
                                                      </div>
                                                    <!-- ContactHistory Ends -->
                                                    <!-- otherSymptoms Start -->
                                                      <div class="form-group center-align col-md-offset-2">
                                                          <label class="control-label col-sm-2 col-xs-4" for="name">OtherComplaints:</label>
                                                          <div class="col-sm-2 col-xs-6">
                                                              <textarea class="form-control" id="OtherComplaints" readonly name="OtherComplaints" rows="3" column="3" ><?php echo $row['OtherComplaints']; ?></textarea>
                                                          </div>
                                                      </div>
                                                    <!-- OtherSymptoms Ends -->
                                                    <div class="text-center">   
                                                        <input  type="submit" name="ComplaintEdit" value="Edit" class="btn btn-success align-self-center mx-auto" >
                                                    </div>
                                                    
                                              </form>
                                          </div>
                                      <?php
                                          }
                                      ?>
                                    </div>
                                    




                                    <div class="<?php if ($tab==2) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab2primary">
                                      <?php
                                          if(isset($_POST['ComorbiditiesEdit'])){
                                      ?>
                                              <form  class="form-horizontal" method="post" action="outpatientdata.php">
                                                      <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                      <input type="hidden" name="DOC" value=<?php echo $DOC; ?>>
                                                      <input type="hidden" name="TOC" value=<?php echo $TOC; ?>>
                                                  <!-- HTN Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">H.T.N:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" class="radioValue1" name="htn" value="Yes"  <?php if($row['HTN']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" class="radioValue2" name="htn" value="No" <?php if($row['HTN']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                      
                                                  </div>
                                                <!-- HTN Ends -->
                                                <!-- DM Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">D.M:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="dm" value="Yes"  <?php if($row['DM']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="dm" value="No"  <?php if($row['DM']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                </div>
                                                <!-- DM Ends -->
                                                 <!-- IHD/MI Start -->
                                                 <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">IHD/MI:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="ihdmi" value="Yes"  <?php if($row['IHD']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="ihdmi" value="No"  <?php if($row['IHD']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- IHD/MI Ends -->
                                                <!-- ASTHMA/COPD Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">ASTHMA/COPD:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="asthmacopd" value="Yes"  <?php if($row['Asthma']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="asthmacopd" value="No"  <?php if($row['Asthma']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                </div>
                                                <!-- ASTHMA/COPD Ends -->
                                                <!-- CLD Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">C.L.D:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="cld" value="Yes"  <?php if($row['CLD']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="cld" value="No" <?php if($row['CLD']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- CLD Ends -->
                                                <!-- SEIZURE DISORDER Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">SEIZURE DISORDER</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="seizuredisorder" value="Yes"  <?php if($row['Seizure']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="seizuredisorder" value="No"  <?php if($row['Seizure']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- SEIZURE DISORDER Ends -->
                                                 <!-- otherComorbidities Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">OtherComorbidities:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                          <textarea class="form-control" id="otherComorbidities" name="otherComorbidities" rows="3" column="3"><?php echo $row['OtherComorbidities']; ?></textarea>
                                                      </div>
                                                  </div>
                                                <!-- OtherComorbidities Ends -->
                                                <div class="text-center">   
                                                    <input  type="submit" name="ComorbiditiesUpdate" value="Update" class="btn btn-success align-self-center mx-auto">
                                                </div>
                                          </form>


                                      <?php

                                          }
                                          else{
                                      ?>
                                            <form  class="form-horizontal" method="post" action="outpatientdata.php">
                                                      <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                      <input type="hidden" name="DOC" value=<?php echo $DOC; ?>>
                                                      <input type="hidden" name="TOC" value=<?php echo $TOC; ?>>
                                                  <!-- HTN Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">H.T.N:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" class="radioValue1" name="htn" value="Yes"  <?php if($row['HTN']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" class="radioValue2" name="htn" value="No" <?php if($row['HTN']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                      
                                                  </div>
                                                <!-- HTN Ends -->
                                                <!-- DM Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">D.M:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="dm" value="Yes"  <?php if($row['DM']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="dm" value="No"  <?php if($row['DM']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                </div>
                                                <!-- DM Ends -->
                                                 <!-- IHD/MI Start -->
                                                 <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">IHD/MI:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="ihdmi" value="Yes"  <?php if($row['IHD']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="ihdmi" value="No"  <?php if($row['IHD']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- IHD/MI Ends -->
                                                <!-- ASTHMA/COPD Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">ASTHMA/COPD:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="asthmacopd" value="Yes"  <?php if($row['Asthma']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="asthmacopd" value="No"  <?php if($row['Asthma']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                </div>
                                                <!-- ASTHMA/COPD Ends -->
                                                <!-- CLD Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">C.L.D:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="cld" value="Yes"  <?php if($row['CLD']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="cld" value="No" <?php if($row['CLD']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- CLD Ends -->
                                                <!-- SEIZURE DISORDER Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">SEIZURE DISORDER</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="seizuredisorder" value="Yes"  <?php if($row['Seizure']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="seizuredisorder" value="No"  <?php if($row['Seizure']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- SEIZURE DISORDER Ends -->
                                                 <!-- otherComorbidities Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">OtherComorbidities:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                          <textarea class="form-control" id="otherComorbidities" readonly name="otherComorbidities" rows="3" column="3"><?php echo $row['OtherComorbidities'];  ?></textarea>
                                                      </div>
                                                  </div>
                                                <!-- OtherComorbidities Ends -->
                                                    <div class="text-center">   
                                                        <input  type="submit" name="ComorbiditiesEdit" value="Edit" class="btn btn-success align-self-center mx-auto" >
                                                    </div>
                                          </form>
                                          <?php
                                          }
                                          ?>
                                    </div>
                                    <div class=" <?php if ($tab==3) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab3primary">
                                      <?php
                                        if(isset($_POST['AddictionsEdit'])){
                                        ?>
                                        <form  class="form-horizontal" method="post" action="outpatientdata.php">
                                                    <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                    <input type="hidden" name="DOC" value=<?php echo $DOC; ?>>
                                                    <input type="hidden" name="TOC" value=<?php echo $TOC; ?>>
                                                  <!-- Smoking Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Smoking</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="smoking" value="Yes"  <?php if($row['Smoking']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="smoking" value="No"  <?php if($row['Smoking']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                      
                                                  </div>
                                                <!-- Smoking Ends -->
                                                <!-- Alcohol Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Alcohol</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="alcohol" value="Yes"  <?php if($row['Alcohol']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="alcohol" value="No"  <?php if($row['Alcohol']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                </div>
                                                <!-- Alcohol Ends -->
                                                 <!-- Gutka Chewing Start -->
                                                 <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Gutka Chewing</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="gutka" value="Yes"  <?php if($row['Gutka']=='Yes') echo 'checked'; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="gutka" value="No"  <?php if($row['Gutka']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- Gutka Chewing Ends -->
                                                
                                                 <!-- other Addictions Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Other Addictions:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                          <textarea class="form-control" id="otherAddictions" name="otherAddictions" rows="3" column="3" ><?php echo $row['OtherAddictions']; ?></textarea>
                                                      </div>
                                                  </div>
                                                <!-- Other Addictions Ends -->
                                                <div class="text-center">   
                                                    <input  type="submit" name="AddictionsUpdate" value="Update" class="btn btn-success align-self-center mx-auto" >
                                                </div>
                                          </form>
                                    <?php
                                        }
                                        else{
                                      ?>
                                            <form  class="form-horizontal" method="post" action="outpatientdata.php">
                                                    <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                    <input type="hidden" name="DOC" value=<?php echo $DOC; ?>>
                                                    <input type="hidden" name="TOC" value=<?php echo $TOC; ?>>
                                                  <!-- Smoking Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Smoking</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="smoking" value="Yes"  <?php if($row['Smoking']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="smoking" value="No"  <?php if($row['Smoking']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                      
                                                  </div>
                                                <!-- Smoking Ends -->
                                                <!-- Alcohol Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Alcohol</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="alcohol" value="Yes"  <?php if($row['Alcohol']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="alcohol" value="No"  <?php if($row['Alcohol']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                </div>
                                                <!-- Alcohol Ends -->
                                                 <!-- Gutka Chewing Start -->
                                                 <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Gutka Chewing</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="gutka" value="Yes"  <?php if($row['Gutka']=='Yes') echo 'checked'; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="gutka" value="No"  <?php if($row['Gutka']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- Gutka Chewing Ends -->
                                                
                                                 <!-- other Addictions Start -->
                                                  <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Other Addictions:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                          <textarea class="form-control" id="otherAddictions"  readonly name="otherAddictions" rows="3" column="3" ><?php echo $row['OtherAddictions']; ?></textarea>
                                                      </div>
                                                  </div>
                                                <!-- Other Addictions Ends -->
                                                <div class="text-center">   
                                                    <input  type="submit" name="AddictionsEdit" value="Edit" class="btn btn-success align-self-center mx-auto" >
                                                </div>
                                          </form>
                                      <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="<?php if ($tab==4) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab4primary">
                                      <?php
                                        if(isset($_POST['ExaminationEdit'])){
                                    ?>
                                        <form  class="form-horizontal" method="post" action="outpatientdata.php">
                                                    <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                    <input type="hidden" name="DOC" value=<?php echo $DOC; ?>>
                                                    <input type="hidden" name="TOC" value=<?php echo $TOC; ?>>
                                                  <div class="row">
                                                    <div class="col-md-offset-1 col-md-2">
                                                      <h3><strong><u>GENERAL:-</u></strong></h3>
                                                    </div>
                                                  </div>
                                                  <!-- Pallor Start -->
                                                    <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Pallor</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Pallor" value="Yes" <?php if($row['Pallor']=='Yes') echo 'checked'; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Pallor" value="No"  <?php if($row['Pallor']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                      
                                                  </div>
                                                <!-- Pallor Ends -->
                                                <!-- Icterus Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Icterus</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Icterus" value="Yes" <?php if($row['Icterus']=='Yes') echo 'checked'; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Icterus" value="No"  <?php if($row['Icterus']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                      
                                                  </div>
                                                <!-- Icterus Ends -->
                                                 <!-- Clubbing Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Clubbing</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Clubbing" value="Yes" <?php if($row['Clubbing']=='Yes') echo 'checked'; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Clubbing" value="No"  <?php if($row['Clubbing']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- Clubbing Ends -->
                                                <!-- Cyanosis Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Cyanosis</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Cyanosis" value="Yes" <?php if($row['Cyanosis']=='Yes') echo 'checked'; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Cyanosis" value="No"  <?php if($row['Cyanosis']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- Cyanosis Ends -->
                                                <!-- lympadenopathy Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">lympadenopathy</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="lympadenopathy" value="Yes" <?php if($row['Lympadenopathy']=='Yes') echo 'checked'; ?>  >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="lympadenopathy" value="No"  <?php if($row['Lympadenopathy']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- lympadenopathy Ends -->
                                                <!-- Edema Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Edema</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Edema" value="Yes" <?php if($row['Edema']=='Yes') echo 'checked'; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Edema" value="No"  <?php if($row['Edema']=='No') echo 'checked'; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- Edema Ends -->
                                                <div class="row">
                                                    <div class="col-md-offset-1 col-md-2">
                                                      <h3><strong><u>VITALS:-</u></strong></h3>
                                                    </div>
                                                  </div>
                                                <!-- Temp Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">Temp:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="Temp"  name="Temp" placeholder="---/F" value=<?php echo "'".$row['Temp']."'"?>>
                                                        </div>
                                                </div>        
                                                <!-- Temp Ends -->   
                                                <!-- HR Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">HR:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="HR"  name="HR" placeholder="---/Min" value=<?php echo "'".$row['HR']."'";?>>
                                                        </div>
                                                </div>        
                                                <!-- HR Ends -->
                                                <!-- BP Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">BP:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="BP"  name="BP" placeholder="---/mmHg" value=<?php echo "'".$row['BP']."'";?>>
                                                        </div>
                                                </div>        
                                                <!-- BP Ends -->
                                                <!-- RR Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">RR:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="RR"  name="RR" placeholder="---/Min" value=<?php echo "'".$row['RR']."'";?>>
                                                        </div>
                                                </div>
                                                <!-- RR Ends -->
                                                <!-- SPO2 Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">SPO2:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="SPO2"  name="SPO2" placeholder="---%" value=<?php echo "'".$row['SPO2']."'";?>>
                                                        </div>
                                                </div>
                                                <!-- SPO2 Ends -->  
                                                <div class="row">
                                                    <div class="col-md-offset-1 col-md-2">
                                                      <h3><strong><u>SYSTEMIC:-</u></strong></h3>
                                                    </div>
                                                  </div>
                                                <!-- CNS Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">CNS:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="CNS"  name="CNS" value=<?php echo "'".$row['CNS']."'";?>>
                                                        </div>
                                                </div>
                                                <!-- CNS Ends -->
                                                <!-- CVS Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">CVS:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="CVS"  name="CVS" value=<?php echo "'".$row['CVS']."'"; ?>>
                                                        </div>
                                                </div>
                                                <!-- CVS Ends -->
                                                <!-- RS Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">RS:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="RS"  name="RS" value=<?php echo "'".$row['RS']."'"; ?>>
                                                        </div>
                                                </div>
                                                <!-- RS Ends -->
                                                <!-- GIT Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">GIT:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="GIT"  name="GIT" value=<?php echo "'".$row['GIT']."'"; ?>>
                                                        </div>
                                                </div>
                                                <!-- GIT Ends -->  
                                                <!-- other Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Others:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                          <textarea class="form-control" id="otherSystemic" name="otherSystemic" rows="3" column="3"><?php echo $row['OtherSystemic']; ?></textarea>
                                                      </div>
                                                  </div>
                                                <!-- Other  Ends --> 
                                                <div class="text-center">   
                                                    <input  type="submit" name="ExaminationUpdate" value="Update" class="btn btn-success align-self-center mx-auto">
                                                </div>
                                      </form>

                                    <?php
                                        }
                                        else{
                                      ?>
                                      <form  class="form-horizontal" method="post" action="outpatientdata.php">
                                                    <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                    <input type="hidden" name="DOC" value=<?php echo $DOC; ?>>
                                                    <input type="hidden" name="TOC" value=<?php echo $TOC; ?>>
                                                  <div class="row">
                                                    <div class="col-md-offset-1 col-md-2">
                                                      <h3><strong><u>GENERAL:-</u></strong></h3>
                                                    </div>
                                                  </div>
                                                  <!-- Pallor Start -->
                                                    <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Pallor</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Pallor" value="Yes" <?php if($row['Pallor']=='Yes') echo 'checked'; else echo "disabled"; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Pallor" value="No"  <?php if($row['Pallor']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                      
                                                  </div>
                                                <!-- Pallor Ends -->
                                                <!-- Icterus Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Icterus</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Icterus" value="Yes" <?php if($row['Icterus']=='Yes') echo 'checked'; else echo "disabled"; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Icterus" value="No"  <?php if($row['Icterus']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                      
                                                  </div>
                                                <!-- Icterus Ends -->
                                                 <!-- Clubbing Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Clubbing</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Clubbing" value="Yes" <?php if($row['Clubbing']=='Yes') echo 'checked'; else echo "disabled"; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Clubbing" value="No"  <?php if($row['Clubbing']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- Clubbing Ends -->
                                                <!-- Cyanosis Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Cyanosis</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Cyanosis" value="Yes" <?php if($row['Cyanosis']=='Yes') echo 'checked'; else echo "disabled"; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Cyanosis" value="No"  <?php if($row['Cyanosis']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- Cyanosis Ends -->
                                                <!-- lympadenopathy Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">lympadenopathy</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="lympadenopathy" value="Yes" <?php if($row['Lympadenopathy']=='Yes') echo 'checked'; else echo "disabled"; ?>  >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="lympadenopathy" value="No"  <?php if($row['Lympadenopathy']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- lympadenopathy Ends -->
                                                <!-- Edema Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Edema</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue1" name="Edema" value="Yes" <?php if($row['Edema']=='Yes') echo 'checked'; else echo "disabled"; ?> >Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="radioValue2" name="Edema" value="No"  <?php if($row['Edema']=='No') echo 'checked'; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- Edema Ends -->
                                                <div class="row">
                                                    <div class="col-md-offset-1 col-md-2">
                                                      <h3><strong><u>VITALS:-</u></strong></h3>
                                                    </div>
                                                  </div>
                                                <!-- Temp Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">Temp:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="Temp" readonly  name="Temp" placeholder="---/F" value=<?php echo "'".$row['Temp']."'"?>>
                                                        </div>
                                                </div>        
                                                <!-- Temp Ends -->   
                                                <!-- HR Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">HR:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="HR" readonly name="HR" placeholder="---/Min" value=<?php echo "'".$row['HR']."'";?>>
                                                        </div>
                                                </div>        
                                                <!-- HR Ends -->
                                                <!-- BP Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">BP:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="BP" readonly name="BP" placeholder="---/mmHg" value=<?php echo "'".$row['BP']."'";?>>
                                                        </div>
                                                </div>        
                                                <!-- BP Ends -->
                                                <!-- RR Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">RR:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="RR" readonly name="RR" placeholder="---/Min" value=<?php echo "'".$row['RR']."'";?>>
                                                        </div>
                                                </div>
                                                <!-- RR Ends -->
                                                <!-- SPO2 Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">SPO2:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="SPO2" readonly name="SPO2" placeholder="---%" value=<?php echo "'".$row['SPO2']."'";?>>
                                                        </div>
                                                </div>
                                                <!-- SPO2 Ends -->  
                                                <div class="row">
                                                    <div class="col-md-offset-1 col-md-2">
                                                      <h3><strong><u>SYSTEMIC:-</u></strong></h3>
                                                    </div>
                                                  </div>
                                                <!-- CNS Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">CNS:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="CNS" readonly name="CNS" value=<?php echo "'".$row['CNS']."'";?>>
                                                        </div>
                                                </div>
                                                <!-- CNS Ends -->
                                                <!-- CVS Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">CVS:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="CVS" readonly name="CVS" value=<?php echo "'".$row['CVS']."'"; ?>>
                                                        </div>
                                                </div>
                                                <!-- CVS Ends -->
                                                <!-- RS Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">RS:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="RS" readonly name="RS" value=<?php echo "'".$row['RS']."'"; ?>>
                                                        </div>
                                                </div>
                                                <!-- RS Ends -->
                                                <!-- GIT Starts -->
                                                <div class="form-group center-align col-md-offset-2">
                                                <label class="control-label col-sm-2 col-xs-4" for="name">GIT:</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="GIT" readonly name="GIT" value=<?php echo "'".$row['GIT']."'"; ?>>
                                                        </div>
                                                </div>
                                                <!-- GIT Ends -->  
                                                <!-- other Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Others:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                          <textarea class="form-control" id="otherSystemic" readonly name="otherSystemic" rows="3" column="3"><?php echo $row['OtherSystemic']; ?></textarea>
                                                      </div>
                                                  </div>
                                                <!-- Other  Ends --> 
                                                <div class="text-center">   
                                                    <input  type="submit" name="ExaminationEdit" value="Edit" class="btn btn-success align-self-center mx-auto" >
                                                </div>
                                      </form>
                                      <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="<?php if ($tab==5) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab5primary">
                                          <form  class="form-horizontal" method="post" action="activepatients.php">
                                                 <!-- other Investigation Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Investigation :</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                          <textarea class="form-control" id="otherInvestigation" readonly name="Investigation" rows="3" column="3"><?php echo $row['Investigation']; ?></textarea>
                                                      </div>
                                                  </div>
                                                <!-- Other Investigation Ends --> 

                                                <!-- other Treatment Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">Treatment :</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                          <textarea class="form-control" id="otherTreatment" readonly name="Treatment" rows="3" column="3"><?php echo $row['Treatment']; ?></textarea>
                                                      </div>
                                                  </div>
                                                <!-- Other Treatment Ends -->
                                                <!-- InPatient Start -->
                                                <div class="form-group center-align col-md-offset-2">
                                                      <label class="control-label col-sm-2 col-xs-4" for="name">InPatient:</label>
                                                      <div class="col-sm-2 col-xs-6">
                                                        <label class="radio-inline">
                                                          <input type="radio" id="InPatient1" name="InPatient" value="Yes" onclick="displayInPatient()" <?php if($row['InPatient']=='Yes') echo "checked"; else echo "disabled"; ?>>Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" id="InPatient2" name="InPatient" value="No" onclick="displayInPatient()" <?php if($row['InPatient']=='No') echo "checked"; else echo "disabled"; ?>>No
                                                        </label>
                                                      </div>
                                                  </div>
                                                <!-- InPatient Ends -->
                                                <div id="displayInPatient">
                                                        
                                                        <!-- other Follow Up Start -->
                                                        <div class="form-group center-align col-md-offset-2">
                                                              <label class="control-label col-sm-2 col-xs-4" for="name">Follow Up :</label>
                                                              <div class="col-sm-2 col-xs-6">
                                                                  <textarea class="form-control" id="FollowUp" readonly name="FollowUp" rows="3" column="3"><?php echo $row['FollowUp']; ?></textarea>
                                                              </div>
                                                          </div>
                                                        <!-- Other Follow Up Ends -->    
                                                    </div> 
                                          </form>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $conn -> close();
              }
            
            ?>