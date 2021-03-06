<?php 
    session_start();
    require_once('components/db_connect.php');
    require_once('components/boot.php');
    require_once('components/displayQueryFunc.php');

    if (isset($_SESSION['adm'])){
        header("Location: dashboard.php");
        exit;
    }
    //if !admin and !user, then proceed to login page, because user is not logged in.
    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])){
        header("Location: index.php");
        exit;
    }
    //create the logged in users details, procedurally
    $res = mysqli_query($connect, "SELECT * FROM user where id =" . $_SESSION['user']);
    var_dump($res);
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    $connect->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome - <?php echo $row['first_name']; ?></title>
<style>
.userImage{
width: 200px;
height: 200px;
}
.hero {
   background: rgb(2,0,36);
    background: linear-gradient(24deg, rgba(2,0,36,1) 0%, rgba(0,212,255,1) 100%);  
}
</style>
</head>
<body>
<div class ="container">
   <div class="hero">
       <img class= "userImage" src="pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['first_name']; ?>">
       <p class ="text-white" >Hi <?php  echo $row['first_name']; ?></p >
   </div>
   <a href="logout.php?logout"> Sign Out</a>
   <a href="update.php?id=<?php echo $_SESSION['user'] ?>">Update your profile</a>
   <a href="products/index.php">view bookings</a>
</div>
</body>
</html>