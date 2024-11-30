<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="./views/styles.css">
    <link rel="icon" href="./images/img_site/logo_blog.png" type="image/x-icon">
</head>

<body>
    <header>
        <nav class="navbar" id="navbar">
            <a href="index.php?action=blog" class="logo">
                <img src="./images/img_site/logo_blog.png" alt="Accueil">
            </a>
            <ul class="nav-links">
                <li><a href="index.php?action=blog">Blog</a></li>
                <li><a href="index.php?action=archives">Archives</a></li>
                <li><a href="index.php?action=profil">Profil</a></li>
                <li><a href='index.php?action=admin' class="pageactive">Administration</a></li>
            </ul>
            <!-- Si l'utilisateur est connecté, on affiche vous êtes connecté, sinon on affiche Se connecter -->
            <?php if (isset($_SESSION['login'])) {
                echo "<a href='index.php?action=authentification' class='login-link'>Vous êtes connecté</a>";
            } else {
                echo "<a href='index.php?action=authentification' class='login-link'>Se connecter</a>";
            } ?>
        </nav>
    </header>
    <?php
    // Si l'utilisateur est un admin, on affiche le panel d'administration sinon on affiche un message d'erreur
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {

        ?>
        <div class="admin-section">
            <nav class="barrehorizontale">
                <ul>
                    <li><button onclick="afficherSection('createpost')">Création de Post</button></li>
                    <li><button onclick="afficherSection('utilisateurs')">Gestion des utilisateurs</button></li>
                    <li><button onclick="afficherSection('commentaires')">Gestion des post</button></li>
                </ul>
            </nav>

            <div class="main-content">
                <section id="default" class="paneladmin-section active">
                    <h1>Bienvenue sur le panel d'administration</h1>
                      <?php  if (isset($_SESSION['Adminmessage'])) {
                        echo "<p class='billetmessage'>{$_SESSION['Adminmessage']}</p>";
                        unset($_SESSION['Adminmessage']); // Supprime le message après affichage
                    } ?>    
                </section>

                <!-- SECTION création de post -->
                <section id="createpost" class="paneladmin-section">
                    <h1>Création de Post</h1>
                    <div class="form-containercreateposte">
                        <h2>Créer un nouveau post</h2>
                        <!-- Formulaire de creation de billet avec enctype="multipart/form-data" qui permet de mettre un fichier sur le serveur-->
                        <form action="index.php?action=addbillet" method="POST" enctype="multipart/form-data">
                            <div class="form-groupAdmin">
                                <label for="titre">Titre du post :</label>
                                <input type="text" id="titre" name="titre" placeholder="Entrez le titre de votre post"required>
                            </div>
                            <div class="form-groupAdmin">
                                <label for="contenu">Contenu du post :</label>
                                <textarea id="contenu" name="contenu" rows="6"
                                    placeholder="Écrivez le contenu de votre post" required></textarea>
                            </div>
                            <div class="form-groupAdmin">
                                <p style='color:#FF0000'>Taille d'image conseillée 1000 X 200 px</p>
                                <label for="photo_post">Image du post :</label>
                                <input type="file" id="photo_post" name="photo_post">
                            </div>
                            <input type="submit" class="createpost-button" value="Publier le post">
                        </form>
                    </div>


                </section>
                <!-- SECTION gestion des utilisateurs -->
                <section id="utilisateurs" class="paneladmin-section">
                    <div class="tablescroll">
                        <div class="admin-container">
                            <h1>Gestion des Utilisateurs</h1>
                            <!-- Table des utilisateurs -->
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Login</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Photo Url</th>
                                        <th>Photo de profil</th>
                                        <th>Administrateur</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // On récupère tout les utilisateurs avec la variable $result qui appelle la fonction getalluser() qui prend tout les utilisateurs
                                    $result = getalluser();
                                    // On boucle sur les utilisateurs pour les afficher
                                    foreach ($result as $info) {
                                        // Info Utilisateurs
                                        echo "<tr>
                                        <td>{$info['id_personne']}</td>
                                        <td>{$info['login']}</td>
                                        <td>{$info['nom']}</td>
                                        <td>{$info['prenom']}</td>
                                        <td>{$info['photo']}</td>
                                        <td><img src='{$info['photo']}' width='50'></td>
                                        <td>{$info['admin']}</td>";

                                        // Boutons de suppresion de l'utilisateur
                                        echo "<td>
                                        <button class='custom_user'>Modifier</button>
                                        <form method='POST' action='index.php?action=suppUser'>";
                                        // On envoie l'id de l'utilisateur à supprimer avec un input hidden pour le récupérer dans le POST
                                        echo "<input type='hidden' name='delete_user' value='{$info['id_personne']}'>
                                        <button type='submit' class='delete-boutton'>Supprimer</button>
                                        </form>
                                        </td>

                                        </tr>";

                                        // Formulaire de modification de l'utilisateur
                                        echo "<tr class='modificationUser'>
                                        <form action='index.php?action=modifUser' method='POST'>";
                                        // On envoie l'id de l'utilisateur à modifier avec un input hidden pour le récupérer dans le POST
                                        echo "<input type='hidden' name='id_personne' value='{$info['id_personne']}'>
                                        <td>{$info['id_personne']}</td>
                                        <td>
                                        <label for='login'>Login :</label><br>
                                        <input type='text' name='login' value='{$info['login']}' required>
                                        </td>
                                        <td>
                                        <label for='nom'>Nom :</label><br>
                                        <input type='text' name='nom' value='{$info['nom']}' required>
                                        </td>
                                        <td>
                                        <label for='prenom'>Prénom :</label><br>
                                        <input type='text' name='prenom' value='{$info['prenom']}' required>
                                        </td>
                                        <td>
                                        <label for='photo'>Photo Url :</label><br>
                                        <input type='text' name='photo' value='{$info['photo']}' required>
                                        </td>
                                        <td>
                                        <img src='{$info['photo']}' alt='photo' width='50'>
                                        </td>
                                        <td>
                                        <label for='admin'>Administrateur :</label><br>
                                        <input type='text' name='admin' value='{$info['admin']}'
                                        </td>
                                        <td>
                                        <button type='submit' class='modif_userform'>Modifier</button>
                                        </td>
                                        </form>
                                        </tr>";

                                    }
                                    // FORMULAIRE ORIGNALE ========================================================
                                

                                    //=============================================================================
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
                <section id="commentaires" class="paneladmin-section">
                    <?php
                    // On récupère les billets avec la variable $billets qui appelle la fonction getALLBillets() qui prend tout les billets
                    $billets = getALLBillets();
                    // On boucle sur les billets pour les afficher
                    foreach ($billets as $billet) {
                        echo "<div class='Billet-blog'>
                        <div class='post-container'>
                        <button class='commentButton'>Voir les commentaires</button>
                        <div class='post-header'>
                        <p style='color:#FF0000'>ID : {$billet['id_billets']}</p>
                        <h2>{$billet['titre']}</h2>
                        <p class='post-auteur'>Publié par {$billet['login']} le {$billet['date_post']}</p>
                        </div>
                        <div class='post-content scroll'>";
                        // Si le billet contient une photo, on l'affiche sinon on affiche seulement le contenu en verifiant si la photo n'est pas null
                        if ($billet['photo_post'] != null) {
                            echo "<img src='{$billet['photo_post']}' alt='' class='post-image'>";
                        }
                        echo "<p>{$billet['contenu']}</p>
                        </div>

                        <div class='lesbouttons'>
                        <button class='modifbuttonbillet'>Modifier le billet</button>

                        <form method='POST' action='index.php?action=suppbillet'>";
                        // On envoie l'id du billet à supprimer avec un input hidden pour le récupérer dans le POST
                        echo "<input type='hidden' name='supp_id' value='{$billet['id_billets']}'>
                        <button type='submit'>Supprimer le billet</button>
                        </form>
                        </div>

                        <div class='billet_class_modif'>
                        <form method='POST' action='index.php?action=modifbillet'>";
                        // On envoie l'id du billet à modifier avec un input hidden pour le récupérer dans le POST
                        echo "<input type='hidden' name='id_billets' value='{$billet['id_billets']}'>
                        <label for='titre'>Titre du post :</label>
                        <input type='text' id='titre' name='titre' value='{$billet['titre']}' required>
                        <br><br>
                        <label for='contenu'>Contenu du post :</label>
                        <textarea name='contenu' id='contenu' required>{$billet['contenu']}</textarea>
                        <br><br>
                        <input type='submit' value='Modifier le billet'>
                        </form>
                        </div>
                        </div>

                        <div class='comments-container'>
                        <h3>Commentaires</h3>
                        <div class='scrollable'>";
                        // On récupère les commentaires du billet avec la variable $commentaire qui appelle la fonction getCommentsByBilletId() et on affiche donc les commentaires associé au billet
                        $commentaires = getCommentsByBilletId($billet['id_billets']);
                        //si il y'a un commentaire on les affiche sinon on affiche qu'il n'y a pas de commentaire
                        if ($commentaires) {
                            // On boucle sur les commentaires pour les afficher
                            foreach ($commentaires as $commentaire) {
                                echo "<div class='commentaireadmin'>
                                <img src='{$commentaire['photo']}' alt='' class='photo_profil_comment'>
                                <div class='commentaireadminP'>
                                <p style='color:#FF0000'>ID : {$commentaire['id_commentaires']}</p>
                                <p>{$commentaire['login']}</p>
                                <p>le {$commentaire['date_post']}</p>
                                <p>{$commentaire['contenu']}</p>
                                </div>
                                <form method='POST' action='index.php?action=suppcomment'>";
                                // On envoie l'id du commentaire à supprimer avec un input hidden pour le récupérer dans le POST
                                echo "<input type='hidden' name='suppcomment_id' value='{$commentaire['id_commentaires']}'>
                                <button type='submit'>Supprimer le commentaire</button>
                                </form>
                                <br>
                                <button class='modifbuttoncomment'>Modifier le commentaire</button>

                                <div class='commentaire_class_modif'>
                                <form method='POST' action='index.php?action=modifcomment'>";
                                // On envoie l'id du commentaire à modifier avec un input hidden pour le récupérer dans le POST
                                echo "<input type='hidden' name='id_commentaires' value='{$commentaire['id_commentaires']}'>
                                <label for='contenu'>Contenu du commentaire :</label>
                                <textarea name='contenu' id='contenu' required>{$commentaire['contenu']}</textarea>
                                <br><br>
                                <input type='submit' value='Modifier le commentaire'>
                                </form>
                                </div>
                                </div>";
                            }
                        } else {
                            echo "<p class='text'>--Aucun commentaire pour le moment--</p>";
                        }
                        echo "</div>
                        </div>
                        </div>";
                    }
                    ?>

                </section>
            </div>
        </div>
        <?php
    } else {
        echo "<h1 class='h1sansperm'>Vous n'avez pas les droits pour accéder à cette page</h1>";
    }
    ?>
    <footer>
        <p>&copy; 2024 Mon Blog. Tous droits réservés. Site fait par Nicolas Molduch</p>
    </footer>
    <script src="views/script.js"></script>
</body>

</html>