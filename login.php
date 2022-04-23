<?php
include "config/connexion.php";
session_start();
if (isset($_SESSION['id'])) {
    header('Location: /monoshop');
}
$error = "";
if (isset($_POST['save'])) {
    try {
        $req = $access->prepare("SELECT * FROM users where email=:em");
        $req->bindParam(':em', $_POST['email']);
        $req->execute();
        $user = $req->fetchObject();
        if ($user) {
            if (password_verify($_POST['password'], $user->password)) {
                if ($user->status == 1) {


                    $_SESSION['avatar'] = $user->avatar;
                    $_SESSION['first_name'] = $user->first_name;
                    $_SESSION['id'] = $user->id;
                    if ($user->role == 'ROLE_USER') {
                        $_SESSION['cart'] = [];
                        header('Location: index.php');
                    } else if ($user->role == 'ROLE_ADMIN') {
                        header('Location: admin/dashboard.php');
                    }
                }else{
                    $error= "Compte Désactiver !! contacter l'administrateur de site";
                }
            } else {
                $error = 'wrong password';
            }
        } else {
            $error = 'User does not exist ';
        }
    } catch (Exception $e) {
        var_dump($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body style="height:100%;
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
    <form method="POST" action="" style="width:380px;height:380px;position:relative;margin:5% auto;background:rgba(0,0,0,0.3);padding:10px;overflow: hidden;">
        <p style="text-align:center; color:#F3DBCF">I am ALREADY A CUSTOMER, I identify myself</p>
        <p style="color:#DE5B6D"><?=$error?></p>
        <div>

            <label style="color:#F3DBCF" for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder='Enter your Email'>
        </div>

        <div>
            <label style="color:#F3DBCF" for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder='Enter Password'>
        </div>
        <input type='checkbox' class='check-box'><span style="color:#F3DBCF">Remember Password</span>
        <div>
            <br>
            <button style="background-color:#DE5B6D;color:#F3DBCF;width:360px" type="submit" class="btn btn-primary" name="save">Save</button>
        </div>
        <span style="color:#F3DBCF">Create <a style="color:#F3DBCF" href="register.php">new account</a></span>
    </form>
</body>

</html>