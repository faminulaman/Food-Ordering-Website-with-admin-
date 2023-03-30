<?php include('../admin/confiq/constants.php');
?>

<html>
    <head>
        <title>Login - Food Heist</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>
            <?php 
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                    if(isset($_SESSION['no-login-massage']))
                    {
                        echo$_SESSION['no-login-massage'];
                        unset($_SESSION['no-login-massage']);
                    }
            ?>
            <br><br>

            <!-- loging start -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"><br><br>
                Password: <br>
                <input type="password" name="password" placeholder="Password"><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary">
                <br><br>

            </form>


            <!-- loging end -->

            <p class="text-center">Created by - <a href="www.adios.com">Adios</a></p>

        </div>
    </body>
</html>

<?php 
    //check the button
    if(isset($_POST['submit']))
    {
        //1. get data for login
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. sql to check pass and username
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. execute
        $res = mysqli_query($conn, $sql);

        //4. count rows to check user exists
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //user available and login
            $_SESSION['login'] = "<div class='success'> Login Successfully.</div>";
            $_SESSION['user'] = $username;
            header('location:'.SITEURL.'admin/');
            

        }
        else
        {
            //user not avilable
            $_SESSION['login'] = "<div class='error text-center'> Login Not Successfully. Try Again.</div>";
            header('location:'.SITEURL.'admin/login.php');
        }

    }

?>
