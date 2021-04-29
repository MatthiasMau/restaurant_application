<?php 
    session_start();
    require_once('../../components/db_connect.php');
    require_once('../../components/boot.php');

    if($_POST){
        $time = $_POST['time'];
        $date = $_POST['date'];
        $picture = $_POST['picture'];
        $fk_user = $_POST['id'];
        // echo gettype($time);
        $uploadError = '';
        //
        //sql query

        if($_SESSION['user']){
            $sqlSelect = "SELECT * from user where id = $fk_user";
            $result = mysqli_query($connect, $sqlSelect);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            // var_dump($row);
        }
        $sql = "INSERT INTO booking (time, date, picture, fk_user) VALUES ('$time', '$date', '$picture', '$fk_user')";

        if ($connect->query($sql) === true){
            $class = "success";
            $message = "The entry below was succesfully created <br>
            <table class='table w-50'>
            <tr>Thank you: ".$row['first_name']." </tr>
            <tr>Your booking is at : $time </tr>
            <tr> On: $date</tr>
            <tr> Your seating choice is: $picture</tr>
            </table>";
        } else {
            $class = "danger";
            $message = "Error creating record." . $connect->error;
        }$connect->close();
    } else {
        header("Location: ../error.php");
    }
?>
<!DOCTYPE html>
<html lang= "en">
   <head>
       <meta  charset="UTF-8">
       <title>Update</title>
   </head>
   <body>
       <div class="container">
           <div class="mt-3 mb-3" >
               <h1>Create request response</h1>
           </div>
            <div class="alert alert-<?=$class;?>" role="alert">
               <p><?php echo ($message) ?? ''; ?></p>
                <p><?php echo ($uploadError) ?? ''; ?></p>
                <a href='../index.php'><button class="btn btn-primary"  type='button'>Home</button ></a>
           </div>
       </div>
   </body>
</html>