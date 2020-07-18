<?php
    require "includes/dbh.inc.php";
    if (isset($_POST["employee_id"])) {
      $output = '';
      $query = "SELECT buyer1.name, buyer1.email, buyer1.phone, buyer1.buy_date, cars1.mark, cars1.type FROM buyer1 INNER JOIN cars1 ON buyer1.bought_car_id = cars1.id WHERE buyer1.id = '".$_POST["employee_id"]."'";
      $result = mysqli_query($conn, $query);

       $output .= '
      <div class="table-responsive">
           <table class="table table-bordered">';
      while($row = mysqli_fetch_array($result))
      {
           $output .= '


                <tr>
                     <td width="30%"><label>Vásárló neve:</label></td>
                     <td width="70%">'.$row["name"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Vásárló emailcíme:</label></td>
                     <td width="70%">'.$row["email"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Vásárló telefonszáma:</label></td>
                     <td width="70%">'.$row["phone"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Vásárlás dátuma:</label></td>
                     <td width="70%">'.$row["buy_date"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Vásárolt gépjármű:</label></td>
                     <td width="70%">'.$row["mark"]." ".$row["type"].'</td>
                </tr>
              ';
      }
      $output .= "</table></div>";
      echo $output;
    }
 ?>
