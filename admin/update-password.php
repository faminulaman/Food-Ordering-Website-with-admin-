<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" Name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" Name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" Name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" Name="id" value="<?php echo $id; ?>">
                        <input type="submit" Name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>

            </table>
        
        </form>
    </div>
</div>

<?php 

            if(isset($_POST['submit']))
            {
                //echo "clicked"; 

                //1. get data
                $id = $_POST['id'];
                $current_password = md5($_POST['current_password']);
                $new_password = md5($_POST['new_password']);
                $confirm_password = md5($_POST['confirm_password']);

                //2. check match
                $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

                //execute query
                $res = mysqli_query($conn, $sql);

                if($res==true)
                {
                    //check data available
                    $count=mysqli_num_rows($res);

                    if($count==1)
                    {
                        //echo "User Found";

                        if($new_password==$confirm_password)
                        {
                            //echo "match";
                            //update password
                            $sql2 = "UPDATE tbl_admin SET
                                password='$new_password'
                                WHERE id=$id
                            ";

                            //excute
                            $res2 =mysqli_query($conn, $sql2);

                            //check
                            if($res2==true)
                            {
                                $_SESSION['change-pwd'] = "<div class='success'>Password Changed.</div>";
                                header('location:'.SITEURL.'admin/manage-admin.php');

                            }
                            else
                            {
                                $_SESSION['change-pwd'] = "<div class='error'>Failed To Change. Try Again.</div>";
                                header('location:'.SITEURL.'admin/manage-admin.php');
                            }
                        }
                        else
                        {
                            $_SESSION['pwd-not-match'] = "<div class='error'>Password Not Match. Try Again.</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        $_SESSION['user-not-found'] = "<div class='error'>User Not Found. Try Again.</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }

            }

?>

<?php include('partials/footer.php');?>