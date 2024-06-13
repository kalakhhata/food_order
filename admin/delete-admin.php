<?php 
    //Include constant.php file here
    include('../config/constants.php');

    //1. Get the ID of Admin to be deleted
    $id = $_GET['id'];
    
    //2. Create SQL Query to delete Admin
    $sql= "DELETE FROM tbl_admin WHERE id=$id";
    
    //Ececute the Query
    $res=mysqli_query($conn, $sql);

    //Check wheather the query executed successfully or not
    if($res==TRUE)
    {
        //Query executed successfully
        //echo "Admin deleted";
        //Create a session variable to Display Message
        $_SESSION['delete']="<div class='success'>Admin Deleted Successfully</div>";
        //Redirect to Manage Admin Page
        header('location:'.SITEURL.'admin/manage-admin.php');

    }
    else
    {
        //Failed to delete Admin
        //echo "Admin not deleted";
        $_SESSION['delete']="<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    //3. Redirect to manage-admin paget with message (success/failure)
?>