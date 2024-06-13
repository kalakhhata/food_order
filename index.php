<?php include('partials-front/menu.php'); ?>




    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php 

            if(isset($_SESSION['order']))
            {
                echo $_SESSION['order'];
                unset($_SESSION['order']);
            }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php 
                 $sql="SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                 
                 $res=mysqli_query($conn,$sql);
                 
                 $count = mysqli_num_rows($res);
                 if($count>0)
                {
                    //get the categories
                   while($row=mysqli_fetch_assoc($res))
                   {
                        $id=$row['id'];
                        $title=$row['title'];
                        $image_name=$row['image_name'];
                        ?>
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                //check wheathr the image name is available
                                    if($image_name=="")
                                    {
                                        echo "<div class='error'>Image Not Available.</div>";
                                    }
                                    else
                                    {
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                             

                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>
                            
                        <?php
                   }
                    
                }
                else
                {
                    echo "<div class='error'>Category Data Not Available.</div>";
                }
            ?>

            

            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                //Get data from database
                $sql1="SELECT * FROM tbl_food WHERE featured='Yes' AND active='Yes'";
                //Execute the query
                $res1=mysqli_query($conn,$sql1);
                //Check wthaether we get the data or not
                $count1=mysqli_num_rows($res1);
                if($count1>0)
                {
                    //Data Available
                    while($row1=mysqli_fetch_assoc($res1))
                    {
                        $id=$row1['id'];
                        $title=$row1['title'];
                        $price=$row1['price'];
                        $description=$row1['discription'];
                        $image_name=$row1['image_name'];
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php

                                if($image_name=="")
                                {
                                    echo "<div class='error'>Image Not Available.</div>";
                                }
                                else
                                {
                                   ?> 
                                   <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>" class="img-responsive img-curve"> 
                                   <?php
                                   //echo $image_name;
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

                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                </div>
            </div>

                        <?php
                    }
                }
                else
                {
                    //Data Not Available
                    echo "<div class='error'>Data Not Available.</div>";
                }
            ?>

            

           

            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

   <?php include('partials-front/footer.php'); ?>