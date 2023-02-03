<?php
 require 'particlas\_dbconnect.php';
    $sql = "SELECT * FROM `user`";
    $result = mysqli_query($conn, $sql);
    $num=mysqli_num_rows($result);
    $num1=1;
    if ($num>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            
            $new = htmlspecialchars('http://localhost/registration/particlas/uploadedpics/'.$row['profile'].'', ENT_QUOTES);
            // $new = htmlspecialchars('"/registration/particals/uplodedpics/"', ENT_QUOTES);
        
            echo" <tr>
            <td>".$num1." </td>
            
            <td><img src=$new> </td>
            <td>".$row ['firstname']." ".$row ['lastname']." </td>
            <td>".$row ['email']."</td>
            <td>".$row ['hobbies']."</td>
            <td>".$row ['gender']."</td>
            <td>".$row ['designation']."</td>
            <td>".$row ['mobile']."</td>
            <td><button class='edit btn btn-sm btn-primary' id=e".$row['sno'].">EDIT</button>  <button class='delete btn btn-sm btn-primary' id=".$row['sno']." >DELETE</button></td> 
          </tr>";
               $num1++;
        
           
        }
    }
    
    
?>
 