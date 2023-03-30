<?php 

    //check login or not
    if(!isset($_SESSION['user']))//if not set session
    {
        //user is not log in and  redirect to login page

        $_SESSION['no-login-massage'] = "<div class='error text-center'>Please loging to access Admin Panel.</div>";
        header('location:'.SITEURL.'admin/login.php');
            
        
    }

?>