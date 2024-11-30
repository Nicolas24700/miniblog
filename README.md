# 📝 Projet Blog PHP - Nicolas Molduch  

Bienvenue dans le projet **Blog PHP** réalisé dans le cadre d'un exercice de développement dans mon but mmi où l'objectif était de faire un blog avec une structure MVC en PHP

---
## 🌐 URL du projet  

- **Back-office (admin)** :  
  [🔗 https://miniblog.molduch.butmmi.o2switch.site/index.php?action=admin](https://miniblog.molduch.butmmi.o2switch.site/index.php?action=admin)  

- **Site public** :  
  [🔗 https://miniblog.molduch.butmmi.o2switch.site/index.php?action=blog](https://miniblog.molduch.butmmi.o2switch.site/index.php?action=blog)  

---

## 👥 Comptes utilisateurs disponibles  

### 🔑 Utilisateur standard - TOTO  
- **Login** : `TOTO`  
- **Mot de passe** : `TOTO`  

### 🔑 Utilisateur standard - TITI  
- **Login** : `TITI`  
- **Mot de passe** : `TITI`  

---

## 💻 Fonctionnalités développées  

- 🌟 **Gestion des images des billets** :  
  - Lors de la création d’un billet, il est possible d'ajouter une image.  
  - En cas d'erreur avec l'image (ex. : mauvais format), le billet n'est pas publié.  

- 🔒 **Gestion des connexions utilisateur** :  
  - Si l’utilisateur **n’est pas connecté**, un bouton indiquant *« Vous n’êtes pas connecté »* s’affiche dans le profil.  
  - Si l’utilisateur **connecté n’a pas les permissions administrateur**, la section "Admin" est masquée dans la barre de navigation.  

- 🔄 **Modification des états des utilisateurs et billets** :  
  - Lorsqu’un utilisateur ou un billet est supprimé, l’image associée est également supprimée du serveur.  
  - Lorsqu’un utilisateur modifie sa photo de profil :  
    - La nouvelle photo remplace l’ancienne.  
    - Les formats acceptés pour la nouvelle photo doivent correspondre au format d’origine (JPG ou PNG).  

- ✅ **Amélioration UX** :  
  - Lorsqu’un utilisateur est connecté, le texte du bouton *« Se connecter »* devient *« Vous êtes connecté »*.  
