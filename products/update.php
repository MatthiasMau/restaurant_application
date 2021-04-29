<?php 
    require_once('../components/db_connect.php');
    require_once('../components/boot.php');
    // require_once('../components/adminUpdate.php');

//this gathers all the information to be edited.
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
            $email = $data['email'];
            $time = $data['time'];
            $date = $data['date'];
            $picture = $data['picture'];

        } else { //if no row returned with the id, redirect to error
            header("Location: error.php");
        
        $connection->close(); 
        }
    }
//This gathers all the information from the _POST form (defined below), and then updates it in the DB 
    if ($_POST){
        $date = $_POST['date'];
        $time = $_POST['time'];
        $picture = $_POST['picture'];
        //need ID to make sure the correct row is updated
        $id = $_POST['id'];

        $sql = "UPDATE booking SET date = '$date', time = '$time', picture = '$picture' WHERE id = {$id}";

        if ($connect->query($sql) === true){
            echo '<script type ="text/JavaScript">';  
            echo 'alert("Succesfully updated")';  
            echo '</script>';  
            header("refresh:0.1;url=index.php");
        } else {
            $class = "danger";
            $message = "Error updating" . $connect->error;
            header("Location: error.php");

        } $connect->close();
    }
?>
<html>
    <head>
       <title> Edit Product </title>
       <style type= "text/css">
           fieldset {
               margin: auto;
               margin-top: 100px;
               width: 60% ;
           }  
           .img-thumbnail{
               width: 70px !important;
                height: 70px !important;
           }    
       </style>
   </head>
   <body>
       <fieldset>
           <legend class='h2'> Update request </legend>
           <p class='text-danger'>We do not accept bookings before 10:00 and after 21:00</p>
           <form action ='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'  method="post"  enctype="multipart/form-data">
                <table class="table">
                <tr>
        <th>Date and Time</th>
        <td><input  class ='form-control' type='time' name='time' min='10:00' max= '21:00' placeholder ='time' value="<?php echo $time ?>" /></td>
        <td><input class ='form-control' type='date' min="2021-04-28" name='date' placeholder='Date' value='<?php echo $date ?>' /></td>
    </tr>
    <tr>
         <th>Where would you like to sit?</th>
         <td>
             <select class='form-select' name ='picture' aria-label='Default select example'>
             <option value='<?php echo $picture ?>' selected><?php echo $picture ?></option>
             <option value='inside'>Inside</option>
             <option value='outside'>Outside</option>
             <option value='patio'>Patio</option>
             </select>
             </td>
     </tr>
    <tr>
        <input type= 'hidden' name= 'id'  value= "<?php echo $data['id'] ?>" />
        <td><button class ='btn btn-success' type = 'submit'>Save Changes</button></td>
        <td><a href= 'index.php' ><button class ='btn btn-warning' type ='button'>Back </button></a></td>
    </tr>
               </table>
           </form>
       </fieldset>
   </body>
</html>