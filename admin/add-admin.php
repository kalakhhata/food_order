<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
    <h1>Add Admin</h1>

    <br/><br/>
    <?php 
    if(isset($_SESSION['add'])) //Checking wheather thesession is set or not
    {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    ?>
<form action="" method="POST">
    <table class="tbl-30">
        <tr>
        <td>Full Name</td>
        <td> 
            <input type="text" name="full_name" placeholder="Enter Your Name">
        </td>
        </tr>

        <tr>
        <td>User Name</td>
        <td>
            <input type="text" name="user_name" placeholder="Enter Your Username">
        </td> 
        </tr>   

        <tr>
        <td>Password</td>
        <td>
            <input type="password" name="password" placeholder="Enter Your Password">
        </td>
        </tr>

        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
            </td>
        </tr>
    </table>
</form>
    </div>
</div>
<?php include('partials/footer.php') ?>

<?php 
    //Process the value from Form and save it in Database

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //button clicked
        //echo 'Button is Clicked';

        //1. Get the data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['user_name'];
        $password = md5($_POST['password']); //Pass Encryption with md5

        //2. SQL Query to save the data into database
        $sql = "INSERT INTO tbl_admin SET 
        full_name='$full_name',
        username='$username',
        password='$password'
        ";
        
        //3. Execute the Query and Save data into database
        
       $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
       
       //4. Check wheather the Query is executed or not and data is inserted or not
        if($res==TRUE)
        {
            //echo"Data is inserted";
            //Create a session variable to display message
            $_SESSION['add']="<div class='success'>Admin Added Successfully</div>";
            //Redirect Page to Manage Admin
            header("location:".SITEURL."admin/manage-admin.php");
        }
        else
        {
            //echo "Data is not inserted";
            $_SESSION['add']="<div class='error'>Failed to Add Admin.</div>";
            //Redirect Page to Add Admin
            header("location:".SITEURL."admin/add-admin.php");
        }

      


    }
    
?>