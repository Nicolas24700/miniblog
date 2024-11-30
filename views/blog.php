<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog</title>
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
                <li><a href="index.php?action=blog" class="pageactive">Blog</a></li>
                <li><a href="index.php?action=archives">Archives</a></li>
                <li><a href="index.php?action=profil">Profil</a></li>
                <?php
                // Si l'utilisateur est un admin, on affiche le lien vers l'administration
                if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                    echo "<li><a href='index.php?action=admin'>Administration</a></li>";
                }
                ?>
            </ul>
            <!-- Si l'utilisateur est connecté, on affiche vous êtes connecté, sinon on affiche Se connecter -->
            <?php if (isset($_SESSION['login'])) {
                echo "<a href='index.php?action=authentification' class='login-link'>Vous êtes connecté</a>";
            } else {
                echo "<a href='index.php?action=authentification' class='login-link'>Se connecter</a>";
            } ?>
        </nav>
    </header>
    <main>
        <section class="accueilsection">
            <?php
            // Si il y'a un message dans la session, on l'affiche
            if (isset($_SESSION['message'])) {
                echo "<p class='pcommentadd'>{$_SESSION['message']}</p>";
                unset($_SESSION['message']); // on supprime la valeur de session message après affichage
            } ?>
            <h1>Bienvenue sur mon blog</h1>
            <div class="intro">
                <span class="arrow">&#8595;</span>
                <a href="index.php?action=blog#recentpost">Les récents post.</a>
                <span class="arrow">&#8595;</span>
            </div>
        </section>
    </main>

    <section id="recentpost" class="recentpost">
        <?php
        // On récupère les billets avec la variable $billets qui appelle la fonction getBillets() qui prend les 3 derniers billets
        $billets = getBillets();
        // On boucle sur les billets pour les afficher
        foreach ($billets as $billet) {

            //Div pour chaque billet
            echo "<div class='Billet-blog'>
            <div class='post-container'>
            <button class='commentButton'>Voir les commentaires</button>
            <div class='post-header'>
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
            </div> ";

            //Div pour les commentaires
            echo "<div class='comments-container'>
            <h3>Commentaires</h3>
            <div class='scrollable'>";
            // On récupère les commentaires du billet avec la variable $commentaire qui appelle la fonction getCommentsByBilletId() et on affiche donc les commentaires associé au billet
            $commentaires = getCommentsByBilletId($billet['id_billets']);
            //si il y'a un commentaire on les affiche sinon on affiche qu'il n'y a pas de commentaire
            if (($commentaires)) {
                // On boucle sur les commentaires pour les afficher
                foreach ($commentaires as $commentaire) {
                    echo "<div class='commentaire'>
                    <img src='{$commentaire['photo']}' alt='' class='photo_profil_comment'>
                    <p>{$commentaire['login']}</p>
                    <p>le {$commentaire['date_post']}</p>
                    <p class='text'>{$commentaire['contenu']}</p>
                    </div>";
                }
            } else {
                echo "<p class='text'>--Aucun commentaire pour le moment--</p>";
            }
            //Div pour le formulaire de commentaire
            echo "</div>
            <form action='index.php?action=addComment' method='POST' class='comment-form'>
            <label for='contenu'>Ajouter un commentaire :</label>
            <textarea name='contenu' id='contenu' rows='4' placeholder='Votre commentaire...' required></textarea>";
            // On récupère l'id du billet pour l'envoyer avec le commentaire
            echo "<input type='hidden' name='id_billet' value='{$billet['id_billets']}'>
            <input type='submit' class='button-commentaire' value='Envoyer'></button>
            </form>
            </div>
            </div>";
        }
        ?>
    </section>

    <footer>
        <p>&copy; 2024 Mon Blog. Tous droits réservés. Site fait par Nicolas Molduch</p>
    </footer>
    <script src="./views/script.js"></script>
</body>

</html>