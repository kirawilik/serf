# Description du Projet
SERF est une application web développée en PHP natif pour gérer les activités internes d’une école de surf à Taghazout.
Elle permet de suivre les élèves, organiser les cours et gérer les inscriptions de manière centralisée.

Ce projet a été réalisé dans le cadre d’un apprentissage avancé en :

Programmation Orientée Objet (POO)
Architecture MVC (Modèle - Vue - Contrôleur)

Le développement a été effectué avec Visual Studio Code (VS Code)
## Objectifs du Projet
Remplacer les systèmes manuels (papier, Excel)
Structurer le code avec une architecture MVC
Implémenter la POO avec encapsulation
Assurer la sécurité des données (PDO, validation, hashage)
Faciliter la gestion des cours et des élèves
## Structure du Projet (Arborescence)
SERF/
│
├── config/
│   └── Database.php          # Connexion à la base de données (PDO)
│
├── Controller/
│   ├── AdminController.php   # Gestion des fonctionnalités admin
│   ├── InscriptionController.php # Gestion des inscriptions aux cours
│   ├── LessonController.php  # Gestion des sessions de surf
│   ├── StudentController.php # Gestion des élèves
│   └── UserController.php    # Authentification et gestion des utilisateurs
│
├── model/
│   ├── admin.php             # Modèle administrateur
│   ├── Inscription.php       # Modèle des inscriptions
│   ├── Lesson.php            # Modèle des cours
│   ├── Student.php           # Modèle des élèves
│   └── User.php              # Modèle utilisateur
│
└── view/
    ├── account_admin.php     # Tableau de bord admin
    ├── account_student.php   # Espace utilisateur (surfeur)
    ├── edit_lesson.php       # Modification des cours
    ├── login.php             # Page de connexion
    └── logout.php            # Déconnexion
## Sécurité
Requêtes préparées avec PDO
Hachage des mots de passe (password_hash)
Validation des formulaires
Protection contre les injections SQL
 ## Fonctionnalités
 Admin
Gestion des élèves
Création et modification des cours
Inscription des élèves aux sessions
Suivi des niveaux
Surfeur
Création de compte
Connexion
Consultation des cours
Suivi du statut de paiement
 
