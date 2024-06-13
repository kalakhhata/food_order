<?php include('partials-front/menu.php'); ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                //Query to get the data from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                //Execute the query
                $res = mysqli_query($conn, $sql);
                //Check wtheather we get any data or not
                $count=mysqli_num_rows($res);
                if($count>0)
                {
                    //Data Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id=$row['id'];
                        $title=$row['title'];
                        $image_name=$row['image_name'];
                        ?>
                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php
                                        if($image_name=="")
                                        {
                                            echo "<div>Image is Not Available.</div>";
                                        }
                                        else
                                        {
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>" class="img-responsive img-curve">
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
                    //No Data Exists
                    echo "<div class='error'>No Data Exists.</div>";

                }
            ?>
           

           
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>