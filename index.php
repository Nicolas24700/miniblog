<?php
//Démarre la session
session_start();
// on inclut le fichier User.php qui est le models qui contient les fonctions
require 'models/User.php';

// Récupère l'action à partir des paramètres GET, ou une chaîne vide si aucune action n'est spécifiée
$action = isset($_GET['action']) ? $_GET['action'] : '';

// on utilise une structure switch pour exécuter différentes actions en fonction de la valeur de $action
switch ($action) {
    case 'authentification':
        //on inclut la vue authentification.php qui permet de rester sur la page d'authentification
        include('views/authentification.php');
        break;
    case 'inscription':
        // on vérifie si la méthode de requête est POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // on récupère les valeurs des champs du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $login = $_POST['login'];
            $motdepasse = $_POST['motdepasse'];
            $motdepasse2 = $_POST['motdepasse2'];

        // on appele la fonction d'inscription pour envoyer les données et les stocker dans la base de données
            $message = inscription($nom, $prenom, $login, $motdepasse, $motdepasse2);
            include('views/authentification.php');
        }
        break;
    case 'connexion':
        // on vérifie si la méthode de requête est POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // on récupère les valeurs des champs du formulaire
            $login = $_POST['login'];
            $motdepasse = $_POST['motdepasse'];

            // on appelle la fonction connexion pour vérifier si l'utilisateur existe dans la base de données
            $utilisateur = connexion($login);

            // on vérifie si l'utilisateur existe et si le mot de passe est correct
            if ($utilisateur && password_verify($motdepasse, $utilisateur["motdepasse"])) {
        // on démarre la session et on stocke les informations de l'utilisateur dans la session
                $_SESSION["login"] = $utilisateur["login"];
                $_SESSION["admin"] = $utilisateur["admin"];
                include('views/blog.php');
            } else {
                $error = "Login ou mot de passe incorrect";
                include('views/authentification.php');
            }
        }

        break;
    case 'logout':
        // on détruit la session et on redirige l'utilisateur vers la page d'accueil
        $_SESSION = array();
        session_destroy();
        header('Location: index.php');
        break;
    // COMMENTAIRE ET BLOG =================================
    case 'blog':
        // on récupère les billets avec la variable $billets qui appelle la fonction getBillets() qui prend les 3 derniers billets
        $billets = getBillets();
        include('views/blog.php');
        break;
    case 'archives':
    // on récupère les billets avec la variable $billets qui appelle la fonction getALLBillets() qui prend tous les billets
        $billets = getALLBillets();
        include('views/archives.php');
        break;
    case 'addComment':
    // on vérifie si la méthode de requête est POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // on vérifie si l'utilisateur est connecté
            if (isset($_SESSION['login'])) {

            // on récupère les valeurs des champs du formulaire

                $billetId = $_POST['id_billet'];
                $contenu = $_POST['contenu'];
            // on appelle la fonction connexion pour récupérer les informations de l'utilisateur

                $utilisateur = connexion($_SESSION['login']);
                $auteur_id = $utilisateur['id_personne'];

            // on appelle la fonction addComment pour ajouter le commentaire dans la base de données avec les donnes récupérées
                addComment($billetId, $contenu, $auteur_id);
            // on redirige l'utilisateur vers la page du blog
                header('Location: index.php?action=blog');
            } else {
            // on affiche un message d'erreur si l'utilisateur n'est pas connecté
            $_SESSION['message'] = "Vous devez être connecté pour ajouter un commentaire";
            // on redirige l'utilisateur vers la page de blog
            header('Location: index.php?action=blog');
            }

        }
        break;
    // PANEL ADMIN =================================
    case 'admin':
        include('views/admin.php');
        break;

    // PANEL ADMIN MODIFICATION / SUPPRESION / CREATION DE BILLET =================================
    case 'addbillet':
        // on vérifie si la méthode de requête est POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // on vérifie si l'utilisateur est connecté et si c'est un admin
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $titre = $_POST['titre'];
                $contenu = $_POST['contenu'];
                $utilisateur = connexion($_SESSION['login']);
                $auteur_id = $utilisateur['id_personne'];
                // on met la variable $target_file à null pour éviter les erreurs si il y'a pas de fichier
                $target_file = null;


                if (isset($_FILES['photo_post']) && $_FILES['photo_post']['error'] == 0) {
                    // On créer le chemin du fichier dans lequel l'image sera uploader
                    $target_dir = "images/uploads_post/";
                    // On récupère l'extension du fichier
                    $imageFileType = strtolower(pathinfo($_FILES['photo_post']['name'], PATHINFO_EXTENSION));

                    // On créer le chemin complet du fichier avec le nom du fichier qui est post_ suivi du temps pour éviter les doublons
                    $target_file = $target_dir . "post_" . time() . "." . $imageFileType;
                    // On initialise la variable $uploadOk à 1
                    $uploadOk = 1;
                    // Limite la taille du fichier (1 Mo ici)
                    if ($_FILES['photo_post']['size'] > 1000000) {
                        // Si le fichier est trop grand, on affiche un message d'erreur
                        $_SESSION['Adminmessage'] = "Désolé, le post n'a pas été uploadé car votre image dépasse 1Mo.";
                        $uploadOk = 0;
                    }

                    // Limite les formats de fichiers
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $_SESSION['Adminmessage'] = "Désolé, seul les formats JPG, JPEG, PNG & GIF sont autorisés. Votre post a été uploadé sans votre image.";
                        $uploadOk = 0;
                    }

                    // Si tout est ok, uploade le fichier avec le post
                    if ($uploadOk && move_uploaded_file($_FILES['photo_post']['tmp_name'], $target_file)) {
                        addbillet($titre, $contenu, $auteur_id, $target_file);
                        $_SESSION['Adminmessage'] = "Le Post " . $titre . " a été uploadé avec succès.";
                    } else {
                        $target_file = null;
                    }
                }

                // on appelle la fonction addbillet pour ajouter le billet dans la base de données avec les donnes récupérées si il y'a pas d'image d'uploads.
                else {
                    addbillet($titre, $contenu, $auteur_id, $target_file);
                    $_SESSION['Adminmessage'] = "Le Post " . $titre . " a été uploadé avec succès.";
                }
            } else {
                $_SESSION['Adminmessage'] = "vous n'avez pas les permissions";
            }
            include('views/admin.php');
        }
        break;

    // ==============================
    case 'suppbillet':
        if (isset($_POST['supp_id'])) {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $postId = $_POST['supp_id'];

                $_SESSION['Adminmessage'] = "Le Billet $postId à été supprimé avec succès.";
                suppbillet($postId);
                include('views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    case 'modifbillet':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $titre = $_POST['titre'];
                $contenu = $_POST['contenu'];
                $id = $_POST['id_billets'];

                modifbillet($titre, $contenu);
                $_SESSION['Adminmessage'] = "Le Billet $id avec comme titre : $titre , à été modifié avec succès.";
                include('views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    //PANEL ADMIN MODIFICATION / SUPPRESION DE COMMENTAIRE =================================
    case 'suppcomment':
        if (isset($_POST['suppcomment_id'])) {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $suppId = $_POST['suppcomment_id'];
                suppcomment($suppId);
        $_SESSION['Adminmessage'] = "Le commentaire $suppId à été supprimé avec succès.";
                include('views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    case 'modifcomment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $contenu = $_POST['contenu'];
                $IDcomment= $_POST['id_commentaires'];

             $_SESSION['Adminmessage'] = "Le commentaire $IDcomment du Post à été modifié avec succès, maintenant le commentaire est {$contenu}.";
                modifcomment($contenu);
                include('views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;

    // PANEL ADMIN SUPPRESION / MODIFICATION DES UTILISATEURS ================================
    case 'suppUser':
        if (isset($_POST['delete_user'])) {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $postId = $_POST['delete_user'];
                suppUser($postId);
                $_SESSION['Adminmessage'] = "Utilisateur $postId à correctement été supprimée.";
                include('views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    case 'modifUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $prenom = $_POST['prenom'];
                $nom = $_POST['nom'];
                $login = $_POST['login'];
                $photo = $_POST['photo'];
                $admin = $_POST['admin'];
            // on appelle la fonction modifUser pour modifier l'utilisateur dans la base de données avec les données récupérées
                modifUser($prenom, $nom, $login, $photo, $admin);
                $_SESSION['Adminmessage'] = "Utilisateur $login a été modifié avec succès.";
                include('views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    // PANEL DE MODIFICATION DE PROFIL =================================
    case 'profil':
        if (isset($_SESSION['login'])) {
        // on récupère les informations de l'utilisateur connecté
            $userInfo = connexion($_SESSION['login']);
            include('views/profil.php');
        } else {
            include('views/profil.php');
        }
        break;
    case 'upload_Photo':
        if (isset($_FILES['photo'])) {
            if (isset($_SESSION['login'])) {
                $login = $_SESSION['login'];
            // on récupère les informations de l'utilisateur connecté
                $user = connexion($login);

                // Si l'utilisateur est connecté
                if ($user) {
                    // On récupère l'id de l'utilisateur
                    $id_personne = $user['id_personne'];
                // On créer le chemin du fichier dans lequel l'image sera uploader
                    $target_dir = "images/uploads/";
            // On récupère l'extension du fichier
                    $imageFileType = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            // On créer le chemin complet du fichier
                    $target_file = $target_dir . "profil_" . $id_personne . "." . $imageFileType;
                // On initialise la variable $uploadOk à 1
                    $uploadOk = 1;

                    // Limite la taille du fichier (1 Mo ici)
                    if ($_FILES['photo']['size'] > 1000000) {
                        $_SESSION['message'] = "Désolé, votre fichier est supérieur à 1Mo.";
                        $uploadOk = 0;
                    }

                    // Limite les formats de fichiers
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $_SESSION['message'] =  "Désolé, seul les formats JPG, JPEG, PNG & GIF sont autorisée.";
                        $uploadOk = 0;
                    }

                    // Supprimer l'ancien fichier s'il existe
                    if (file_exists($target_file)) {
                    // Supprime le fichier
                        unlink($target_file);
                    }

                    // Si tout est ok, uploade le fichier
                    if ($uploadOk && move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                    // On appelle la fonction updateUserPhoto pour mettre à jour la photo de profil de l'utilisateur
                        updateUserPhoto($id_personne, $target_file);
                        $_SESSION['message'] = "La photo de profil a été mise à jour avec succès.";

                    }
                }
            } else {
                $_SESSION['message'] = "Vous devez être connectée pour uploader une photo de profil.";
            }
        }
        header('Location: index.php?action=profil');
        break;
    default:
        include 'views/blog.php';
        break;
}
?>