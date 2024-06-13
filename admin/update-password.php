<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Chnage Password</h1>
        <br/><br/>

        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
            <tr>    
            <td>Current Password :</td>
                <td>
                    <input type="password" name="current_password" placeholder="Enter Current Password">
                </td>
            </tr>    
            <tr>    
            <td>New Password :</td>
                <td>
                    <input type="password" name="new_password" placeholder="Enter New Password">
                </td>
            </tr>   
            <tr>    
            <td>Confirm Password :</td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
            </tr> 
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                </td>
            </tr>  
            </table>
        </form>
    </div>
</div>
<?php 
         //Check wheather the submit button is clicked or not
         if(isset($_POST['submit']))
         {
            //echo "Clicked";
            //1. Get the data from form
            $id=$_POST['id'];
            $current_password = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);


            //2. Check wheather the user with current id and password exists
            $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

            //Execute Query
            $res=mysqli_query($conn, $sql);

            if($res==TRUE)
            {
                //Check wheather the data is available or not
                $count=mysqli_num_rows($res);
                if($count==1)
                {
                    //User Exists and password can be changed
                    //echo "User Exist";
                    //Wheather the new password and confirm password match
                    if($new_password==$confirm_password)
                    {
                        $new_password = md5($new_password);
                        //Update Password
                        $sql2="UPDATE tbl_admin SET
                        password='$new_password'
                        WHERE id=$id";

                        //Execute the query
                        $res2=mysqli_query($conn, $sql2);

                        //Check wheather the query is executed or not
                        if($res2==TRUE)
                        {
                            //Display Success Message
                            $_SESSION['change-pwd']="<div class='success'>Password changed Successfully.</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                            
                        }
                        else
                        {
                            //Display Error Message
                            $_SESSION['change-pwd']="<div class='error'>Something is wrong. Try again later.</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }

                    }
                    else
                    {
                        $_SESSION['pw-not-match']="<div class='error'>New Password and Confirm Password do not match</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //User does not exist set messages and redirect
                    $_SESSION['user-not-found']="<div class='error'>User not found</div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }

            }
            //3. Check wheather the new password and confirm password matches
            //4. Chnage password if all above is true
         }

?>

<?php include('partials/footer.php') ?>