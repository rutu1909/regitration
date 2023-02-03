
<?php
  $showPasswordError=false; 
  $showMobileError=false; 
  $showEmailError=false; 
  $showSuccess=false;
  $showImageError=false;
  $showError= false;


if($_SERVER['REQUEST_METHOD']=="POST")
{
    require 'particlas\_dbconnect.php';
   
    $profilepic=$_FILES['profilepic']['name'];

    // echo "<pre>";
    // print_r($_FILES['profilepic']);
    // echo "</pre>";
    
    if(empty($_FILES['profilepic']['name']))
    {
            $profilepic="123.jpg";
          
    }else
    {
      
      $profilepic=$_FILES['profilepic']['name'];
      $profilepicsize=$_FILES['profilepic']['size'];
      $tmp_name=$_FILES['profilepic']['tmp_name'];
      $error=$_FILES['profilepic']['error'];
      
      if($error===0)
      { 
                  $img_ex=pathinfo($profilepic,PATHINFO_EXTENSION);
                  $img_ex_lc=strtolower($img_ex);
                  $allowes_file=array("jpg","jpeg","png");
                  if(in_array($img_ex_lc,$allowes_file))
           {
                        $new_name=uniqid("IMG-",true).'.'.$img_ex_lc;
                        $img_upload_path='C:/xampp/htdocs/registration/particlas/uploadedpics/'.$profilepic;
                                              
                        move_uploaded_file($tmp_name,$img_upload_path);
                      }
                      else
                      {
                                 $showImageError=true;

                      } 
                }
      else
        {
                   $showError=true;
        }
    }
if($showImageError==false && $showError==false)
{
    
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    $gender=$_POST['radio-stacked'];
    if(empty($profilepic)){
      $profilepic="dimg.png";
    }
    if(empty($_POST['designation'])){
      $designation="Update your designation";
    }
    else
    {
      $designation=implode("",$_POST['designation']);
    }
    if(empty($_POST['hobbie'])){
      $hobbie="Update your hobbie";
    }
    else{
      $hobbie=implode(", ",$_POST['hobbie']);
    
    }
    
    $existsql="SELECT * FROM `user` WHERE email='$email' OR mobile='$mobile'";
    $result=mysqli_query($conn,$existsql);
    $numExistrow=mysqli_num_rows($result);
    if($numExistrow>=1)
    {
      $row = mysqli_fetch_assoc($result);
        if($row['email']==$email){
          $showEmailError=true;
        }
        else{
          $showMobileError=true;
        }
        
    }
    else if($password == $cpassword){
      $password=md5($password);
      
      $sql="INSERT INTO `user` (`sno`, `firstname`, `lastname`, `profile`, `email`, `hobbies`, `gender`, `designation`, `mobile`, `password`) VALUES (NULL, '$firstname', '$lastname', '$profilepic', '$email', '$hobbie', '$gender', '$designation', '$mobile', '$password')";
      $result=mysqli_query($conn, $sql);
      echo "$sql";
      var_dump($result);
     
    
      if($result){
          $showSuccess=true;
      }   
    }
    else{
      $showPasswordError=true; 
    }


   }
   else{
    $showImageError=true;
   }

}


    

    


?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</head>

