<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php 
        //1. get id of selected admin
        $id=$_GET['id'];

        //2. create sql query
        $sql="SELECT * FROM tbl_admin WHERE id=$id";

        //execute
        $res=mysqli_query($conn,$sql);

        //check execute
        if($res==true)
        {
            //data available
            $count = mysqli_num_rows($res);
            //check admin data or not
            if($count==1)
            {
                //get the details
                //echo "Admin Available";
                $row=mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            }
            else
            {
                //redirect to manage admin page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        
        ?>

        <form action="" method="POST">
        
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" Name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                
                <tr>
                <td>Username: </td>
                <td>
                    <input type="text" Name="username" value="<?php echo $username; ?>">
                </td>
                </tr>   

                <tr>
                <td colspan="2">
                    <input type="hidden" Name="id" value="<?php echo $id; ?>">
                    <input type="submit" Name="submit" value="Update Admin" class="btn-secondary">
                </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php 
    //check the button
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";
        //get all the values from to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //sql query to  update
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id='$id'
        ";

        // execute 
        $res = mysqli_query($conn, $sql);

        //check query
        if($res==true)
        {
            $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";
            //redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            $_SESSION['update'] = "<div class='error'>Failed To Update.</div>";
            //redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');

        }
    }

?>

<?php include('partials/footer.php');?>