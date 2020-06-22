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
<?php
    $tab=0;
    $rowcount="";
    if(isset($_POST['InPatientChart'])){
        $tab=1;
        $PatientID=$_POST['InPatientChart'];
        include "../dbconnection.php";
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];
        $conn -> close();
    }
    else if(isset($_POST['TreatmentSubmit'])){
        // echo $_POST['TreatmentSubmit'];
        $PatientID=$_POST['TreatmentSubmit'];
        date_default_timezone_set("Asia/Kolkata");
        $timestamp=date("Y-m-d H:i:s");
        include "../dbconnection.php";
        $TreatmentDate=$_POST['TreatmentDate'];
        $TreatmentDate = date("Y-m-d", strtotime($TreatmentDate));
        $stmt = $conn->prepare("INSERT INTO treatmenttable(TimeStamp,PatientID, TreatmentDate, Medication, Dose, Route, Frequency) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $timestamp, $PatientID,$TreatmentDate,$_POST['Medication'],$_POST['Dose'],$_POST['Route'],$_POST['Frequency']);
        if($stmt->execute()){
        //   echo "Inserted Treatment Chart";
           $tab=3;
        }
        else{
            echo $stmt->error;
        }
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];
        $conn -> close();
    }
    else if(isset($_POST['TreatmentEdit'])){
        $PatientID= substr($_POST['TreatmentEdit'],0,12);
        $rowcount=substr($_POST['TreatmentEdit'],12);
        $tab=3;
        include "../dbconnection.php";
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];
        $conn -> close();
    }
    else if(isset($_POST['TreatmentSave'])){
        $PatientID= substr($_POST['TreatmentSave'],0,12);
        $rowcount=substr($_POST['TreatmentSave'],12);
        $TimeStamp=$_POST['TimeStamp'.$rowcount];
        include "../dbconnection.php";
        $stmt = $conn->prepare("UPDATE treatmenttable  SET  TreatmentDate=?,  Medication=?,  Dose=?,  Route=?,  Frequency=? WHERE PatientID=? AND TimeStamp=? ");
        $stmt->bind_param("sssssss", $_POST['TreatmentDate'.$rowcount], $_POST['Medication'.$rowcount], $_POST['Dose'.$rowcount], $_POST['Route'.$rowcount], $_POST['Frequency'.$rowcount], $PatientID, $_POST['TimeStamp'.$rowcount]);
        if($stmt->execute()){
            // echo "Updated Treatment Chart";
            $tab=3;
            $rowcount="";
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
        $PatientID= substr($_POST['TreatmentDelete'],0,12);
        $rowcount=substr($_POST['TreatmentDelete'],12);
        $TimeStamp=$_POST['TimeStamp'.$rowcount];
        include "../dbconnection.php";
        $stmt = $conn->prepare("DELETE FROM treatmenttable WHERE PatientID=? AND TimeStamp=? ");
        $stmt->bind_param("ss", $PatientID, $TimeStamp);
        if($stmt->execute()){
            // echo "Deleted a record";
            $tab=3;
            $rowcount="";
        }
        else{
            echo "error on deleting";
        }
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName']; 
        $conn -> close();    
    }

    else if(isset($_POST['ProgressForm'])){
        $PatientID= $_POST['ProgressForm'];
        include "../dbconnection.php";
        $stmt = $conn->prepare("UPDATE progresstable SET ProgressNotes=?, PatientCondition=?, CovidStatus=?, Plan=? WHERE PatientID=? AND DOA=(SELECT MAX(DOA) FROM inpatienttable WHERE PatientID=?)");
        $stmt->bind_param("ssssss", $_POST['ProgressNotes'], $_POST['IPCondition'], $_POST['CovidStatus'], $_POST['Plan'], $PatientID, $PatientID);
        if($stmt->execute()){
            // echo "Updated progress record";
            $tab=4;
            $rowcount="";
        }
        else{
            echo "error on updating";
        }     
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];
        $conn -> close();
    }
    else if(isset($_POST['VitalUpdate'])){
        include "../dbconnection.php";
        $PatientID=$_POST['VitalUpdate'];
        // echo $_POST['vitalTemp'];
        $stmt = $conn->prepare("UPDATE vitaltable  SET  Temp=?, HR=?, BP=?, SPO2=?, RR=?, GRBS=?, GCS=?, VitalOthers=? WHERE PatientID=? AND VitalDate=? AND VitalTime=?");
        $stmt->bind_param("sssssssssss", $_POST['vitalTemp'],$_POST['vitalHR'],$_POST['vitalBP'],$_POST['vitalSPO2'],$_POST['vitalRR'],$_POST['vitalGRBS'],$_POST['vitalGCS'],$_POST['vitalOthers'],$PatientID,$_POST['vitalDate'],$_POST['vitalTime']);
        if($stmt->execute()){
            // echo "Updated Vital Chart";
            $tab=1;

        }
        else{
            echo "error on updating";
        }          
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];  
        $conn -> close();      
        
    }

    else if(isset($_POST['PrintForm'])){

            require_once __DIR__ . '/vendor/autoload.php';
            $mpdf=new \Mpdf\Mpdf();

                $html="";
   
                $html.='


                    <html>
                    <head>
                        <style>
                                @page   {
                                  
                                    margin-bottom: 1cm;
                                    margin-left:1cm;
                                }                        
                        </style>
                    </head>
                    <body>
                      <div style="text-align: center; font-weight: bold;background-color:blue;padding:20px; color:white">
                                            ABC Hospital
                                            
                                        </div>
                                         <div style="text-align: left; font-weight: bold; color:red">
                                            '.$_SESSION['doctor'].'
                                                <div style="text-align: right; font-weight: bold; color:red">
                                            '.$_POST['DateOfDischarge'].'
                                                    </div>
                                        </div>
                                        
                                        <div style="text-align: center; font-weight: bold; color:black">
                                            Discharge Form
                                        </div>
                                       
                                        <hr>
                                    <br><br><br>
                                <div class="container-fluid">
                                                <form class="form-horizontal text-center" action="" method="post">
                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>Patient Name:</b> '.$_POST["PatientName"].'</label>
                                                           
                                                        </div>
                                                        <br>
                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>Age</b>: '.$_POST["Age"].'</label>
                                                           
                                                        </div>
                                                        <br>
                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>Sex</b>: '.$_POST["Sex"].'</label>
                                            
                                                        </div>
                                                        <br>
                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>Patient ID:</b>'.$_POST["PatientID"].'</label>
                                                            
                                                        </div>
                                                        <br>
                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>Date Of Admission: </b>'.$_POST["DateOfAdmission"].'</label>
                                                            
                                                        </div>
                                                        <br>
                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>Date Of Discharge:</b>'.$_POST["DateOfDischarge"] .'</label>
                                                           
                                                        </div>
                                                        <br>
                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>CHIEF COMPLAINTS:</b>'.$_POST["ChiefComplaints"].'</label>
                                                           
                                                        </div>
                                                        <br>
                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>VITALS ON TIME OF ADMISSION:</b></label>
                                                            <div class="col-sm-8" style="margin-left:8cm">
                                                            <br>
                                                                    <!-- Temp Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-1 col-xs-4" for="name">Temp:'.$_POST["VitalTemp"].'</label>
                                                                                
                                                                        </div>  
                                                                        <br>      
                                                                    <!-- Temp Ends -->   
                                                                    <!-- HR Starts -->
                                                                    <div class="form-group center-align col-md-offset-2">
                                                                    <label class="control-label col-sm-1 col-xs-4" for="name">HR:'.$_POST["VitalHR"].'</label>
                                                                            
                                                                    </div>  
                                                                    <br>      
                                                                    <!-- HR Ends -->
                                                                    <!-- BP Starts -->
                                                                    <div class="form-group center-align col-md-offset-2">
                                                                    <label class="control-label col-sm-1 col-xs-4" for="name">BP:'.$_POST["VitalBP"].'</label>
                                                                            
                                                                    </div>   
                                                                    <br>     
                                                                    <!-- BP Ends -->
                                                                    <!-- RR Starts -->
                                                                    <div class="form-group center-align col-md-offset-2">
                                                                    <label class="control-label col-sm-1 col-xs-4" for="name">RR:'.$_POST["VitalRR"].'</label>
                                                                         
                                                                    </div>
                                                                    <br>
                                                                    <!-- RR Ends -->
                                                                    <!-- SPO2 Starts -->
                                                                    <div class="form-group center-align col-md-offset-2">
                                                                    <label class="control-label col-sm-1 col-xs-4" for="name">SPO2:'.$_POST["VitalSPO2"].'</label>
                                                                           
                                                                    </div>
                                                                    <br>
                                                                    <!-- SPO2 Ends -->  
                                                               
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>HOSPITAL TREATMENT:</b>'.$_POST["HospitalTreatment"].'</label>
                                                           
                                                        </div>
                                                        <br>
                                                       

                                                        <div class="form-group col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>MEDICATION ADVISED:</b>'.$_POST["MedicationAdvised"].'</label>
                                                          
                                                        </div>
                                                        <br>
                                                        <div class="form-group center-align col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>CONDITION AT DISCARGE:</b>'.$_POST["ConditionAtDischarge"].'</label>
                                                            
                                                        </div>
                                                        <br>
                                                        <div class="form-group center-align col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>FOLLOW UP:</b>'.$_POST["FollowUp"].'</label>
                                                            
                                                        </div>
                                                        <br>
                                                        <div class="form-group center-align col-md-offset-5" style="margin-left:2cm">
                                                            <label class="control-label col-sm-2" for="name"><b>DOCTOR NAME:</b>'.$_POST["DoctorName"].'</label>
                                                          
                                                        </div>
                                                        <br>
                                   
                                                </form>
                                            </div>
                                 </body>
                             </html>
                
                    ';
            $mpdf->WriteHTML($html);
            $mpdf->SetDisplayMode('fullpage');
            date_default_timezone_set("Asia/Kolkata");
            $mpdf->Output($_POST['PatientID']."_".date("H:i"),"D");
            // echo "hiii";
            
    }
    else if(isset($_POST['DischargeForm'])){
        // echo "hello..";
                include "../dbconnection.php";
                $tab=5;
                $PatientID=$_POST['PatientID'];
                $stmt = $conn->prepare("UPDATE patients SET Status=? WHERE PatientID=?");
                $Status="CLOSED";
                date_default_timezone_set("Asia/Kolkata");
                $TOD=date("H:i:s");
                $stmt->bind_param("ss",$Status,$PatientID);
                if($stmt->execute()){
                    // echo "hii";
                    $sql = $conn->prepare("UPDATE inpatienttable SET DOD=?,TOD=?, ChiefComplaints=?, HospitalTreatment=?, MedicationAdvised=?, ConditionAtDischarge=?, FollowUp=?, DoctorName=? WHERE PatientID=? AND DOD='9999-12-31'");
                    $sql->bind_param("sssssssss",$_POST['DateOfDischarge'],$TOD,$_POST['ChiefComplaints'],$_POST['HospitalTreatment'],$_POST['MedicationAdvised'],$_POST['ConditionAtDischarge'],$_POST['FollowUp'],$_POST['DoctorName'],$PatientID);
                    if($sql->execute()){
                        echo "Patient Discharged";
                        header("Location: inpatientrecord.php");
                    }
                    else{
                        echo "error on updating";
                    }
    
                }
                else{
                    echo "error on updating";
                }
                $conn -> close();

    }
    else if(isset($_POST['VitalEdit'])){
        include '../dbconnection.php';
        $PatientID=substr($_POST['VitalEdit'],0,12);
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];
        $tab=1;
        $conn -> close();
    }
    else if(isset($_POST['InvestigationEdit'])){
        include '../dbconnection.php';
        $PatientID=$_POST['PatientID'];
        $tab=2;
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];
        $conn -> close();
    }
    else if(isset($_POST['InvestigationUpdate'])){
        include "../dbconnection.php";
        $PatientID=$_POST['InvestigationUpdate'];
        $stmt = $conn->prepare("UPDATE investigationtable  SET  HB=?,  TLC=?,  PLT=?,  HCT=?,  FBS=?,  PPBS=?,  RBS=?,  HBA1C=?,  BUREA=?,  CREAT=?,  NA=?,  K=?,  CL=?,  TBIL=?,  DIRECT=?,  INDIRECT=?,  SGOT=?,  SGPT=?,  ALP=?,  ALBUMIN=?,  GLOBULIN=?,  BT=?,  CCT=?,  PTINR=?,  DENGUE=?,  MP=?,  WIDAL=?,  PUSCELLS=?,  RBC=?,  SUGARS=?,  KETONE=?,  HIV=?,  HBSAG=?,  HCV=?,  CHESTXRAY=?,  USG=?,  ICT=?,  MRI=?,  ECG=?,  TROPI=?,  ECHO=?,  SPECIFICINVEST=?,  SWAB=?,  RAPIDANTIGENTEST=?,  ABG=?,  PROCALCITONIN=?, InvestigationOthers=? WHERE PatientID=? AND ICDate=? AND ICTime=?");
        $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssss", $_POST['HB'], $_POST['TLC'], $_POST['PLT'], $_POST['HCT'], $_POST['FBS'], $_POST['PPBS'], $_POST['RBS'], $_POST['HBA1C'], $_POST['BUREA'], $_POST['CREAT'], $_POST['NA'], $_POST['K'], $_POST['CL'], $_POST['TBIL'], $_POST['DIRECT'], $_POST['INDIRECT'], $_POST['SGOT'], $_POST['SGPT'], $_POST['ALP'], $_POST['ALBUMIN'], $_POST['GLOBULIN'], $_POST['BT'], $_POST['CCT'], $_POST['PTINR'], $_POST['DENGUE'], $_POST['MP'], $_POST['WIDAL'], $_POST['PUSCELLS'], $_POST['RBC'], $_POST['SUGARS'], $_POST['KETONE'], $_POST['HIV'], $_POST['HBSAG'], $_POST['HCV'], $_POST['CHESTXRAY'], $_POST['USG'], $_POST['ICT'], $_POST['MRI'], $_POST['ECG'], $_POST['TROPI'], $_POST['ECHO'], $_POST['SPECIFICINVEST'], $_POST['SWAB'], $_POST['RAPIDANTIGENTEST'], $_POST['ABG'], $_POST['PROCALCITONIN'],$_POST['InvestigationOthers'],$PatientID, $_POST['ICDate'],$_POST['ICTime']);
        if($stmt->execute()){
            // echo "Updated Investigation Chart";
            $tab=2;

        }
        else{
            echo "error on updating";
        }            
        $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
        $result = $conn->query($sql);
        $PatientName = mysqli_fetch_assoc($result)['PatientName'];  
        $conn -> close();
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
          <!-- <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
          <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->
          <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>  
         <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> 

    
          <style> 
            .table_wrapper{
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
</style>

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
                    <li ><a href="doctor.php">Active Patient Records</a></li>
                    <li class="active">
                      <a href="inpatientrecord.php">InPatient Records</a>
                    </li>
                    <li ><a href="bulletin.php">Bulletin</a></li>
                  </ul>
                  
                  <ul class="nav navbar-nav navbar-right">
                  <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['doctor']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
                </div>
            </div>
          </nav>
        <!-- Active InPateint Records -->
        <h2 id="active-heading">Active InPatient Records</h2>
        <hr>
        <div class="container-fluid">
              <div class="row">
                <div class=" col-md-3">
                
                  <h3>Patient Name:<?php echo  $PatientName?></h3>  
                </div>
                <div class="col-md-6 ">
                
                  <h3>Patient ID:<?php echo $PatientID;?></h3>
                </div>
              </div>
           </div>


        <?php
        if($tab==1 || $tab==2 || $tab==3 || $tab==4 || $tab==5){
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel with-nav-tabs panel-primary">
                            <div class="panel-heading">
                                <ul class="nav nav-tabs">
                                    <li class=<?php if ($tab==1) echo "active";else echo "inactive"; ?>><a href="#tab1primary" data-toggle="tab">VITAL CHART</a></li>
                                    <li class=<?php if ($tab==2) echo "active";else echo "inactive"; ?>><a href="#tab2primary" data-toggle="tab">INVESTIGATION CHART</a></li>
                                    <li class=<?php if ($tab==3) echo "active";else echo "inactive"; ?>><a href="#tab3primary" data-toggle="tab">TREATMENT CHART</a></li>
                                    <li class=<?php if ($tab==4) echo "active";else echo "inactive"; ?>><a href="#tab4primary" data-toggle="tab">PROGRESS NOTES</a></li>
                                    <li class=<?php if ($tab==5) echo "active";else echo "inactive"; ?>><a href="#tab5primary" data-toggle="tab">DISCHARGE SUMMARY</a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class=" <?php if ($tab==1) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab1primary">
                                        <?php
                                            if(isset($_POST['VitalEdit'])){
                                                // echo $_POST['VitalEdit'];
                                                $rowcount=substr($_POST['VitalEdit'],12);
                                        ?>
                                            <div class="container-fluid">
                                                        <form  class="form-horizontal" method="POST" action="inpatient.php">
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
                                            <form action="inpatient.php" method="post">
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
                                                            $sql="SELECT * FROM vitaltable ,inpatienttable where vitaltable.PatientID=inpatienttable.PatientID AND vitaltable.PatientID="."'".$PatientID."' AND vitaltable.VitalDate>=(SELECT DOA FROM inpatienttable WHERE inpatienttable.PatientID='".$PatientID."' AND DOD='9999-12-31') AND DOD='9999-12-31'";
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
                                                                        <td><button type="submit" class='btn btn-success align-self-center mx-auto'  onClick="return confirm('Are you sure, you want to Edit?');" name="VitalEdit" value=<?php echo $PatientID.$count; ?>>Edit</button></td>
                                                                    </tr>
                                                                    <?php
                                                                    $count++;
                                                                }
                                                            } else {
                                                                // echo "0 inpatients";
                                                            }
                                                            $conn -> close();


                                                    

                                            // conn.close();
                                                    ?>
                                                            </tbody>
                                                        </table>
                                                        </form>
                                            <?php
                                            }
                                            ?>
                                    </div>
                                    <div class=" <?php if ($tab==2) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab2primary">
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
                                                                    <form  class="form-horizontal" method="post" action="inpatient.php">
                                                                       
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
                                        $sql="SELECT * FROM investigationtable ,inpatienttable where investigationtable.PatientID=inpatienttable.PatientID AND investigationtable.PatientID="."'".$PatientID."' AND investigationtable.ICDate>=(SELECT DOA FROM inpatienttable WHERE inpatienttable.PatientID='".$PatientID."' AND DOD='9999-12-31') AND DOD='9999-12-31'";
                                        $result=mysqli_query($conn,$sql);
                                        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
                                        $count=count($row);
                                    ?>
                                        <form action="inpatient.php" method="post">
                                            <input type="hidden" name="PatientID" value=<?php echo $PatientID; ?>>
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
                                    <div class=" <?php if ($tab==3) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab3primary">
                                        <div class="container-fluid">
                                            <form method="post" autocomplete="off" action="inpatient.php">
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
                                                                $sql="SELECT * FROM treatmenttable t1, inpatienttable t2 where t1.PatientID=t2.PatientID AND t1.PatientID="."'".$PatientID."'"."AND t1.TreatmentDate>=(SELECT DOA FROM inpatienttable WHERE inpatienttable.PatientID="."'".$PatientID."'". "AND DOD='9999-12-31') AND DOD='9999-12-31'";
                                                                $result = $conn->query($sql);
                                                                $count=1;
                                                                if ($result->num_rows > 0) {
                                                                    // output data of each row
                                                                    while($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <tr>
                                                                
                                                                <td><?php echo $count ?></td>
                                                                <?php
                                                                    if($count!=$rowcount){
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
                                                                <input type="hidden" name=<?php echo "TimeStamp".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['TimeStamp']."'"; ?>>
                                                                
                                                                <td><input class="form-control" id="medication" type="text" name=<?php echo "Medication".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Medication']."'"; ?>></td><div id="medicationList"></div>
                                                                <td><input class="form-control" type="text" name=<?php echo "Dose".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Dose']."'"; ?>></td>
                                                                <td><input class="form-control" type="text" name=<?php echo "Route".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Route']."'"; ?>></td>
                                                                <td><input class="form-control" type="text" name=<?php echo "Frequency".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Frequency']."'"; ?>></td>
                                                                <?php
                                                                    if($rowcount!=$count){
                                                                ?>
                                                                    <td><button type="submit" class='btn btn-success align-self-center mx-auto'  onClick="removeRequiredforEdit(this.form)" name="TreatmentEdit" value=<?php echo $PatientID.$count; ?>>Edit</button> <button type="submit" name="TreatmentDelete"   Onclick=" return removeRequiredforDelete(this.form)" class='btn btn-danger align-self-center mx-auto' value=<?php echo $row['PatientID'].$count; ?>>Delete</button> </td>
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
                                                                    if($rowcount==""){
                                                            ?>
                                                                    <tr>
                                                                    <td><?php echo $count; ?></td>
                                                                        <td><input  type="text" class="form-control" required id="TreatmentDate" value=<?php echo date('Y-m-d'); ?>  name="TreatmentDate" width="270"></td>
                                                                        <td><input class="form-control" id="medication" type="text" required name="Medication"></td>
                                                                        <td><input class="form-control" type="text" required name="Dose"></td>
                                                                        <td><input class="form-control" type="text" required name="Route"></td>
                                                                        <td><input class="form-control" type="text" required name="Frequency"></td>
                                                                        <td><button type="submit" name="TreatmentSubmit" value=<?php echo $PatientID; ?> class='btn btn-success align-self-center mx-auto'>Submit</button></td>
                                                                    </tr>
                                                            <?php
                                                                    }
                                                            ?>
                                                            
                                                    </tbody>
                                                </table>
                                                
                                                </form>
                                                    
                                        </div>
                                    </div>
                                    <!-- Treatment chrt ends -->
                                    <!-- Tab Progress Notes -->
                                    <div class=" <?php if ($tab==4) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab4primary">
                                    <div class="container-fluid">

                                                <?php
                                                       include "../dbconnection.php";
                                                       $sql="SELECT * FROM progresstable where PatientID='".$PatientID."'AND DOA=(SELECT MAX(DOA) FROM progresstable WHERE PatientID='".$PatientID."')";
                                                       $result = $conn->query($sql);
                                                       if ($result->num_rows > 0) {
                                                       $row = $result->fetch_assoc();
                                                       } else {
                                                           echo "no progress chart";
                                                       } 
                                                       $conn -> close();
                                                ?>
                                                <form class="form-horizontal text-center" action="inpatient.php" method="post">
                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Progress Notes:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="ProgressNotes" name="ProgressNotes" ><?php echo $row['ProgressNotes']  ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">Patient Condition</label>
                                                            <div class="col-sm-3">
                                                            <select class="form-control" id="IPCondition" name="IPCondition" >
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
                                                            <input type="text" class="form-control"  id="CovidStatus" name="CovidStatus"  placeholder=" Enter Covid Status" value=<?php echo "'".$row['CovidStatus']."'" ?>>
                                                            </div>
                                                        </div>

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name" >Plan:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="Plan" name="Plan" ><?php  echo $row['Plan'] ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="text-center mt-2">
                                                            <button  type="submit" name="ProgressForm" value=<?php echo $PatientID; ?> class="btn btn-success align-self-center mx-auto">Submit</button>
                                                        </div>
                                                        
                                                </form>
                                            </div>
                                    
                                    </div>
                                    <!-- Progress Chart ends -->
                                    <!-- Discharge From -->
                                    <div class=" <?php if ($tab==5) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab5primary">
                                        <?php
                                            date_default_timezone_set("Asia/Kolkata");
                                            include "../dbconnection.php";
                                            $sql="SELECT * FROM patients where PatientID="."'".$PatientID."' AND Status='INPATIENT'";
                                            $result = $conn->query($sql);
                                            $sql="SELECT * FROM patientcheckup where PatientID="."'".$PatientID."' AND DOC=(SELECT max(DOC) from patientcheckup where PatientID="."'".$PatientID ."')";
                                            $result1 = $conn->query($sql);
                                            if ($result->num_rows > 0 && $result1->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $row1 = $result1->fetch_assoc();
                                                // echo $row['PatientID'];
                                        ?>



                                            <div class="container-fluid">
                                                <form class="form-horizontal text-center" action="inpatient.php" method="post">
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
                                                                <input type="text"  class="form-control" id="DoD" name="DateOfDischarge" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">CHIEF COMPLAINTS:</label>
                                                            <div class="col-sm-3">
                                                               <textarea type="text" class="form-control" name="ChiefComplaints"></textarea>
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
                                                                <textarea type="text" class="form-control" id="HospitalTreatment" name="HospitalTreatment"></textarea>
                                                            </div>
                                                        </div>

                                                       

                                                        <div class="form-group  col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">MEDICATION ADVISED:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="MedicationsAdvised" name="MedicationAdvised"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group center-align col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">CONDITION AT DISCARGE:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="ConditionAtDischarge" name="ConditionAtDischarge"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group center-align col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">FOLLOW UP:</label>
                                                            <div class="col-sm-3">
                                                            <textarea type="text" class="form-control" id="FollowUp" name="FollowUp"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group center-align col-md-offset-5">
                                                            <label class="control-label col-sm-2" for="name">DOCTOR NAME :</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="name" name="DoctorName" placeholder="DOCTOR NAME ">
                                                            </div>
                                                        </div>

                                                        <div class="text-center mt-2">
                                                            <button  type="submit" name="PrintForm" value=<?php echo $PatientID; ?> class="btn btn-success align-self-center mx-auto">Print Summary</button>
                                                            <button  type="submit" id="DischargeForm" name="DischargeForm" onclick=" return confirm('Are You Sure, Want to Discharge?');" value=<?php echo $PatientID; ?> class="btn btn-success align-self-center mx-auto">Discharge</button>
                                                        </div>
                                                </form>
                                            </div>
                                            <?php
                                            }
                                            else{
                                                echo "no data found";
                                            }
                                            $conn -> close();
                                            ?>
                                    </div>
                                    <!-- Discharge ends -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Inpatient Records -->
        <?php
        }
        ?>
        <!-- Active InPatient Records -->


        


                    <script>
                        


                      function removeRequiredforEdit(form){
                            $.each(form, function(key, value) {
                                if ( value.hasAttribute("required")){
                                    value.removeAttribute("required");
                                }
                            });
                        }
                        function removeRequiredforDelete(form){
                            
                            $.each(form, function(key, value) {
                                if ( value.hasAttribute("required")){
                                    value.removeAttribute("required");
                                }
                            });
                            return confirm('Are you sure, you want to delete the record?');
                        }

             
                    </script> 
                    <script>
                        $('#TreatmentDate').datepicker({
              
                                dateFormat: 'yy-mm-dd'
                            });
                    </script>
                    <script>
                            $('#DoD').datepicker({
                                    
                                    dateFormat: 'yy-mm-dd'
                                });
          
                    </script>

                        <script>
                        if ( window.history.replaceState ) {
                            window.history.replaceState( null, null, 'inpatientrecord.php' );
                            }
                        </script>
    </body>
    </html>