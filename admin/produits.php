<?php
include "../config/connexion.php";
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /monoshop');
}
$req = $access->prepare("SELECT * FROM produits");
$req->execute();
$products = $req->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

</head>

<body>



    <header>
        <div id="menu-bar" class="fas fa-bars"></div>

        <a href="#" class="logo nike">nike</a>
        <nav class="navbar">
            <a href="dashboard.php">home</a>
            <a href="produits.php">Produits</a>
            <a href="users.php">Utilisateurs</a>
        </nav>

        <div class="icons d-flex align-items-center">
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
                echo '<img src="../' . $_SESSION['avatar'] . '" style="width:50px;height:50px;border-radius:50%">';
            }
            ?>
        </div>
    </header>

    <section class="products" id="products" style="margin-top: 10%;">
        <h1 class="heading">Les produits de votre <span>Panier</span></h1>
        <div class="d-flex justify-content-center mb-4">
            <a href="addProduct.php" class="btn">Ajouter un Produit</a>
        </div>
        <div class="box-container">
            <?php foreach ($products as $produit) { ?>
                <div class="box">
                    <img src="../images/<?= $produit->image ?>" alt="">
                    <div class="content">
                        <h3 class="name"><?= $produit->nom ?></h3>
                        <div class="price"><?= $produit->prix ?></div>
                        <a href="#" class="btn delete" data-id="<?= $produit->id ?>">Suppmiré</a>
                        <a href="editProduct.php?id=<?= $produit->id ?>" class="btn">Edit</a>
                    </div>
                </div>
            <?php } ?>
        </div>

    </section>

    <script src="./main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.delete').click(function(){
            let btn = $(this);
            $.ajax({
                url : "../ajax_functions.php",
                method : 'POST',
                dataType : 'JSON',
                data : {
                    action : "deleteProduct",
                    product_id : $(this).data('id'),
                },
                success:function(data){
                    if(data.success){
                        Swal.fire({
                            icon : "success",
                            title : data.message,
                        })
                        btn.closest('.box').remove();
                    }else{
                        Swal.fire({
                            icon : "error",
                            title : data.message,
                        })
                    }
                },
                error : function(){
                    Swal.fire({
                            icon : "error",
                            title : "Un erreur est survenue, SVP réessayer plus tard !!",
                        })
                }
            })
        });
    </script>
</body>

</html>