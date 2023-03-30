<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br/> <br/> 

        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>
                <br> <br> <br>
        <form action=""method="post">

        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td><input type="text" Name="full_name" placeholder="Enter Your Name"></td>
            </tr>
            <tr>
                <td>Username: </td>
                <td><input type="text" Name="username" placeholder="Your Username"></td>
            </tr>            <tr>
                <td>Password: </td>
                <td><input type="password" Name="password" placeholder="Your Password"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" Name="submit" value="Add Admin" class="btn-secondary">
                </td>
            </tr>

        </table>
    </div>

</div>

<?php include('partials/footer.php');?>

<?php
    //process the value from form and save it in database
    //check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        //button clicked
        //echo "Button Clicked";

        //1.get the data fro form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //password encryption with md5

         //2.sql query to save the data into database
         
         $sql = "INSERT INTO tbl_admin set
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        //3. executing query and saving date into datebase
       
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //4.check quary is executed

        if($res==TRUE)
        {
            //date inserted
            //echo "data inserted";
            //create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
            //redirect page  to manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //failed to date inserted
            //echo "failed to data inserted";
            //create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
            //redirect page to add admin
            header("location:".SITEURL.'admin/add-admin.php');

        }
        

    }


            
        
?>