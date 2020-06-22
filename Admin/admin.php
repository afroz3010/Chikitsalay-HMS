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
  $rowcount="";
  if(isset($_POST['ReceptionistSubmit'])){
    include "../dbconnection.php";
        $stmt = $conn->prepare("INSERT INTO receptionists(UserID, Password, Name, Contact) VALUES (?, ?, ?, ?)");
        $pwd=password_hash($_POST['Password'],PASSWORD_DEFAULT);
        $stmt->bind_param("ssss",$_POST['UserID'],$pwd,$_POST['Name'],$_POST['Contact']);
        if($stmt->execute()){
          // echo "Inserted Recaptionist";
           $tab=1;
        }
        else{
            echo $stmt->error;
        }
        $conn -> close();
  }
  else if(isset($_POST['ReceptionistEdit'])){
    $rowcount=$_POST['ReceptionistEdit'];
  }
  else if(isset($_POST['ReceptionistSave'])){
    $rowcount=$_POST['ReceptionistSave'];
    include "../dbconnection.php";
    $stmt = $conn->prepare("UPDATE receptionists  SET  Name=?,  Contact=?,  Password=? WHERE UserID=? ");
    $pwd=password_hash($_POST['Password'.$rowcount], PASSWORD_DEFAULT);
    $stmt->bind_param("ssss", $_POST['Name'.$rowcount], $_POST['Contact'.$rowcount], $pwd, $_POST['UserID'.$rowcount]);
    if($stmt->execute()){
        // echo "Updated Receptionist";
        $rowcount="";
    }
    else{
        echo "error on updating";
    }      
    $conn -> close();
}
else if(isset($_POST['ReceptionistDelete'])){
  $rowcount=$_POST['ReceptionistDelete'];
  include "../dbconnection.php";
  $stmt = $conn->prepare("DELETE FROM receptionists WHERE UserID=?");
  $stmt->bind_param("s",$_POST['UserID'.$rowcount]);
  if($stmt->execute()){
      // echo "Deleted a record";
      $rowcount="";
  }
  else{
      echo "error on deleting";
  }     
  $conn -> close();
}  
if(isset($_POST['NurseSubmit'])){
  include "../dbconnection.php";
      $stmt = $conn->prepare("INSERT INTO nurses(UserID, Password, Name, Contact) VALUES (?, ?, ?, ?)");
      $pwd=password_hash($_POST['Password'], PASSWORD_DEFAULT);
      $stmt->bind_param("ssss",$_POST['UserID'],$pwd,$_POST['Name'],$_POST['Contact']);
      if($stmt->execute()){
        // echo "Inserted Recaptionist";
         $tab=1;
      }
      else{
          echo $stmt->error;
      }
      $conn -> close();
}
else if(isset($_POST['NurseEdit'])){
  $rowcount=$_POST['NurseEdit'];
}
else if(isset($_POST['NurseSave'])){
  $rowcount=$_POST['NurseSave'];
  include "../dbconnection.php";
  $stmt = $conn->prepare("UPDATE nurses  SET  Name=?,  Contact=?,  Password=? WHERE UserID=? ");
  $pwd=password_hash($_POST['Password'.$rowcount], PASSWORD_DEFAULT);
  $stmt->bind_param("ssss", $_POST['Name'.$rowcount], $_POST['Contact'.$rowcount], $pwd, $_POST['UserID'.$rowcount]);
  if($stmt->execute()){
      // echo "Updated Nurse";
      $rowcount="";
  }
  else{
      echo "error on updating";
  }     
  $conn -> close(); 
}
else if(isset($_POST['NurseDelete'])){
$rowcount=$_POST['NurseDelete'];
include "../dbconnection.php";
$stmt = $conn->prepare("DELETE FROM nurses WHERE UserID=?");
$stmt->bind_param("s",$_POST['UserID'.$rowcount]);
if($stmt->execute()){
    // echo "Deleted a record";
    $rowcount="";
}
else{
    echo "error on deleting";
}   
$conn -> close();  
}  
if(isset($_POST['DoctorSubmit'])){
  include "../dbconnection.php";
      $stmt = $conn->prepare("INSERT INTO doctors(UserID, Password, Name, Contact) VALUES (?, ?, ?, ?)");
      $pwd=password_hash($_POST['Password'], PASSWORD_DEFAULT);
      $stmt->bind_param("ssss",$_POST['UserID'],$pwd,$_POST['Name'],$_POST['Contact']);
      if($stmt->execute()){
        // echo "Inserted Recaptionist";
         $tab=1;
      }
      else{
          echo $stmt->error;
      }
      $conn -> close();
}
else if(isset($_POST['DoctorEdit'])){
  $rowcount=$_POST['DoctorEdit'];
}
else if(isset($_POST['DoctorSave'])){
  $rowcount=$_POST['DoctorSave'];
  include "../dbconnection.php";
  $stmt = $conn->prepare("UPDATE doctors  SET  Name=?,  Contact=?,  Password=? WHERE UserID=? ");
  $pwd=password_hash($_POST['Password'.$rowcount], PASSWORD_DEFAULT);
  $stmt->bind_param("ssss", $_POST['Name'.$rowcount], $_POST['Contact'.$rowcount], $pwd, $_POST['UserID'.$rowcount]);
  if($stmt->execute()){
      // echo "Updated Doctor";
      $rowcount="";
  }
  else{
      echo "error on updating";
  }     
  $conn -> close(); 
}
else if(isset($_POST['DoctorDelete'])){
$rowcount=$_POST['DoctorDelete'];
include "../dbconnection.php";
$stmt = $conn->prepare("DELETE FROM doctors WHERE UserID=?");
$stmt->bind_param("s",$_POST['UserID'.$rowcount]);
if($stmt->execute()){
    // echo "Deleted a record";
    $rowcount="";
}
else{
    echo "error on deleting";
}  
$conn -> close();   
}  

