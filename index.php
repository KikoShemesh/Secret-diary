<?php
/*
TODO - If user exist with ajax

*/


include("connection.php");

session_start();

// Create connection

$error = "";

if(array_key_exists('logout',$_GET))
{
    //unset($_SESSION);
    setcookie("customerId" , "" , time () - 60 * 60); 
    $_COOKIE["id"]= "";

}


else if ((array_key_exists('id',$_SESSION) && $_SESSION['id'] ) || (array_key_exists('id',$_COOKIE)&& $_COOKIE['id']) ){
    header("Location: main.php");
}

if(array_key_exists('submit',$_POST))
{
    if(!$_POST["email"])
    {
        $error .= "<p>email is requried</p>";


    }
    if(!$_POST["password"])
    {
        $error .= "<p>password is requried</p>";

   }

   if($error != "")
      {
      $error ="There is error(s) in your form: ".$error;
    }
    else{

        if($_POST['actionBtn'] == '1')
        {
            $query ="SELECT id FROM `secret_diary` WHERE email ='".mysqli_real_escape_string($conn,$_POST['email'])."'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)>0){
                echo "<p>email allready exist</p>";
            }
            else
                {
          // $query ="INSERT INTO `secret_diary`(`email`,`password`) VALUES ('".mysqli_real_escape_string($conn,$_POST['email'])."','".mysqli_real_escape_string($conn,$_POST['password'])."')";
          //$query ="INSERT INTO `secret_diary`(`email`,`password`) VALUES ('kai.shemesh@gmail.com','129873')";
            $query ="INSERT INTO `secret_diary`(`email`,`password`,`text`) VALUES ('".mysqli_real_escape_string($conn,$_POST['email'])."','".mysqli_real_escape_string($conn,$_POST['password'])."','')";

        
          if(mysqli_query($conn,$query)){
              //hash to secure the password
            $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $query ="UPDATE `secret_diary` SET password = '$hash' WHERE `id`=".mysqli_insert_id($conn)." LIMIT 1";
            mysqli_query($conn,$query);
            $_SESSION['id'] = mysqli_insert_id($conn); 
            
            $_SESSION['email'] = $_POST['email'];
            //echo $_SESSION['email'];

            if($_POST['rememberMeCheckBox'] ==1 )
              {
               setcookie("id" , mysqli_insert_id($conn) , time () + 60 * 60 * 24); 
                }
            header("Location: main.php");           
           
        }
        else{
            echo "error!";
        }
        }
    }
    else{
        $query ="SELECT * FROM `secret_diary` WHERE email ='".mysqli_real_escape_string($conn,$_POST['email'])."'";
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_array($result);
        //$hashPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
        
        if (password_verify($_POST["password"], $row["password"])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            echo $_SESSION['email'];

            if($_POST['rememberMeCheckBox'] ==1 )
            {
             setcookie("id" , $row['id'] , time () + 60 * 60 * 24); 
            }
            header("Location: main.php");     
        
        } else {
            echo "not match";
        }


    }
    }
   
}



?>

<?php include("header.php") ?>


    <div class="container">
        <h1>My Secret Diary</h1>
        <div id="errorDiv">
            <?php echo $error; ?> </div>
        <form method="post"  id="signUpForm">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="password">
            </div>
           <div class="form-check">
             <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="rememberMeCheckBox">
               Remmber me
                </label>
            </div>
            <!- the hidden button is for we know what form to send ->
            <input type="hidden" name="actionBtn" value="1">
            <div class="form-group">
                <input type="submit"  class="btn btn-success" name="submit" value="register">
            </div>
            <p> Already have an account? <a class="showLogInForm" >Sign in </a></p>
        </form>


        <form method="post" id="logInForm">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="email">
            </div>
            <div class="form-group">
                <input type="password"  class="form-control" name="password" placeholder="password">
            </div>
             <div class="form-check">
             <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="rememberMeCheckBox">
                Remmber me
                </label>

            </div>



            <input type="hidden" name="actionBtn" value="0">
            <div class="form-group">
                <input type="submit" class="btn btn-success"  name="submit" value="sign in">
            </div>
            <p> dont have an account? <a class="showLogInForm" >Sign up! </a></p>

        </form>
    </div>

    <?php include("footer.php") ?>

