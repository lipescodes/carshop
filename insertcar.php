<?php

require "includes/dbh.inc.php";
$connect = mysqli_connect("localhost", "root", "", "carshop");
if(!empty($_POST))
{
     $output = '';
     $message = '';
     $mark = mysqli_real_escape_string($connect, $_POST["mark"]);
     $type = mysqli_real_escape_string($connect, $_POST["type"]);
     $year_of_production = mysqli_real_escape_string($connect, $_POST["year_of_production"]);
     $ccm = mysqli_real_escape_string($connect, $_POST["ccm"]);
     $hp = mysqli_real_escape_string($connect, $_POST["hp"]);
     $salesman_id = mysqli_real_escape_string($connect, $_POST["salesman_id"]);
     $price = mysqli_real_escape_string($connect, $_POST["price"]);
     if($_POST["employee_id"] != '')
     {
          $query = "
          UPDATE cars1
          SET mark='$mark',
          type='$type',
          year_of_production='$year_of_production',
          ccm = '$ccm',
          hp = '$hp',
          salesman_id = '$salesman_id',
          price = '$price'
          WHERE id='".$_POST["employee_id"]."'";
          $message = 'Adatok frissítve';
     }
     else
     {
          $query = "
          INSERT INTO cars1(mark, type, year_of_production, ccm, hp, salesman_id, price)
          VALUES('$mark', '$type', '$year_of_production', '$ccm', '$hp', '$salesman_id', '$price');
          ";
          $message = 'Sikeres adatbevitel';
     }
     if(mysqli_query($connect, $query))
     {
          $output .= '<label class="text-success">' . $message . '</label>';
          $select_query = "SELECT * FROM cars1 ORDER BY id DESC";
          $result = mysqli_query($connect, $select_query);
          $output .= '
               <table class="table table-bordered">
                    <tr>
                         <th width="70%">Járművek Adatai:</th>
                         <th width="15%">Szerkesztés</th>
                         <th width="15%">Megtekintés</th>
                    </tr>
          ';
          while($row = mysqli_fetch_array($result))
          {
               $output .= '
                    <tr>
                         <td>' .$row["mark"]." ".$row["type"]. '</td>
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
