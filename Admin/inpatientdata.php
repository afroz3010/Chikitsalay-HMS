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
            $rcount="";
            if(isset($_POST['InPatientView'])){
              $rowcount=$_POST['InPatientView'];
              $PatientID=$_POST['PatientID'.$rowcount];
              $DOA= $_POST['DOA'.$rowcount];
              $DOD= $_POST['DOD'.$rowcount];
              // echo $DOA;
                $tab=1;
            }
            if(isset($_POST['InPatientDelete'])){
              $rowcount=$_POST['InPatientDelete'];
              $PatientID=$_POST['PatientID'.$rowcount];
              $DOA= $_POST['DOA'.$rowcount];
              $DOD= $_POST['DOD'.$rowcount];
              include "../dbconnection.php";
              $stmt = $conn->prepare("DELETE FROM Vitaltable WHERE PatientID=? AND VitalDate>=? AND VitalDate<=?");
              $stmt->bind_param("sss", $PatientID,$DOA,$DOD);
              if($stmt->execute()){
                // echo "Deleted record";

              }
              else{
                  echo "error on deleting";
              }
              $stmt = $conn->prepare("DELETE FROM investigationtable WHERE PatientID=? AND ICDate>=? AND ICDate<=?");
              $stmt->bind_param("sss", $PatientID,$DOA,$DOD);
              if($stmt->execute()){
                // echo "Deleted record";

              }
              else{
                  echo "error on deleting";
              }
              $stmt = $conn->prepare("DELETE FROM treatmenttable WHERE PatientID=? AND TreatmentDate>=? AND TreatmentDate<=?");
              $stmt->bind_param("ss", $PatientID,$DOA,$DOD);
              if($stmt->execute()){
                // echo "Deleted record";

              }
              else{
                  echo "error on deleting";
              }
              $stmt = $conn->prepare("DELETE FROM progresstable WHERE PatientID=? AND DOA=?");
              $stmt->bind_param("ss", $PatientID,$DOA);
              if($stmt->execute()){
                // echo "Deleted record";

              }
              else{
                  echo "error on deleting";
              }
              $stmt = $conn->prepare("DELETE FROM inpatienttable WHERE PatientID=? AND DOA=? AND DOD=?");
              $stmt->bind_param("sss", $PatientID,$DOA,$DOD);
              if($stmt->execute()){
                // echo "Deleted record";

              }
              else{
                  echo "error on deleting";
              }
              $stmt = $conn->prepare("DELETE FROM patientcheckup WHERE PatientID=? AND DOC=?");
              $stmt->bind_param("sss", $PatientID,$DOA);
              if($stmt->execute()){
                // echo "Deleted record";

              }
              else{
                  echo "error on deleting";
              }
              $status="CLOSED";
              $stmt = $conn->prepare("UPDATE patients SET STATUS=? WHERE PatientID=?");
              $stmt->bind_param("ss",$status, $PatientID);
              if($stmt->execute()){
                // echo "Deleted record";

              }
              else{
                  echo "error on deleting";
              }
              $conn -> close();
              header('location:inpatientlist.php');
            }
            else if(isset($_POST['ComplaintEdit'])){
              $PatientID=$_POST['PatientID'];
              $DOA=$_POST['DOA'];
              $DOD=$_POST['DOD'];
              $tab=1;
            }
            else if(isset($_POST['ComplaintUpdate'])){
              include "../dbconnection.php";
              $PatientID=$_POST['PatientID'];
              $DOA=$_POST['DOA'];
              $DOD=$_POST['DOD'];
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
              $stmt = $conn->prepare("UPDATE patientcheckup SET Cold=?, ColdDuration=? ,     Cough =? ,     CoughType =?,     CoughDuration =?,     SOB=?  ,     SOBDuration=? ,     Fever =? ,     FeverDuration =?,     SoreThroat =? ,     TravelHistory =? ,     ContactHistory =? ,     OtherComplaints=? WHERE PatientID=? AND DOC=?");
              $stmt->bind_param("sissisisissssss", $_POST['Cold'],$ColdDuration,$_POST['Cough'],$CoughType,$CoughDuration,$_POST['SOB'],$SOBDuration,$_POST['Fever'],$FeverDuration,$_POST['SoreThroat'],$_POST['TravelHistory'],$_POST['ContactHistory'],$_POST['OtherComplaints'],$PatientID,$DOA);
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
              $DOA=$_POST['DOA'];
              $DOD=$_POST['DOD'];
              $tab=2;
            }
            else if(isset($_POST['ComorbiditiesUpdate'])){
              include "../dbconnection.php";
              $PatientID=$_POST['PatientID'];
              $DOA=$_POST['DOA'];
              $DOD=$_POST['DOD'];
              $stmt = $conn->prepare("UPDATE patientcheckup SET	HTN=?  ,     DM =? ,     IHD=?  ,     Asthma =? ,     CLD =? ,     Seizure =? ,     OtherComorbidities =? WHERE PatientID=? AND DOC=?");
              $stmt->bind_param("sssssssss",$_POST['htn'],$_POST['dm'],$_POST['ihdmi'],$_POST['asthmacopd'],$_POST['cld'],$_POST['seizuredisorder'],$_POST['otherComorbidities'],$PatientID,$DOA);
              
            
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
              $DOA=$_POST['DOA'];
              $DOD=$_POST['DOD'];
              $tab=3;
            }
            else if(isset($_POST['AddictionsUpdate'])){
              include "../dbconnection.php";
              $PatientID=$_POST['PatientID'];
              $DOA=$_POST['DOA'];
              $DOD=$_POST['DOD'];
              $stmt = $conn->prepare("UPDATE patientcheckup SET	Smoking=?  ,     Alcohol =? ,     Gutka=?  ,     OtherAddictions=? WHERE PatientID=? AND DOC=?");
              $stmt->bind_param("ssssss",$_POST['smoking'],$_POST['alcohol'],$_POST['gutka'],$_POST['otherAddictions'],$PatientID,$DOA);
              
            
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
              $DOA=$_POST['DOA'];
              $DOD=$_POST['DOD'];
              $tab=4;
            }
            else if(isset($_POST['ExaminationUpdate'])){
              include "../dbconnection.php";
              $PatientID=$_POST['PatientID'];
              $DOA=$_POST['DOA'];
              $DOD=$_POST['DOD'];
              $stmt = $conn->prepare("UPDATE patientcheckup SET Pallor=?,Icterus=?,Clubbing=?,Cyanosis=?,Lympadenopathy=?,Edema=?,Temp=?,HR=?,BP=?,RR=?,SPO2=?,CNS=?,CVS=?,RS=?,GIT=?,OtherSystemic=?  WHERE PatientID=? AND DOC=?");
                $stmt->bind_param("ssssssssssssssssss", $_POST['Pallor'],$_POST['Icterus'],$_POST['Clubbing'],$_POST['Cyanosis'],$_POST['lympadenopathy'],$_POST['Edema'],$_POST['Temp'],$_POST['HR'],$_POST['BP'],$_POST['RR'],$_POST['SPO2'],$_POST['CNS'],$_POST['CVS'],$_POST['RS'],$_POST['GIT'],$_POST['otherSystemic'],$PatientID,$DOA);
                if($stmt->execute()){
                  // echo "Updated Complaints";
                  $tab=4;
            
                }
                else{
                    echo "error on updating";
                }
                $conn -> close();
            }
            else if(isset($_POST['VitalEdit'])){
              include '../dbconnection.php';
              $PatientID=substr($_POST['VitalEdit'],0,12);
              $DOA=$_POST['DOA'];
              $DOD=$_POST['DOD'];
              $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
              $result = $conn->query($sql);
              $PatientName = mysqli_fetch_assoc($result)['PatientName'];
              $tab=6;
              $conn -> close();
          }
          else if(isset($_POST['VitalDelete'])){
            $tab=6;
            $DOA=$_POST['DOA'];
            $DOD=$_POST['DOD'];
              $r=substr($_POST['VitalDelete'],12);
              $PatientID=$_POST['PatientID'.$r];
              $VitalDate=$_POST['VitalDate'.$r];
              $VitalTime=$_POST['VitalTime'.$r];
              include "../dbconnection.php";
              $sql = $conn->prepare("DELETE FROM vitaltable WHERE PatientID=? AND VitalDate=? AND VitalTime=?");
              $sql->bind_param("sss",$PatientID,$VitalDate,$VitalTime);
              if($sql->execute()){
                  $tab=6;
              }
              else{
                  echo "error on updating";
              }
              $conn -> close();
          }
          else if(isset($_POST['VitalUpdate'])){
            include "../dbconnection.php";
            $PatientID=$_POST['VitalUpdate'];
            $DOA=$_POST['DOA'];
            $DOD=$_POST['DOD'];
            $stmt = $conn->prepare("UPDATE vitaltable  SET  Temp=?, HR=?, BP=?, SPO2=?, RR=?, GRBS=?, GCS=?, VitalOthers=? WHERE PatientID=? AND VitalDate=? AND VitalTime=?");
            $stmt->bind_param("sssssssssss", $_POST['vitalTemp'],$_POST['vitalHR'],$_POST['vitalBP'],$_POST['vitalSPO2'],$_POST['vitalRR'],$_POST['vitalGRBS'],$_POST['vitalGCS'],$_POST['vitalOthers'],$PatientID,$_POST['vitalDate'],$_POST['vitalTime']);
            if($stmt->execute()){
                // echo "Updated Vital Chart";
                $tab=6;
            }
            else{
                echo "error on updating";
            }          
            $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
            $result = $conn->query($sql);
            $PatientName = mysqli_fetch_assoc($result)['PatientName'];     
            $conn -> close();   
            
        }
        else if(isset($_POST['InvestigationEdit'])){
          include '../dbconnection.php';
          $PatientID=$_POST['PatientID'];
          $DOA=$_POST['DOA'];
          $DOD=$_POST['DOD'];
          $tab=7;
          $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
          $result = $conn->query($sql);
          $PatientName = mysqli_fetch_assoc($result)['PatientName'];
          $conn -> close();
      }
      else if(isset($_POST['InvestigationUpdate'])){
          include "../dbconnection.php";
          $PatientID=$_POST['InvestigationUpdate'];
          $DOA=$_POST['DOA'];
          $DOD=$_POST['DOD'];
          $stmt = $conn->prepare("UPDATE investigationtable  SET  HB=?,  TLC=?,  PLT=?,  HCT=?,  FBS=?,  PPBS=?,  RBS=?,  HBA1C=?,  BUREA=?,  CREAT=?,  NA=?,  K=?,  CL=?,  TBIL=?,  DIRECT=?,  INDIRECT=?,  SGOT=?,  SGPT=?,  ALP=?,  ALBUMIN=?,  GLOBULIN=?,  BT=?,  CCT=?,  PTINR=?,  DENGUE=?,  MP=?,  WIDAL=?,  PUSCELLS=?,  RBC=?,  SUGARS=?,  KETONE=?,  HIV=?,  HBSAG=?,  HCV=?,  CHESTXRAY=?,  USG=?,  ICT=?,  MRI=?,  ECG=?,  TROPI=?,  ECHO=?,  SPECIFICINVEST=?,  SWAB=?,  RAPIDANTIGENTEST=?,  ABG=?,  PROCALCITONIN=?, InvestigationOthers=? WHERE PatientID=? AND ICDate=? AND ICTime=?");
          $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssss", $_POST['HB'], $_POST['TLC'], $_POST['PLT'], $_POST['HCT'], $_POST['FBS'], $_POST['PPBS'], $_POST['RBS'], $_POST['HBA1C'], $_POST['BUREA'], $_POST['CREAT'], $_POST['NA'], $_POST['K'], $_POST['CL'], $_POST['TBIL'], $_POST['DIRECT'], $_POST['INDIRECT'], $_POST['SGOT'], $_POST['SGPT'], $_POST['ALP'], $_POST['ALBUMIN'], $_POST['GLOBULIN'], $_POST['BT'], $_POST['CCT'], $_POST['PTINR'], $_POST['DENGUE'], $_POST['MP'], $_POST['WIDAL'], $_POST['PUSCELLS'], $_POST['RBC'], $_POST['SUGARS'], $_POST['KETONE'], $_POST['HIV'], $_POST['HBSAG'], $_POST['HCV'], $_POST['CHESTXRAY'], $_POST['USG'], $_POST['ICT'], $_POST['MRI'], $_POST['ECG'], $_POST['TROPI'], $_POST['ECHO'], $_POST['SPECIFICINVEST'], $_POST['SWAB'], $_POST['RAPIDANTIGENTEST'], $_POST['ABG'], $_POST['PROCALCITONIN'],$_POST['InvestigationOthers'],$PatientID, $_POST['ICDate'],$_POST['ICTime']);
          if($stmt->execute()){
              // echo "Updated Investigation Chart";
              $tab=7;
  
          }
          else{
              echo "error on updating";
          }            
          $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
          $result = $conn->query($sql);
          $PatientName = mysqli_fetch_assoc($result)['PatientName'];  
          $conn -> close();
      }
      else if(isset($_POST['InvestigationDelete'])){
        $PatientID=$_POST['PatientID'];
        $DOA=$_POST['DOA'];
        $DOD=$_POST['DOD'];
        $ICDate=substr($_POST['InvestigationDelete'],0,10);
        $ICTime=substr($_POST['InvestigationDelete'],10,8);
        include "../dbconnection.php";
              $sql = $conn->prepare("DELETE FROM investigationtable WHERE PatientID=? AND ICDate=? AND ICTime=?");
              $sql->bind_param("sss",$PatientID,$ICDate,$ICTime);
              if($sql->execute()){
                  $tab=7;
              }
              else{
                  echo "error on updating";
              }
              $conn -> close();

      }
      else if(isset($_POST['TreatmentEdit'])){
        $PatientID= substr($_POST['TreatmentEdit'],0,12);
        $DOA=$_POST['DOA'];
          $DOD=$_POST['DOD'];
        $rcount=substr($_POST['TreatmentEdit'],12);
        $tab=8;
        include "../dbconnection.php";
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];
        $conn -> close();
    }
    else if(isset($_POST['TreatmentSave'])){
        $PatientID= substr($_POST['TreatmentSave'],0,12);

        $DOA=$_POST['DOA'];
          $DOD=$_POST['DOD'];
        $rcount=substr($_POST['TreatmentSave'],12);
        $TimeStamp=$_POST['TimeStamp'.$rcount];
        include "../dbconnection.php";
        $stmt = $conn->prepare("UPDATE treatmenttable  SET  TreatmentDate=?,  Medication=?,  Dose=?,  Route=?,  Frequency=? WHERE PatientID=? AND TimeStamp=? ");
        $stmt->bind_param("sssssss", $_POST['TreatmentDate'.$rcount], $_POST['Medication'.$rcount], $_POST['Dose'.$rcount], $_POST['Route'.$rcount], $_POST['Frequency'.$rcount], $PatientID, $_POST['TimeStamp'.$rcount]);
        if($stmt->execute()){
            // echo "Updated Treatment Chart";
            $tab=8;
            $rcount="";
        }
        else{
            echo "error on updating";
        }
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];  
        $conn -> close();      
    }
    else if(isset($_POST['TreatmentDelete'])){
      $r=substr($_POST['TreatmentDelete'],12);
        $PatientID= substr($_POST['TreatmentDelete'],0,12);
        $DOA=$_POST['DOA'];
        $DOD=$_POST['DOD'];
        $TimeStamp=$_POST['TimeStamp'.$r];
        include "../dbconnection.php";
        $sql = $conn->prepare("DELETE FROM treatmenttable WHERE PatientID=? AND TimeStamp=?");
        $sql->bind_param("ss",$PatientID,$TimeStamp);
        if($sql->execute()){
            $tab=8;
        }
        else{
            echo "error on updating";
        }
        $conn -> close();
    }
    else if(isset($_POST['ProgressEdit'])){
      $PatientID= $_POST['ProgressEdit'];
      $DOA=$_POST['DOA'];
      $DOD=$_POST['DOD'];
      $tab=9;
      include "../dbconnection.php";
      $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
      $result = $conn->query($sql);
      $PatientName = mysqli_fetch_assoc($result)['PatientName'];
      $conn -> close();

    }
    else if(isset($_POST['ProgressUpdate'])){
      $PatientID= $_POST['ProgressUpdate'];
      $DOA=$_POST['DOA'];
          $DOD=$_POST['DOD'];
      include "../dbconnection.php";
      $stmt = $conn->prepare("UPDATE progresstable SET ProgressNotes=?, PatientCondition=?, CovidStatus=?, Plan=? WHERE PatientID=? AND DOA=(SELECT MAX(DOA) FROM InPatientTable WHERE PatientID=?)");
      $stmt->bind_param("ssssss", $_POST['ProgressNotes'], $_POST['IPCondition'], $_POST['CovidStatus'], $_POST['Plan'], $PatientID, $PatientID);
      if($stmt->execute()){
          // echo "Updated progress record";
          $tab=9;
          $rcount="";
      }
      else{
          echo "error on updating";
      }     
      $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
      $result = $conn->query($sql);
      $PatientName = mysqli_fetch_assoc($result)['PatientName'];
      $conn -> close();
  }
  else if(isset($_POST['DischargeEdit'])){
    $PatientID= $_POST['DischargeEdit'];
    $DOA=$_POST['DOA'];
    $DOD=$_POST['DOD'];
    $tab=10;
    include "../dbconnection.php";
    $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
    $result = $conn->query($sql);
    $PatientName = mysqli_fetch_assoc($result)['PatientName'];
    $conn -> close();

  }
  else if(isset($_POST['DischargeUpdate'])){
    $PatientID= $_POST['DischargeUpdate'];
    $DOA=$_POST['DOA'];
    $DOD=$_POST['DOD'];
    include "../dbconnection.php";
    date_default_timezone_set("Asia/Kolkata");
    $TOD=date("H:i:s");
    $sql = $conn->prepare("UPDATE inpatienttable SET DOD=?,TOD=?, ChiefComplaints=?, HospitalTreatment=?, MedicationAdvised=?, ConditionAtDischarge=?, FollowUp=?, DoctorName=? WHERE PatientID=? AND DOA=? AND DOD=?");
    $sql->bind_param("sssssssssss",$_POST['DateOfDischarge'],$TOD,$_POST['ChiefComplaints'],$_POST['HospitalTreatment'],$_POST['MedicationAdvised'],$_POST['ConditionAtDischarge'],$_POST['FollowUp'],$_POST['DoctorName'],$PatientID,$DOA,$DOD);
    if($sql->execute()){
        // echo "discharge form updated";
        $tab=10;
    }
    else{
        echo "error on updating";
    }
    $conn -> close();
  }
  
 
  
