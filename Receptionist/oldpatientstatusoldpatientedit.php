<?php
//session_start();
require("../process.php"); 

  if(!isset($_SESSION['receptionist']) && $_SESSION['receptionist'] == ""){
     //array_push($errors, "You must login/register first");
    //echo "Not Allowed";
     header('location:../index.php');
     exit;
  }

if(isset($_POST['ReceptionistHome'])){
    header("Location:receptionisthome.php");
}
    if(isset($_POST['Revisit'])){
        include "../dbconnection.php";
        date_default_timezone_set("Asia/Kolkata");
        $currentDate=date("Y-m-d");
        $currentTime=date("H:i:s");
        $sql="UPDATE patients SET Status='ACTIVE',DOA='".$currentDate."', TOA='".$currentTime."' WHERE PatientID="."'".$_POST['PID']."'";
        if($conn->query($sql)){
            $sql="SELECT * FROM patientcheckup where PatientID="."'".$_POST['PID']."'"." and concat(DOC,' ',TOC)=(SELECT MAX(concat(DOC,' ',TOC)) FROM patientcheckup where PatientID="."'".$_POST['PID']."'".")";
            $result=$conn->query($sql);
            // $arr=array();
            if($result->num_rows > 0){
                    $row=$result->fetch_assoc();
                    
                    $stmt = $conn->prepare("INSERT INTO patientcheckup (	PatientID ,     DOC,TOC ,     Cold  ,     ColdDuration ,     Cough  ,     CoughType ,     CoughDuration ,     SOB  ,     SOBDuration ,     Fever  ,     FeverDuration ,     SoreThroat  ,     TravelHistory  ,     ContactHistory  ,     OtherComplaints ,     HTN  ,     DM  ,     IHD  ,     Asthma  ,     CLD  ,     Seizure  ,     OtherComorbidities ,     Smoking  ,     Alcohol  ,     Gutka  ,     OtherAddictions ,     Pallor  ,     Icterus  ,     Clubbing  ,     Cyanosis  ,     Lympadenopathy  ,     Edema  ,     Temp  ,     HR  ,     BP  ,     RR  ,     SPO2  ,     CNS  ,     CVS  ,     RS  ,     GIT  ,     OtherSystemic ,     Investigation ,     Treatment ,     InPatient,     FollowUp) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssissisisisssssssssssssssssssssssssssssssssss",$row['PatientID'],$currentDate,$currentTime,$row['Cold'],$row['ColdDuration'],$row['Cough'],$row['CoughType'],$row['CoughDuration'],$row['SOB'],$row['SOBDuration'],$row['Fever'],$row['FeverDuration'],$row['SoreThroat'],$row['TravelHistory'],$row['ContactHistory'],$row['OtherComplaints'],$row['HTN'],$row['DM'],$row['IHD'],$row['Asthma'],$row['CLD'],$row['Seizure'],$row['OtherComorbidities'],$row['Smoking'],$row['Alcohol'],$row['Gutka'],$row['OtherAddictions'],$row['Pallor'],$row['Icterus'],$row['Clubbing'],$row['Cyanosis'],$row['Lympadenopathy'],$row['Edema'],$row['Temp'],$row['HR'],$row['BP'],$row['RR'],$row['SPO2'],$row['CNS'],$row['CVS'],$row['RS'],$row['GIT'],$row['OtherSystemic'],$row['Investigation'],$row['Treatment'],$row['InPatient'],$row['FollowUp']);
                    if($stmt->execute()){
                        echo "Added Row to PatientChecup";
                        header("Location:receptionisthome.php");

                    }
                    else{
                        ?>
                        <script> alert ("Patient already active") </script>
                        <?php
                        header("Location:receptionisthome.php");
                    }


            }
            else{
                echo "error";
            }
        }
        else{
            echo "error on updating status";
        }
        $conn -> close();
    }
    if(isset($_POST['UpdatePatient'])){
        $address=$_POST['hno'].",".$_POST['village'].",".$_POST['city'].",".$_POST['state'].",".$_POST['pincode'];
        include "../dbconnection.php";
        if($_POST['remp']=="Yes")
            $RempID=$_POST['rempidedit'];
        else
            $RempID="";
        $sql="UPDATE patients SET PatientName=" ."'".$_POST['patientname']."'".",Age="  .$_POST['age'].",Sex="  ."'".$_POST['sex']."'"." ,MobileNumber=" ."'".$_POST['mbl']."'".", AadharNumber= " ."'".$_POST['adharnumber']."'".",GovtID=" ."'".$_POST['govtid']."'".",RailwayEmployee="  ."'".$_POST['remp']."'".",RailwayEmployeeID=" ."'".$RempID."'".",Address="."'".$address."' ".       "WHERE PatientID="."'".$_POST['PatientID']."'";
        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        if($stmt->execute()){
            echo " records UPDATED successfully";
            ?>
                <script> alert ("Patient already active") </script>
            <?php
                header("Location:receptionisthome.php");
        }
        else
            echo $sql . "<br>" . $e->getMessage();
        
            $conn -> close();
    }
?>