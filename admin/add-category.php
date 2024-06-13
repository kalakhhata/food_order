<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>
        <?php
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        
        ?>
        <br><br>
        <!-- Add Category Form Starts -->
        <form method="POST" action="" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td><input type="text" name="title" placeholder="Enter the Category Title"></td>
                </tr>
                <tr>
                    <td>Image :</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured :</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active :</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category"class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Category Form Ends -->
        
        <?php 
        //Check wheather the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //echo "Submit Clicked";
            
            //1. Get the values from category form
            $title=$_POST['title'];
            if(isset($_POST['featured']))
            {
                $featured=$_POST['featured'];
            }
            else
            {
                $featured="No";
            }
            if(isset($_POST['active']))
            {
                $active=$_POST['active'];
            }
            else
            {
                $active="No";
            }

            //Check wheather the image is selected or not and set the value for image name accordingly
            //print_r($_FILES['image']);
            if(isset($_FILES['image']['name']))
            {

                //Upload the Image
                //To Upload the image name we need source path and destination path

                $image_name = $_FILES['image']['name'];

                //upload the Image name if only image is selected
                if($image_name!="")
                {

                
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
                        header('location:'.SITEURL.'admin/add-category.php');
                        //Stop the Process
                        die();
                    }
                }


            }
            else
            {
                //Dont upload the image and set up  the value as blank
                $image_name="";
            }
            //2. Create a SQL Query to insert the data into database
            $sql="INSERT INTO tbl_category (title,image_name,featured,active) VALUES ('$title','$image_name','$featured','$active')";
           

            //3. Execute the Query
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
            //4. Check wheather the Query successfully Executes or not
            if($res==true)
            {
                //Query executed and category added
                $_SESSION['add']="<div class='success'>Category Added Successfully</div>";
                //Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                //Failed to add category
                $_SESSION['add']="<div class='error'>Failed to Add Category</div>";
                //Redirect to Add Category Page
                header('location:'.SITEURL.'admin/add-category.php');
            }
            
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>

</body>
</html>




