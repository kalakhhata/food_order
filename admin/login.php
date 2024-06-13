<?php include('../config/constants.php') ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login - Food Order System</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
        <h1 class="text-center">Login</h1>
        <?php 
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if(isset($_SESSION['no-login-message']))
        {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br><br>

        <!--Login Forms Starts Here -->
        <form method="POST" class="text-center">
           Username :<br>
           <input type="text" name="username" placeholder="Enter Your Username"><br><br>
           Password :<br>
           <input type="password" name="password" placeholder="Enter Your Password"><br><br>

           <input type="submit" name="submit" value="Login" class="btn-primary">
           <br><br>
        </form>
        <!--Login Forms Ends Here -->
        
        
        <p class="text-center">Created By <a href="#">Om Patel</a></p>
        </div>
              
    </body>
</html>

<?php 

//Check wheather the submit button is clicked
if(isset($_POST['submit']))
{
    //Process for login
    //1. Get the data from login
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5($_POST['password']);

    //2. Sql query to check wheather the user with username and password exists or not
    $sql= "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    //3. Execute the query
    $res=mysqli_query($conn,$sql);

    //4. Count rows wheather the user existes or not
    $count = mysqli_num_rows($res);

    if($count==1)
    {
        //user available and login success
        $_SESSION['login']="<div class='success text-center'>Login Successful</div>";
        $_SESSION['user']=$username; //Check wheather the user is logedin or not
        
        header('location:'.SITEURL.'admin/');
    }
    else
    {
        //user not available and login fail
        $_SESSION['login']="<div class='error text-center'>Login Failed</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
}
?>