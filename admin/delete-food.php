<?php 
include('../config/constants.php');

//Check wheather the id and image_name is available
if(isset($_GET['id']) && isset($_GET['image_name']))
{
    //id and image is available
    //echo "All Set with ID and Image";

    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    
    //Delete the image from file
    if($image_name!="")
    {
        //Create a path of Image
        $path = "../images/food/".$image_name;
        //Remove the image 
        $remove = unlink($path);
        //Check wheather the Image is removed or not
        if($remove==false)
        {
            $_SESSION['remove'] = "<div class='error'>Failed to Delete Image.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            die();
        }
    }

    //Delete the data from the database

    //Create the Sql query
    $sql= "DELETE FROM tbl_food WHERE id=$id";
    //Execute the query
    $res = mysqli_query($conn, $sql);
    //Check wheather the data deleted or not
    if($res==true)
    {
        $_SESSION['delete']="<div class='success'>Data Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        $_SESSION['delete']="<div class='error'>Failed to Delete Data.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
}
else
{
    //Redirect to the manage-food.php
    header('location:'.SITEURL.'admin/manage-food.php');
}
?>