<?php
 $connect = mysqli_connect("localhost", "root", "", "carshop");
 if(isset($_POST["employee_id"]))
 {
      $query = "SELECT * FROM cars1 WHERE id = '".$_POST["employee_id"]."'";
      $result = mysqli_query($connect, $query);
      $row = mysqli_fetch_array($result);
      echo json_encode($row);
 }
 ?>
