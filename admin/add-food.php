<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title :</td>
                    <td>
                        <input type="text" name="title" placeholder="Enter the Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description :</td>
                    <td>
                        <textarea name="des" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price :</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image :</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category :</td>
                    <td>
                    <select name="category">
                        <?php

                            //Create PHP Code to display categories from database
                            //1. Create Sql query to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //Executing the query
                            $res = mysqli_query($conn, $sql);
                            //Count the rows to check wheather we have categories or not

                            $count=mysqli_num_rows($res);

                            //If count>0 we have categories else we dont have the categories
                            if($count>0)
                            {
                                //We have categories
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get the details of categories
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id;?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //We dont have categories
                                ?>
                                <option value="0">No Categories Found</option>
                                <?php
                            }

                            //2. Display on dropdown
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Featured :</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active :</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php

        //Check wheather the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //Add the food in Database

            //1. Get the data from Form
            $title=$_POST['title'];
            $des=$_POST['des'];
            $price=$_POST['price'];
            $category=$_POST['category'];

            //Check wtheaer the radio button for featured and active is selected or not
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

            //2. Upload the image if selected
            //Check wheather the image file is selected or not and upload the image only if it is selected
            if(isset($_FILES['image']['name']))
            {
                //Get the Details of selected image
                $image_name=$_FILES['image']['name'];

                //Check wheather the image is selected and only upload after selected
                if($image_name!="")
                {
                    //Image is selected
                    //A. Rename the Image
                    //Get the extension of Image(jpg.png,gif,etc.)
                    $ext=end(explode('.',$image_name));

                    //Create new image name for image
                    $image_name="Food-Name-".rand(0000,9999).".".$ext; 

                    //B. Upload the Image
                    //Get the src path and destination path

                    //Src patch is the current location of image
                    $src = $_FILES['image']['tmp_name'];

                    //destination path for the image to be uploaded
                    $dst = "../images/food/".$image_name;

                    //Finnally upload the Food image
                    $upload= move_uploaded_file($src,$dst);

                    //Check wheather the image uploaded or not
                    if($upload==false)
                    {
                        $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        //Stop the Process
                        die();
                    }
                }
            }
            else
            {
                $image_name=""; //Setting Default value as Blank
            }

            //3. Insert into Database

            //Sql query
            $sql2="INSERT INTO tbl_food SET
            title='$title',
            discription='$des',
            price=$price,
            image_name='$image_name',
            category_id=$category,
            featured='$featured',
            active='$active'";

            //Execute the query

            $res2=mysqli_query($conn,$sql2);

            //  Check wtheaer data inserted or not
            if($res2==true)
            {
                //Data inserted successfully
                $_SESSION['add']="<div class='Success'>Data Inserted Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                $_SESSION['add']="<div class='error'>Failed to Add Food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }

            //4. Redirect with Message to Manage-food.php
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>