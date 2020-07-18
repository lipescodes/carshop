<?php
  session_start();
  
 ?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <style>
  body {
    margin: 0;
  }
  .mybutton {
      max-width: 140px;
      padding: 10px 10px;
      margin-top: 35px;
      margin-bottom: auto;
      margin-left: 50%;
      transform: translate(-50%, -50%);
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      background-color: rgba(0, 0, 0, 0.8);
      font-size: 16px;
      color: white;
      float: left;
    }
    .mybutton:hover {

      filter: invert(70%);
      transition-duration: 0.5s;
    }

    .topnav {
  overflow: hidden;
  background-color: #333;

}

.topnav p{
  width: auto;
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 15px 16px;
  text-decoration: none;
  font-size: 17px;
}
.top{
  padding-top: 10px;
}
.topnav a{
  margin-left: 0px;
  margin-top: 20px;

}
/*.topnav a:hover {
  background-color: #ddd;
  color: black;
}*/

.topnav a.active {
  /*background-color: #4CAF50;*/
  color: white;
  text-decoration: none;
/*  padding-top: 20px;
  padding-left: 30px;*/
  font-size: 25px;
  margin-top: 100px;

}
.topnav a.active:hover {
  filter: invert(70%);
  transition-duration: 0.5s;
}

.topnav-right {
  float: right;
  padding-right: 30px;
}
.topnav-left {
  float: left;
  padding-left: 20px;
}
  </style>
  <meta charset="utf-8">
  <title>Car Shop</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header class="navbar navbar-fixed-top">
    <div class="topnav">
      <div class="topnav-left">
        <p>
  <a class="active" href="index.php">Car Shop Inc.</a>
        </p>
      </div>

  <div class="topnav-right">

     <?php
        if (isset($_SESSION['userId'])) {
          echo '<form  action="includes/logout.inc.php" method="POST">
            <button class="mybutton" type="submit" name="logout-submit">Kijelentkezés</button>
          </form>';
        }
        else {

          header("Location: login.html");
          exit;
        }
       ?>
  </div>
  <div class="topnav-right top">
  <p>  <?php
      echo "Bejelentkezve:&nbsp;&nbsp;&nbsp;&nbsp;".$_SESSION['userUID'];
     ?></p>
  </dv>
</div>



  </header>
</body>
</html>
