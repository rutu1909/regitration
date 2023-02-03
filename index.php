<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header ("location: login.php");
exit();
}
?>

<?php
 $ShowDelete=false;
 $showEmailError=false;
 $showMobileError=false;
 $showEdit=false;

require 'particlas\_dbconnect.php';
if(isset($_GET['delete'])){
    $sno=$_GET['delete'];
    $sql="DELETE FROM `user` WHERE `user`.`sno` = '$sno'";
    $result=mysqli_query($conn,$sql);
   
  if($result){
      $ShowDelete=true;
      
   
    // echo "record inserted sucessfully";
  }
      
}
else if($_SERVER['REQUEST_METHOD']=="POST"){
    $sno=$_POST['snoedit'];
    $profile=$_FILES['profilepicedit']['name'];

$firstname=$_POST['firstnameedit'];
$lastname=$_POST['lastnameedit'];
$email=$_POST['emailedit'];
$mobile=$_POST['mobileedit'];
$sql = "SELECT * FROM `user` WHERE `sno`='$sno';";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
if(empty($profilepic)){
  $profilepic=$row['profile'];
}
if(empty($_POST['designationedit'])){
  $designation=$row['designation'];
}
else
{
  $designation=implode("",$_POST['designationedit']);
}
if(empty($_POST['hobbieedit'])){
  $hobbie=$row['hobbies'];
}
else{
  $hobbie=implode(", ",$_POST['hobbieedit']);

}
if(empty($_POST['radio-stacked-edit'])){
  $gender=$row['gender'];
}
else{
    $gender=$_POST['radio-stacked-edit'];

}

$existsql="SELECT * FROM `user` WHERE email='$email' OR mobile='$mobile'";
$result=mysqli_query($conn,$existsql);
$numExistrow=mysqli_num_rows($result);
if($numExistrow>1)
{
  $row = mysqli_fetch_assoc($result);
    if($row['email']==$email && $row['sno']!==$sno) {
      $showEmailError=true;
    }
    else if($row['mobile']==$mobile && $row['sno']!==$sno){
      $showMobileError=true;
    }
    
}
else{
    $sql="UPDATE `user` SET `firstname` = '$firstname', `lastname` = '$lastname', `profile` = '$profilepic', `email` = '$email', `hobbies` = '$hobbie', `gender` = '$gender', `designation` = '$designation', `mobile` = '$mobile' WHERE `user`.`sno` = '$sno';";
    

   
    $result=mysqli_query($conn,$sql);
    if($result){
        $showEdit=true;
    }

}
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" class="css">
  <title>Index</title>
  <style>
    img{
      height: 50px; width: 50px;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">from</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
        </li>
        
        
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
    <?php
    if($ShowDelete){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!!</strong>Your note was deleted successfully.. 
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
    if($showEdit){
     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
     <strong>Success!</strong> Record was inserted successfully...
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
 }?>
     <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModal">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="/registration/index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="snoedit" id="snoedit">
           
        <div class="mb-3 my-3">
                <label for="validationTooltip04" class="form-label">Profile Picture</label>
                <input type="file" class="form-control"id="profilepicedit" name="profilepicedit" aria-label="file example" >
    
             </div>

            <div class="col-md-12 my-3  position-relative">

                    <label for="validationTooltip01" class="form-label">First name<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="firstnameedit" name="firstnameedit" value="" required>
            </div>
            <div class="col-md-12 my-3  position-relative">

                    <label for="validationTooltip01" class="form-label">Last name<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="lastnameedit" name="lastnameedit" value="" required>
                  
            </div>
           
            <div class="col-md-4 my-3 position-relative">
                <label for="validationTooltipUsername" class="form-label">Email<span style="color: red;">*</span></label>
                <div class="input-group has-validation">
                  <input type="email" class="form-control" id="emailedit" name="emailedit" aria-describedby="validationTooltipUsernamePrepend" required>    
                </div>
            </div>
          <div class="col-md-4 position-relative my-3 d-flex">
            <label for="validationTooltip04" class="form-label">Hobbies</label>
            <div class="form-check mx-2 mb-3">
                <input type="checkbox" class="form-check-input" id="hobbieedit" name="hobbieedit[]" value="Playing" >
                <label class="form-check-label" for="validationFormCheck11">Playing</label>
               
            </div>
            <div class="form-check mx-2 mb-3">
                <input type="checkbox" class="form-check-input" id="hobbieedit"  name="hobbieedit[]" value="Reading" >
                <label class="form-check-label" for="validationFormCheck22">Reading</label>
               
            </div>
            <div class="form-check mx-2 mb-3">
                <input type="checkbox" class="form-check-input"id="hobbieedit"  name="hobbieedit[]" value="Driving">
                <label class="form-check-label" for="validationFormCheck33">Driving</label>
               
            </div>
            <div class="form-check mx-2 mb-3">
                <input type="checkbox" class="form-check-input"id="hobbieedit"  name="hobbieedit[]" value="Dancing">
                <label class="form-check-label" for="validationFormCheck33">Dancing</label>
               
            </div>
           
          </div>

            <div class="col-md-4 position-relative my-3">
                <label for="validationTooltip04" class="form-label">Designation</label>
                <select class="form-select" id="designationedit" name="designationedit[]" >
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
                <input type="radio" class="form-check-input" id="validationFormCheck01" name="radio-stacked-edit"  value="Male" required>
                <label class="form-check-label" for="validationFormCheck01">Male</label>
              </div>
              <div class="form-check mb-3">
                <input type="radio" class="form-check-input" id="validationFormCheck02" name="radio-stacked-edit" value="Female" required>
                <label class="form-check-label" for="validationFormCheck02">Female</label>
              </div>
              <div class="form-check mb-3">
                <input type="radio" class="form-check-input" id="validationFormCheck03" name="radio-stacked-edit" value="Other" required>
                <label class="form-check-label" for="validationFormCheck03">Other</label>
              </div>
            
              <div class="col-md-4 my-3  position-relative">

                <label for="validationTooltip01" class="form-label">Mobile Number<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="mobileedit" name="mobileedit" value="" required>
        </div>

            <button type="submit" class="btn btn-primary my-4">Update</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

    
     <div class=" my-5 mx-auto">
        
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Number</th>
          <th scope="col">profilepic</th>
          <th scope="col">name</th>

          <th scope="col">email</th>
          <th scope="col">hobbie</th>
          <th scope="col">gender</th>
          <th scope="col">designation</th>
          <th scope="col">mobile</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
                require 'display.php';
        ?>
      </tbody>
    </table>

     <script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
   <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit",);
        tr = e.target.parentNode.parentNode;
        profilepic = tr.getElementsByTagName("td")[1].innerText;
        firstname = tr.getElementsByTagName("td")[2].innerText.split(" ")[0];
        lastname = tr.getElementsByTagName("td")[2].innerText.split(" ")[1];
        email = tr.getElementsByTagName("td")[3].innerText;
        hobbies = tr.getElementsByTagName("td")[4].innerText;
        gender = tr.getElementsByTagName("td")[5].innerText;
        designation = tr.getElementsByTagName("td")[6].innerText;
        mobile = tr.getElementsByTagName("td")[7].innerText;

        $('#profilepicedit').val(profilepic);
        $('#firstnameedit').val(firstname);
        $('#lastnameedit').val(lastname);
        $('#emailedit').val(email);
        $('#hobbieedit').val(hobbies);
        $('#genderedit').val(gender);
        $('#designationedit').val(designation);
        $('#mobileedit').val(mobile);
        
        snoedit.value=e.target.id.substr(1, )
        console.log(snoedit);
        $('#editModal').modal('toggle');
      })
    })
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit",);
        // num=e.target.sno.substr(1,);
        // console.log(num);
        $('#snoedit').val(e.target.id);
        console.log(e.target.id);
        
        if(confirm("Press a button!")){
          console.log("yes");
          e.preventDefault();
          window.location=`/registration/index.php?delete=${e.target.id}`
        }
        else{
          console.log("no");
        }
      
      })
    })

  </script>
  
</body>
</html>