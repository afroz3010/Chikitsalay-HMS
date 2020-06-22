<?php
  $rowcount="";
  if(isset($_POST['AdminSubmit'])){
    include "dbconnection.php";
        $stmt = $conn->prepare("INSERT INTO admins(UserID, Password, Name, Contact) VALUES (?, ?, ?, ?)");
        $pwd=password_hash($_POST['Password'],PASSWORD_DEFAULT);
        $stmt->bind_param("ssss",$_POST['UserID'],$pwd,$_POST['Name'],$_POST['Contact']);
        if($stmt->execute()){
        //   echo "Inserted Recaptionist";
           $tab=1;
        }
        else{
            echo $stmt->error;
        }
        $conn -> close();
  }
  else if(isset($_POST['AdminEdit'])){
    $rowcount=$_POST['AdminEdit'];
  }
  else if(isset($_POST['AdminSave'])){
    $rowcount=$_POST['AdminSave'];
    include "dbconnection.php";
    $stmt = $conn->prepare("UPDATE admins  SET  Name=?,  Contact=?,  Password=? WHERE UserID=? ");
    $pwd=password_hash($_POST['Password'.$rowcount], PASSWORD_DEFAULT);
    $stmt->bind_param("ssss", $_POST['Name'.$rowcount], $_POST['Contact'.$rowcount], $pwd, $_POST['UserID'.$rowcount]);
    if($stmt->execute()){
        echo "Updated Admin";
        $rowcount="";
    }
    else{
        echo "error on updating";
    }      
    $conn -> close();
}
else if(isset($_POST['AdminDelete'])){
  $rowcount=$_POST['AdminDelete'];
  include "dbconnection.php";
  $stmt = $conn->prepare("DELETE FROM admins WHERE UserID=?");
  $stmt->bind_param("s",$_POST['UserID'.$rowcount]);
  if($stmt->execute()){
      echo "Deleted a record";
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
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
          <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
    
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
          <script src="val.js"></script>
        </head>
        <body>

        <?php include 'header.php';?>
        <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                  </button>
                  <a class="navbar-brand" href="#">WebSiteName</a>
                </div>
                
              </div>
          </nav>
<div class="container-fluid">
    <form method="post" action=""  onsubmit="return confirm('Are you sure want to perform the action?');">
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
                        include "dbconnection.php";
                        $sql='SELECT * FROM admins';
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
                            <td><button type="submit" class='btn btn-success align-self-center mx-auto' name="AdminEdit" value=<?php echo $count; ?>>Edit</button> <button type="submit" name="AdminDelete" class='btn btn-danger align-self-center mx-auto' value=<?php echo $count; ?>>Delete</button> </td>
                            </div>
                        <?php
                            }
                            else{
                        ?>
                            <div class="text-center">
                            <td><button type="submit" class='btn btn-success align-self-center mx-auto' name="AdminSave" value=<?php echo $count; ?>>Save</button>
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
                                <td><input class="form-control" type="text" name="Name" ></td>
                                <td><input class="form-control" type="text" name="Contact" ></td>
                                <td><input class="form-control" type="text" name="UserID" ></td>
                                <td><input class="form-control" type="text" name="Password" ></td>
                                <td><button type="submit" name="AdminSubmit" value=<?php echo $count; ?> class='btn btn-success align-self-center mx-auto'>Submit</button></td>
                            </tr>
                    <?php
                        
                            }
                            
                    ?>
                    
            </tbody>
        </table>
        
        </form>
            
</div>
                        </body>
                        </html>