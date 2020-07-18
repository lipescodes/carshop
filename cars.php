<?php
require "includes/dbh.inc.php";
require "header.php";
require "sidebar.php";
//$query = "SELECT * FROM cars1";
//$result = mysqli_query($conn, $query);
if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];

    $query = "SELECT * FROM cars1 WHERE CONCAT(cars1.mark, cars1.type) LIKE '%".$valueToSearch."%' OR (SELECT id FROM users WHERE username LIKE '%".$valueToSearch."%' AND users.id = cars1.salesman_id)";
    $search_result = filterTable($query);

}
 else {
    $query = "SELECT * FROM cars1";
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
  <title></title>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
main {
  margin-left: 160px;
  font-size: 28px;
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
    <h3>Üdvözöllek a Car Shop Inc. nyilvántartásában.</h3>
    <div class="container" style="width:700px;">
        <h3>Itt tekintheti meg forgalmazott gépjárműveink adatit:</h3>


            <br />

          <div align="center">
            <form action="cars.php" method="post">
            <input type="text" name="valueToSearch" placeholder="Márka/Típus/Értékesítő"><br><br>
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
                           <th width="70%">Forgalmazott autók</th>

                           <th width="15%">Szerkesztés</th>
                           <th width="15%">Megtekintés</th>
                      </tr>
                      <?php
                      while($row = mysqli_fetch_array($search_result))
                      {
                      ?>
                      <tr>
                           <td><?php echo $row["mark"]." ".$row["type"]; ?></td>
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
                     <h4 class="modal-title">Autó részletei</h4>
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
                    <h4 class="modal-title">Gépjármű adatainak szerkesztése</h4>
               </div>
               <div class="modal-body">
                    <form method="post" id="insert_form">
                      <label>Gépjármű márkája:</label>
                      <input type="text" name="mark" id="mark" class="form-control" />
                      <br />
                      <label>Gépjármű típusa:</label>
                      <input type="text" name="type" id="type" class="form-control"/>
                      <br />
                      <label>Gyártási év:</label>
                      <input type="number" name="year_of_production" id="year_of_production" class="form-control">
                      <br />
                      <label>Hengerűrtartalom</label>
                      <input type="text" name="ccm" id="ccm" class="form-control" />
                      <br />
                      <label>Lóerő</label>
                      <input type="text" name="hp" id="hp" class="form-control" />
                      <br />
                      <br />
                      <label>Értékesítő azonosítója:</label>
                      <input type="text" name="salesman_id" id="salesman_id" class="form-control" />
                      <br />
                      <br />
                      <label>Ár:</label>
                      <input type="text" name="price" id="price" class="form-control" />
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
                 url:"fetchcar.php",
                 method:"POST",
                 data:{employee_id:employee_id},
                 dataType:"json",
                 success:function(data){
                   $('#mark').val(data.mark);
                   $('#type').val(data.type);
                   $('#year_of_production').val(data.year_of_production);
                   $('#ccm').val(data.ccm);
                   $('#hp').val(data.hp);
                   $('#salesman_id').val(data.salesman_id);
                   $('#price').val(data.price);
                   $('#employee_id').val(data.id);
                   $('#insert').val("Update");
                   $('#add_data_Modal').modal('show');
                 }
            });
       });

       $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#mark').val() == "")
            {
             alert("Márka mező üres");
            }
            else if($('#type').val() == '')
            {
             alert("Típus mező üres");
            }
            else if($('#year_of_production').val() == '')
            {
             alert("Gyártási év mező üres");
            }
            else if($('#ccm').val() == '')
            {
             alert("Hengerűrtartalom mező üres");
            }
            else if($('#hp').val() == '')
            {
             alert("Lóerő mező üres");
            }
            else if($('#salesman_id').val() == '')
            {
             alert("Értékesítő azonosítója üres");
            }
            else if($('#price').val() == '')
            {
             alert("Ár mező üres");
            }
            else
            {

                 $.ajax({

                      url:"insertcar.php",
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
                      url:"selectcar.php",
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
