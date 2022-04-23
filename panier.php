<?php
include "config/connexion.php";
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /monoshop');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

</head>

<body>



    <header>
        <div id="menu-bar" class="fas fa-bars"></div>

        <a href="#" class="logo nike">nike</a>
        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="#products">products</a>
            <a href="#featured">featured</a>
            <a href="#review">review</a>
        </nav>

        <div class="icons d-flex align-items-center">
            <a href="#" class="fas fa-heart"></a>
            <a href="panier.php" class="fas fa-shopping-cart"></a>
            <?php
            if (isset($_SESSION['id'])) {
                echo '<a href="?logout" class="fa fa-sign-out"></a>';
            } else {
                echo '<a href="login.php" class="fas fa-user"></a>';
            }
            ?>
            <a href="#"><?= isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '' ?></a>
            <?php
            if (isset($_SESSION['id'])) {
                echo '<img src="' . $_SESSION['avatar'] . '" style="width:50px;height:50px;border-radius:50%">';
            }
            ?>
        </div>
    </header>
    <section class="products" id="products" style="margin-top: 10%;">
        <h1 class="heading">Les produits de votre <span>Panier</span></h1>
        <div class="box-container">

            <?php foreach ($_SESSION['cart'] as $produit) { ?>
                <div class="box">
                    <img src="<?= $produit['image'] ?>" alt="">
                    <div class="content">
                        <h3 class="name"><?= $produit['name'] ?></h3>
                        <div class="price"><?= $produit['price'] ?></div>
                        <a href="#" class="btn deleteFromCard" data-id="<?= $produit['product_id'] ?>">Suppmiré</a>
                    </div>
                </div>
            <?php } ?>
        </div>

    </section>

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>our stores</h3>
                <a href="#">sousse</a>
                <a href="#">tunis</a>
                <a href="#">sfax</a>
                <a href="#">beja</a>
            </div>



            <div class="box">
                <h3>quick links</h3>
                <a href="/">home</a>
                <a href="#products">products</a>
                <a href="#freatured">featured</a>
                <a href="#review">review</a>
            </div>
            <div class="box">
                <h3>follow us</h3>
                <a href="#">facebook</a>
                <a href="#">twitter</a>
                <a href="#">instagram</a>
                <a href="#">linkedin</a>
            </div>
            <div class="box">
                <h3>extra links</h3>
                <a href="#">my favorite</a>
                <a href="#">my orders</a>
                <a href="aboutus.html">About uS </a>
            </div>
            <div class="box">
                <h3>Payment methods</h3>
                <a href="#">CrediT Card</a>
                <a href="#">PayPal</a>
            </div>
            <div class="box">
                <h3>Easy online shopping</h3>
                <a href="#">Try first, pay after</a>
                <a href="#">Fast delivery, free return</a>
            </div>



            <div class="credits">created by <span>Mdeda Tesnim</span> | all rights reserved </div>

        </div>

    </section>

    <script src="./main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.deleteFromCard').click(function() {
            let btn = $(this);
            $.ajax({
                url: "ajax_functions.php",
                method: 'POST',
                dataType: 'JSON',
                data: {
                    action: "removeFromCart",
                    product_id: $(this).data('id'),
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: data.message,
                        })
                        btn.closest('.box').remove();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: data.message,
                        })
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Un erreur est survenue, SVP réessayer plus tard !!",
                    })
                }
            })
        });
    </script>
</body>

</html>