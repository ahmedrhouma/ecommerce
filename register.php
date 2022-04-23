<?php
include "config/connexion.php";
if (isset($_POST['save'])) {
    $req = $access->prepare("SELECT * FROM users where email=:em");
    $req->bindParam(':em', $_POST['email']);
    $req->execute();
    $user = $req->fetchObject();
    if (!$user) {
        try {
            $target_file = 'uploads/' . basename($_FILES["avatar"]["name"]);
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
            //encrypt password before insert to database
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $req = $access->prepare("INSERT INTO users (first_name,last_name,email,password,avatar,role,status) values (:fn,:ln,:em,:pwd,:pic,'ROLE_USER',1)");
            $req->bindParam(':fn', $_POST['first_name']);
            $req->bindParam(':ln', $_POST['last_name']);
            $req->bindParam(':em', $_POST['email']);
            $req->bindParam(':pwd', $password);
            $req->bindParam(':pic', $target_file);
            $req->execute();
            if ($req->rowCount() != 0) {
                session_start();
                $_SESSION['first_name'] = $_POST['first_name'];
                $_SESSION['avatar'] = $target_file;
                $_SESSION['cart'] = [];
                $_SESSION['id'] = $access->lastInsertId();
                header('Location: /monoshop');
                echo 'Welcome you are subscribed';
            } else {
                echo 'Ghalet manedrouch 3leh';
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    } else {
        echo 'email already exist !!!! baaadel ';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body style="height: 100%;
	width: 100%;
	background-image: linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)),url(BG.jpg);
	background-position: center;
	background-size: cover">
    <link rel="stylesheet" href="test.css">
    <div class="navbar">
        <nav>
            <ul id='MenuItems'>
                <li><a href='index.php'>Home</a></li>
                <li><a href='aboutus.html'>About Us</a></li>
            </ul>
        </nav>
    </div>
    <form method="POST" action="" enctype="multipart/form-data" style="width:380px;height:530px;position:relative;margin:2% auto;background:rgba(0,0,0,0.3);padding:10px;overflow: hidden;">
        <p style="text-align:center;color:#F3DBCF">I am a NEW CUSTOMER, I create my account </p>
        <div>
            <label style="color:#F3DBCF" for="first_name">First name</label>
            <input type="text" name="first_name" id="first_name" class="form-control">
        </div>
        <div>
            <label style="color:#F3DBCF" for="last_name">Last name</label>
            <input type="text" name="last_name" id="last_name" class="form-control">
        </div>
        <div>
            <label style="color:#F3DBCF" for="pic">AVATAR</label>
            <input type="file" name="avatar" id="pic" class="form-control">
        </div>
        <div>
            <label style="color:#F3DBCF" for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div>
            <label style="color:#F3DBCF" for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <br>
        <div>

            <button style="background-color:#DE5B6D;color:#F3DBCF;width:360px" type="submit" class="btn btn-primary" name="save">Save</button>
        </div>
        <span style="color:#F3DBCF">Account <a style="color:#F3DBCF" href="login.php">already exist</a></span>
    </form>
</body>

</html>