?>





        <?php
          if($tab==0 || $tab==1 || $tab==2 || $tab==3 || $tab==4 || $tab==5 || $tab==6 || $tab==7 || $tab==8 || $tab==9 || $tab==10){
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
                  <a class="navbar-brand" href="admin.php">WebSiteName</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav">
                    <li><a href="admin.php">User Managment</a></li>
                    <li><a href="outpatientlist.php">OutPatient Records</a></li>
                    <li class="active">
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
           <div class="container-fluid">
              <div class="row">
                <div class=" col-md-3">
                  
                  <h3>Patient Name:<?php echo " ".$PatientName; ?></h3>  
                </div>
                <div class="col-md-3 ">
                  <h3>Patient ID:<?php echo " ".$PatientID;?></h3>
                </div>
                <div class="col-md-3 ">
                  <h3>DOA:<?php echo " ".$DOA;?></h3>
                </div>
                <div class="col-md-3 ">
                  <h3>DOD:<?php  if($DOD=='9999-12-31') echo "ACTIVE"; else echo " ".$DOD;?></h3>
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
                                        <li class=<?php if($tab==6) echo "active"; else echo "inactive"; ?>><a href="#tab6primary" data-toggle="tab">VITAL CHART</a></li>
                                        <li class=<?php if($tab==7) echo "active"; else echo "inactive"; ?>><a href="#tab7primary" data-toggle="tab">INVESTIGATION CHART</a></li>
                                        <li class=<?php if($tab==8) echo "active"; else echo "inactive"; ?>><a href="#tab8primary" data-toggle="tab">TREATMENT CHART</a></li>
                                        <li class=<?php if($tab==9) echo "active"; else echo "inactive"; ?>><a href="#tab9primary" data-toggle="tab">PROGRESS NOTES</a></li>
                                        <?php
                                          if($DOD!="9999-12-31"){
                                        ?>
                                          <li class=<?php if($tab==10) echo "active"; else echo "inactive"; ?>><a href="#tab10primary" data-toggle="tab">DISCHARGE SUMMARY</a></li>
                                        <?php
                                          }
                                        ?>
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
                                              <form class="form-horizontal" method="post" action="">
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
                                      $sql="SELECT * FROM patientcheckup WHERE PatientID="."'".$PatientID."'"." AND DOC='".$DOA."'";
                                      $result = $conn->query($sql);
                                      // echo $DOA;
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
                                            //   echo $DOA;
                                      ?>
                                        <div class="container-field">
                                              <form  class="form-horizontal"  method="post" action="inpatientdata.php">
                                                  <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                  <input type="hidden" name="DOA" value=<?php echo $DOA; ?>>
                                                  <input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
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
                                      
                                              <form  class="form-horizontal"  method="post" action="inpatientdata.php">
                                                      <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                      <input type="hidden" name="DOA" value=<?php echo $DOA; ?>><input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
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
                                              <form  class="form-horizontal" method="post" action="inpatientdata.php">
                                                      <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                      <input type="hidden" name="DOA" value=<?php echo $DOA; ?>><input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
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
                                            <form  class="form-horizontal" method="post" action="inpatientdata.php">
                                                      <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                      <input type="hidden" name="DOA" value=<?php echo $DOA; ?>><input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
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
                                        <form  class="form-horizontal" method="post" action="inpatientdata.php">
                                                    <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                    <input type="hidden" name="DOA" value=<?php echo $DOA; ?>><input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
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
                                            <form  class="form-horizontal" method="post" action="inpatientdata.php">
                                                    <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                    <input type="hidden" name="DOA" value=<?php echo $DOA; ?>><input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
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
                                        <form  class="form-horizontal" method="post" action="inpatientdata.php">
                                                    <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                    <input type="hidden" name="DOA" value=<?php echo $DOA; ?>>
                                                    <input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
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
                                      <form  class="form-horizontal" method="post" action="inpatientdata.php">
                                                    <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                    <input type="hidden" name="DOA" value=<?php echo $DOA; ?>><input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
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
                                    <div class=" <?php if ($tab==6) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab6primary">
                                        <?php
                                          $conn -> close();
                                            if(isset($_POST['VitalEdit'])){
                                                // echo $_POST['VitalEdit'];
                                                $rowcount=substr($_POST['VitalEdit'],12);
                                        ?>
                                            <div class="container-fluid">
                                                        <form  class="form-horizontal" method="POST" action="inpatientdata.php">
                                                            <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                            <input type="hidden" name="DOA" value=<?php echo $DOA; ?>>
                                                            <input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
                                                        <div class="form-group center-align">
                                                            <label class="control-label col-sm-2" for="name">Select Date</label>
                                                            
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" readonly value=<?php echo $_POST['VitalDate'.$rowcount]; ?>  name="vitalDate" width="270">
                                                            </div>
                                                            

                                                        </div>
                                                        <!-- vitalTime Start -->
                                                        <div class="form-group center-align">
                                                                    <label class="control-label col-sm-2 col-xs-4" for="name">Time</label>
                                                                    <div class="col-sm-2 col-xs-6">
                                                                        <label class="radio-inline">
                                                                        <input type="radio" id="radioValue1" name="vitalTime" value="8:00AM"  <?php if($_POST['VitalTime'.$rowcount]=="8:00AM") echo "checked"; else echo "disabled"; ?>>8AM
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                        <input type="radio" id="radioValue2" name="vitalTime" value="2:00PM"  <?php if($_POST['VitalTime'.$rowcount]=="2:00PM") echo "checked"; else echo "disabled"; ?> >2PM
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                        <input type="radio" id="radioValue3" name="vitalTime" value="8:00PM"  <?php if($_POST['VitalTime'.$rowcount]=="8:00PM") echo "checked"; else echo "disabled"; ?> >8PM
                                                                        </label><label class="radio-inline">
                                                                        <input type="radio" id="radioValue4" name="vitalTime" value="2:00AM"   <?php if($_POST['VitalTime'.$rowcount]=="2:00AM") echo "checked"; else echo "disabled"; ?>>2AM
                                                                        </label>
                                                                    </div>
                                                            </div>
                                                                <!-- vitalTime Ends -->
                                                                <br>
                                                        <!-- vitalTemp Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">Temp:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalTemp"  name="vitalTemp" placeholder="---/F" value=<?php echo "'".$_POST['Temp'.$rowcount]."'"; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalTemp Ends -->
                                                        <!-- vitalHR Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">HR:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalHR"  name="vitalHR" placeholder="---/Min" value=<?php echo "'".$_POST['HR'.$rowcount]."'"; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalHR Ends -->
                                                        <!-- vitalBP Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">BP:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalBP"  name="vitalBP" placeholder="---/mmHg" value=<?php echo "'".$_POST['BP'.$rowcount]."'"; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalBP Ends -->
                                                        <!-- vitalSPO2 Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">SPO2:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalSPO2"  name="vitalSPO2" placeholder="---%" value=<?php echo "'".$_POST['SPO2'.$rowcount]."'"; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalSPO2 Ends -->
                                                        <!-- vitalRR Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">RR:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalRR"  name="vitalRR" placeholder="---/Min" value=<?php echo "'".$_POST['RR'.$rowcount]."'"; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalRR Ends -->
                                                            <!-- vitalGRBS Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">GRBS:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalGRBS"  name="vitalGRBS" value=<?php echo "'".$_POST['GRBS'.$rowcount]."'"; ?>>
                                                                        </div>
                                                            </div>        
                                                            <!-- vitalGRBS Ends -->
                                                            <!-- vitalGCS Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">GCS:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalGCS"  name="vitalGCS" value=<?php echo "'".$_POST['GCS'.$rowcount]."'"; ?>>
                                                                        </div>
                                                            </div>        
                                                            <!-- vitalGCS Ends -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">OTHERS:</label>
                                                                        <div class="col-sm-2">
                                                                        <textarea class="form-control" id="vitalOthers"  name="vitalOthers" ><?php echo $_POST['Others'.$rowcount]; ?></textarea>
                                                                        </div>
                                                            </div>   
                                                            
                                                            <div class="text-center">   
                                                                    <button  type="submit" name="VitalUpdate" value=<?php echo $PatientID; ?> class="btn btn-success align-self-center mx-auto">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                        <?php
                                            }
                                            else{
                                        ?>
                                            <form action="inpatientdata.php" method="post">
                                                    <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                    <input type="hidden" name="DOA" value=<?php echo $DOA; ?>>
                                                    <input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
                                                        <table class="table tab table-hover table-bordered table-responsive">
                                                            <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>Patient ID</th>
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>Temp</th>
                                                                <th>HR</th>
                                                                <th>BP</th>
                                                                <th>SPO2</th>
                                                                <th>RR</th>
                                                                <th>GRBS</th>
                                                                <th>GCS</th>
                                                                <th>Others</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                    <?php  
                                                    //  }
                                                            include "../dbconnection.php";
                                                            $sql="SELECT * FROM vitaltable where PatientID="."'".$PatientID."' AND VitalDate>='".$DOA."' AND Vitaldate<='".$DOD."'";
                                                            $result = $conn->query($sql);
                                                            if ($result->num_rows > 0) {
                                                            // output data of each row
                                                            $count=1;
                                                            while($row = $result->fetch_assoc()){
                                                                    ?>
                                                                    <input type="hidden" name=<?php echo "PatientID".$count; ?> value=<?php echo "'".$row['PatientID']."'"; ?>>
                                                                    <input type="hidden" name=<?php echo "VitalDate".$count; ?> value=<?php echo "'".$row['VitalDate']."'"; ?>>
                                                                    <input type="hidden" name=<?php echo "VitalTime".$count; ?> value=<?php echo "'".$row['VitalTime']."'"; ?>>
                                                                    <input type="hidden" name=<?php echo "Temp".$count; ?> value=<?php echo "'".$row['Temp']."'"; ?>>
                                                                    <input type="hidden" name=<?php echo "HR".$count; ?> value=<?php echo "'".$row['HR']."'"; ?>>
                                                                    <input type="hidden" name=<?php echo "BP".$count; ?> value=<?php echo "'".$row['BP']."'"; ?>>
                                                                    <input type="hidden" name=<?php echo "SPO2".$count; ?> value=<?php echo "'".$row['SPO2']."'"; ?>>
                                                                    <input type="hidden" name=<?php echo "RR".$count; ?> value=<?php echo "'".$row['RR']."'"; ?>>
                                                                    <input type="hidden" name=<?php echo "GRBS".$count; ?> value=<?php echo "'".$row['GRBS']."'"; ?>>
                                                                    <input type="hidden" name=<?php echo "GCS".$count; ?> value=<?php echo "'".$row['GCS']."'"; ?>>
                                                                    <textarea style="display:none" name=<?php echo "Others".$count; ?>><?php echo $row['VitalOthers']; ?></textarea>
                                                                    <?php
                                                                    echo   "<tr><td>".$count."</td><td>".$row["PatientID"]."</td><td >".$row["VitalDate"]."</td><td>".$row["VitalTime"]."</td><td>".$row["Temp"]."</td><td>".$row["HR"]."</td><td>".$row["BP"]."</td><td>".$row["SPO2"]."</td><td>".$row["RR"]."</td><td>".$row["GRBS"]."</td><td>".$row["GCS"]."</td><td>".$row['VitalOthers']."</td>";
                                                                    ?>
                                                                        <td>
                                                                          <button type="submit" class='btn btn-success align-self-center mx-auto'  onClick="return confirm('Are you sure, you want to Edit?');" name="VitalEdit" value=<?php echo $PatientID.$count; ?>>Edit</button>
                                                                          <button type="submit" class='btn btn-danger align-self-center mx-auto'  onClick="return confirm('Are you sure, you want to Delete?');" name="VitalDelete" value=<?php echo $PatientID.$count; ?>>Delete</button>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $count++;
                                                                }
                                                            } else {
                                                                echo "0 inpatients";
                                                            }


                                                    

                                            // conn.close();
                                                    ?>
                                                            </tbody>
                                                        </table>
                                                        </form>
                                            <?php
                                            $conn -> close();
                                            }
                                            ?>
                                    </div>
                                    <div class=" <?php if ($tab==7) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab7primary">
                                            <?php
                                                if(isset($_POST['InvestigationEdit'])){
                                                    echo $PatientID;
                                                    $ICDate=substr($_POST['InvestigationEdit'],0,10);
                                                    $ICTime=substr($_POST['InvestigationEdit'],10,8);
                                                    include "../dbconnection.php";
                                                    $sql="SELECT * FROM investigationtable where PatientID="."'".$PatientID."' AND ICDate="."'".$ICDate."' AND ICTime="."'".$ICTime."'";
                                                    $result = $conn->query($sql);
                                                    $row = $result->fetch_assoc()
                                            ?>
                                                                    <form  class="form-horizontal" method="post" action="inpatientdata.php">
                                                                            <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                                            <input type="hidden" name="DOA" value=<?php echo $DOA; ?>>
                                                                            <input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
                                                                       
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                               <label class="control-label col-sm-1 col-xs-4" for="name">Date:</label>
                                                                               <div class="col-sm-2">
                                                                                   <input type="text" class="form-control" id="ICDate" readonly name="ICDate" value=<?php echo "'".$row['ICDate']."'"; ?>>
                                                                               </div>
                                                                               <label class="control-label col-sm-1 col-xs-4" for="name">Time:</label>
                                                                               <div class="col-sm-2">
                                                                                   <input type="text" class="form-control" id="ICTime" readonly name="ICTime" value=<?php echo "'".$row['ICTime']."'"; ?>>
                                                                               </div>
                                                                       </div>  

                                                                          <br> 

                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>CBP</strong></h4>
                                                                           </div>
                                                                       </div>
                                                                       <!-- HB Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">HB:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="HB"  name="HB" value=<?php echo "'".$row['HB']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--HB Ends -->   
                                                                       <!-- TLC Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">TLC:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="TLC"  name="TLC" value=<?php echo "'".$row['TLC']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--TLC Ends --> 
                                                                       <!-- PLT Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">PLT:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="PLT"  name="PLT" value=<?php echo "'".$row['PLT']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--PLT Ends --> 
                                                                       <!-- HCT Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">HCT:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="HCT"  name="HCT" value=<?php echo "'".$row['HCT']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--HCT Ends --> 
                                                                       <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>BLOOD  GLUCOSE</strong></h4>
                                                                           </div>
                                                                       </div>

                                                                       <!-- FBS Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-8" for="name">FBS:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="FBS"  name="FBS" value=<?php echo "'".$row['FBS']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--FBS Ends --> 
                                                                        <!-- PPBS Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">PPBS:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="PPBS"  name="PPBS" value=<?php echo "'".$row['PPBS']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--PPBS Ends --> 
                                                                       <!-- RBS Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">RBS:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="RBS"  name="RBS" value=<?php echo "'".$row['RBS']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--RBS Ends --> 
                                                                       <!-- HBA1C Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">HBA1C:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="HBA1C"  name="HBA1C" value=<?php echo "'".$row['HBA1C']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <hr>
                                                                       <!--HBA1C Ends --> 
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>RFT</strong></h4>
                                                                           </div>
                                                                       </div> 

                                                                       <!-- BUREA Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">B.UREA:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="BUREA"  name="BUREA" value=<?php echo "'".$row['BUREA']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--BUREA Ends --> 
                                                                       <!-- CREAT Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">Sr. CREAT:</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="CREAT"  name="CREAT" value=<?php echo "'".$row['CREAT']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--CREAT Ends -->
                                                                       <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>Sr. ELECTROLYTES</strong></h4>
                                                                           </div>
                                                                       </div> 

                                                                       <!-- NA Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">NA+ :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="NA"  name="NA" value=<?php echo "'".$row['NA']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--NA Ends --> 
                                                                       <!-- K Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">K+ :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="K"  name="K" value=<?php echo "'".$row['K']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--K Ends --> 
                                                                       <!-- CL Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">CL- :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="CL"  name="CL" value=<?php echo "'".$row['CL']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--CL Ends --> 
                                                                       <hr>
                                                                        <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>LFT:-</strong></h4>
                                                                           </div>
                                                                       </div>

                                                                       <!-- TBIL Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">T.BIL :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="TBIL"  name="TBIL" value=<?php echo "'".$row['TBIL']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--TBIL Ends --> 
                                                                       <!-- DIRECT Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">DIRECT :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="DIRECT"  name="DIRECT" value=<?php echo "'".$row['DIRECT']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--DIRECT Ends --> 
                                                                       <!-- INDIRECT Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">INDIRECT :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="INDIRECT"  name="INDIRECT" value=<?php echo "'".$row['INDIRECT']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--INDIRECT Ends -->                                                                                                                                                 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                                                                       <!-- SGOT Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">SGOT :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="SGOT"  name="SGOT" value=<?php echo "'".$row['SGOT']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--SGOT Ends --> 
                                                                       <!-- SGPT Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">SGPT :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="SGPT"  name="SGPT" value=<?php echo "'".$row['SGPT']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--SGPT Ends --> 
                                                                       <!-- ALP Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">ALP :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="ALP"  name="ALP" value=<?php echo "'".$row['ALP']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--ALP Ends --> 
                                                                       <!-- ALBUMIN Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">Sr.ALBUMIN :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="ALBUMIN"  name="ALBUMIN" value=<?php echo "'".$row['ALBUMIN']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--ALBUMIN Ends -->                                                                                                                                                                                                                                                                                                 
                                                                       <!-- GLOBULIN Starts -->
                                                                       <div class="form-group center-align col-md-offset-2">
                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">Sr.GLOBULIN :</label>
                                                                               <div class="col-sm-2">
                                                                               <input type="text" class="form-control" id="GLOBULIN"  name="GLOBULIN" value=<?php echo "'".$row['GLOBULIN']."'"; ?>>
                                                                               </div>
                                                                       </div>        
                                                                       <!--GLOBULIN Ends --> 
                                                                       <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>COAGULATION</strong></h4>
                                                                           </div>
                                                                       </div>   
                                                                                   <!-- BT Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">BT:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="BT"  name="BT" value=<?php echo "'".$row['BT']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--BT Ends --> 
                                                                                   <!-- CCT Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">CT:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="CCT"  name="CCT" value=<?php echo "'".$row['CCT']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--CCT Ends -->
                                                                                   <!-- PTINR Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">PTINR:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="PTINR"  name="PTINR" value=<?php echo "'".$row['PTINR']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--PTINR Ends -->      
                                                                   <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>CUE</strong></h4>
                                                                           </div>
                                                                       </div>
                                                                               <!-- DENGUE Start -->
                                                                                   <div class="form-group center-align col-md-offset-2">
                                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">DENGUE:</label>
                                                                                           <div class="col-sm-2">
                                                                                               <input type="text" class="form-control" id="DENGUE"  name="DENGUE" value=<?php echo "'".$row['DENGUE']."'"; ?>>
                                                                                           </div>
                                                                                   </div>        
                                                                               <!--DENGUE Ends -->
                                                                               <!-- MP Start -->
                                                                                   <div class="form-group center-align col-md-offset-2">
                                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">MP:</label>
                                                                                           <div class="col-sm-2">
                                                                                               <input type="text" class="form-control" id="MP"  name="MP" value=<?php echo "'".$row['MP']."'"; ?>>
                                                                                           </div>
                                                                                   </div>        
                                                                               <!--MP Ends -->
                                                                               <!-- WIDAL Start -->
                                                                                   <div class="form-group center-align col-md-offset-2">
                                                                                       <label class="control-label col-sm-3 col-xs-4" for="name">WIDAL:</label>
                                                                                           <div class="col-sm-2">
                                                                                               <input type="text" class="form-control" id="WIDAL"  name="WIDAL" value=<?php echo "'".$row['WIDAL']."'"; ?>>
                                                                                           </div>
                                                                                   </div>        
                                                                               <!--WIDAL Ends -->
                                                                               <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>CUE</strong></h4>
                                                                           </div>
                                                                       </div>
                                                                                   <!-- PUSCELLS Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">PUSCELLS:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="PUSCELLS"  name="PUSCELLS" value=<?php echo "'".$row['PUSCELLS']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--PUSCELLS Ends -->
                                                                                   <!-- RBC Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">RBC:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="RBC"  name="RBC" value=<?php echo "'".$row['RBC']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--RBC Ends -->
                                                                                   <!-- SUGARS Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">SUGARS:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="SUGARS"  name="SUGARS" value=<?php echo "'".$row['SUGARS']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--SUGARS Ends -->
                                                                                   <!-- KETONE Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">KETONE:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="KETONE"  name="KETONE" value=<?php echo "'".$row['KETONE']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--KETONE Ends -->
                                                                                   <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>SEROLOGY</strong></h4>
                                                                           </div>
                                                                       </div>
                                                                                   <!-- HIV Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">HIV:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="HIV"  name="HIV" value=<?php echo "'".$row['HIV']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--HIV Ends -->
                                                                                   <!-- HBSAG Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">HBSAG:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="HBSAG"  name="HBSAG" value=<?php echo "'".$row['HBSAG']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--HBSAG Ends -->
                                                                                   <!-- HCV Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">HCV:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="HCV"  name="HCV" value=<?php echo "'".$row['HCV']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--HCV Ends -->
                                                                                   <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>IMAGING</strong></h4>
                                                                           </div>
                                                                       </div>
                                                                                   <!-- CHESTXRAY Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">CHESTXRAY:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="CHESTXRAY"  name="CHESTXRAY" value=<?php echo "'".$row['CHESTXRAY']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--CHESTXRAY Ends -->
                                                                                   <!-- USG Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">USG:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="USG"  name="USG" value=<?php echo "'".$row['USG']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--USG Ends -->
                                                                                   <!-- ICT Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">CT:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="ICT"  name="ICT" value=<?php echo "'".$row['ICT']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--ICT Ends -->
                                                                                   <!-- MRI Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">MRI:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="MRI"  name="MRI" value=<?php echo "'".$row['MRI']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--MRI Ends -->
                                                                                   <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>CARDIAC</strong></h4>
                                                                           </div>
                                                                       </div>
                                                                                   <!-- ECG Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">ECG:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="ECG"  name="ECG" value=<?php echo "'".$row['ECG']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--ECG Ends -->
                                                                                   <!-- TROPI Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">TROPI:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="TROPI"  name="TROPI" value=<?php echo "'".$row['TROPI']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--TROPI Ends -->
                                                                                   <!-- ECHO Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">CT:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="ECHO"  name="ECHO" value=<?php echo "'".$row['ECHO']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--ECHO Ends -->
                                                                                   <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>SPECIFIC INVEST</strong></h4>
                                                                                   <div class="row">
                                                                                       <div class="col-md-offset-12 col-md-12">
                                                                                       <input type="text" class="form-control" id="SPECIFICINVEST"  name="SPECIFICINVEST" value=<?php echo "'".$row['SPECIFICINVEST']."'"; ?>>
                                                                                       </div>
                                                                                   </div>
                                                                           </div>
                                                                       </div>

                                                                       <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>CORONA</strong></h4>
                                                                           </div>
                                                                       </div>
                                                                                   <!-- SWAB Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">SWAB:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="SWAB"  name="SWAB" value=<?php echo "'".$row['SWAB']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--SWAB Ends -->
                                                                                   <!-- RAPIDANTIGENTEST Start -->
                                                                                       <div class="form-group center-align col-md-offset-2">
                                                                                           <label class="control-label col-sm-3 col-xs-4" for="name">RAPIDANTIGENTEST:</label>
                                                                                               <div class="col-sm-2">
                                                                                                   <input type="text" class="form-control" id="RAPIDANTIGENTEST"  name="RAPIDANTIGENTEST" value=<?php echo "'".$row['RAPIDANTIGENTEST']."'"; ?>>
                                                                                               </div>
                                                                                       </div>        
                                                                                   <!--RAPIDANTIGENTEST Ends -->
                                                                                   <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>ABC</strong></h4>
                                                                               <div class="row">
                                                                                   <div class="col-md-offset-12 col-md-12">
                                                                                       <input type="text" class="form-control" id="ABG"  name="ABG" value=<?php echo "'".$row['ABG']."'"; ?>>
                                                                                   </div>
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                       <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>PROCALCITONIN</strong></h4>
                                                                               <div class="row">
                                                                                   <div class="col-md-offset-12 col-md-12">
                                                                                       <input type="text" class="form-control" id="PROCALCITONIN"  name="PROCALCITONIN" value=<?php echo "'".$row['PROCALCITONIN']."'"; ?>>
                                                                                   </div>
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                       <hr>
                                                                       <div class="row">
                                                                           <div class="col-md-offset-1 col-md-2">
                                                                           <h4><strong>Others</strong></h4>
                                                                               <div class="row">
                                                                                   <div class="col-md-offset-12 col-md-12">
                                                                                       <textarea type="text" class="form-control" id="InvestigationOthers"  name="InvestigationOthers"><?php echo $row['InvestigationOthers']; ?></textarea>
                                                                                   </div>
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                                   
                                                           <div class="text-center">   
                                                                   <button  type="submit" name="InvestigationUpdate" value=<?php echo $PatientID ?> class="btn btn-success align-self-center mx-auto">Update</button>
                                                           </div>
                                               </form>
                                            <?php
                                            $conn -> close();
                                                }
                                                else{
                                            ?>
                                                    <?php
                                        include "../dbconnection.php";
                                        // echo $PatientID;
                                        $sql="SELECT * FROM investigationtable where PatientID="."'".$PatientID."' AND ICDate>='".$DOA."' AND ICDate<='".$DOD."'";
                                        $result=mysqli_query($conn,$sql);
                                        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
                                        $count=count($row);
                                    ?>
                                        <form action="inpatientdata.php" method="post">
                                                  <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                  <input type="hidden" name="DOA" value=<?php echo $DOA; ?>>
                                                  <input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
                                            <table class="table tab table-hover table-bordered table-responsive table_wrapper">
                                                <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Parameter</th>
                                                    <th>Test</th>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                    ?>
                                                            <th>
                                                                <?php echo $row[$i]['ICDate']." ".$row[$i]['ICTime']; ?>
                                                                <br>
                                                                <button type="submit" class='btn btn-success align-self-center mx-auto'  onClick="return confirm('Are you sure, you want to Edit?');" name="InvestigationEdit" value=<?php echo $row[$i]['ICDate'].$row[$i]['ICTime']; ?>>Edit</button>
                                                                <button type="submit" class='btn btn-danger align-self-center mx-auto'  onClick="return confirm('Are you sure, you want to Delete?');" name="InvestigationDelete" value=<?php echo $row[$i]['ICDate'].$row[$i]['ICTime']; ?>>Delete</button>
                                                            </th>
                                                    <?php
                                                        }

                                                    ?>
                                                </tr>
                                                </thead>
                                                <tr>
                                                    <td rowspan=4>1</td>
                                                    <td rowspan=4>CBP</td>
                                                    <td>HB</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['HB']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>TLC</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['TLC']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>PLT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['PLT']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>HCT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['HCT']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td rowspan=4>2</td>
                                                    <td rowspan=4>BLOOD GLUCOSE</td>
                                                    <td>FBS</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['FBS']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>PPBS</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['PPBS']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>RBS</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['RBS']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>HBA1C</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['HBA1C']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td rowspan=2>3</td>
                                                    <td rowspan=2>RFT</td>
                                                    <td>B.UREA</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['BUREA']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>Sr.CREAT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['CREAT']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td rowspan=3>4</td>
                                                    <td rowspan=3>Sr.ELECTROLYTES</td>
                                                    <td>NA+</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['NA']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>K+</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['K']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>CL-</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['CL']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td rowspan=8>5</td>
                                                    <td rowspan=8>LFT</td>
                                                    <td>T.BIL</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['TBIL']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>DIRECT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['DIRECT']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>INDIRECT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['INDIRECT']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>SGOT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['SGOT']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>SGPT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['SGPT']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>ALP</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['ALP']."</td>";
                                                        }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>Sr.ALBUMIN</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['ALBUMIN']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>Sr.GLOBULIN</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['GLOBULIN']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td rowspan=3>6</td>
                                                    <td rowspan=3>COAGULATION</td>
                                                    <td>BT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['BT']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>CT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['CCT']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>PT/INR</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['PTINR']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td rowspan=3>7</td>
                                                    <td rowspan=3>FEVER PROFILE</td>
                                                    <td>DENGUE</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['DENGUE']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>MP</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['MP']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>WIDAL</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['WIDAL']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td rowspan=4>8</td>
                                                    <td rowspan=4>CUE</td>
                                                    <td>PUSCELLS</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['PUSCELLS']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>RBC</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['RBC']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>SUGARS</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['SUGARS']."</td>";
                                                        }

                                                    ?>
                                                </tr>  
                                                <tr>
                                                    <td>KETONE</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['KETONE']."</td>";
                                                        }

                                                    ?>
                                                </tr>                                              
                                               
                                               <tr>
                                                    <td rowspan=3>9</td>
                                                    <td rowspan=3>SEROLOGY</td>
                                                    <td>HIV</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['HIV']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>HBSAG</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['HBSAG']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>HCV</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['HCV']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                               
                                               <tr>
                                                    <td rowspan=4>10</td>
                                                    <td rowspan=4>IMAGING</td>
                                                    <td>CHEST XRAY</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['CHESTXRAY']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>USG</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['USG']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>CT</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['ICT']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>MRI</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['MRI']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                               
                                               
                                               
                                               
                                                <tr>
                                                    <td rowspan=3>11</td>
                                                    <td rowspan=3>CARDIAC</td>
                                                    <td>ECG</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['ECG']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>TROPI</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['TROPI']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>ECHO</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['ECHO']."</td>";
                                                        }

                                                    ?>
                                                </tr>


                                                <tr>
                                                    <td>12</td>
                                                    <td colspan=2>SPECIFIC INVEST</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['SPECIFICINVEST']."</td>";
                                                        }
                                                    ?>
                                                </tr>  

                                                <tr>
                                                    <td rowspan=2>13</td>
                                                    <td rowspan=2>CORONA</td>
                                                    <td>SWAB</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['SWAB']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>RAPID ANTIGEN TEST</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['RAPIDANTIGENTEST']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                             
                                                    <tr>
                                                    <td>14</td>
                                                    <td colspan=2>ABG</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['ABG']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td colspan=2>PROCALCITONIN</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['PROCALCITONIN']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>16</td>
                                                    <td colspan=2>Others</td>
                                                    <?php
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            echo "<td>".$row[$i]['InvestigationOthers']."</td>";
                                                        }

                                                    ?>
                                                </tr>
                                    </table>
                                    </form>
                                                
                                                
                                            <?php
                                            $conn -> close();
                                                }
                                            ?>
                                    
                                    </div>
                            <!-- Tab Treatment Chart -->
                                <div class=" <?php if ($tab==8) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab8primary">
                                        <div class="container-fluid">
                                            <form method="post" autocomplete="off" action="inpatientdata.php">
                                                  <input type="hidden" name="DOA" value=<?php echo $DOA; ?>>
                                                  <input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
                                                <table class="table table-bordered table-hover table-responsive" id="displayInPatientRecords">
                                                     <colgroup>
                                                        <col span="1" style="width: 5%;">
                                                        <col span="1" style="width: 20%;">
                                                        <col span="1" style="width: 25%;">
                                                        <col span="1" style="width: 15%;">
                                                        <col span="1" style="width: 10%;">
                                                        <col span="1" style="width: 10%;">
                                                        <col span="1" style="width: 15%;">
                                                    </colgroup>
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th class="text-center">S.NO</th>
                                                            <th class="text-center">Date</th>
                                                            <th class="text-center">Medication</th>
                                                            <th class="text-center">Dose</th>
                                                            <th class="text-center">Route</th>
                                                            <th class="text-center">Frequency</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php
                                                                date_default_timezone_set("Asia/Kolkata");
                                                                include "../dbconnection.php";
                                                                $sql="SELECT * FROM treatmenttable where PatientID="."'".$PatientID."' AND TreatmentDate>='".$DOA."' AND TreatmentDate<='".$DOD."'";
                                                                $result = $conn->query($sql);
                                                                $count=1;
                                                                if ($result->num_rows > 0) {
                                                                    // output data of each row
                                                                    while($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <tr>
                                                                
                                                                <td><?php echo $count ?></td>
                                                                <?php
                                                                    if($count!=$rcount){
                                                                ?>
                                                                    <td><input type="text" class="form-control" readonly value=<?php echo $row['TreatmentDate']; ?>  name=<?php echo "TreatmentDate".$count ?> width="270"></td>
                                                                <?php
                                                                    }
                                                                    else{
                                                                ?>
                                                                    <td><input type="text" class="form-control" id="TreatmentDate" value=<?php echo $row['TreatmentDate']; ?>  name=<?php echo "TreatmentDate".$count ?> width="270"></td>
                                                                <?php
                                                                    }
                                                                ?>
                                                                <input type="hidden" name=<?php echo "TimeStamp".$count; ?>  value=<?php echo "'".$row['TimeStamp']."'"; ?>>
                                                                
                                                                <td><input class="form-control" id="medication" type="text" name=<?php echo "Medication".$count ?> <?php if($rcount!=$count) echo "readonly"; ?> value=<?php echo $row['Medication']; ?>></td><div id="medicationList"></div>
                                                                <td><input class="form-control" type="text" name=<?php echo "Dose".$count ?> <?php if($rcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Dose']."'"; ?>></td>
                                                                <td><input class="form-control" type="text" name=<?php echo "Route".$count ?> <?php if($rcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Route']."'"; ?>></td>
                                                                <td><input class="form-control" type="text" name=<?php echo "Frequency".$count ?> <?php if($rcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Frequency']."'"; ?>></td>
                                                                <?php
                                                                    if($rcount!=$count){
                                                                ?>
                                                                    <td>
                                                                    <button type="submit" class='btn btn-success align-self-center mx-auto'  onClick="return confirm('Are you sure, you want to edit?');" name="TreatmentEdit" value=<?php echo $PatientID.$count; ?>>Edit</button> 
                                                                    <button type="submit" class='btn btn-danger align-self-center mx-auto'  onClick="return confirm('Are you sure, you want to delete?');" name="TreatmentDelete" value=<?php echo $PatientID.$count; ?>>Delete</button> 
                                                                    </td>
                                                                <?php
                                                                    }
                                                                    else{
                                                                ?>
                                                                    <td><button type="submit" class='btn btn-success align-self-center mx-auto' name="TreatmentSave" value=<?php echo $PatientID.$count; ?>>Save</button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </tr>
                                                            <?php
                                                                    $count++;
                                                                    }
                                                                    } 
                                                                    $conn -> close();
                                                            ?>
                                                    </tbody>
                                                </table>
                                                
                                                </form>
                                                    
                                        </div>
                                    </div>
                                    <!-- Treatment chrt ends -->
                                    
                                    <!-- Tab Progress Notes -->
<?php
                                                       include "../dbconnection.php";
                                                       $sql="SELECT * FROM progresstable where PatientID='".$PatientID."'AND DOA='".$DOA."'";
                                                       $result = $conn->query($sql);
                                                       if ($result->num_rows > 0) {
                                                       $row = $result->fetch_assoc();
                                                       } else {
                                                           echo "No progress";
                                                       } 

                                                       $conn -> close();
                                                ?>
                        <div class=" <?php if ($tab==9) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab9primary">
                                    <div class="container-fluid">
                                    
                                        
                                                <form class="form-horizontal text-center" action="inpatientdata.php" method="post">
                                                      <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
                                                        <input type="hidden" name="DOA" value=<?php echo $DOA; ?>>
                                                        <input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Progress Notes:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="ProgressNotes" <?php if(!(isset($_POST['ProgressEdit']))) echo "readonly"; ?> name="ProgressNotes" ><?php echo $row['ProgressNotes']  ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Patient Condition</label>
                                                            <div class="col-sm-3">
                                                            <select class="form-control" id="IPCondition" name="IPCondition" <?php if(!(isset($_POST['ProgressEdit']))) echo "disabled"; ?>>
                                                            <option <?php if($row['PatientCondition']=='STABLE') echo "selected"; ?> >STABLE</option>
                                                            <option <?php if($row['PatientCondition']=='DETERIORATING') echo "selected"; ?> >DETERIORATING</option>
                                                            <option <?php if($row['PatientCondition']=='EXPIRED') echo "selected"; ?> >EXPIRED</option>
                                                            <option <?php if($row['PatientCondition']=='DISCHARGED') echo "selected"; ?> >DISCHARGED</option>
                                                          </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Covid Status:</label>
                                                            <div class="col-sm-3">
                                                            <input type="text" class="form-control"  id="CovidStatus" name="CovidStatus"  placeholder=" Enter Covid Status" <?php if(!(isset($_POST['ProgressEdit']))) echo "readonly"; ?> value=<?php echo "'".$row['CovidStatus']."'" ?>>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name" >Plan:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="Plan" name="Plan" <?php if(!(isset($_POST['ProgressEdit']))) echo "readonly"; ?>><?php  echo $row['Plan'] ?></textarea>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            if(isset($_POST['ProgressEdit'])){
                                                        ?>
                                                            <div class="text-center mt-2">
                                                                <button  type="submit" name="ProgressUpdate" value=<?php echo $PatientID; ?> class="btn btn-success align-self-center mx-auto">Update</button>
                                                            </div>
                                                        <?php
                                                            }
                                                            else{
                                                        ?>
                                                        <div class="text-center mt-2">
                                                            <button  type="submit" name="ProgressEdit" value=<?php echo $PatientID; ?> class="btn btn-success align-self-center mx-auto">Edit</button>
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        
                                                </form>
                                                
                                    </div>
                                </div>
                                    <!-- Progress Chart ends -->
                                    
                                      <!-- Discharge From -->
                                      <div class=" <?php if ($tab==10) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab10primary">
                                                            123
                                        <?php
                                            date_default_timezone_set("Asia/Kolkata");
                                            include "../dbconnection.php";
                                            $sql="SELECT * FROM patients where PatientID="."'".$PatientID."'";
                                            $result = $conn->query($sql);
                                            $sql="SELECT * FROM patientcheckup where PatientID="."'".$PatientID."' AND DOC='".$DOA."'";
                                            $result1 = $conn->query($sql);
                                            $sql="SELECT * FROM inpatienttable where PatientID="."'".$PatientID."' AND DOA='".$DOA."'";
                                            $result2 = $conn->query($sql);
                                            if ($result->num_rows > 0 && $result1->num_rows > 0 && $result2->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $row1 = $result1->fetch_assoc();
                                                $row2 = $result2->fetch_assoc();
                                                echo $row['PatientID'];
                                        ?>
                                            <?php
                                                if($DOD!=date("9999-12-31")){
                                            ?>


                                            <div class="container-fluid">
                                                <form class="form-horizontal text-center" action="" method="post">
                                                        <input type="hidden" name="DOA" value=<?php echo $DOA; ?>>
                                                        <input type="hidden" name="DOD" value=<?php echo $DOD; ?>>
                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Patient Name:</label>
                                                            <div class="col-sm-3">
                                                            <input type="text" class="form-control" readonly id="Patientname" name="PatientName" value=<?php echo "'".$row['PatientName']."'"; ?>>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Age:</label>
                                                            <div class="col-sm-3">
                                                            <input type="text" class="form-control" readonly id="Age" name="Age" value=<?php echo $row['Age']; ?>>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Sex:</label>
                                                            <div class="col-sm-3">
                                                            <input type="text" class="form-control" readonly id="Sex" name="Sex" value=<?php echo $row['Sex']; ?>>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Patient ID:</label>
                                                            <div class="col-sm-3">
                                                            <input type="text" class="form-control" readonly id="PatientID" name="PatientID" value=<?php echo $row['PatientID']; ?>>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Date Of Admission:</label>
                                                            <div class="col-sm-3">
                                                            <input type="text" class="form-control" readonly id="DOA" name="DateOfAdmission" value=<?php echo $row1['DOC']; ?>>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Date Of Discharge:</label>
                                                            <div class="col-sm-3">
                                                                <input type="text"  class="form-control" readonly id="DoD" name="DateOfDischarge" value=<?php echo $row2['DOD']; ?>>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">CHIEF COMPLAINTS:</label>
                                                            <div class="col-sm-3">
                                                               <textarea type="text" class="form-control" name="ChiefComplaints"  <?php if(!(isset($_POST['DischargeEdit']))) echo "readonly"; ?>><?php echo $row2['ChiefComplaints']; ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">VITALS ON TIME OF ADMISSION:</label>
                                                            <div class="col-sm-8">
                                                            <br>
                                                                    <!-- Temp Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-1 col-xs-4" for="name">Temp:</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" readonly id="VitalTemp" name="VitalTemp" value=<?php echo "'".$row1['Temp']."'"; ?>>
                                                                                </div>
                                                                        </div>        
                                                                    <!-- Temp Ends -->   
                                                                    <!-- HR Starts -->
                                                                    <div class="form-group center-align col-md-offset-2">
                                                                    <label class="control-label col-sm-1 col-xs-4" for="name">HR:</label>
                                                                            <div class="col-sm-2">
                                                                            <input type="text" class="form-control" readonly id="VitalHR" name="VitalHR" value=<?php echo "'".$row1['HR']."'"; ?>>
                                                                            </div>
                                                                    </div>        
                                                                    <!-- HR Ends -->
                                                                    <!-- BP Starts -->
                                                                    <div class="form-group center-align col-md-offset-2">
                                                                    <label class="control-label col-sm-1 col-xs-4" for="name">BP:</label>
                                                                            <div class="col-sm-2">
                                                                            <input type="text" class="form-control" readonly id="VitalBP" name="VitalBP" value=<?php echo "'".$row1['BP']."'"; ?>>
                                                                            </div>
                                                                    </div>        
                                                                    <!-- BP Ends -->
                                                                    <!-- RR Starts -->
                                                                    <div class="form-group center-align col-md-offset-2">
                                                                    <label class="control-label col-sm-1 col-xs-4" for="name">RR:</label>
                                                                            <div class="col-sm-2">
                                                                            <input type="text" class="form-control"  readonly id="VitalRR"  name="VitalRR" value=<?php echo "'".$row1['RR']."'";?>>
                                                                            </div>
                                                                    </div>
                                                                    <!-- RR Ends -->
                                                                    <!-- SPO2 Starts -->
                                                                    <div class="form-group center-align col-md-offset-2">
                                                                    <label class="control-label col-sm-1 col-xs-4" for="name">SPO2:</label>
                                                                            <div class="col-sm-2">
                                                                            <input type="text" class="form-control" id="ViatalSPO2" readonly name="VitalSPO2"  value=<?php echo "'".$row1['SPO2']."'";?>>
                                                                            </div>
                                                                    </div>
                                                                    <!-- SPO2 Ends -->  
                                                               
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">HOSPITAL TREATMENT:</label>
                                                            <div class="col-sm-3">
                                                                <textarea type="text" class="form-control" id="HospitalTreatment" name="HospitalTreatment" <?php if(!(isset($_POST['DischargeEdit']))) echo "readonly"; ?>><?php echo $row2['HospitalTreatment']; ?></textarea>
                                                            </div>
                                                        </div>

                                                       

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">MEDICATION ADVISED:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="MedicationsAdvised" name="MedicationAdvised" <?php if(!(isset($_POST['DischargeEdit']))) echo "readonly"; ?>><?php echo $row2['MedicationAdvised']; ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group center-align col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">CONDITION AT DISCARGE:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="ConditionAtDischarge" name="ConditionAtDischarge" <?php if(!(isset($_POST['DischargeEdit']))) echo "readonly"; ?>><?php echo $row2['ConditionAtDischarge']; ?> </textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group center-align col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">FOLLOW UP:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="FollowUp" name="FollowUp"  <?php if(!(isset($_POST['DischargeEdit']))) echo "readonly"; ?>><?php echo $row2['FollowUp']; ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group center-align col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">DOCTOR NAME :</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="name" name="DoctorName" placeholder="DOCTOR NAME " value=<?php echo "'".$row2['DoctorName']."'"; ?> <?php if(!(isset($_POST['DischargeEdit']))) echo "readonly"; ?>>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if(isset($_POST['DischargeEdit'])){
                                                          ?>
                                                          <div class="text-center mt-2">
                                                            <button  type="submit" name='DischargeUpdate' value=<?php echo $PatientID; ?> class="btn btn-success align-self-center mx-auto">Update</button>
                                                        </div>
                                                          <?php
                                                        }
                                                        else{
                                                        ?>
                                                        <div class="text-center mt-2">
                                                            <button  type="submit" name='DischargeEdit' value=<?php echo $PatientID; ?> class="btn btn-success align-self-center mx-auto">Edit</button>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                </form>
                                            </div>
                                </div>
                                    <?php
                                        }
                                        else{
                                          echo "cherry";
                                        }
                                    ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
              }
              $conn -> close();
            }
            ?>