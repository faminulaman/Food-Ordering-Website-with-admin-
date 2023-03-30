<?php include('partials-front/menu.php'); ?>

<?php 

    if(isset($_GET['category_id']))
    {
        $category_id = $_GET['category_id'];
        // get category title base on if
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($res);

        $category_title = $row['title'];
    }
    else
    {
        header('location:'.SITEURL);
    }

?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

                //display all the categories
                //sql query
                $sql2 = "SELECT * FROM tbl_food Where category_id=$category_id";

                $res2 = mysqli_query($conn, $sql2);

                $count2 = mysqli_num_rows($res2);

                //check available
                if($count2>0)
                {
                    //category available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        //get the values like id,title
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>

                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php 
                                            //check image is available or not
                                            if($image_name=="")
                                            {
                                                //display message
                                                echo "<div class='error'>Image not Available.</div>";
                                            }
                                            else
                                            {
                                                //image available
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                                <?php
                                            }
                                        ?>

                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price">$<?php echo $price; ?></p>
                                    <p class="food-detail">
                                    <?php echo $description; ?>
                                    </p>
                                    <br>

                                    <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>


                        <?php
                    }
                }
                else
                {
                    //categories not available
                    echo "<div class='error'>Food not Available.</div>";
                }
            

            ?>

            
            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->
    
    <?php include('partials-front/footer.php'); ?>