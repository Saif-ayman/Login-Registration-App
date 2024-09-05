<?php
include 'config.php';
if (isset($_POST['submit'])){
    $name=mysqli_real_escape_string($conn, $_POST['name']);
    $email=mysqli_real_escape_string($conn, $_POST['email']);
    $password=mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword=mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $image=$_FILES['image']['name'];
    $image_size=$_FILES['image']['size'];
    $image_temp=$_FILES['image']['tmp_name'];
    $image_folder='uploaded_img/'.$image;

    $select=mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email' AND password='$password'") or die('query failed');
    if(mysqli_num_rows($select)>0){
        $message[]='user already exists';
    }else{
        if($password!=$cpassword){
            $message[]='Password and confirm password does not match';
        }elseif($image_size > 2000000){
            $message[]='Image should not be more than 2MB';
        }else{
            $insert=mysqli_query($conn, "INSERT INTO `user_form` (name, email, password, image) VALUES ('$name', '$email', '$password', '$image')") or die('query failed');
            if($insert){
                move_uploaded_file($image_temp, $image_folder);
                $message[]='User registered successfully!';
                header('location:login.php');
            }else{
                $message[]='User registration failed!';
            }
           


        }

        
    }

}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Register now</h3>
            <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
            ?>
            <input type="text" name ="name" placeholder="Enter Name" class="box" required >
            <input type="email" name ="email" placeholder="Enter email" class="box" required >
            <input type="password" name ="password" placeholder="Enter password" class="box" required >
            <input type="password" name ="cpassword" placeholder="Confirm password" class="box" required >
            <input type="file"  name ="image"class="box" accept="image/jpg, image/jpeg, image/png" >
            <input type="submit" name='submit' value="Register now" class="btn">
            <p>already have an account ?<a href="login.php">login</a></p>
        </form>
    </div>
</body>
</html>