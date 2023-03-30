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

        <!--Add Category starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Feature: </td>
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <!--Add Category end -->

        <?php
        
            //check button
            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //1. get the value
                $title = $_POST['title'];

                //for radio input
                if(isset($_POST['featured']))
                {
                    //get the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //set the defualt value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    //get the value from form
                    $active = $_POST['active'];
                }
                else
                {
                    //set the defualt value
                    $active = "No";
                }

                //check image selected or not 
                //print_r($_FILES['image']);

                //die();
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
                            $dst = "../images/category/".$image_name;

                            //finally upload image
                            $upload = move_uploaded_file($src, $dst);

                            //check image upoloded or not
                            if($upload==false)
                            {
                                //failed to upload
                                //redirect to add food page
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                                header('location:'.SITEURL.'admin/add-category.php');
                                //stop the process
                                die();
                            }

                        }

                    }
                    else
                    {
                        $image_name = "";
                    }

                

                //2. sql query to insert category
                $sql = "INSERT INTO tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                ";

                //3. execute query and save in database
                $res = mysqli_query($conn, $sql);

                //4. check query executed
                if($res==true)
                {
                    //category add
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to add
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                    //redirect page to add admin
                    header("location:".SITEURL.'admin/add-category.php');
                }
            }
        
        ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>