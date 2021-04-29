<?php 
session_start();
    require_once('../components/boot.php');
    require_once('../components/db_connect.php');
    require_once('../components/sanitizeData.php');
    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
        header("Location: ../index.php" );
         exit;
     }
if($_SESSION['user']){
     $id = $_SESSION['user'];
    } else {
        $id != $_SESSION['user'];
        $id = $_SESSION['adm'];
    }


?>
<!DOCTYPE html>
<html lang="en" >
   <head>
       <meta charset="UTF-8">
        <meta name="viewport" content ="width=device-width, initial-scale=1.0">
       <title>PHP CRUD  |  Create Booking</title>
       <style>
           fieldset {
               margin: auto;
               margin-top: 100px;
               width: 60% ;
           }      
       </style>
   </head>
   <body>
       <fieldset>
           <legend class='h2'> Create Booking </legend>
           <p class='text-danger'>We do not accept bookings before 10:00 and after 21:00</p>
           <form action="actions/a_create.php"  method= "post" enctype= "multipart/form-data">
               <table  class='table'>
                   <tr>
                       <th>Pick a date and time</th>
                       <td><input  class ='form-control' type="time" min="10:00" max="21:00" name="time"  placeholder ="Choose a time" /><span class="text-danger" ></span></td>
                        <td><input  class ='form-control' type="date"  min="2021-04-28" name="date"  placeholder ="Choose a date to dine on" /></td>
                   </tr>   
                    <tr>
                        <th>Where would you like to sit?</th>
                        <td>
                            <select class="form-select" name ="picture" aria-label="Default select example">
                            <option value='inside'>Inside</option>
                            <option value='outside'>Outside</option>
                            <option value='patio'>Patio</option>
                            </select>
                            </td>
                    </tr>
                    <td><input  class ='form-control' type="hidden"  name="id" value='<?php echo $id; ?>' /></td>
                   <tr>
                       <td><button class ='btn btn-success' name="btn-create" type= "submit">Insert Product</button></td>
                       <td><a href="index.php" ><button class= 'btn btn-warning' type= "button">Home</button></a></td>
                   </tr>
               </table>
           </form>
       </fieldset>
   </body>
</html>