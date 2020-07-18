<?php
    require "includes/dbh.inc.php";
    if (isset($_POST["employee_id"])) {
      $output = '';
      $query = "SELECT cars1.mark, cars1.type, cars1.year_of_production, cars1.ccm, cars1.hp, users.fullname, IF(cars1.avalible = 1, 'Jelenleg elérhető', 'Jelenleg nem elérhető') AS avalible, price FROM cars1 INNER JOIN users ON cars1.salesman_id = users.id WHERE cars1.id = '".$_POST["employee_id"]."'";
      $result = mysqli_query($conn, $query);

       $output .= '
      <div class="table-responsive">
           <table class="table table-bordered">';
      while($row = mysqli_fetch_array($result))
      {
           $output .= '


                <tr>
                     <td width="30%"><label>Márka:</label></td>
                     <td width="70%">'.$row["mark"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Típus:</label></td>
                     <td width="70%">'.$row["type"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Gyártási év:</label></td>
                     <td width="70%">'.$row["year_of_production"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Hengerűrtartalom:</label></td>
                     <td width="70%">'.$row["ccm"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Lóerő:</label></td>
                     <td width="70%">'.$row["hp"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Felelős</label></td>
                     <td width="70%">'.$row["fullname"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Jelenleg elérhető:</label></td>
                     <td width="70%">'.$row["avalible"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Ár:</label></td>
                     <td width="70%">'.$row["price"].' Ft</td>
                </tr>';
      }
      $output .= "</table></div>";
      echo $output;
    }
 ?>
