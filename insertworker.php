<?php

require "includes/dbh.inc.php";
$connect = mysqli_connect("localhost", "root", "", "carshop");
if(!empty($_POST))
{
     $output = '';
     $message = '';
     $username = mysqli_real_escape_string($connect, $_POST["username"]);
     $fullname = mysqli_real_escape_string($connect, $_POST["fullname"]);
     $password = mysqli_real_escape_string($connect, $_POST["password"]);
     $email = mysqli_real_escape_string($connect, $_POST["email"]);
     $phone = mysqli_real_escape_string($connect, $_POST["phone"]);
     $work_start = mysqli_real_escape_string($connect, $_POST["work_start"]);
     $boss = mysqli_real_escape_string($connect, $_POST["boss"]);
     $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
     if($_POST["employee_id"] != '')
     {
          $query = "
          UPDATE users
          SET username='$username',
          fullname='$fullname',
          password='$hashedPwd',
          email = '$email',
          phone = '$phone',
          work_start = '$work_start',
          boss = '$boss'
          WHERE id='".$_POST["employee_id"]."'";
          $message = 'Adatok frissítve';
     }
     else
     {
          $query = "
          INSERT INTO users(username, fullname, password, email, phone, work_start, boss)
          VALUES('$username', '$fullname', '$hashedPwd', '$email', '$phone', '$work_start', '$boss');
          ";
          $message = 'Sikeres adatbevitel';
     }
     if(mysqli_query($connect, $query))
     {
          $output .= '<label class="text-success">' . $message . '</label>';
          $select_query = "SELECT * FROM users ORDER BY id DESC";
          $result = mysqli_query($connect, $select_query);
          $output .= '
               <table class="table table-bordered">
                    <tr>
                         <th width="70%">Alkalmazottak:</th>
                         <th width="15%">Szerkesztés</th>
                         <th width="15%">Megtekintés</th>
                    </tr>
          ';
          while($row = mysqli_fetch_array($result))
          {
               $output .= '
                    <tr>
                         <td>' .$row["fullname"]. '</td>
                         <td><input type="button" name="edit" value="Szerkesztés" id="'.$row["id"] .'" class="btn btn-info btn-md center-block edit_data" /></td>
                         <td><input type="button" name="view" value="Megtekintés" id="'.$row["id"] .'" class="btn btn-info btn-md center-block view_data" /></td>
                    </tr>
               ';
          }
          $output .= '</table>';
     }
     echo $output;
}
?>
