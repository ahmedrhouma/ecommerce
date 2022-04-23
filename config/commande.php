<?php
function ajouter($image, $nom, $prix, $desc)
{
    if (require("connexion.php")) {
        $req = $access->prepare("INSERT INTO produits (image,nom,prix,description) VALUES (:img,:nom,:prix,:desc)");
        $req->bindParam(':img',$image);
        $req->bindParam(':nom',$nom);
        $req->bindParam(':prix',$prix);
        $req->bindParam(':desc',$desc);
        $req->execute();
        $req->closeCursor();
    }
}
function afficher()
{
    if (require("connexion.php")) {
        $req = $access->prepare("SELECT * FROM produits ORDER BY id DESC");
        $req->execute();
        $date = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
    }
}
function supprimer($id)
{
    if (require("connexion.php")) {
        $req = $access->prepare("DELETE * FROM produits WHERE id=?");
        $req->execute(array($id));
    }
}
