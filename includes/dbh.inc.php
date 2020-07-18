<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "carshop";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
 mysqli_set_charset($conn, "utf-8");
 
if(!$conn){
  die("Sikertelen csatlakozás:".mysqli_connect_error());
}
