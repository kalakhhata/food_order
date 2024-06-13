<?php
ob_start(); // Start output buffering
include('partials/menu.php');
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
         
        <?php
        //Write php code to get the data from database

        //Check if we have the id or not
        if(isset($_GET['id']))
        {
            //Get the id
            $id=$_GET['id'];
            //Create the sql query to get data from database
            $sql1="SELECT * FROM tbl_food WHERE id=$id";
            //Execute the query
            $res=  mysqli_query($conn, $sql1);
            //Check if we get any data or not
            $count=mysqli_num_rows($res);
            if($count==1)
            {
                //it gets the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $discription = $row['discription'];
                $price = $row['price'];
                $current_image = $row['image_name'];
                $current_category = $row['category_id'];
                $featured = $row['featured'];
                $active = $row['active'];
            }
            else
            {
                //it does not have any data
                $_SESSION['cnf']="<div class='error'>Data Not Found.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }

        }
        else
        {
            $_SESSION['dnf']="<div class='error'>Couldn't Procedd The Request.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Discription :</td>
                    <td>
                    <textarea name="des" cols="30" rows="5"><?php echo $discription; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price :</td>
                    <td>
                        <input type="number" value="<?php echo $price; ?>" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Current Image :</td>
                    <td>
                        <?php 

                            if($current_image!="")
                            {
                                ?>
                                    <img width="150px" src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" >
                                <?php

                            }
                            else
                            {
                                echo "<div class='error'>Image Not Added.</div>";
                            }
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image :</td>
                    <td>
                        <input type="file" name="new_image">
                    </td>
                </tr>
                <tr>
                    <td>Category :</td>
                    <td>
                        <select name="category">
                            <?php
                                //Query to get active category
                                $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //Execute the query
                                $res2=mysqli_query($conn, $sql2);
                                //Check if we get any data or not
                                $count1=mysqli_num_rows($res2);
                                if($count1>0)
                                {
                                    //Display the category
                                    while($row1=mysqli_fetch_assoc($res2))
                                    {
                                        $category_title = $row1['title'];
                                        $category_id = $row1['id'];
                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                            <option value="<?php echo $category_id; ?>" <?php if($current_category==$category_id){echo "selected";} ?>><?php echo $category_title; ?></option>
                                        <?php
                                    }

                                }
                                else
                                {
                                    //Display the message
                                    echo "<option value='0'>No Category Available</option>";
                                }
                            ?>
                    </td>
                </tr>
                <tr>
                    <td>Featured :</td>
                    <td>
                        <input <?php if($featured=="Yes"){ echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        
                        <input <?php if($featured=="No"){ echo "checked"; } ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>    
                    <td>Active :</td>
                    <td>
                        <input <?php if($active=="Yes"){ echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        
                        <input <?php if($active=="No"){ echo "checked"; } ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" class="btn-secondary" value="Update Food"> 
                    </td>
                </tr>
            </table>

        </form>

        <?php
            if(isset($_POST['submit']))
            {
                //echo "Button Clicked";
                //1. Get all the data from form
                $id = $_POST['id'];
                $title =$_POST['title'];
                $description = $_POST['des'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Upload the image if selected

                if(isset($_FILES['new_image']['name']))
                {
                   
                    $image_name = $_FILES['new_image']['name']; //new image name

                    //Check wheather the file is available or not
                    if($image_name!="")
                    {
                        //Image is available
                        //get the extension
                        $var= explode('.', $image_name);
                        $ext = end($var);

                        $image_name = "Food-Name-".rand(0000,9999).'.'.$ext; //This will be renamed image

                        //Get the source path and destination path
                        $src_path = $_FILES['new_image']['tmp_name']; //Source path
                        $dest_path = "../images/food/".$image_name; //Destination path

                        //Upload the image
                        $upload = move_uploaded_file($src_path,$dest_path);

                        //Check wheather the image is uploaded or not

                        if($upload==false)
                        {
                            //Failed to upload
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload new Image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the process
                            die();
                        }
                        
                        //3. Remove the image if new image is uploaded and current image exists

                        //Remove the current image if available
                        if($current_image!="")
                        {
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);

                            //CHECK WHETHAER THE IMAGE IS REMOVED OR NOT
                            if($remove==false)
                            {
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove the Image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
                            }
                        }
                    }
                    else
                    {
                    $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                


                //4. Update the food in database
                $sql3="UPDATE tbl_food SET
                title='$title',
                discription = '$description',
                price=$price,
                image_name='$image_name',
                category_id='$category',
                featured='$featured',
                active='$active'
                WHERE id=$id";

                //Execute the sql query
                $res3 = mysqli_query($conn,$sql3);

                //Check wheather the query is executed or not
                if($res3==true)
                {
                    $_SESSION['update']="<div class='success'>Data Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['update']="<div class='success'>Failed to Update the Data.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                //Redirect to Manage food with session message
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>