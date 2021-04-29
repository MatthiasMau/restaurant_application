<?php 
require_once('db_connect.php');
session_start();

function adminUpdate(){
    $buttons = '';
    if(isset($_SESSION['adm']) != "")
    { $update = 
        "<tr>
        <th>Date and Time</th>
        <td><input  class ='form-control' type='time'  name='time'  placeholder ='time' value="<?php echo $time ?>" /></td>
        <td><input class ='form-control' type='date'   name='date' placeholder='Date' value='<?php echo $date ?>' /></td>
    </tr>
    <tr>
         <th>Where would you like to sit?</th>
         <td>
             <select class='form-select' name ='picture' aria-label='Default select example'>
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
    </tr>";
    } else {
        $update = "<a href='create.php'><button class='btn btn-primary mx-5' type= 'button' >Add booking</button></a>
        <a href='../home.php'><button class='btn btn-primary mx-5' type= 'button'>Home</button></a>";
    } echo $update;
    
}
?>