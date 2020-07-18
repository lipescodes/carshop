<?php
require "includes/dbh.inc.php";
require "header.php";
require "sidebar.php";
//$query = "SELECT * FROM buyer1";
//$result = mysqli_query($conn, $query);
if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];

    $query = "SELECT * FROM buyer1 WHERE CONCAT(name, email, phone) LIKE '%".$valueToSearch."%'  OR (SELECT id FROM cars1 WHERE mark LIKE '%".$valueToSearch."%' AND cars1.id = buyer1.bought_car_id) ";
    $search_result = filterTable($query);

}
 else {
    $query = "SELECT * FROM buyer1";
    $search_result = filterTable($query);
}
function filterTable($query)
{

    $connect = mysqli_connect("localhost", "root", "", "carshop");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;

}
?>
<html>
<head>
  <title>Carshop</title>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
main {
  margin-left: 160px; /* Same as the width of the sidenav */
  font-size: 28px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}
h3{
  text-align: center;
  margin-top: 7%;
}

</style>
</head>
<body>
<main>
  <div class="wrapper-main">
    <br>
    <h3>Üdvözöllek a Car Shop Inc. nyilvántartásában.</h3><br>

    <div class="container" style="width:700px;">
      <h3>Itt tekintheti meg vásárlóink adatit:</h3>
      <br/>
      <div align="center">
      <form action="buyer.php" method="post">
      <input type="text" name="valueToSearch" placeholder="Név/Email/Gépjármű"><br><br>
      <input type="submit" name="search" value="Keresés"><br><br>
      <div class="table-responsive" id="cars1_table">
      </form>
      </div>

      <div align="right">
          <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Hozzáad</button>
      </div>
        <br>
            <div id="employee_table">
                 <table class="table table-bordered">
                      <tr>
                           <th width="70%">Vásárlók</th>
                          <!-- <th class="text-center" width="30%">Megtekintés</th> -->
                           <th width="15%">Szerkesztés</th>
                           <th width="15%">Megtekintés</th>
                      </tr>
                      <?php
                      while($row = mysqli_fetch_array($search_result))
                      {
                      ?>
                      <tr>
                           <td><?php echo $row["name"]; ?></td>
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
  </div>
</main>
</body>
</html>
<div id="dataModal" class="modal fade">
      <div class="modal-dialog">
           <div class="modal-content">
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Vásárló adatai:</h4>
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
                    <h4 class="modal-title">Vásárló adatainak szerkesztése</h4>
               </div>
               <div class="modal-body">
                    <form method="post" id="insert_form">
                      <label>Vásárló neve:</label>
                      <input type="text" name="name" id="name" class="form-control" />
                      <br />
                      <label>Vásárló emailcíme:</label>
                      <input type="email" name="email" id="email" class="form-control"/>
                      <br />
                      <label>Vásárló telefonszáma:</label>
                      <input type="text" name="phone" id="phone" class="form-control">
                      <br />
                      <label>Vásárlás dátuma:</label>
                      <input type="date" name="buy_date" id="buy_date" class="form-control" />
                      <br />
                      <label>Vásárolt gépjármű azonosítója:</label>
                      <input type="number" name="bought_car_id" id="bought_car_id" class="form-control" />
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
                 url:"fetchbuyer.php",
                 method:"POST",
                 data:{employee_id:employee_id},
                 dataType:"json",
                 success:function(data){
                   $('#name').val(data.name);
                   $('#email').val(data.email);
                   $('#phone').val(data.phone);
                   $('#ccm').val(data.ccm);
                   $('#buy_date').val(data.buy_date);
                   $('#bought_car_id').val(data.bought_car_id);
                   $('#employee_id').val(data.id);
                   $('#insert').val("Update");
                   $('#add_data_Modal').modal('show');
                 }
            });
       });

       $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#name').val() == "")
            {
             alert("Név mező üres");
            }
            else if($('#email').val() == '')
            {
             alert("Email mező üres");
            }
            else if($('#phone').val() == '')
            {
             alert("Telefonszám mező üres");
            }
            else if($('#buy_date').val() == '')
            {
             alert("Vásárlás dátuma mező üres");
            }
            else if($('#bought_car_id').val() == '')
            {
             alert("Vásárolt gépjármű azonosítója mező üres");
            }

            else
            {

                 $.ajax({

                      url:"insertbuyer.php",
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
                      url:"selectbuyer.php",
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
