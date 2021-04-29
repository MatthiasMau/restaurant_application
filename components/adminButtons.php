<?php 
require_once('db_connect.php');
session_start();

function adminButtons(){
    $buttons = '';
    if(isset($_SESSION['adm']) != "")
    { $buttons = 
           "<a href= '../dashboard.php'><button class='btn btn-info ms-4' type = 'button' >Dashboard</button></a>
           <a href='../products/create.php'><button class='btn btn-primary mx-5' type= 'button' >Add booking</button></a>";
    } else {
        $buttons = "<a href='create.php'><button class='btn btn-primary mx-5' type= 'button' >Add booking</button></a>
        <a href='../home.php'><button class='btn btn-primary mx-5' type= 'button'>Home</button></a>";
    } echo $buttons;
    
}
?> 