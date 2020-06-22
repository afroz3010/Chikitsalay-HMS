<?php  
 include "../dbconnection.php"; 
 if(isset($_POST["query"]))  
 {  
      $output = '';  
      $query = "SELECT * FROM patients WHERE PatientName LIKE '%".$_POST["query"]."%'";  
      $result = mysqli_query($conn, $query);  
      $output = '<ul class="list-unstyled">';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '<li>'.$row["PatientName"].'</li>';  
           }  
      }  
      else  
      {  
           $output .= '<li>Name Not Found</li>';  
      }  
      $output .= '</ul>';  
      echo $output;  
 }  
 $conn -> close();
 ?> 