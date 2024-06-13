<?php 
    include('partials/menu.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        <?php 
            //Check wheather the id is set or not
            if(isset($_GET['id']))
            {
                //Get the ID and all other data
                //echo "Get data";
                $id=$_GET['id'];
                //Create sql query to get all the data
                $sql="SELECT * FROM tbl_category WHERE id=$id";
                //Execute the query
                $res=mysqli_query($conn, $sql);
                //Count the rows to check wheather the id is correct or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Get the data
                    $row = mysqli_fetch_assoc($res);
                    $title=$row['title'];
                    $current_image=$row['image_name'];
                    $featured=$row['featured'];
                    $active=$row['active'];
                }
                else
                {
                    //Redirect to Manage Category with Message
                    $_SESSION['no-category-found']="<div class='error'>No Data Found</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                
            }
            else
            {
                //Redirect to Manage Category with session message
                $_SESSION['dnf']="Date Not Found.";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image :</td>
                    <td>
                        <!-- Image will be displayed here -->
                        <?php
                            if($current_image!="")
                            {
                                //Display the Image
                                ?>
                                <img width="150px" src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>">
                                <?php
                            }
                            else
                            {
                                //Display the Message
                                echo "<div class='error'>Image Not Added.</div>";
                            }
                        ?>
                        
                    </td>
                </tr>
                <tr>
                    <td>New Image :</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured :</td>
                    <td>
                        <input <?php if($featured=="Yes"){ echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                        <input <?php if($featured=="No"){ echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active :</td>
                    <td>
                        <input <?php if($active=="Yes"){ echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                        <input <?php if($active=="No"){ echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>";>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">     
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //1. Get All the values from form
                $id=$_POST['id'];
                $title=$_POST['title'];
                $current_image=$_POST['current_image'];
                $featured=$_POST['featured'];
                $active=$_POST['active'];
                //2. Updating New Image if selected
                //Check wheather the Image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //Get The image details
                    $image_name=$_FILES['image']['name'];
                    if($image_name!="")
                    {
                        //image availabe
                        //Upload the new image and remove the current image
                        //Auto Rename our Image
                    //Get the Extension of our Image (jpg, png, gif, etc) e.g. "special.food1.jpg"
                    $var= explode('.', $image_name);
                    $ext = end($var);

                    //Rename the Image
                    $image_name = "Food_Category_".rand(000,999).".".$ext; //Food_Category_834.jpg

                    
                    $source_path = $_FILES['image']['tmp_name'];
                    
                    $destination_path = "../images/category/".$image_name;

                    // Finally Upload the Image
                    $upload = move_uploaded_file($source_path,$destination_path);

                    //Check wheather the Image is uploaded or not
                    //And if the image is not uploaded then we will stop the process and redirect with error message
                    if($upload==false)
                    {
                        //Set Message
                        $_SESSION['upload']="<div class='error'>Failed to Upload the Image.</div>";
                        //Redirect to add category page
                        header('location:'.SITEURL.'admin/manage-category.php');
                        //Stop the Process
                        die();
                    }
                    //B. Remove the Current Image if available
                    if($current_image!="")
                    {
                        $remove_path="../images/category/".$current_image;
                        $remove = unlink($remove_path);
                        //Check wheater the Image is removed or not
                        //If failed to remove then display message and stop the process
                        if($remove==false)
                        {
                            $_SESSION['failed-remove']="<div class='error'>Failed to remove the Current Image</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die(); // Stop the process
                        }
                    }
                   
                    }
                    else
                    {
                        $image_name=$current_image;
                    }
                }
                else
                {
                    $image_name=$current_image;
                }

                //3. Update the Database
                $sql2="UPDATE tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                WHERE id=$id
            ";
            //Execute the query
            $res2=mysqli_query($conn, $sql2);

                //4. Redirect to Manage Category With Message 
                //Check wheather the query is executed or not
                if($res2==true)
                {
                    $_SESSION['update']="<div class='success'>Category Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update']="<div class='error'>Failed to Update Category.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }



            }
        ?>
    </div>
</div>
<?php 
    include('partials/footer.php');
?>