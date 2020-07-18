<?php
require "includes/dbh.inc.php";
require "header.php";
require "sidebar.php";
$query = "SELECT * FROM users";

$result = mysqli_query($conn, $query);
mysqli_set_charset($conn, "utf-8");

?>
<html>
<head>
  <title>Webslesson Tutorial | Bootstrap Modal with Dynamic MySQL Data using Ajax & PHP</title>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
         <meta name="viewport" content="width=device-width,initial-scale=1.0" charset="UTF-8"/>
<style>
main {
  margin-left: 160px; /* Same as the width of the sidenav */
  font-size: 28px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}
h3{
  text-align: center;

}

</style>
</head>
<body>
<main>
  <div class="wrapper-main">
    <br>
    <br><br>
    <h3>Üdvözöllek a Car Shop Inc. nyilvántartásában.</h3>
    <p><php echo .$_SESSION['userUID'] ?></p>
    <h3>Itt tekintheti meg alkalmazottaink adatit:</h3>
    <div class="container" style="width:700px;">

            <br />
            <div align="right">
         <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Hozzáad</button>

        </div>
<br>

            <div id="employee_table">
                 <table class="table table-bordered">
                      <tr>
                           <th width="70%">Alkalmazottaink:</th>
                           <th width="15%">Szerkesztés</th>
                           <th width="15%">Megtekintés</th>
                      </tr>
                      <?php
                      while($row = mysqli_fetch_array($result))
                      {
                      ?>
                      <tr>
                           <td><?php echo $row["fullname"] ?></td>
                           <td><input type="button" name="edit" value="Szerkesztés" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-md center-block edit_data" /></td>
                           <td><input type="button" name="view" value="Megtekintés" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-md center-block view_data" /></td>
                      </tr>
                      <?php
                      }
                      ?>
                 </table>
            </div>
       </div>

  </div>
</main>
</body>
</html>
<div id="dataModal" class="modal fade">
      <div class="modal-dialog">
           <div class="modal-content">
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Dolgozó adatai:</h4>
                </div>
                <div class="modal-body" id="employee_detail">
                </div>
              <!--  <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
           </div>
      </div>
 </div>

 <div id="add_data_Modal" class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Dolgozó adatainak szerkesztése</h4>
               </div>
               <div class="modal-body">
                    <form method="post" id="insert_form">
                      <label>Dolgozó  felhasználóneve:</label>
                      <input type="text" name="username" id="username" class="form-control" />
                      <br />
                      <label>Dolgozó teljes neve:</label>
                      <input type="text" name="fullname" id="fullname" class="form-control"/>
                      <br />
                      <label>Dolgozó jelszava:</label>
                      <input type="password" name="password" id="password" class="form-control">
                      <br />
                      <label>Dolgozó emailcíme</label>
                      <input type="email" name="email" id="email" class="form-control" />
                      <br />
                      <label>Dolgozó telefonszáma</label>
                      <input type="text" name="phone" id="phone" class="form-control" />
                      <br />
                      <br />
                      <label>Munkábaállás dátuma:</label>
                      <input type="date" name="work_start" id="work_start" class="form-control" />
                      <br />
                      <br />
                      <label>Vezetői jogosultság:</label>
                      <input type="number" name="boss" id="boss" class="form-control" />
                      <br />
                         <input type="hidden" name="employee_id" id="employee_id" />
                         <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                    </form>
               </div>
            <!--   <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>  -->
          </div>
     </div>
</div>
 <script>
 $(document).ready(function(){
       $('#add').click(function(){
            $('#insert').val("Insert");
            $('#insert_form')[0].reset();

       });
       $(document).on('click', '.edit_data', function(){
            var employee_id = $(this).attr("id");

            $.ajax({
                 url:"fetchworker.php",
                 method:"POST",
                 data:{employee_id:employee_id},
                 dataType:"json",
                 success:function(data){
                   $('#username').val(data.username);
                   $('#fullname').val(data.fullname);
                   $('#password').val(data.pasword);
                   $('#email').val(data.email);
                   $('#phone').val(data.phone);
                   $('#work_start').val(data.work_start);
                   $('#boss').val(data.boss);
                   $('#employee_id').val(data.id);
                   $('#insert').val("Update");
                   $('#add_data_Modal').modal('show');
                 }
            });
       });

       $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#username').val() == "")
            {
             alert("Felhasználónév mező üres");
            }
            else if($('#fullname').val() == '')
            {
             alert("Teljesnév mező üres");
            }
            else if($('#password').val() == '')
            {
             alert("Jelszó év mező üres");
            }
            else if($('#email').val() == '')
            {
             alert("Email mező üres");
            }
            else if($('#phone').val() == '')
            {
             alert("Telefonszám mező üres");
            }
            else if($('#work_start').val() == '')
            {
             alert("Munkábaállás dátuma mező üres");
            }
            else if($('#boss').val() == '')
            {
             alert("Vezetői jogosultság mező üres");
            }
            else
            {

                 $.ajax({

                      url:"insertworker.php",
                      method:"POST",
                      data:$('#insert_form').serialize(),
                      beforeSend:function(){
                           $('#insert').val("Inserting");

                      },
                      success:function(data){
                           $('#insert_form')[0].reset();
                           $('#add_data_Modal').modal('hide');
                           $('#employee_table').html(data);
                      }
                 });
            }
       });
       $(document).on('click', '.view_data', function(){
            var employee_id = $(this).attr("id");
            if(employee_id != '')
            {
                 $.ajax({
                      url:"selectworker.php",
                      method:"POST",
                      data:{employee_id:employee_id},
                      success:function(data){
                           $('#employee_detail').html(data);
                           $('#dataModal').modal('show');
                      }
                 });
            }
       });
  });

 </script>
<?php
require "footer.php";
?>
