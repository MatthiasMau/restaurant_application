<?php 
    session_start();
    require_once('components/db_connect.php');
    require_once('components/boot.php');
    if(!isset($_SESSION['adm']) && !isset($_SESSION['user'])){
        header("Location: index.php");
        exit;
    }

    if(isset($_SESSION['user'])){
        header("Location: home.php");
        exit;
    }
    //bootstrap for the confirmation message
    $class = 'd-none';
    //get the id of the selected user (to delete)
    if($_GET['id']){
        $id = $_GET['id'];
        //query to select correct user
        $sql = "SELECT * FROM user WHERE id = {$id}";
        //store query in $result
        $result = $connect->query($sql);
        $data = $result->fetch_assoc();
        //if found row returned, split the row into individual variables
        if ($result->num_rows == 1){
            $f_name = $data['first_name'];
            $l_name = $data['last_name'];
            $email = $data['email'];
            $date_of_birth = $data['date_of_birth'];
            $picture = $data['picture'];
        }
    }

    //Post method called to delete user
    if ($_POST){
        //get the user's ID and pic
        $id = $_POST['id'];
        $picture = $_POST['picture'];
        ($picture == "avatar.jpg")?: unlink("pictures/$picture");
        //sql query to delete user based on ID
        $sql = "DELETE FROM user WHERE id = {$id}";
        if($connect->query($sql) === TRUE){
            $class = "alert alert-success";
            $message = "successfully deleted!";
            //wait 2 seconds, then redirect to dashboard
            header("refresh:2;url=dashboard.php");
        } else {
            $class = "alert alert-danger";
            $message = "The entry was not deleted because of <br>" . $connect->error;
        }
    }
    $connect->close();
?>

<!DOCTYPE html>
<html lang="en" >
<head>
   <meta charset="UTF-8">
    <meta name="viewport"   content="width=device-width, initial-scale=1.0">
   <title>Delete User</title>
   <style type= "text/css" >
      fieldset {
           margin: auto;
           margin-top: 100px;
           width: 70% ;
       }    
       .img-thumbnail{
           width: 70px  !important;
           height: 70px !important;
       }    
  </style>
</head>
<body>
<div class="<?php echo $class; ?>" role="alert" >
       <p><?php echo ($message) ?? ''; ?></p>           
</div>
<fieldset>
<legend class='h2 mb-3' >Delete request <img class= 'img-thumbnail rounded-circle'  src='pictures/<?php echo $picture ?>' alt="<?php echo $f_name ?>"></legend >
<h5>You have selected the data below: </h5>
<table class="table w-75 mt-3">
<tr>
           <td><?php echo "$f_name $l_name"?></td>
           <td><?php echo $email?></ td>
           <td ><?php echo $date_of_birth?></td>
</tr>
</table>

<h3 class="mb-4" >Do you really want to delete this user?</h3>
<form method="post">
  <input type="hidden" name ="id" value= "<?php echo $id ?>" />
  <input type= "hidden" name= "picture" value= "<?php echo $picture ?>" />
  <button class="btn btn-danger"  type="submit"> Yes, delete it! </button>
  <a href="dashboard.php" ><button  class="btn btn-warning"  type= "button">No, go back!</button></a>
</form>
</fieldset>
</body>
</html>