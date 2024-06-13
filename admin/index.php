<?php include('partials/menu.php'); ?>       
       <!-- Main content Section Starts -->
       <div class="main-content">
            <div class="wrapper">
            <h1>Dashboard</h1>
            <?php 
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br><br>

            <div class="col-4 text-center">

            <?php
                //SQL Query
                $sql="SELECT * FROM tbl_category";
                //Execute Query
                $res = mysqli_query($conn, $sql);
                //Count Rows
                $count = mysqli_num_rows($res);
            ?>
                <h1><?php echo $count; ?></h1>
                <br>
                Categories
            </div>
            <div class="col-4 text-center">
            <?php
                $sql1="SELECT * FROM tbl_food;";
                //Execute the query
                $res1=mysqli_query($conn, $sql1);
                //count rows
                $count1 = mysqli_num_rows($res1);
            ?>
                <h1><?php echo $count1; ?></h1>
                <br>
                Foods
            </div>
            <div class="col-4 text-center">
            <?php
                $sql2="SELECT * FROM tbl_order";
                
                $res2=mysqli_query($conn, $sql2);

                $count2=mysqli_num_rows($res2);

            ?>
                <h1><?php echo $count2; ?></h1>
                <br>
                Total Orders
            </div>
            <div class="col-4 text-center">
                <?php
                    //Create the sql query to get total revenue generated
                    //Using Aggregate function in SQL
                    $sql3 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                    //Execute the Query
                    $res3 = mysqli_query($conn, $sql3);

                    //Get the total value
                    $row = mysqli_fetch_assoc($res3);
                    $total_revenue = $row['Total'];
                ?>
                <h1>$<?php echo $total_revenue; ?></h1>
                <br>
                Revenue Generateds
            </div>
            <div class="clearfix"></div>
        </div>
       </div>
       <!-- Main content Section Ends -->

     <?php include('partials/footer.php'); ?>