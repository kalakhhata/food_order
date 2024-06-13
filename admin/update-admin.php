<?php include('partials/menu.php'); ?>

<div class="main-content">
      <div class="wrapper">
      <h1>Update Admin</h1>
      <br/><br/>

      <?php
      //1 .Get the ID of Selected table
      $id=$_GET['id'];

      //2 .Create SQL Query TO GET the Details
      $sql="SELECT * FROM tbl_admin WHERE id=$id";
      
      //3 .Execute the Query
      $res=mysqli_query($conn, $sql);

      //4. Check wheather the query is executed or not
      if($res==TRUE)
      {
        //echo "Update request sent";
        //Check wheather the data is available or not
        $count = mysqli_num_rows($res);
        //Check wheather we have admin data or not
        if($count==1)
        {
            //Get the details
            $row=mysqli_fetch_assoc($res);
            $full_name=$row['full_name'];
            $username=$row['username'];

        }
        else
        {
            //Redirect to manage-admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
      }
      else
      {
        //echo "Update request failed";
      }
      ?>
      <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name :</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>User Name :</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspasn="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>
      </form>
      </div>
</div>

<?php
//Check wheather the submit button is clicked
if(isset($_POST['submit']))
{
    //echo "Button Clicked";
    //Get all the values from form to update
    $id=$_POST['id'];
    $full_name=$_POST['full_name'];
    $username=$_POST['username'];

    //Create SQL Query to update admin
    $sql = "UPDATE tbl_admin SET 
    full_name = '$full_name',
    username = '$username'
    WHERE id='$id'
    ";

    //Execute the Query
    $res=mysqli_query($conn, $sql);
    

    //Check wheather the Query executed successfully or not
    if($res==TRUE)
    {
        //Query Executed and Admin Updated
        $_SESSION['update']="<div class='success'>Admin updated Successfully.</div>";
        //Redirected to the manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        $_SESSION['update']="<div class='error'>Failed to update the Admin.</div>";
        //Redirected to the manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

}
?>
<?php include('partials/footer.php'); ?>