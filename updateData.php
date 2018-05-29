<?php
session_start();


if(array_key_exists("content", $_POST))
{
    include("connection.php");
    echo $_SESSION['email'];
    $userMail = $_SESSION['email'];
    $myData = $_POST["content"];
    $query ="UPDATE `secret_diary` SET text = ' $myData' WHERE email= '$userMail' LIMIT 1";
      if(mysqli_query($conn,$query))
       {
           //echo "success!".$myData;
       } 
     else
        {
            //echo "failed";
    
        }
}
  
    ?>