<?php

session_start();
echo $_SESSION['email'];
$diaryData = "";
if(array_key_exists("id",$_COOKIE))
{
    $_SESSION['id'] = $_COOKIE['id'];
}
if(array_key_exists("id",  $_SESSION)){
    include("connection.php");
    $userMail = $_SESSION['email'];
    echo  "<p>looged in  <a href='index.php?logout=1'>log out!</a></p>";
    $query ="SELECT `text` FROM `secret_diary` WHERE email= '$userMail' LIMIT 1";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    $diaryData = $row['text'];
}
else{

    header("Location: index.php");  
}
?>



<?php include("header.php") ?>

<div class="container-fluid">
    <textarea class="form-control" id="myDiary" placeholder="My dear diary..."> <?php echo $diaryData; ?></textarea>

</div>

<?php include("footer.php") ?>
