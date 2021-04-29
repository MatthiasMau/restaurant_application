<?php 
    // session_start();
    require_once('../components/db_connect.php');
    require_once('../components/boot.php');
    // require_once('../components/authentification.php');
    require_once('../components/adminButtons.php');

if ($_SESSION['user']){
    echo $_SESSION['user'];
    $sql = "SELECT * FROM booking where fk_user = {$_SESSION['user']}";
        //create query
        $result = mysqli_query($connect, $sql);
        $tbody = '';
        //if query returns rows
        if(mysqli_num_rows($result) > 0){
            //run them through while loop, for as many rows as there are
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $tbody .= "<tr>
                <td><img class='w-100' src= '../pictures/".$row['picture']. ".jfif'>".$row['picture']."</td>
                <td>" .$row['time']."</td>
               <td>" .$row['date']."</td>
                <td>" .$row['email']."</td>
               <td><a href='update.php?id=".$row['id']."'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
               <a href='delete.php?id=".$row['id']."'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
               </tr>";
       };
    } else {
        $tbody =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}
}
if (!$_SESSION['user']){
    $sql = "SELECT * FROM booking";
        //create query
        $result = mysqli_query($connect, $sql);
        $tbody = '';
        //if query returns rows
        if(mysqli_num_rows($result) > 0){
            //run them through while loop, for as many rows as there are
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $tbody .= "<tr>
                <td>User #: ".$row['id']." made this booking</td>
                <td><img class='w-100' src= '../pictures/".$row['picture']. ".jfif'>".$row['picture']."</td>
                <td>" .$row['time']."</td>
               <td>" .$row['date']."</td>
                <td>" .$row['email']."</td>
               <td><a href='update.php?id=".$row['id']."'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
               <a href='delete.php?id=".$row['id']."'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
               </tr>";
       };
    } 
else {
    $tbody =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
 }
}


$connect->close();
?>

<!DOCTYPE html>
<html lang="en" >
   <head>
       <meta charset="UTF-8">
       <meta name="viewport"  content="width=device-width, initial-scale=1.0">
       <title>PHP CRUD</title>
       <style type= "text/css">
           .manageProduct {          
               margin: auto;
           }
           .img-thumbnail {
               width: 70px !important;
                height: 70px !important;
           }
           td {          
               text-align: left;
               vertical-align: middle;

            }
           tr {
               text-align: center;
           }
       </style>
   </head>
   <body>
       <div class="manageProduct w-75 mt-3" >   
           <div class='mb-3'>
           <a href= "../logout.php?logout"><button>Log out</button></a>
           <?php adminButtons(); ?>
            </div>
           <p class='h2'>Bookings</p>

            <table class='table table-striped'>
               <thead class='table-success' >
                   <tr>
                        <th>Seating location</th>
                        <th>Time</th>
                       <th>Date</th>
                       <th>Contact Email</th>
                        <th>Change/delete booking</th>
                   </tr>
               </thead>
               <tbody >
               <?=$tbody?>
               </tbody>
            </table>
       </div>
    </body>
</html >