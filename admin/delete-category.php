<?php
    //Include Constants File
    include('../config/constants.php');
    //  Check wheather the id and image_name is set or not
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Get the value and delete
        //echo "Get value and Delete";
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //Remove the phycical image file if it is availabe

        if($image_name!="")
        {
            //Image is availabe. So remove it
            $path="../images/category/".$image_name;
            echo $path;
            //Remove the image
            $remove = unlink($path); //It gives a boolean value
            //If failed to remove the image then add an error message and stop the process
            if($remove==false)
            {
                //Set the seesion message
                $_SESSION['remove']="<div class='error'>Failed to Remove the Image.</div>";
                //Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');
                //Stop the Process
                die();
            }
        }


        //Delete data from database
        $sql="DELETE FROM tbl_category WHERE id=$id";

        //Execute the query
        $res=mysqli_query($conn, $sql) or die(mysqli_error($conn));
        //echo $res;

        //Check wheather the data is deletd from database or not
        if($res==true)
        {
            //Get Success message and redirect
            $_SESSION['delete']="<dic class='success'>Data Deleted Sucessfully.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //Set failed message and redirect
            $_SESSION['delete']="<dic class='success'>Failed to Detele Category.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        //Redirect to Manage Category Page with Message 
    }
    else
    {
        //Redirect to Manage Category Page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>