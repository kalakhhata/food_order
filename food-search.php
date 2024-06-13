<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on Your Search <a href="#" class="text-white"><?php if(isset($_POST['search'])){ echo $_POST['search']; }?></a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            //Get search keyword

            if(isset($_POST['search']))
            {

            
            $search = mysqli_real_escape_string($conn,$_POST['search']);

            //Sql Query to get foods based on search keyword
            $sql ="SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR discription LIKE '%$search%'";

            //Execute the query
            $res = mysqli_query($conn, $sql);

            //Count rows
            $count = mysqli_num_rows($res);

            //Check wheather the food is available
            if($count>0)
            {
                //Food Available
                while($row=mysqli_fetch_assoc($res))
                {
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['discription'];
                $image_name = $row['image_name'];
                ?>
                <div class="food-menu-box">
                <div class="food-menu-img">
                    <?php
                        if($image_name=="")
                        {
                            echo "<div class='error' >Image Not Available.</div>";
                        }
                        else
                        {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>" class="img-responsive img-curve">
                            <?php
                        }
                    ?>
                    
                </div>

                <div class="food-menu-desc">
                    <h4><?php echo $title; ?></h4>
                    <p class="food-price"><?php echo "$ ".$price; ?></p>
                    <p class="food-detail">
                    <?php echo $description; ?>
                    </p>
                    <br>

                    <a href="#" class="btn btn-primary">Order Now</a>
                </div>
            </div>
            <?php
                }

            }
            else
            {
                ?>
                    <h4 class="error text-center">Food Not Available</h4>
                <?php
            }
            


        }
            ?>

            

           

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->
<?php include('partials-front/footer.php'); ?>