<?php

require "includes/dbh.inc.php";
$connect = mysqli_connect("localhost", "root", "", "carshop");
if(!empty($_POST))
{
     $output = '';
     $message = '';
     $name = mysqli_real_escape_string($connect, $_POST["name"]);
     $email = mysqli_real_escape_string($connect, $_POST["email"]);
     $phone = mysqli_real_escape_string($connect, $_POST["phone"]);
     $buy_date = mysqli_real_escape_string($connect, $_POST["buy_date"]);
     $bought_car_id = mysqli_real_escape_string($connect, $_POST["bought_car_id"]);

     if($_POST["employee_id"] != '')
     {
          $query = "
          UPDATE buyer1
          SET name='$name',
          email='$email',
          phone='$phone',
          buy_date = '$buy_date',
          bought_car_id = '$bought_car_id'
          WHERE id='".$_POST["employee_id"]."'";
          $message = 'Adatok frissítve';
     }
     else
     {
          $query = "
          INSERT INTO buyer1 (name, email, phone, buy_date, bought_car_id)
          VALUES('$name', '$email', '$phone', '$buy_date', '$bought_car_id');
          ";
          $message = 'Sikeres adatbevitel';
     }
     if(mysqli_query($connect, $query))
     {
          $output .= '<label class="text-success">' . $message . '</label>';
          $select_query = "SELECT * FROM buyer1 ORDER BY id DESC";
          $result = mysqli_query($connect, $select_query);
          $output .= '
               <table class="table table-bordered">
                    <tr>
                         <th width="70%">Vásárlók adatai:</th>
                         <th width="15%">Szerkesztés</th>
                         <th width="15%">Megtekintés</th>
                    </tr>
          ';
          while($row = mysqli_fetch_array($result))
          {
               $output .= '
                    <tr>
                         <td>' .$row["name"]. '</td>
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
