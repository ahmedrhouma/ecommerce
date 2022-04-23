<?php
include "../config/connexion.php";
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /monoshop');
}
if (isset($_GET['id'])) {
    $reqP = $access->prepare("SELECT * FROM produits where id = :id");
    $reqP->bindParam('id', $_GET['id']);
    $reqP->execute();
    $product = $reqP->fetchObject();
    if (isset($_POST['edit'])) {
        $file = $product->image;
        if (isset($_FILES["image"])) {
            $target_file = '../images/' . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $file =  basename($_FILES["image"]["name"]);
            }
        }
        $req = $access->prepare("UPDATE `produits` SET `image`=:img,`nom`=:nm,`prix`=:pr,`description`=:desc  where id = :id");
        $req->bindParam(':id', $_GET['id']);
        $req->bindParam(':nm', $_POST['name']);
        $req->bindParam(':img', $file);
        $req->bindParam(':pr', $_POST['price']);
        $req->bindParam(':desc', $_POST['description']);
        $req->execute();
        if ($req->rowCount() != 0) {
            $success = true;
        } else {
            $success = false;
        }
        $reqP->execute();
        $product = $reqP->fetchObject();
    }
} else {
    header('Location: produits.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produit</title>
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
        <h1 class="heading">Edit Produit <span>Panier</span></h1>
        <?php
        if (isset($success)) {
            if ($success) {
                echo '<div class="alert alert-success" role="alert">
                    Produit a était changer avec succés.
                  </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                    Erreur !! Rien changer
                  </div>';
            }
        }
        ?>
        <div class="box-container justify-content-center">
            <form method="POST" enctype="multipart/form-data">
                <div>
                    <label for="img">Image</label>
                    <input type="file" class="form-control" id="img" name="image" required>
                </div>
                <div>
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $product->nom ?>" required>
                </div>
                <div>
                    <label for="price">Prix ( $ )</label>
                    <input type="number" step="0.1" class="form-control" id="price" name="price" value="<?= $product->prix ?>" required>
                </div>
                <div>
                    <label for="desc">Description</label>
                    <textarea class="form-control" id="desc" name="description"><?= $product->description ?></textarea>
                </div>

                <div>
                    <button type="submit" class="btn" name="edit">Sauvegardé les changements</button>
                </div>
            </form>
        </div>

    </section>
</body>

</html>