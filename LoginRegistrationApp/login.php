<?php
include 'config.php';
session_start();
if (isset($_POST['submit'])){
    $email=mysqli_real_escape_string($conn, $_POST['email']);
    $password=mysqli_real_escape_string($conn, md5($_POST['password']));


    $select=mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email' AND password='$password'") or die('query failed');
    if(mysqli_num_rows($select)>0){
            $row=mysqli_fetch_assoc($select);
            $_SESSION['user_id'] = $row['id'];
            header('Location: home.php');
        }else{
            $message[]='incorrect email or password';
        }

        
    }




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Login now</h3>
            <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
            ?>
           
            <input type="email" name ="email" placeholder="Enter email" class="box" required >
            <input type="password" name ="password" placeholder="Enter password" class="box" required >
            <input type="submit" name='submit' value="login now" class="btn">
            <p>don't have an account ?<a href="register.php">register now</a></p>
        </form>
    </div>
</body>
</html>