?>




        <!DOCTYPE html>
        <html lang="en">
        <head>
          <title>Chikitsalay</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
          <link rel="stylesheet" href="../style.css">
          <script src="https://code.jquery.com/jquery-3.4.1.js"integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
    
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
          <script src="../val.js"></script>
          
          <style>
          .row{
            padding-top:10px;
            padding-left:50px;
            margin-left:20px;
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
                  <a class="navbar-brand" href="admin.php">WebSiteName</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="admin.php">User Managment</a></li>
                    <li><a href="outpatientlist.php">OutPatient Records</a></li>
                    <li>
                      <a href="inpatientlist.php">InPatient Records</a>
                    </li>
                    <li><a href="adminbulletin.php">Bulletin</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                  <li ><a href="#"> <span style="color: white;text-decoration:none; ">Welcome <?php echo $_SESSION['admin']; ?></span></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                  </ul>
                </div>
              </div>
          </nav>
      
             
                        <?php
                        if(isset($_POST['viewReceptionist']) || isset($_POST['ReceptionistSubmit']) || isset($_POST['ReceptionistEdit']) || isset($_POST['ReceptionistSave']) || isset($_POST['ReceptionistDelete'])){

                        ?>
                          <div class="container-fluid">
                                    <h2 class="text-center">Receptionists</h2>
                                            <form method="post" action="admin.php"  >
                                                <table class="table table-bordered table-hover table-responsive" id="displayInPatientRecords">
                                                     <colgroup>
                                                        <col span="1" style="width: 5%;">
                                                        <col span="1" style="width: 20%;">
                                                        <col span="1" style="width: 10%;">
                                                        <col span="1" style="width: 15%;">
                                                        <col span="1" style="width: 20%;">
                                                        <col span="1" style="width: 10%;">
                                                    </colgroup>
                                                    <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th> Name</th>
                                                        <th>Contact</th>
                                                        <th>User ID</th>
                                                        <th>Password</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php
                                                                date_default_timezone_set("Asia/Kolkata");
                                                                include "../dbconnection.php";
                                                                $sql='SELECT * FROM receptionists';
                                                                $result = $conn->query($sql);
                                                                $count=1;
                                                                if ($result->num_rows > 0) {
                                                                    // output data of each row
                                                                    while($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $count ?></td>
                                                                
                                                                <td><input class="form-control" type="text"  name=<?php echo "Name".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Name']."'"; ?> ></td>
                                                                <td><input class="form-control" type="text"  name=<?php echo "Contact".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Contact']."'"; ?> ></td>
                                                                <td><input class="form-control" type="text" name=<?php echo "UserID".$count ?> readonly value=<?php echo "'".$row['UserID']."'"; ?>></td>
                                                                <td><input class="form-control" type="text"  name=<?php echo "Password".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Password']."'"; ?> ></td>
                                                                <?php
                                                                    if($rowcount!=$count){
                                                                ?>
                                                                  <div class="text-center">
                                                                    <td><button type="submit" class='btn btn-success align-self-center mx-auto' onclick=" removeRequiredforEdit(this.form)" name="ReceptionistEdit" value=<?php echo $count; ?>>Edit</button> <button type="submit" name="ReceptionistDelete" onclick="return removeRequiredforDelete(this.form)" class='btn btn-danger align-self-center mx-auto' value=<?php echo $count; ?>>Delete</button> </td>
                                                                  </div>
                                                                <?php
                                                                    }
                                                                    else{
                                                                ?>
                                                                  <div class="text-center">
                                                                    <td><button type="submit" class='btn btn-success align-self-center mx-auto' name="ReceptionistSave" value=<?php echo $count; ?>>Save</button>
                                                                      </div>
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
                                                                        <td><input class="form-control" type="text" name="Name" required ></td>
                                                                        <td><input class="form-control" type="text" name="Contact" required></td>
                                                                        <td><input class="form-control" type="text" name="UserID" required></td>
                                                                        <td><input class="form-control" type="text" name="Password" required ></td>
                                                                        <td><button type="submit" name="ReceptionistSubmit" value=<?php echo $count; ?> class='btn btn-success align-self-center mx-auto'>Submit</button></td>
                                                                    </tr>
                                                            <?php
                                                                    }
                                                            ?>
                                                            
                                                    </tbody>
                                                </table>
                                                
                                                </form>
                                                    
                                        </div>
                        <?php
                        }
                        else if(isset($_POST['viewNurse']) || isset($_POST['NurseSubmit']) || isset($_POST['NurseEdit']) || isset($_POST['NurseSave']) || isset($_POST['NurseDelete'])){
                          ?>
                          <div class="container-fluid">
                          <h2 class="text-center">Nurses</h2>
                                            <form method="post" action="admin.php"  >
                                                <table class="table table-bordered table-hover table-responsive" id="displayInPatientRecords">
                                                     <colgroup>
                                                        <col span="1" style="width: 5%;">
                                                        <col span="1" style="width: 20%;">
                                                        <col span="1" style="width: 10%;">
                                                        <col span="1" style="width: 15%;">
                                                        <col span="1" style="width: 20%;">
                                                        <col span="1" style="width: 10%;">
                                                    </colgroup>
                                                    <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th> Name</th>
                                                        <th>Contact</th>
                                                        <th>User ID</th>
                                                        <th>Password</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php
                                                                date_default_timezone_set("Asia/Kolkata");
                                                                include "../dbconnection.php";
                                                                $sql='SELECT * FROM nurses';
                                                                $result = $conn->query($sql);
                                                                $count=1;
                                                                if ($result->num_rows > 0) {
                                                                    // output data of each row
                                                                    while($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $count ?></td>
                                                                
                                                                <td><input class="form-control" type="text"  name=<?php echo "Name".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Name']."'"; ?> ></td>
                                                                <td><input class="form-control" type="text"  name=<?php echo "Contact".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Contact']."'"; ?> ></td>
                                                                <td><input class="form-control" type="text" name=<?php echo "UserID".$count ?> readonly value=<?php echo "'".$row['UserID']."'"; ?>></td>
                                                                <td><input class="form-control" type="text"  name=<?php echo "Password".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Password']."'"; ?> ></td>
                                                                <?php
                                                                    if($rowcount!=$count){
                                                                ?>
                                                                  <div class="text-center">
                                                                    <td><button type="submit" class='btn btn-success align-self-center mx-auto' name="NurseEdit" onclick=" removeRequiredforEdit(this.form)" value=<?php echo $count; ?>>Edit</button> <button type="submit" name="NurseDelete" onclick="return removeRequiredforDelete(this.form)" class='btn btn-danger align-self-center mx-auto' value=<?php echo $count; ?>>Delete</button> </td>
                                                                  </div>
                                                                <?php
                                                                    }
                                                                    else{
                                                                ?>
                                                                  <div class="text-center">
                                                                    <td><button type="submit" class='btn btn-success align-self-center mx-auto' name="NurseSave" value=<?php echo $count; ?>>Save</button>
                                                                      </div>
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
                                                                        <td><input class="form-control" type="text" name="Name" required></td>
                                                                        <td><input class="form-control" type="text" name="Contact" required></td>
                                                                        <td><input class="form-control" type="text" name="UserID" required></td>
                                                                        <td><input class="form-control" type="text" name="Password" required></td>
                                                                        <td><button type="submit" name="NurseSubmit" value=<?php echo $count; ?> class='btn btn-success align-self-center mx-auto'>Submit</button></td>
                                                                    </tr>
                                                            <?php
                                                                    }
                                                            ?>
                                                            
                                                    </tbody>
                                                </table>
                                                
                                                </form>
                                                    
                                        </div>
                        <?php    
                        }
                        else if(isset($_POST['viewDoctor']) || isset($_POST['DoctorSubmit']) || isset($_POST['DoctorEdit']) || isset($_POST['DoctorSave']) || isset($_POST['DoctorDelete'])){
                        ?>
                          <div class="container-fluid">
                          <h2 class="text-center">Doctors</h2>
                          <form method="post" action="admin.php"  >
                              <table class="table table-bordered table-hover table-responsive" id="displayInPatientRecords">
                                   <colgroup>
                                      <col span="1" style="width: 5%;">
                                      <col span="1" style="width: 20%;">
                                      <col span="1" style="width: 10%;">
                                      <col span="1" style="width: 15%;">
                                      <col span="1" style="width: 20%;">
                                      <col span="1" style="width: 10%;">
                                  </colgroup>
                                  <thead>
                                  <tr>
                                      <th>S.No</th>
                                      <th> Name</th>
                                      <th>Contact</th>
                                      <th>User ID</th>
                                      <th>Password</th>
                                      <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                          <?php
                                              date_default_timezone_set("Asia/Kolkata");
                                              include "../dbconnection.php";
                                              $sql='SELECT * FROM doctors';
                                              $result = $conn->query($sql);
                                              $count=1;
                                              if ($result->num_rows > 0) {
                                                  // output data of each row
                                                  while($row = $result->fetch_assoc()) {
                                          ?>
                                          <tr>
                                              <td><?php echo $count ?></td>
                                              
                                              <td><input class="form-control" type="text"  name=<?php echo "Name".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Name']."'"; ?> ></td>
                                              <td><input class="form-control" type="text"  name=<?php echo "Contact".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Contact']."'"; ?> ></td>
                                              <td><input class="form-control" type="text" name=<?php echo "UserID".$count ?> readonly value=<?php echo "'".$row['UserID']."'"; ?>></td>
                                              <td><input class="form-control" type="text"  name=<?php echo "Password".$count ?> <?php if($rowcount!=$count) echo "readonly"; ?> value=<?php echo "'".$row['Password']."'"; ?> ></td>
                                              <?php
                                                  if($rowcount!=$count){
                                              ?>
                                                <div class="text-center">
                                                  <td><button type="submit" class='btn btn-success align-self-center mx-auto' name="DoctorEdit" onclick=" removeRequiredforEdit(this.form)" value=<?php echo $count; ?>>Edit</button> <button type="submit" name="DoctorDelete" onclick="return removeRequiredforDelete(this.form)" class='btn btn-danger align-self-center mx-auto' value=<?php echo $count; ?>>Delete</button> </td>
                                                </div>
                                              <?php
                                                  }
                                                  else{
                                              ?>
                                                <div class="text-center">
                                                  <td><button type="submit" class='btn btn-success align-self-center mx-auto' name="DoctorSave" value=<?php echo $count; ?>>Save</button>
                                                    </div>
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
                                                      <td><input class="form-control" type="text" name="Name" required></td>
                                                      <td><input class="form-control" type="text" name="Contact" required></td>
                                                      <td><input class="form-control" type="text" name="UserID" required></td>
                                                      <td><input class="form-control" type="text" name="Password" required></td>
                                                      <td><button type="submit" name="DoctorSubmit" value=<?php echo $count; ?> class='btn btn-success align-self-center mx-auto'>Submit</button></td>
                                                  </tr>
                                          <?php
                                                  }
                                          ?>
                                          
                                  </tbody>
                              </table>
                              
                              </form>
                                  
                      </div>
                      <?php
                        }
                        else{
                        ?>
                        <div class="container">
                                <div class="row">
                                    <div class="col-md-4 col-lg-4">
                                        <div class="text-center mx-auto" style="width: 18rem;">
                                            <img class="card-img-top" src="3.webp" height="280px" width="180px" alt="Card image cap">
                                            <div class="card-body">
                                                
                                                    <form action="" method="post">
                                                        <div class="text-center mx-auto">   
                                                            <h3 class="card-title">Receptionist</h3>          
                                                            <button type="submit" name="viewReceptionist" class="btn btn-primary align-self-center mx-auto">View</button>
                                                        </div>
                                                    <form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 ">
                                        <div class="text-center mx-auto" style="width: 18rem;">
                                            <img class="card-img-top" src="2.webp" height="280px" width="180px" alt="Card image cap">
                                            <div class="card-body">
                                                
                                                    <form action="" method="post">
                                                        <div class="text-center">  
                                                        <h3 class="card-title">Nurses</h3> 
                                                        <button type="submit" name="viewNurse"class="btn btn-primary align-self-center mx-auto">View</button>
                                                        </div>
                                                    <form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 ">
                                        <div class="text-center mx-auto" style="width: 18rem;">
                                            <img class="card-img-top" src="1.webp" height="280px" width="180px" alt="Card image cap">
                                            <div class="card-body">
                                                
                                                    <form action="" method="post">
                                                        <div class="text-center">   
                                                            <h3 class="card-title">Doctors</h3>
                                                            <button type="submit" name="viewDoctor" class="btn btn-primary align-self-center mx-auto">View</button>
                                                        </div>
                                                    <form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>   
                            <?php
                                }
                            ?>





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
        </body>
        </html> 