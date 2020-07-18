<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>


.sidenav {
  height: 100%;
  width: 170px;
  position: fixed;
  z-index: 1;
  top: 55px;
  left: 0;
    background-color: #333;
  overflow-x: hidden;
  padding-top: 10px;
  text-align: center;
    text-decoration: none;
}
a, a:hover, a:focus {
    text-decoration: none;
}
.sidenav a {
  padding: 16px 18px 6px 16px;
  text-decoration: none;
  font-size: 20px;
  color: white;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
  filter: invert(70%);
  transition-duration: 0.5s;
  text-decoration: none;
}

.main {
  margin-left: 160px; /* Same as the width of the sidenav */
  font-size: 28px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

</style>
</head>
<body>

<div class="sidenav">
  <a href="cars.php">Autók</a>
  <a href="workers.php">Alkalmazottak</a>
  <a href="buyer.php">Vevők</a>

</div>
</body>
</html>
