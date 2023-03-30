<?php
    include('../admin/confiq/constants.php');
    //echo"aa";
    
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
       //process to delete 
       //echo"delete";

       //1. get id and image name
       $id = $_GET['id'];
       $image_name = $_GET['image_name'];

       //2. remove the image
       //check image available
       if($image_name != "")
       {
        //it has image and remove it
        //get the image path
        $path = "../images/food/".$image_name;

        //remove image file
        $remove = unlink($path);

        //check the image is removed or not
        

        }

       //3. delete from  database
       $sql = "DELETE FROM tbl_food WHERE id=$id";
       //execute the query
       $res = mysqli_query($conn, $sql);

       //check the query
       //4. redirect to manage food
       if($res==true)
       {
        //food deleted
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
       }
       else
       {
        //failed to deleted
        $_SESSION['delete'] = "<div class='error'>Food Failed to Deleted.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
       }

       

    }
    else
    {
        //redirect to manage food page
        //echo"rede";
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Acess.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>