<body>
    <?php
    require 'particlas\_nav.php';

    
    if($showPasswordError){
       echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       <strong>Error!</strong>Password does not match...
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
   }
    if($showEmailError){
       echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       <strong>Error!</strong>This Email is already used...
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
   }
    if($showMobileError){
       echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       <strong>Error!</strong>This mobile number is already used...
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
   }
    if($showImageError){
       echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       <strong>Error!</strong>This file is not valid..
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
   }
   if($showSuccess){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your account was created successfully you can login now....
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
    ?>
    <div class="container my-5">

        <form action="/registration/signUp.php" method="post" enctype="multipart/form-data">
            
            <div class="mb-3 my-3">
                <label for="validationTooltip04" class="form-label">Profile Picture</label>
                <input type="file" class="form-control"id="profilepic" name="profilepic" aria-label="file example" >
    
             </div>

            <div class="col-md-12 my-3  position-relative">

                    <label for="validationTooltip01" class="form-label">First name<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="" required>
            </div>
            <div class="col-md-12 my-3  position-relative">

                    <label for="validationTooltip01" class="form-label">Last name<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="" required>
                  
            </div>
           
            <div class="col-md-4 my-3 position-relative">
                <label for="validationTooltipUsername" class="form-label">Email<span style="color: red;">*</span></label>
                <div class="input-group has-validation">
                  <input type="email" class="form-control" id="email" name="email" aria-describedby="validationTooltipUsernamePrepend" required>    
                </div>
            </div>
          <div class="col-md-4 position-relative my-3 d-flex">
            <label for="validationTooltip04" class="form-label">Hobbies</label>
            <div class="form-check mx-2 mb-3">
                <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Playing" >
                <label class="form-check-label" for="validationFormCheck11">Playing</label>
               
            </div>
            <div class="form-check mx-2 mb-3">
                <input type="checkbox" class="form-check-input" id="hobbie"  name="hobbie[]" value="Reading" >
                <label class="form-check-label" for="validationFormCheck22">Reading</label>
               
            </div>
            <div class="form-check mx-2 mb-3">
                <input type="checkbox" class="form-check-input"id="hobbie"  name="hobbie[]" value="Driving">
                <label class="form-check-label" for="validationFormCheck33">Driving</label>
               
            </div>
            <div class="form-check mx-2 mb-3">
                <input type="checkbox" class="form-check-input"id="hobbie"  name="hobbie[]" value="Dancing">
                <label class="form-check-label" for="validationFormCheck33">Dancing</label>
               
            </div>
           
          </div>

            <div class="col-md-4 position-relative my-3">
                <label for="validationTooltip04" class="form-label">Designation</label>
                <select class="form-select" id="designation" name="designation[]" >
                  <option selected disabled value="Choose your designation">Choose your designation</option> 
                  <option value="Student">Student</option>      
                  <option value="Intern">Intern</option>
                  <option value="Employee">Employee</option>
                  <option value="Team Leader">Team Leader</option>
                  <option value="Project Manager">Project Manager</option>
                  <option value="HR">HR</option>
                  <option value="Director">Director</option>
                </select>
            </div>

            <div class="form-check my-3">
                <input type="radio" class="form-check-input" id="validationFormCheck1" name="radio-stacked"  value="Male" required>
                <label class="form-check-label" for="validationFormCheck1">Male</label>
              </div>
              <div class="form-check mb-3">
                <input type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked" value="Female" required>
                <label class="form-check-label" for="validationFormCheck2">Female</label>
              </div>
              <div class="form-check mb-3">
                <input type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked" value="Other" required>
                <label class="form-check-label" for="validationFormCheck3">Other</label>
                <div class="invalid-feedback">More example invalid feedback text</div>
              </div>
            
              <div class="col-md-4 my-3  position-relative">

                <label for="validationTooltip01" class="form-label">Mobile Number<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="" required>
        </div>

        
        <div class="col-md-6 my-3  position-relative">

            <label for="validationTooltip01" class="form-label">Password<span style="color: red;">*</span></label>
            <input type="password" class="form-control" id="password" name="password" value="" required>
    </div>
    <div class="col-md-6 my-3  position-relative">
        
            <label for="validationTooltip01" class="form-label">Confirm password<span style="color: red;">*</span></label>
            <input type="password" class="form-control" id="cpassword" name="cpassword" value="" required>
          
    </div>
   


            <button type="submit" class="btn btn-primary my-4">Submit</button>
        </form>
        <form action="index.php">
        <div id="emailHelp" class="form-text">For View click here... </div>
        <button type="submit" class="btn btn-primary">View Details</button>
        </form>
    </div>

</body>

</html>