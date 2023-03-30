<?php

    include('../admin/confiq/constants.php');

    //1. get the id of admin to be deleted
    echo $id = $_GET['id'];

    //2. create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //execute the quary
    $res = mysqli_query($conn, $sql);

    //check query
    if($res==true)
    {
        //echo "Admin Deleted";
        //create session
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
        //redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //echo "failed";
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again.</div>";
        //redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3. redirect to manage admin page with massage



?>