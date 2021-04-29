<?php 
    session_start();
    require_once('components/db_connect.php');
    require_once('components/boot.php');
    require_once('components/displayQueryFunc.php');
    // require_once('components/authentification.php');

    //declare the $id as admin
//     $id = $_SESSION['adm'];
//     //set the status to admin
    $status = 'adm';
//     //create query to select from user where status is = x
//     $sql = "SELECT * FROM user WHERE status = ?";
//     //make sure query is returning back true
//     $stmt = $connect->prepare($sql);
//     //search the query for a string = $status
//     $stmt->bind_param("s", $status);
//     //execute query
//     $work = $stmt->execute();
//     //store results of query in $result
//     $result = $stmt->get_result();

//     $tbody = '';
//     //if number of returned results is < 0, loop through to output data
//     if ($result->num_rows > 0){
//         //while data is in array, fetch_array, output with $row
//         while ($row = $result->fetch_array(MYSQLI_ASSOC)){
//             $tbody .= "<tr>
//             <td><img class='img-thumbnail rounded-circle' src='pictures/" . $row['picture'] . "' alt=" . $row['first_name'] . "></td>
//            <td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
//            <td>" . $row['date_of_birth'] . "</td>
//            <td>" . $row['email'] . "</td>
//            <td><a href='update.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
//            <a href='delete.php?id=" . $row['id'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
//             </tr>";
//         } 
//     }else { $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
//     }
// function hello($c, $a=null, $b=null){
//     if (null !== $a && null !== $b){
//         echo "isset";
//     } else {
//         echo " $c is not set";
//     }
// }

    $connect->close();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
   <meta charset="UTF-8">
    <meta name="viewport"   content="width=device-width, initial-scale=1.0">
   <title>Adm-DashBoard</title>
   <style type="text/css" >       
       .img-thumbnail{
           width: 70px !important;
            height: 70px !important;
       }
       td
       {
           text-align: left;
           vertical-align: middle;
       }
       tr
       {
           text-align: center;
       }
       .userImage{
width: 100px ;
height: auto;
}
   </style>
</head>
<body>
<div class="container" >
   <div class= "row">
       <div class="col-2">
       <img class="userImage" src="pictures/admin.jpg" alt= "Adm avatar" >
       <p>Administrator</p>
       <a href="products/index.php"><button class='btn btn-primary'>Manage Bookings</button></a>
       <a href="logout.php?logout"><button class='btn btn-danger'>Sign Out</button></a>
       </div >
       <div  class="col-8 mt-2">
        <p class='h2'>Users</p>
        <a href="create.php"><button class='btn btn-info'>Create User</button></a>
        <div>
        </div>
        <div>
        <?=generateTable("SELECT * FROM booking");?>
        <?=generateTable("SELECT * FROM user WHERE status != ?", "s", $status);?>
       </div>
   </div>
</div>
</body>
</html>         
