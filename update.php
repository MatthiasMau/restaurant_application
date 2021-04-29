<?php 
    session_start();
    require_once('components/db_connect.php');
    require_once('components/file_upload.php');
    require_once('components/boot.php');
    // require_once('components/authentification.php');

    if( !isset($_SESSION['adm']) && !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }

    $backBtn = '';
    //if user create back button to home.php
    if(isset($_SESSION['user'])){
        $backBtn = "home.php";
    }

    //if admin, -> dashboard.php
    if(isset($_SESSION['adm'])){
        $backBtn = "dashboard.php";
    }

    //get form with current data, get item ID
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        //query to match item id 
        $sql = "SELECT * FROM user WHERE id = {$id}";
        //store the connnect to db in $result
        $result = $connect->query($sql);
        //if $result returns 1 row (aka query was successfull)
        if ($result->num_rows == 1){
            //store the fetched_assoc in $data
            $data = $result->fetch_assoc();
            //break up the array into specific variabels - in order to display in form
            $f_name = $data['first_name'];
            $l_name = $data['last_name'];
            $email = $data['email'];
            $date_birth = $data['date_of_birth'];
            $picture = $data['picture'];
        }
    }

    //update function
    $class = 'd-none';
    //get the data from submit button
    if (isset($_POST['submit'])){
        //assign each var to the $_POST from form
        $f_name = $_POST['first_name'];
        $l_name = $_POST['last_name'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['date_of_birth'];
        $id = $_POST['id'];
        //variable for upload pictures errors
        $uploadError = '';
        //storing the file_upload in $pictureArray
        $pictureArray = file_upload($_FILES['picture']);
        $picture = $pictureArray->fileName;
        if ($pictureArray->error === 0){
            //if there is no error, 
            ($_POST["picture"] == "avatar.jpg") ?: unlink("pictures/{$_POST["picture"]}");
            //query if picture is selected
            $sql = "UPDATE user SET first_name = '$f_name', last_name = '$l_name', email = '$email', date_of_birth = '$date_of_birth', picture = '$pictureArray->fileName' WHERE id = {$id}";
        } else {
            //sql if no picture is selected
            $sql = "UPDATE user SET first_name = '$f_name', last_name = '$l_name', email = '$email', date_of_birth = '$date_of_birth' WHERE id = {$id}";
        }
        if ($connect->query($sql) === true){
            //if query works out, no errorMessage etc. etc.
            $class = "alert alert-success";
            $message = "Record was updated successfully!";
            $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
            //wait 2 seconds and then refresh update url
            header("refresh:2;url=update.php?id={$id}");
        } else {
            //error occured
            $class = "alert alert-danger";
            $message = "Error while updating record: <br>" .$connect->error;
            $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage: '';
            header("refresh:2;url=update.php?id={$id}");
        }
    }
    $connect->close();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <style type= "text/css">
      fieldset {
           margin: auto;
           margin-top: 100px ;
           width: 60% ;
       }
       .img-thumbnail{
           width: 70px !important;
           height: 70px !important;
       }
  </style>
</head>
<body>
<div class ="container">
   <div class="<?php echo $class; ?>"  role="alert">
       <p><?php echo ($message) ?? ''; ?></p>
        <p><?php echo ($uploadError) ?? ''; ?></p>       
    </div>
   
       <h2>Update</h2>       
       <img class='img-thumbnail rounded-circle'  src='pictures/<?php echo $data['picture'] ?>' alt="<?php echo $f_name ?>">
       <form  method="post" enctype="multipart/form-data" >
           <table  class="table">
               <tr>
                   <th>First Name</th >
                   <td><input class="form-control"  type="text"  name ="first_name" placeholder = "First Name"  value="<?php echo $f_name ?>"   /></td>
               </tr>
               <tr>
                   <th>Last Name</th>
                   <td ><input class= "form-control" type= "text"  name="last_name"  placeholder="Last Name" value ="<?php echo $l_name ?>" /></td>
               </tr>
               <tr>
                   <th>Email</th>
                   <td><input class ="form-control" type ="email" name ="email" placeholder = "Email" value = "<?php echo $email ?>" /></td>
               </tr>
               <tr>
                   <th>Date of birth</th>
                    <td ><input class= "form-control" type ="date"  name="date_of_birth"  placeholder= "Date of birth" value = "<?php echo $date_birth ?>"/></td>
               </tr>
               <tr>
                   <th>Picture</th>
                    <td><input  class= "form-control"  type ="file"   name = "picture"   /></td>
                </tr>
                <tr>
                    <input   type = "hidden" name = "id" value = "<?php echo $data['id'] ?>"  />
                    <input   type = "hidden" name = "picture" value = "<?php echo $picture ?>"  />
                    <td><button name = "submit" class = "btn btn-success"   type = "submit"> Save Changes </button></td>
                    <td><a href = "<?php echo $backBtn?>"><button class = "btn btn-warning" type = "button"> Back </button></a></td>
                </tr>
            </table>
        </form>    
</div>
</body>
</html>