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
          <!-- <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
          <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->
          <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>  
         <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> 

        </head>
        <body>

        <?php include '../header.php';?> <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
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
                  <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['nurse']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
                </div>
            </div>
             
          </nav>

<?php


    // Vital Chart start
    $tab=0;
    $Submit="VitalEntry";
    $currentDate=date('Y-m-d');
        $currentTime="2:00AM";
        $Temp="";
        $HR="";
        $BP="";
        $SPO2="";
        $RR="";
        $GRBS="";
        $GCS="";
        $VitalOthers="";
        
    if(isset($_POST['patientChart'])){
        $PatientID=$_POST['patientChart'];
        $tab=3;
    }
    else if(isset($_POST['VitalEntry'])){
        // echo "***";
        $PatientID=$_POST['VitalEntry'];
        include "../dbconnection.php";
        $VitalDate=$_POST['vitalDate'];
        $VitalDate = date("Y-m-d", strtotime($VitalDate));
        $stmt = $conn->prepare("INSERT INTO vitaltable(PatientID, VitalDate, VitalTime, Temp, HR, BP, SPO2, RR, GRBS, GCS,VitalOthers) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("sssssssssss", $_POST['VitalEntry'],$VitalDate,$_POST['vitalTime'],$_POST['vitalTemp'],$_POST['vitalHR'],$_POST['vitalBP'],$_POST['vitalSPO2'],$_POST['vitalRR'],$_POST['vitalGRBS'],$_POST['vitalGCS'],$_POST['vitalOthers']);
        if($stmt->execute()){
        //   echo "Inserted Vital Chart";
           $tab=1;
        }
        else{
            // echo "error on inserting vital chart";
            ?>
            <script>alert("Record already exists");</script>
            <?php
            $tab=3;
        }
        $conn -> close();
        
    }
    else if(isset($_POST['VitalEdit'])){
        // echo $_POST['VitalEdit'];
        
        $Submit='VitalUpdate';
        $PatientID=substr($_POST['VitalEdit'],0,12);
        $currentDate=substr($_POST['VitalEdit'],12,10);
        $currentTime=substr($_POST['VitalEdit'],22,6);
        

            include "../dbconnection.php";
            $sql="SELECT * FROM vitaltable where PatientID="."'".$PatientID."' AND VitalDate="."'".$currentDate."' AND VitalTime="."'".$currentTime."'";
            $result = $conn->query($sql);
            if($row = $result->fetch_assoc()){
                $Temp="'".$row['Temp']."'";
                $HR="'".$row['HR']."'";
                $BP="'".$row['BP']."'";
                $SPO2="'".$row['SPO2']."'";
                $GRBS="'".$row['GRBS']."'";
                $GCS="'".$row['GCS']."'";
                $RR="'".$row['RR']."'";
                $VitalOthers=$row['VitalOthers'];
                $tab=3;
            }
            // echo $Temp;
            $conn -> close();
    }
    else if(isset($_POST['VitalUpdate'])){
        include "../dbconnection.php";
        $PatientID=$_POST['VitalUpdate'];
        $stmt = $conn->prepare("UPDATE vitaltable  SET  Temp=?, HR=?, BP=?, SPO2=?, RR=?, GRBS=?, GCS=?, VitalOthers=? WHERE PatientID=? AND VitalDate=? AND VitalTime=?");
        $stmt->bind_param("sssssssssss", $_POST['vitalTemp'],$_POST['vitalHR'],$_POST['vitalBP'],$_POST['vitalSPO2'],$_POST['vitalRR'],$_POST['vitalGRBS'],$_POST['vitalGCS'],$_POST['vitalOthers'],$PatientID,$_POST['vitalDate'],$_POST['vitalTime']);
        if($stmt->execute()){
            // echo "Updated Vital Chart";
            $tab=1;

        }
        else{
            echo "error on updating";
        }                  
        $conn -> close();
    }
    // Vital Chart ends


    // Investigation chart starts
    $Submit1="InvestigationEntry";
    $HB="";
    $TLC="";
    $PLT="";
    $HCT="";
    $FBS="";
    $PPBS="";
    $RBS="";
    $HBA1C="";
    $BUREA="";
    $CREAT="";
    $NA="";
    $K="";
    $CL="";
    $TBIL="";
    $DIRECT="";
    $INDIRECT="";
    $SGOT="";
    $SGPT="";
    $ALP="";
    $ALBUMIN="";
    $GLOBULIN="";
    $BT="";
    $CCT="";
    $PTINR="";
    $DENGUE="";
    $MP="";
    $WIDAL="";
    $PUSCELLS="";
    $RBC="";
    $SUGARS="";
    $KETONE="";
    $HIV="";
    $HBSAG="";
    $HCV="";
    $CHESTXRAY="";
    $USG="";
    $ICT="";
    $MRI="";
    $ECG="";
    $TROPI="";
    $ECHO="";
    $SPECIFICINVEST="";
    $SWAB="";
    $RAPIDANTIGENTEST="";
    $ABG="";
    $PROCALCITONIN="";
    $InvestigationOthers="";
    if(isset($_POST['InvestigationEntry'])){
        $PatientID=$_POST['InvestigationEntry'];
        date_default_timezone_set("Asia/Kolkata");
        $ICDate=date('Y-m-d');
        $ICTime=date('H:i:s');
        include "../dbconnection.php";
        $stmt = $conn->prepare("INSERT INTO investigationtable(PatientID, ICDate, ICTime, HB, TLC, PLT, HCT, FBS, PPBS, RBS, HBA1C, BUREA, CREAT, NA, K, CL, TBIL, DIRECT, INDIRECT, SGOT, SGPT, ALP, ALBUMIN, GLOBULIN, BT, CCT, PTINR, DENGUE, MP, WIDAL, PUSCELLS, RBC, SUGARS, KETONE, HIV, HBSAG, HCV, CHESTXRAY, USG, ICT, MRI, ECG, TROPI, ECHO, SPECIFICINVEST, SWAB, RAPIDANTIGENTEST, ABG, PROCALCITONIN, InvestigationOthers) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssss",$PatientID,$ICDate,$ICTime, $_POST['HB'], $_POST['TLC'], $_POST['PLT'], $_POST['HCT'], $_POST['FBS'], $_POST['PPBS'], $_POST['RBS'], $_POST['HBA1C'], $_POST['BUREA'], $_POST['CREAT'], $_POST['NA'], $_POST['K'], $_POST['CL'], $_POST['TBIL'], $_POST['DIRECT'], $_POST['INDIRECT'], $_POST['SGOT'], $_POST['SGPT'], $_POST['ALP'], $_POST['ALBUMIN'], $_POST['GLOBULIN'], $_POST['BT'], $_POST['CCT'], $_POST['PTINR'], $_POST['DENGUE'], $_POST['MP'], $_POST['WIDAL'], $_POST['PUSCELLS'], $_POST['RBC'], $_POST['SUGARS'], $_POST['KETONE'], $_POST['HIV'], $_POST['HBSAG'], $_POST['HCV'], $_POST['CHESTXRAY'], $_POST['USG'], $_POST['ICT'], $_POST['MRI'], $_POST['ECG'], $_POST['TROPI'], $_POST['ECHO'], $_POST['SPECIFICINVEST'], $_POST['SWAB'], $_POST['RAPIDANTIGENTEST'], $_POST['ABG'], $_POST['PROCALCITONIN'],$_POST['InvestigationOthers']);
        if($stmt->execute()){
        //   echo "Inserted Investigation Chart";
          $tab=2;
        }
        else{
            ?>
            <!-- <script>alert("Data Sakkaga Kottave..!!!!");</script> -->
             <?php
        }
        $conn -> close();
        
    }
    else if(isset($_POST['InvestigationEdit'])){
        // echo $_POST['InvestigationEdit'];
        $Submit1='InvestigationUpdate';
        $PatientID=substr($_POST['InvestigationEdit'],0,12);
        $ICDate=substr($_POST['InvestigationEdit'],12,10);
        $ICTime=substr($_POST['InvestigationEdit'],22,8);
        include "../dbconnection.php";
        $sql="SELECT * FROM investigationtable where PatientID="."'".$PatientID."' AND ICDate="."'".$ICDate."' AND ICTime="."'".$ICTime."'";
        $result = $conn->query($sql);
        if($row = $result->fetch_assoc()){
            $HB="'".$row['HB']."'";
            $TLC="'".$row['TLC']."'";
            $PLT="'".$row['PLT']."'";
            $HCT="'".$row['HCT']."'";
            $FBS="'".$row['FBS']."'";
            $PPBS="'".$row['PPBS']."'";
            $RBS="'".$row['RBS']."'";
            $HBA1C="'".$row['HBA1C']."'";
            $BUREA="'".$row['BUREA']."'";
            $CREAT="'".$row['CREAT']."'";
            $NA="'".$row['NA']."'";
            $K="'".$row['K']."'";
            $CL="'".$row['CL']."'";
            $TBIL="'".$row['TBIL']."'";
            $DIRECT="'".$row['DIRECT']."'";
            $INDIRECT="'".$row['INDIRECT']."'";
            $SGOT="'".$row['SGOT']."'";
            $SGPT="'".$row['SGPT']."'";
            $ALP="'".$row['ALP']."'";
            $ALBUMIN="'".$row['ALBUMIN']."'";
            $GLOBULIN="'".$row['GLOBULIN']."'";
            $BT="'".$row['BT']."'";
            $CCT="'".$row['CCT']."'";
            $PTINR="'".$row['PTINR']."'";
            $DENGUE="'".$row['DENGUE']."'";
            $MP="'".$row['MP']."'";
            $WIDAL="'".$row['WIDAL']."'";
            $PUSCELLS="'".$row['PUSCELLS']."'";
            $RBC="'".$row['RBC']."'";
            $SUGARS="'".$row['SUGARS']."'";
            $KETONE="'".$row['KETONE']."'";
            $HIV="'".$row['HIV']."'";
            $HBSAG="'".$row['HBSAG']."'";
            $HCV="'".$row['HCV']."'";
            $CHESTXRAY="'".$row['CHESTXRAY']."'";
            $USG="'".$row['USG']."'";
            $ICT="'".$row['ICT']."'";
            $MRI="'".$row['MRI']."'";
            $ECG="'".$row['ECG']."'";
            $TROPI="'".$row['TROPI']."'";
            $ECHO="'".$row['ECHO']."'";
            $SPECIFICINVEST="'".$row['SPECIFICINVEST']."'";
            $SWAB="'".$row['SWAB']."'";
            $RAPIDANTIGENTEST="'".$row['RAPIDANTIGENTEST']."'";
            $ABG="'".$row['ABG']."'";
            $PROCALCITONIN="'".$row['PROCALCITONIN']."'";
            $InvestigationOthers=$row['InvestigationOthers'];
        }
        $tab=4;
        // echo $Temp;
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
        $conn -> close();
    }

    // Investigation chart ends
?>



<?php
    if($tab==1 || $tab==2  || $tab==3 || $tab==4 || $tab==5){

         include "../dbconnection.php";
            $sql="select PatientName from patients where PatientID="."'".$PatientID."'";
            $result = $conn->query($sql);
            $name = mysqli_fetch_assoc($result)['PatientName'];
            $PatientName=$name;
            $conn -> close();
?>      


            <div class="container-fluid">
              <div class="row">
                <div class=" col-md-3">
                  
                  <h3>Patient Name:<?php echo " ".$PatientName; ?></h3>  
                </div>
                <div class="col-md-6 ">
                
                  <h3>Patient ID:<?php echo " ".$PatientID;?></h3>
                </div>
              </div>
           </div>

                <div class="container-fluid">
                                <div class="row">
                                <div class="col-md-12">
                                        <div class="panel with-nav-tabs panel-primary">
                                            <div class="panel-heading">
                                                    <ul class="nav nav-tabs">
                                                        <li class=<?php if ($tab==1) echo "active";else echo "inactive"; ?>><a href="#tab1primary" data-toggle="tab">Vital Chart History</a></li>
                                                        <li class=<?php if ($tab==2) echo "active";else echo "inactive"; ?>><a href="#tab2primary" data-toggle="tab">Investigation Chart History</a></li>
                                                        <li class=<?php if ($tab==3) echo "active";else echo "inactive"; ?>><a href="#tab3primary" data-toggle="tab">Vital Chart</a></li>
                                                        <li class=<?php if ($tab==4) echo "active";else echo "inactive"; ?>><a href="#tab4primary" data-toggle="tab">Investigation Chart</a></li>
                                                        <li class=<?php if ($tab==5) echo "active";else echo "inactive"; ?>><a href="#tab5primary" data-toggle="tab">Treatment Chart</a></li>
                                                    </ul>
                                            </div>
                                            <div class="panel-body">
                                                <div class="tab-content">


                                                
                                                    <div class="<?php if ($tab==1) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab1primary">
                                                    <?php
                                                // if(isset($_SESSION['InPatientID'])){
                                                ?>

                                                    <form action="inpatientchart.php" method="post">
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
                                                                <th>Modify</th>
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
                                                                    echo   "<tr><td>".$count."</td><td>".$row["PatientID"]."</td><td >".$row["VitalDate"]."</td><td>".$row["VitalTime"]."</td><td>".$row["Temp"]."</td><td>".$row["HR"]."</td><td>".$row["BP"]."</td><td>".$row["SPO2"]."</td><td>".$row["RR"]."</td><td>".$row["GRBS"]."</td><td>".$row["GCS"]."</td><td>".$row["VitalOthers"]."</td><td><button  type='submit' name='VitalEdit' value=".$row['PatientID'].$row['VitalDate'].$row['VitalTime']." class='btn btn-success align-self-center mx-auto'>Modify</button></td></tr>";
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
                                                    </div>
                                                


                                                    <div class="<?php if ($tab==2) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab2primary">
                                                    <form action="inpatientchart.php" method="post">
                                                        <table class="table tab table-hover table-bordered table-responsive">
                                                            <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>Patient ID</th>
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>Modify</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                    <?php  
                                                    //  }
                                                            include "../dbconnection.php";
                                                            $sql="SELECT * FROM investigationtable ,inpatienttable where investigationtable.PatientID=inpatienttable.PatientID AND investigationtable.PatientID="."'".$PatientID."' AND investigationtable.ICDate>=(SELECT DOA FROM inpatienttable WHERE inpatienttable.PatientID='".$PatientID."' AND DOD='9999-12-31') AND DOD='9999-12-31'";
                                                            $result = $conn->query($sql);
                                                            if ($result->num_rows > 0) {
                                                            // output data of each row
                                                            $count=1;
                                                            while($row = $result->fetch_assoc()){
                                                                    echo   "<tr><td>".$count."</td><td>".$row["PatientID"]."</td><td >".$row["ICDate"]."</td><td>".$row["ICTime"]."</td><td><button  type='submit' name='InvestigationEdit' value=".$row['PatientID'].$row['ICDate'].$row['ICTime']." class='btn btn-success align-self-center mx-auto'>Modify</button></td></tr>";
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
                                                    </div>






                                                    <div class="<?php if ($tab==3) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab3primary">
                                                    <div class="container-fluid">
                                                        <form  class="form-horizontal" method="POST" action="inpatientchart.php">
                                                        <div class="form-group center-align">
                                                            <label class="control-label col-sm-2" for="name">Select Date</label>
                                                            <?php
                                                            if($Submit=='VitalEntry'){
                                                            ?>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control"  id="vitalDate" value=<?php echo $currentDate; ?>  name="vitalDate" width="270">
                                                            </div>
                                                            <?php
                                                            }
                                                            else{
                                                            ?>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" readonly value=<?php echo $currentDate; ?>  name="vitalDate" width="270">
                                                            </div>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                        <!-- vitalTime Start -->
                                                        <div class="form-group center-align">
                                                                    <label class="control-label col-sm-2 col-xs-4" for="name">Time</label>
                                                                    <div class="col-sm-4 col-xs-6">
                                                                        <label class="radio-inline">
                                                                        <input type="radio" id="radioValue1" name="vitalTime" value="8:00AM"  <?php if($currentTime=="8:00AM") echo "checked"; if($Submit=="VitalUpdate" && $currentTime!="8:00AM") echo "disabled"; ?>>8AM
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                        <input type="radio" id="radioValue2" name="vitalTime" value="2:00PM"  <?php if($currentTime=="2:00PM") echo "checked"; if($Submit=="VitalUpdate" && $currentTime!="2:00PM") echo "disabled"; ?> >2PM
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                        <input type="radio" id="radioValue3" name="vitalTime" value="8:00PM"  <?php if($currentTime=="8:00PM") echo "checked"; if($Submit=="VitalUpdate" && $currentTime!="8:00PM") echo "disabled"; ?> >8PM
                                                                        </label><label class="radio-inline">
                                                                        <input type="radio" id="radioValue4" name="vitalTime" value="2:00AM"   <?php if($currentTime=="2:00AM") echo "checked"; if($Submit=="VitalUpdate" && $currentTime!="2:00AM") echo "disabled"; ?>>2AM
                                                                        </label>
                                                                    </div>
                                                            </div>
                                                                <!-- vitalTime Ends -->
                                                                <br>
                                                        <!-- vitalTemp Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">Temp:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalTemp"  name="vitalTemp" placeholder="---/F" value=<?php echo $Temp; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalTemp Ends -->
                                                        <!-- vitalHR Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">HR:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalHR"  name="vitalHR" placeholder="---/Min" value=<?php echo $HR; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalHR Ends -->
                                                        <!-- vitalBP Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">BP:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalBP"  name="vitalBP" placeholder="---/mmHg" value=<?php echo $BP; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalBP Ends -->
                                                        <!-- vitalSPO2 Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">SPO2:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalSPO2"  name="vitalSPO2" placeholder="---%" value=<?php echo $SPO2; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalSPO2 Ends -->
                                                        <!-- vitalRR Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">RR:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalRR"  name="vitalRR" placeholder="---/Min" value=<?php echo $RR; ?>>
                                                                        </div>
                                                            </div>        
                                                        <!-- vitalRR Ends -->
                                                            <!-- vitalGRBS Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">GRBS:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalGRBS"  name="vitalGRBS" value=<?php echo $GRBS; ?>>
                                                                        </div>
                                                            </div>        
                                                            <!-- vitalGRBS Ends -->
                                                            <!-- vitalGCS Starts -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">GCS:</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="text" class="form-control" id="vitalGCS"  name="vitalGCS" value=<?php echo $GCS; ?>>
                                                                        </div>
                                                            </div>        
                                                            <!-- vitalGCS Ends -->
                                                            <div class="form-group center-align col-md-offset-2">
                                                                <label class="control-label col-sm-2 col-xs-4" for="name">OTHERS:</label>
                                                                        <div class="col-sm-2">
                                                                        <textarea class="form-control" id="vitalOthers"  name="vitalOthers"><?php echo $VitalOthers; ?></textarea>
                                                                        </div>
                                                            </div>   
                                                            
                                                            <div class="text-center">   
                                                                    <button  type="submit" name=<?php echo $Submit; ?> value=<?php echo $PatientID ?> class="btn btn-success align-self-center mx-auto">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                    <div class="<?php if ($tab==4) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab4primary">
                                                    <form  class="form-horizontal" method="post" action="inpatientchart.php">
                                                                        <?php
                                                                            if($Submit1=='InvestigationUpdate'){
                                                                        ?>
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                <label class="control-label col-sm-1 col-xs-4" for="name">Date:</label>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" class="form-control" id="ICDate" readonly name="ICDate" value=<?php echo $ICDate; ?>>
                                                                                </div>
                                                                                <label class="control-label col-sm-1 col-xs-4" for="name">Time:</label>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" class="form-control" id="ICTime" readonly name="ICTime" value=<?php echo $ICTime; ?>>
                                                                                </div>
                                                                        </div>  
                                                                        
                                                                            
                                                                           <br> 



                                                                        <?php
                                                                            }

                                                                        ?>


                                                                        <div class="row">
                                                                            <div class="col-md-offset-1 col-md-2">
                                                                            <h4><strong>CBP</strong></h4>
                                                                            </div>
                                                                        </div>
                                                                        <!-- HB Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">HB:</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="HB"  name="HB" value=<?php echo $HB; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--HB Ends -->   
                                                                        <!-- TLC Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">TLC:</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="TLC"  name="TLC" value=<?php echo $TLC; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--TLC Ends --> 
                                                                        <!-- PLT Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">PLT:</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="PLT"  name="PLT" value=<?php echo $PLT; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--PLT Ends --> 
                                                                        <!-- HCT Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">HCT:</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="HCT"  name="HCT" value=<?php echo $HCT; ?>>
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
                                                                                <input type="text" class="form-control" id="FBS"  name="FBS" value=<?php echo $FBS; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--FBS Ends --> 
                                                                         <!-- PPBS Starts -->
                                                                         <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">PPBS:</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="PPBS"  name="PPBS" value=<?php echo $PPBS; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--PPBS Ends --> 
                                                                        <!-- RBS Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">RBS:</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="RBS"  name="RBS" value=<?php echo $RBS; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--RBS Ends --> 
                                                                        <!-- HBA1C Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">HBA1C:</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="HBA1C"  name="HBA1C" value=<?php echo $HBA1C; ?>>
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
                                                                                <input type="text" class="form-control" id="BUREA"  name="BUREA" value=<?php echo $BUREA; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--BUREA Ends --> 
                                                                        <!-- CREAT Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">Sr. CREAT:</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="CREAT"  name="CREAT" value=<?php echo $CREAT; ?>>
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
                                                                                <input type="text" class="form-control" id="NA"  name="NA" value=<?php echo $NA; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--NA Ends --> 
                                                                        <!-- K Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">K+ :</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="K"  name="K" value=<?php echo $K; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--K Ends --> 
                                                                        <!-- CL Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">CL- :</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="CL"  name="CL" value=<?php echo $CL; ?>>
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
                                                                                <input type="text" class="form-control" id="TBIL"  name="TBIL" value=<?php echo $TBIL; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--TBIL Ends --> 
                                                                        <!-- DIRECT Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">DIRECT :</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="DIRECT"  name="DIRECT" value=<?php echo $DIRECT; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--DIRECT Ends --> 
                                                                        <!-- INDIRECT Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">INDIRECT :</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="INDIRECT"  name="INDIRECT" value=<?php echo $INDIRECT; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--INDIRECT Ends -->                                                                                                                                                 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                        <!-- SGOT Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">SGOT :</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="SGOT"  name="SGOT" value=<?php echo $SGOT; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--SGOT Ends --> 
                                                                        <!-- SGPT Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">SGPT :</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="SGPT"  name="SGPT" value=<?php echo $SGPT; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--SGPT Ends --> 
                                                                        <!-- ALP Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">ALP :</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="ALP"  name="ALP" value=<?php echo $ALP; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--ALP Ends --> 
                                                                        <!-- ALBUMIN Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">Sr.ALBUMIN :</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="ALBUMIN"  name="ALBUMIN" value=<?php echo $ALBUMIN; ?>>
                                                                                </div>
                                                                        </div>        
                                                                        <!--ALBUMIN Ends -->                                                                                                                                                                                                                                                                                                 
                                                                        <!-- GLOBULIN Starts -->
                                                                        <div class="form-group center-align col-md-offset-2">
                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">Sr.GLOBULIN :</label>
                                                                                <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="GLOBULIN"  name="GLOBULIN" value=<?php echo $GLOBULIN; ?>>
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
                                                                                                    <input type="text" class="form-control" id="BT"  name="BT" value=<?php echo $BT; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--BT Ends --> 
                                                                                    <!-- CCT Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">CT:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="CCT"  name="CCT" value=<?php echo $CCT; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--CCT Ends -->
                                                                                    <!-- PTINR Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">PTINR:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="PTINR"  name="PTINR" value=<?php echo $PTINR; ?>>
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
                                                                                                <input type="text" class="form-control" id="DENGUE"  name="DENGUE" value=<?php echo $DENGUE; ?>>
                                                                                            </div>
                                                                                    </div>        
                                                                                <!--DENGUE Ends -->
                                                                                <!-- MP Start -->
                                                                                    <div class="form-group center-align col-md-offset-2">
                                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">MP:</label>
                                                                                            <div class="col-sm-2">
                                                                                                <input type="text" class="form-control" id="MP"  name="MP" value=<?php echo $MP; ?>>
                                                                                            </div>
                                                                                    </div>        
                                                                                <!--MP Ends -->
                                                                                <!-- WIDAL Start -->
                                                                                    <div class="form-group center-align col-md-offset-2">
                                                                                        <label class="control-label col-sm-3 col-xs-4" for="name">WIDAL:</label>
                                                                                            <div class="col-sm-2">
                                                                                                <input type="text" class="form-control" id="WIDAL"  name="WIDAL" value=<?php echo $WIDAL; ?>>
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
                                                                                                    <input type="text" class="form-control" id="PUSCELLS"  name="PUSCELLS" value=<?php echo $PUSCELLS; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--PUSCELLS Ends -->
                                                                                    <!-- RBC Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">RBC:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="RBC"  name="RBC" value=<?php echo $RBC; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--RBC Ends -->
                                                                                    <!-- SUGARS Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">SUGARS:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="SUGARS"  name="SUGARS" value=<?php echo $SUGARS; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--SUGARS Ends -->
                                                                                    <!-- KETONE Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">KETONE:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="KETONE"  name="KETONE" value=<?php echo $KETONE; ?>>
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
                                                                                                    <input type="text" class="form-control" id="HIV"  name="HIV" value=<?php echo $HIV; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--HIV Ends -->
                                                                                    <!-- HBSAG Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">HBSAG:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="HBSAG"  name="HBSAG" value=<?php echo $HBSAG; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--HBSAG Ends -->
                                                                                    <!-- HCV Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">HCV:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="HCV"  name="HCV" value=<?php echo $HCV; ?>>
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
                                                                                                    <input type="text" class="form-control" id="CHESTXRAY"  name="CHESTXRAY" value=<?php echo $CHESTXRAY; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--CHESTXRAY Ends -->
                                                                                    <!-- USG Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">USG:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="USG"  name="USG" value=<?php echo $USG; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--USG Ends -->
                                                                                    <!-- ICT Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">CT:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="ICT"  name="ICT" value=<?php echo $ICT; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--ICT Ends -->
                                                                                    <!-- MRI Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">MRI:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="MRI"  name="MRI" value=<?php echo $MRI; ?>>
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
                                                                                                    <input type="text" class="form-control" id="ECG"  name="ECG" value=<?php echo $ECG; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--ECG Ends -->
                                                                                    <!-- TROPI Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">TROPI:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="TROPI"  name="TROPI" value=<?php echo $TROPI; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--TROPI Ends -->
                                                                                    <!-- ECHO Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">ECHO:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="ECHO"  name="ECHO" value=<?php echo $ECHO; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--ECHO Ends -->
                                                                                    <hr>
                                                                        <div class="row">
                                                                            <div class="col-md-offset-1 col-md-2">
                                                                            <h4><strong>SPECIFIC INVEST</strong></h4>
                                                                                    <div class="row">
                                                                                        <div class="col-md-offset-12 col-md-12">
                                                                                        <input type="text" class="form-control" id="SPECIFICINVEST"  name="SPECIFICINVEST" value=<?php echo $SPECIFICINVEST; ?>>
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
                                                                                                    <input type="text" class="form-control" id="SWAB"  name="SWAB" value=<?php echo $SWAB; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--SWAB Ends -->
                                                                                    <!-- RAPIDANTIGENTEST Start -->
                                                                                        <div class="form-group center-align col-md-offset-2">
                                                                                            <label class="control-label col-sm-3 col-xs-4" for="name">RAPIDANTIGENTEST:</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" class="form-control" id="RAPIDANTIGENTEST"  name="RAPIDANTIGENTEST" value=<?php echo $RAPIDANTIGENTEST; ?>>
                                                                                                </div>
                                                                                        </div>        
                                                                                    <!--RAPIDANTIGENTEST Ends -->
                                                                                    <hr>
                                                                        <div class="row">
                                                                            <div class="col-md-offset-1 col-md-2">
                                                                            <h4><strong>ABC</strong></h4>
                                                                                <div class="row">
                                                                                    <div class="col-md-offset-12 col-md-12">
                                                                                        <input type="text" class="form-control" id="ABG"  name="ABG" value=<?php echo $ABG; ?>>
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
                                                                                        <input type="text" class="form-control" id="PROCALCITONIN"  name="PROCALCITONIN" value=<?php echo $PROCALCITONIN; ?>>
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
                                                                                        <textarea type="text" class="form-control" id="InvestigationOthers"  name="InvestigationOthers"><?php echo $InvestigationOthers; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                                    
                                                            <div class="text-center">   
                                                                    <button  type="submit" name=<?php echo $Submit1; ?> value=<?php echo $PatientID ?> class="btn btn-success align-self-center mx-auto">Submit</button>
                                                            </div>

                                                                        



                                                </form>
                                            </div>
                                            <div class="<?php if ($tab==5) echo "tab-pane active"; else echo "tab-pane inactive"; ?>" id="tab5primary">
                                                    <div class="container-fluid">
                                                    <table class="table table-bordered table-hover table-responsive" id="displayInPatientRecords">
                                                     <colgroup>
                                                        <col span="1" style="width: 5%;">
                                                        <col span="1" style="width: 20%;">
                                                        <col span="1" style="width: 25%;">
                                                        <col span="1" style="width: 15%;">
                                                        <col span="1" style="width: 10%;">
                                                        <col span="1" style="width: 10%;">
                                                    </colgroup>
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th class="text-center">S.NO</th>
                                                            <th class="text-center">Date</th>
                                                            <th class="text-center">Medication</th>
                                                            <th class="text-center">Dose</th>
                                                            <th class="text-center">Route</th>
                                                            <th class="text-center">Frequency</th>
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
                                                                <td><?php echo $count; ?></td>
                                                                <td><?php echo $row['TreatmentDate']; ?></td>
                                                                <td><?php echo $row['Medication']; ?></td>
                                                                <td><?php echo $row['Dose']; ?></td>
                                                                <td><?php echo $row['Route']; ?></td>
                                                                <td><?php echo $row['Frequency']; ?></td>
                                                            </tr>
                                                            <?php
                                                                    $count++;
                                                                    }
                                                                }
                                                                $conn -> close();
                                                            ?>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php
    }
?>


                            <script>
                        $('#vitalDate').datepicker({
              
                             dateFormat: 'yy-mm-dd'
                        });
                    </script>   
        </body>
    </html>