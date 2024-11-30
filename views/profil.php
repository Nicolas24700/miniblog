<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="./views/styles.css">
    <link rel="icon" href="./images/img_site/logo_blog.png" type="image/x-icon">
</head>

<body>
    <header>
        <nav class="navbar" id="navbar">
            <a href="index.php?action=blog" class="logo">=
                <img src="./images/img_site/logo_blog.png" alt="Accueil">
            </a>
            <ul class="nav-links">
                <li><a href="index.php?action=blog">Blog</a></li>
                <li><a href="index.php?action=archives">Archives</a></li>
                <li><a href="index.php?action=profil" class="pageactive">Profil</a></li>
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

    <section class="sectionprofil">
        <div class="profile">
            <div class="profile-photo">
                <?php
                // Si l'utilisateur est connecté, on affiche sa photo de profil sinon on affiche une image par défaut
                if (isset($_SESSION['login'])) {
                    echo "<img src='{$userInfo['photo']}' alt='Photo de profil'>";
                } else {
                    echo "<img src='https://via.placeholder.com/100' alt='Photo de profil'>";
                }
                ?>
                <p style='color:#FF0000'>Taille d'image conseillée 100 X 100 px</p>

                <!-- Si un message est présent dans la session on l'affiche  -->
                <?php if (isset($_SESSION['message'])) {
                    echo "<p style='color:#FF0000' class='billetmessage'>{$_SESSION['message']}</p>";
                    unset($_SESSION['message']); // Supprime le message après affichage      
                } ?>

                <form action="index.php?action=upload_Photo" method="post" enctype="multipart/form-data">
                    <label for="photo">Modifier la photo de profil :</label>
                    <input type="file" name="photo" id="photo" required>
                    <input type="submit" name="submit" class="bouttonprofil" value="Modifier">
                </form>
            </div>
            <div class="profile-info">
                <div>
                    <h2>Information sur le compte :</h2>
                    <?php
                    // Si l'utilisateur est connecté, on affiche les informations de l'utilisateur sinon on affiche des champs vides
                    if (isset($_SESSION['login'])) {
                        echo "<p>Nom : {$userInfo['nom']} </p>
                        <p>Prénom : {$userInfo['prenom']} </p>
                        <p>Nom d'utilisateur : {$userInfo['login']} </p>";
                    } else {
                        echo "<p>Nom : </p>
                        <p>Prénom :  </p>
                        <p>Nom d'utilisateur : </p>";
                    }


                    ?>
                </div>
                <?php
                // Si l'utilisateur est connecté, on affiche le bouton pour se déconnecté sinon on affiche que l'utilisateur n'est pas connecté
                if (isset($_SESSION['login'])) {
                    echo "<a href='index.php?action=logout' class='button-deco'> Se déconnecter</a>";
                } else {
                    echo "<a href='index.php?action=authentification' class='button-deco'> Vous êtes pas connecter</a>";
                }
                ?>
            </div>

        </div>
    </section>
    <footer>
        <p>&copy; 2024 Mon Blog. Tous droits réservés. Site fait par Nicolas Molduch</p>
    </footer>
</body>

</html>