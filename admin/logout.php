<?php 

include('../admin/confiq/constants.php');

    //1. destroy session
    session_destroy();

    //2.redirect to login page

    header('location:'.SITEURL.'admin/login.php');

?>