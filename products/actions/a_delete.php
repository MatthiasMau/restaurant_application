<?php 
    require_once('../../components/db_connect.php');
    require_once('../../components/boot.php');


    if ($_POST){
        $id = $_POST['id'];
        $user = $_POST['user'];

        $sql = "DELETE FROM booking WHERE id = {$id}";
        if ($connect->query($sql) === TRUE){
            $class = "success";
            $message = "Successfully deleted!";
        } else {
            $class = "danger";
            $message = "The entry was not deleted, because of an error <br>" . $connect->error;
        } $connect->close();
    } else {
        header("Location: ../error.php");
    }
?>
<!DOCTYPE html>
<html lang= "en">
   <head>
       <meta  charset="UTF-8">
       <title>Delete</title>
   </head>
   <body>
       <div  class="container">
           <div class="mt-3 mb-3" >
               <h1>Delete request response</h1>
           </div>
            <div class="alert alert-<?=$class;?>" role="alert">
               <p><?=$message;?></p >
               <a href ='../index.php'><button class= "btn btn-success" type='button'> Home</button></a>
            </div>
       </div >
   </body>
</html>