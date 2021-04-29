 <?php 

if (isset($_SESSION['user']) != "") {
    header("Location: ../home.php");
    exit;
 }
 
 if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php" );
     exit;
 }

?> 