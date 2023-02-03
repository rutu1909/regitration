<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
  require 'particlas\_dbconnect.php';
  $email=$_POST['email'];
  $password=md5($_POST['password']);
  echo ($password);
  $sql = "SELECT * FROM `user` WHERE email='$email' AND password='$password'";
  echo $sql;
  $result = mysqli_query($conn,$sql);
  $num=mysqli_num_rows($result);
  if($num==1)
  {
    session_start();
    $_SESSION['loggedin']=true;

    $_SESSION['email']=$email;
  

    header("location:index.php");
  }
  else{
    echo"wrong password";
  }
}


?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"></script>
</head>
<body>
  <?php
    require 'particlas\_nav.php';
    ?>
  <div class="container my-5">

    <form action="/registration/login.php" method="post" >

   

     

      <div class="col-md-4 my-3 position-relative">
        <label for="validationTooltipUsername" class="form-label">Email<span style="color: red;">*</span></label>
        <div class="input-group has-validation">
          <input type="email" class="form-control" id="email" name="email"
            aria-describedby="validationTooltipUsernamePrepend" required>
        </div>
      </div>
   
      <div class="col-md-6 my-3  position-relative">

        <label for="validationTooltip01" class="form-label">Password<span style="color: red;">*</span></label>
        <input type="password" class="form-control" id="password" name="password" value="" required>
      </div>
  


      <button type="submit" class="btn btn-primary my-4">Submit</button>
    </form>
    <form action="SignUp.php">
      <div id="emailHelp" class="form-text">For View click here... </div>
      <button type="submit" class="btn btn-primary">View Details</button>
    </form>
  </div>
</form>
  </div>
</body>
</html>