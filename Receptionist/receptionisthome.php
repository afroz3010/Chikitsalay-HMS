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
          <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
          <link rel="stylesheet" href="../style.css">
          <script src="../val.js"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.4.1.js"integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script> -->
          <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

          

          <style> 
                #medication{
                  border-radius:20px;

                }
                #medicationList li{
                  padding:12px;
                }
                #medicationList ul{
                  background-color:#eee;
                  cursor:pointer;
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
                  <a class="navbar-brand" href="">WebSiteName</a>
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
              if(isset($_POST['NewPatient'])){
                    header("location:home.php");
                    // echo "hello";
            }
          if(isset($_POST['Search'])){
        
              ?>
                  <!-- Patient Details -->
                  <h2 id="active-heading">Patient Records</h2>
                  <hr>
                  
                  <div class="container-fluid">
          
                    <form action="patientbasicdetails.php" method="post">
                        <table class="table tab table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Patient Name</th>
                                <th>Patient ID</th>
                                <th>View/Edit</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php  
                            include "../dbconnection.php";
                              // echo $_POST['searchvalue'];
                              if((!empty($_POST['searchvalue'])) && ($_POST['searchvalue'])!=" "){
                                  
                                  $sql="SELECT PatientName,PatientID FROM patients where  (PatientName LIKE"."'%".$_POST['searchvalue']."%'". "OR PatientID="."'".$_POST['searchvalue']."')";
                                  $result = $conn->query($sql);
                                  $count=1;
                                  if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                      echo   "<tr><td>".$count."</td><td>".$row["PatientName"]."</td><td>".$row["PatientID"]."</td><td><button  type='submit' name='ViewPatient' value=".$row['PatientID']." class='btn btn-success align-self-center mx-auto'>View</button>&nbsp&nbsp&nbsp<button  type='submit' name='EditPatient' value=".$row['PatientID']." class='btn btn-default align-self-center mx-auto'>Edit</button></td></tr>";
                                      $count++;
                                    }
                                    } else {
                                        echo "No results found";
                                    }
                                    
                                  }
                                else{
                                  echo "No result found";
                                }
                                $conn -> close();
                                // conn.close();
                            ?>
                          </tbody>
                      </table>
                      </form>
                  </div>
                      
                  <!-- Patient Details End -->


            <?php

              }
              else{
            ?>






                    <br><br><br><br><br><br><br>
                  <div class="container" style="width:500px;">
                        <div class="row">
                        <form class="from-horizontal" method="post" action="">
                            <!-- <input class="glyphicon glyphicon-search" id="medication" class="text-center align-self-center mx-auto" type="text" width="500"name="searchvalue" placeholder="Search.."> -->
                           <input type="text" for="inputdefault" autocomplete="off" name="searchvalue" id="medication" class="form-control" placeholder="Enter name">
                           <div id="medicationList"> </div>
                            <br><br>
                            <div class="text-center ">
                                
                                <input type="submit" class="btn btn-success" name="Search" value="Search">  &nbsp&nbsp&nbsp&nbsp&nbsp
                                <input type="submit" class="btn btn-success" name="NewPatient" value="New Patient">
                            </div>
                        </form>
                        </div>
                    </div>
            <?php
              }
              ?>
        <script>

$(document).ready(function(){  
                            $('#medication').keyup(function(){  
                                var query = $(this).val();  
                                if(query != '')  
                                {  
                                        $.ajax({  
                                            url:"search.php",  
                                            method:"POST",  
                                            data:{query:query},  
                                            success:function(data)  
                                            {  
                                                $('#medicationList').fadeIn();  
                                                $('#medicationList').html(data);  
                                            }  
                                        });  
                                } 
                                else{
                                    $('#medicationList').fadeOut();
                                } 
                            });  
                            $(document).on('click', 'li', function(){  
                                $('#medication').val($(this).text());  
                                $('#medicationList').fadeOut();  
                            });  
                        });  
                        
        </script>

        
</body>
</html>