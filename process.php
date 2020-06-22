<?php
ob_start();
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']).'/tmp'));
session_start();
 if(isset($_POST['ReceptionistLogin'])){
     include "dbconnection.php";
    $sql="SELECT * FROM receptionists where UserID='".$_POST['uname']."'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        if($row){
            if(password_verify($_POST['pwd'], $row['Password'])){
               
                $_SESSION['receptionist']=$row['Name'];
                header("Location:Receptionist/receptionisthome.php");
            }
            else{
                header("Location:index.php?msg=Invalid Credentials");
            }
        }
        else{
            header("Location:index.php?msg=Invalid Credentials");
        }
    }
    $conn -> close();
    }
 else if(isset($_POST['doctorLogin'])){
    include "dbconnection.php";
    $sql="SELECT * FROM doctors where UserID='".$_POST['uname']."'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        if($row){
            if(password_verify($_POST['pwd'], $row['Password'])){
                echo "hi";
                $_SESSION['doctor']=$row['Name'];
                header("Location:Doctor/doctor.php");
            }
            else{
                header("Location:Doctor/doctorlogin.php?msg=Invalid Credentials");
            }
        }
        else{
            header("Location:Doctor/doctorlogin.php?msg=Invalid Credentials");
        }
    }
    $conn -> close();
 }
 else if(isset($_POST['nurseLogin'])){
    include "dbconnection.php";
    $sql="SELECT * FROM nurses where UserID='".$_POST['uname']."'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        if($row){
            if(password_verify($_POST['pwd'], $row['Password'])){
                echo "hi";
                $_SESSION['nurse']=$row['Name'];
                header("Location:Nurse/nurse.php");
            }
            else{
                header("Location:Nurse/nurselogin.php?msg=Invalid Credentials");
            }
        }
        else{
            header("Location:Nurse/nurselogin.php?msg=Invalid Credentials");
        }
    }
    $conn -> close();
}
else if(isset($_POST['AdminLogin'])){
    include "dbconnection.php";
    $sql="SELECT * FROM admins where UserID='".$_POST['uname']."'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        if($row){
            if(password_verify($_POST['pwd'], $row['Password'])){
                echo "hi";
                $_SESSION['admin']=$row['Name'];
                header("Location:Admin/admin.php");
            }
            else{
                header("Location:Admin/adminlogin.php?msg=Invalid Credentials");
            }
        }
        else{
            header("Location:Admin/adminlogin.php?msg=Invalid Credentials");
        }
    }
    $conn -> close();
    }
?>
