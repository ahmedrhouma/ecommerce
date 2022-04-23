<?php
include "config/connexion.php";
$action = isset($_POST['action']) ? $_POST['action'] : null;
if ($action == null) return;
session_start();
$response = ['success' => false, 'message' => 'Erreur réessayer plus tard'];
switch ($action) {
    case 'addToCart':
        if (!isset($_SESSION['cart'][$_POST['product_id']])) {
            $_SESSION['cart'][$_POST['product_id']] = ['product_id' => $_POST['product_id'], 'name' => $_POST['name'], 'price' => $_POST['price'], 'image' => $_POST['image']];
            $response = ['success' => true, 'message' => 'Produit ajouter au panier avec succées !'];
        } else {
            $response = ['success' => false, 'message' => 'Produit Déja ajouter !'];
        }
        break;
    case 'removeFromCart':
        if (isset($_SESSION['cart'][$_POST['product_id']])) {
            unset($_SESSION['cart'][$_POST['product_id']]);
            $response = ['success' => true, 'message' => 'Produit supprimé de panier avec succées !'];
        }
        break;
    case 'deleteProduct':
        $req = $access->prepare("DELETE FROM produits WHERE id=:id");
        $req->bindParam(':id', $_POST['product_id']);
        $req->execute();
        if ($req->rowCount() == 1) {
            $response = ['success' => true, 'message' => 'Produit supprimé avec succées !'];
        }
        break;
    case 'enableUser':
        $req = $access->prepare("UPDATE users set status=1 WHERE id=:id");
        $req->bindParam(':id', $_POST['user_id']);
        $req->execute();
        if ($req->rowCount() == 1) {
            $response = ['success' => true, 'message' => 'Utilisateur approuvé avec succées !'];
        }
        break;
    case 'disableUser':
        $req = $access->prepare("UPDATE users set status=0 WHERE id=:id");
        $req->bindParam(':id', $_POST['user_id']);
        $req->execute();
        if ($req->rowCount() == 1) {
            $response = ['success' => true, 'message' => 'Utilisateur Bloqué avec succées !'];
        }
        break;
    case 'deleteUser':
        $req = $access->prepare("DELETE FROM users WHERE id=:id");
        $req->bindParam(':id', $_POST['user_id']);
        $req->execute();
        if ($req->rowCount() == 1) {
            $response = ['success' => true, 'message' => 'Utilisateur Supprimé avec succées !'];
        }
        break;
}
echo json_encode($response);
