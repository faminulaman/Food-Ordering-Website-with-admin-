<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                //echo"getting";
                $id =$_GET['id'];

                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                //execute query
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                
                }
                else
                {
                    $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');

                }
            }
            else
            {
                header('location:'.SITEURL.'admin/manage-category.php');

            }
        ?>
        <br><br>

        <!--Add Category starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>"width="50px">
                                <?php

                            }
                            else
                            {
                                echo "<div class='error'>Image Not Added.</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Feature: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>" >
                        <input type="hidden" name="id" value="<?php echo $id; ?>" >
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            
            if(isset($_POST['submit']))
            {
                //1. get all values
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. updating new image
                if(isset($_FILE['image']['name']))
                {
                    $image_name = $_FILE['image']['name'];

                    if($image_name !="")
                    {
                        //$ext = end(explode('.', $image_name));

                    //$image_name = "Food_Category_".rand(000, 999).'.'.$ext;

                    $source_path = $_FILES['image']['tmp-name'];
                    
                    $destination_path = "../images/category/".$image_name;
                    //finally upload
                    $upload = move_uploaded_file($source_path, $destination_path);
                    //check
                    if($current_image!="")
                    {
                        $remove_path = "../image/category/".$current_image;

                        $remove = unlink($remove_path);

                        if($remove==false)
                        {
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove image.</div>";
                        //redirect page to add admin
                        header("location:".SITEURL.'admin/add-category.php');
                        die();
                    }

                    }

                    }
                    

                }
                else
                {
                    $image_name = $current_image;
                }

                //3. update database
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                $res2 = mysqli_query($conn, $sql2);
                //4. redirect manage category
                //check execute
                if($res2==true)
                {
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Category not Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
        ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>