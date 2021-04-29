<?php 
    session_start();
    require_once('components/db_connect.php');
    require_once('components/file_upload.php');
    // require_once('components/authentification.php');
    require_once('components/sanitizeData.php');
    require_once('components/boot.php');

    if (isset($_SESSION['user']) != ""){
        header("Location: home.php");
    }
    if (isset($_SESSION['adm']) != ""){
        header("Location: dashboard.php");
    }

    $error = false;
    $fname = $lname = $email = $date_of_birth = $pass = $picture = '';
    $fnameError = $lnameError = $emailError = $dateError = $passError = $picError = '';

    if (isset($_POST['btn-signup'])){

        $fname = sanitizeData($_POST['fname']);
        $lname = sanitizeData($_POST['lname']);
        $email = sanitizeData($_POST['email']);
        $date_of_birth = sanitizeData($_POST['date_of_birth']);
        $pass = sanitizeData($_POST['pass']);

        $uploadError = '';
        $picture = file_upload($_FILES['picture']);

        //name validation 
        if (empty($fname) || empty($lname)){
            $error = true;
            $fnameError = "Please enter your first name";
        } else if (strlen($fname) < 3 || strlen($lname) < 3){
            $error = true;
            $fnameError = "Name must be longer than 3 characters";
        } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)){
            $error = true;
            $fnameError = "You failed the regex, only letters please, and no spaces";
        }
        //email validation 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = true;
            $emailError = "Enter valid email address";
        } else {
            $query = "SELECT email FROM user WHERE email = '$email'";
            $result = mysqli_query($connect, $query);
            $count = mysqli_num_rows($result);
            if ($count != 0){
                $error = true;
                $emailError = "Email already registered";
            }
        }

        //date validation 
        if (empty($date_of_birth)){
            $error = true;
            $dateError = "I wasn't born yesterday, please enter your date of birth";
        }
        //password validation 
        if (empty($pass)){
            $error = true;
            $passError = "Enter a password";
        } else if (strlen($pass) < 4){
            $error = true;
            $passError = "Password must have at least 4 characters";
        }
        //password hash 
        $password = hash('sha256', $pass);
        //if no error, continue with signup
        if (!$error){
            $query = "INSERT INTO user(first_name, last_name, password, date_of_birth, email, picture) VALUES ('$fname', '$lname', '$password', '$date_of_birth', '$email', '$picture->fileName')";
            //connect the DB to the query
            $res = mysqli_query($connect, $query);

            if ($res){
                $errType = "success";
                $errMSG = "Successfully registered, you can login now";
                $uploadError = ($picture->error != 0) ? $picture->ErrorMessage: '';
            } else {
                $errType = "danger";
                $errMSG = "Something went wrong!";
                $uploadError = ($picture->error != 0)? $picture->ErrorMessage : '';
            }
        }
    }
    $connect->close();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
   <meta charset="UTF-8">
    <meta name="viewport"   content="width=device-width, initial-scale=1.0">
<title>Login & Registration System </title>
</head>
<body>
<div class ="container">
  <form class="w-75"  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"  enctype="multipart/form-data">
            <h2>Sign Up.</h2>
           <hr/>
           <?php
           if (isset($errMSG)) {
           ?>
           <div class="alert alert-<?php echo $errTyp ?>"  >
                        <p><?php echo $errMSG; ?></p>
                        <p><?php echo $uploadError; ?></ p>
           </div>

           <?php
           }
           ?>

           <input type ="text"  name="fname"  class="form-control" placeholder="First name" maxlength="50" value= "<?php echo $fname ?>"/>
              <span class="text-danger" > <?php echo $fnameError; ?></span>

            <input type ="text"   name="lname"  class ="form-control" placeholder= "Surname" maxlength="50" value="<?php echo $lname ?>"  />
              <span class="text-danger" > <?php echo  $fnameError; ?></span>

           <input  type="email"  name="email" class ="form-control" placeholder ="Enter Your Email" maxlength="40" value = "<?php echo $email ?>" />
              <span  class="text-danger"> <?php  echo $emailError; ?></span>
            <div class ="d-flex">
               <input class='form-control w-50'  type="date"   name="date_of_birth"  value = "<?php echo $date_of_birth ?>"/>
                <span  class="text-danger" > <?php  echo $dateError; ?></span>

                <input class='form-control w-50' type="file" name= "picture" >
                <span class= "text-danger">  <?php echo  $picError; ?></span>
            </div >
            <input   type = "password"   name = "pass"   class = "form-control"   placeholder = "Enter Password"   maxlength = "15"   />
              <span class = "text-danger"><?php echo  $passError; ?></span>
            <hr/>
            <button type = "submit"   class = "btn btn-block btn-primary" name = "btn-signup" >Sign Up</button>
            <hr/>
            <a href = "index.php" > Sign in Here... </a>
  </form>
  </div>
</body>
</html>