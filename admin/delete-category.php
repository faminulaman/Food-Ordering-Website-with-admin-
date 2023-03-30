<?php

    include('../admin/confiq/constants.php');
    //echo "delete";
    //check the id and image is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        //echo "gg";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove image


        //delete data from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check the data is delete
        if($res==true)
        {
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Deleted.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        //redirect to manage category 
    }
    else
    {
        //redirect to manage category
        header("location:".SITEURL.'admin/manage-category.php');
    }

?>