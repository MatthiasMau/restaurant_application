<?php 
    require_once('../components/db_connect.php');
    require_once('../components/boot.php');

    if ($_GET['id']){
        $id = $_GET['id'];
        $sql = "SELECT * FROM booking WHERE id = {$id}";
        $result = $connect->query($sql);
        $data = $result->fetch_assoc();
        if ($result->num_rows == 1){
            $date = $data['date'];
            $time = $data['time'];
            $picture = $data['picture'];
        } else {
            header("Location: error.php");
         $connection->close(); }
    } else {
        header("Location: error.php");
    }

    if($_GET['id']){
        $id = $_GET['id'];
        //create query
        $sql = "SELECT * FROM booking WHERE id= {$id}";
        //store connected query in $result
        $result = $connect->query($sql);
        //if row returned to id, break down the columns of the row
        if ($result->num_rows == 1){
            //store assoc array in $data
            $data = $result->fetch_assoc();
            $date = $data['date'];
            $time = $data['time'];
            $picture = $data['picture'];
        } else { //if no row returned with the id, redirect to error
            header("Location: error.php");
        }
    }
?>
<!DOCTYPE html>
<html lang= "en">
   <head>
       <meta  charset="UTF-8">
       <meta name="viewport"  content="width=device-width, initial-scale=1.0">
       <title>Delete Product</title>
       <style type= "text/css">
           fieldset {
               margin: auto;
               margin-top: 100px;
               width: 70% ;
           }    
           .img-thumbnail{
               width: 70px !important;
                height: 70px !important;
           }    
       </style>
   </head>
   <body>
       <fieldset>
           <legend class='h2 mb-3'> Delete request </legend >
           <h5>You have selected the data below: </h5>
           <table class="table w-75 mt-3" >
               <tr>
                    <td><?php echo $date?></td>
                </tr>
           </table>

           <h3  class="mb-4">Do you really want to delete this product?</h3>
           <form action ="actions/a_delete.php"  method="post">
               <input type="hidden"  name="id" value ="<?php echo $id ?>" />
               <input type="hidden"  name="user"  value="<?php echo $last_name ?>" />
               <button class="btn btn-danger"  type="submit"> Yes, delete it! </button>
                <a href="index.php"><button class="btn btn-warning"  type="button"> No, go back! </button></a>
           </form>
       </fieldset>
   </body>
</html>