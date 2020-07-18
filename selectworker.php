<?php
    require "includes/dbh.inc.php";
    if (isset($_POST["employee_id"])) {
      $output = '';
      $query = "SELECT username, fullname, email, phone, work_start, IF(boss = 1, 'Vezető', 'Értékesítő') AS boss  FROM users WHERE id = '".$_POST["employee_id"]."'";
      $result = mysqli_query($conn, $query);
  
       $output .= '
      <div class="table-responsive">
           <table class="table table-bordered">';
      while($row = mysqli_fetch_array($result))
      {
           $output .= '


                <tr>
                     <td width="30%"><label>Felhasználónév:</label></td>
                     <td width="70%">'.$row["username"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Teljes név:</label></td>
                     <td width="70%">'.$row["fullname"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Email cím:</label></td>
                     <td width="70%">'.$row["email"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Munkába állás dátuma</label></td>
                     <td width="70%">'.$row["work_start"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Vezető:</label></td>
                     <td width="70%">'.$row["boss"].'</td>
                </tr>
              ';
      }
      $output .= "</table></div>";
      echo $output;
    }
 ?>
