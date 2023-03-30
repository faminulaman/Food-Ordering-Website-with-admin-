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
                        <td>Title: </Title></td>
                        <td>
                            <input type="text" name="title" placeholder="Title of the Food.">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of the Food."></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price">
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category">

                                <?php
                                    //create php code to display categories from database
                                    //1. creat sql to get all active categories from database
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    
                                    //executing quary
                                    $res = mysqli_query($conn, $sql);

                                    //count rows to check wheather we have categories or not
                                    $count = mysqli_num_rows($res);

                                    //if count is greater than zero, we have categories we donot have categories
                                    if($count>0)
                                    {
                                        //we have categoris
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            //get the details of categories
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            ?>

                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        //we do not have categories
                                        ?>
                                        <option value="0">No Category Found</option>
                                        <?php
                                    }

                                    
                                    //2. display on dropdown
                                ?>

                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes">Yes
                            <input type="radio" name="featured" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
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

                //check button
                if(isset($_POST['submit']))
                {
                    //add the food in database
                    //echo "clicked";

                    //1. get the data from form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];

                    //check wheather radion button for featured and active are checked or not
                    if(isset($_POST['featured']))
                    {
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        $featured = "No";
                    }

                    if(isset($_POST['active']))
                    {
                        $active = $_POST['active'];
                    }
                    else
                    {
                        $active = "No";
                    }

                    //2. upload the image if selected
                    //check the select image clicked or not
                    if(isset($_FILES['image']['name']))
                    {
                        //get the details
                        $image_name = $_FILES['image']['name'];

                        //check the image is select or not and upload image only if selected
                        if($image_name!="")
                        {
                            //image is selected
                            //a. rename the image
                            //get extention
                            //$ext = end(explode('.', $image_name));

                            //$image_name = "Food_Name_".rand(000, 999).'.'.$ext;

                            //b. upload the image
                            //get the src path and destination path

                            //source path is the current location of the image
                            $src = $_FILES['image']['tmp_name'];

                            //destination path
                            $dst = "../images/food/".$image_name;

                            //finally upload image
                            $upload = move_uploaded_file($src, $dst);

                            //check image upoloded or not
                            if($upload==false)
                            {
                                //failed to upload
                                //redirect to add food page
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                                header('location:'.SITEURL.'admin/add-food.php');
                                //stop the process
                                die();
                            }

                        }

                    }
                    else
                    {
                        $image_name = "";
                    }

                    //3. insert into datebase

                    //create a sql query to save or add food
                    $sql2 = "INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                    ";

                    //executed the query
                    $res2 = mysqli_query($conn, $sql2);
                    //check data inserted
                    //4. redirect with message to mange food page
                    if($res2 == true)
                    {
                        //data inserted
                        $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        //failed to insert data
                        $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }


                }

            ?>
       
        </div>
    </div>

<?php include('partials/footer.php'); ?>