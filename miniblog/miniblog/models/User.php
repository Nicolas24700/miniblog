<?php
function connect_db()
{
    $db = new PDO('mysql:host=localhost;dbname=molduch_miniprojetphp;port=3306;charset=utf8','root','');
    return $db;
}

// FONCTION DE CONNEXION ET D'INSCRIPTION=======================================
function inscription($nom, $prenom, $login, $motdepasse, $motdepasse2)
{
    // On regarde si les mots de passe correspondent bien
    if ($motdepasse !== $motdepasse2) {
        return "Les mots de passe ne correspondent pas";
    }
    $db = connect_db();
    $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE login = :login");
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();

    // On regarde si le login est déjà pris
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        return "Login déjà pris";
    } else {
        $requete = "INSERT INTO utilisateurs VALUES (NULL, :login, :nom, :prenom, :motdepasse, :photo, 0)";
        $stmt = $db->prepare($requete);

        // on met l'url de la photo par défaut
        $photo = "images/uploads/profil_default.png";
        $hash = password_hash($motdepasse, PASSWORD_DEFAULT);

        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':motdepasse', $hash, PDO::PARAM_STR);
        $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
        $stmt->execute();
        return "Inscription réussie. Vous pouvez vous connecter";
    }
}
function connexion($login)
{
    $db = connect_db();
    $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE login = :login");
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// FONCTION DE RECUPERATION DE BILLET AVEC LES COMMENTAIRES ET D'AJOUT DE COMMENTAIRE==========================

function getBillets()
{
    $db = connect_db();
    $stmt = $db->query("SELECT * FROM billets, utilisateurs WHERE billets.auteur_id = utilisateurs.id_personne ORDER BY date_post DESC LIMIT 3");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getALLBillets()
{
    $db = connect_db();
    $stmt = $db->query("SELECT * FROM billets, utilisateurs WHERE billets.auteur_id = utilisateurs.id_personne ORDER BY date_post DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getCommentsByBilletId($billet_id)
{
    $db = connect_db();
    $stmt = $db->prepare("SELECT * FROM commentaires, utilisateurs WHERE commentaires.auteur_id = utilisateurs.id_personne AND commentaires.billet_id = :billet_id ORDER BY date_post DESC");
    $stmt->bindParam(':billet_id', $billet_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function addComment($billet_id, $contenu, $auteur_id)
{
    $db = connect_db();
    $requete = $db->prepare("INSERT INTO commentaires (contenu, date_post, auteur_id, billet_id) VALUES (:contenu, NOW(), :auteur_id, :billet_id)");

    $requete->bindParam(':contenu', $contenu, PDO::PARAM_STR);
    $requete->bindParam(':auteur_id', $auteur_id, PDO::PARAM_INT);
    $requete->bindParam(':billet_id', $billet_id, PDO::PARAM_INT);
    $requete->execute();
    header('Location: views/blog.php');
}
// FONCTION DU PANEL  ADMIN DE MODIFICATION / SUPPRESION / AJOUT DE BILLET ============================
function addbillet($titre, $contenu, $auteur_id, $target_file)
{
    $db = connect_db();
    $requete = $db->prepare("INSERT INTO billets (titre, contenu, date_post, auteur_id, photo_post) VALUES (:titre, :contenu, NOW(), :auteur_id, :photo_post)");
    $requete->bindParam(':titre', $titre, PDO::PARAM_STR);
    $requete->bindParam(':contenu', $contenu, PDO::PARAM_STR);
    $requete->bindParam(':auteur_id', $auteur_id, PDO::PARAM_INT);
    $requete->bindParam(':photo_post', $target_file, PDO::PARAM_STR);

    return $requete->execute();

}
function suppbillet($postId)
{
    $db = connect_db();

    $stmtdelphoto = $db->prepare("SELECT photo_post FROM billets WHERE id_billets = :supp_id");
    $stmtdelphoto->bindParam(':supp_id', $postId, PDO::PARAM_INT);
    $stmtdelphoto->execute();
    // On récupère le chemin de l'image du billet
    $profilePost = $stmtdelphoto->fetch(PDO::FETCH_ASSOC)['photo_post'];
    
    // On supprime l'image du billet si il y'a une image
    if($profilePost && file_exists($profilePost)){
            unlink($profilePost);
        }
    
// On supprime les commentaires du billet
    $stmtComments = $db->prepare("DELETE FROM commentaires WHERE billet_id = :supp_id");
    $stmtComments->bindParam(':supp_id', $postId, PDO::PARAM_INT);
    $stmtComments->execute();

    // On supprime le billet
    $stmt = $db->prepare("DELETE FROM billets WHERE id_billets = :supp_id");
    $stmt->bindParam(':supp_id', $postId, PDO::PARAM_INT);
    $stmt->execute();
}

function modifbillet($titre, $contenu)
{
    $db = connect_db();
    $requete = $db->prepare("UPDATE billets SET titre = :titre, contenu = :contenu WHERE id_billets = :id_billets");

    $requete->bindParam(':titre', $titre, PDO::PARAM_STR);
    $requete->bindParam(':contenu', $contenu, PDO::PARAM_STR);
    $requete->bindParam(':id_billets', $_POST['id_billets'], PDO::PARAM_INT);
    $requete->execute();
}

// PANEL ADMIN SUPPRESION / MODIFICATION DE COMMENTAIRES: 
function suppcomment($suppId)
{
    $db = connect_db();
    $stmtComments = $db->prepare("DELETE FROM commentaires WHERE id_commentaires = :suppcomment_id");
    $stmtComments->bindParam(':suppcomment_id', $suppId, PDO::PARAM_INT);
    $stmtComments->execute();
}
function modifcomment($contenu)
{
    $db = connect_db();

    $requete = $db->prepare("UPDATE commentaires SET contenu = :contenu WHERE id_commentaires = :id_commentaires");
    $requete->bindParam(':contenu', $contenu, PDO::PARAM_STR);
    $requete->bindParam(':id_commentaires', $_POST['id_commentaires'], PDO::PARAM_INT);
    $requete->execute();
}


// FONCTION PANEL ADMIN DE MODIFICATION ET DE SUPPRESION D'UTILISATEURS ===========================
function getalluser()
{
    $db = connect_db();
    $stmt = $db->query('SELECT * FROM utilisateurs ORDER BY id_personne DESC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function suppUser($postId)
{
    $db = connect_db();

    $stmtdelphoto = $db->prepare("SELECT photo FROM utilisateurs WHERE id_personne = :delete_user");
    $stmtdelphoto->bindParam(':delete_user', $postId, PDO::PARAM_INT);
    $stmtdelphoto->execute();
// On récupère le chemin de l'image du profil
    $profilePic = $stmtdelphoto->fetch(PDO::FETCH_ASSOC)['photo'];
    
    // On verifie si l'utilisateur a une image de profil
    if($profilePic && file_exists($profilePic)){
    //si l'image n'est pas l'image par défaut on la supprime
        if($profilePic !== "images/uploads/profil_default.png"){
            // On supprime l'image du profil
            unlink($profilePic);
        }
    }

    // On supprime les commentaires de l'utilisateur
    $stmt = $db->prepare("DELETE FROM commentaires WHERE auteur_id = :delete_user");
    $stmt->bindParam(':delete_user', $postId, PDO::PARAM_INT);
    $stmt->execute();

    // On supprime l'utilisateur
    $stmt = $db->prepare("DELETE FROM utilisateurs WHERE id_personne = :delete_user");
    $stmt->bindParam(':delete_user', $postId, PDO::PARAM_INT);
    $stmt->execute();

}
function modifUser($prenom, $nom, $login, $photo, $admin)
{
    $db = connect_db();

    $requete = $db->prepare("UPDATE utilisateurs SET prenom = :prenom, nom = :nom, login = :login, photo = :photo, admin = :admin WHERE id_personne = :id_personne");

    $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':login', $login, PDO::PARAM_STR);
    $requete->bindParam(':photo', $photo, PDO::PARAM_STR);
    $requete->bindParam(':admin', $admin, PDO::PARAM_INT);
    $requete->bindParam(':id_personne', $_POST['id_personne'], PDO::PARAM_INT);
    $requete->execute();
}
//FONCTION DE MODIFICATION DE PHOTO DE PROFIL ========================================
function updateUserPhoto($id_personne, $target_file)
{
    $db = connect_db();
    $stmt = $db->prepare("UPDATE utilisateurs SET photo = :photo WHERE id_personne = :id_personne");
    $stmt->bindParam(':photo', $target_file, PDO::PARAM_STR);
    $stmt->bindParam(':id_personne', $id_personne, PDO::PARAM_INT);
    $stmt->execute();
}


?>