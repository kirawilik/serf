<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login / Register – Surf Taghazout</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(120deg, #007BFF, #00c6ff);
            min-height: 100vh;
            margin: 0;
        }
        .container {
            width: 400px;
            margin: 60px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(0,0,0,.2);
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }
        button:hover { background: #0056b3; }
        .toggle { margin-top: 10px; }
        .toggle a { color: #007BFF; cursor: pointer; }
        .hidden { display: none; }
        .msg { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }
    </style>
    <script>
        function showRegister() {
            document.getElementById('login').style.display = 'none';
            document.getElementById('register').style.display = 'block';
        }
        function showLogin() {
            document.getElementById('register').style.display = 'none';
            document.getElementById('login').style.display = 'block';
        }
    </script>
</head>
<body>
<div class="container">

    <!-- Messages -->
    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] === 'login'): ?>
            <p class="msg">Email ou mot de passe incorrect.</p>
        <?php elseif ($_GET['error'] === 'register'): ?>
            <p class="msg">Cet email est déjà utilisé.</p>
        <?php elseif ($_GET['error'] === 'empty'): ?>
            <p class="msg">Veuillez remplir tous les champs.</p>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p class="success">Inscription réussie ! Connectez-vous.</p>
    <?php endif; ?>

    <div id="login">
        <h2> Connexion</h2>
        <form action="../Controller/UserController.php?action=login" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <div class="toggle">
            <p>Pas de compte ? <a onclick="showRegister()">Créer un compte</a></p>
        </div>
    </div>

    <div id="register" class="hidden">
        <h2>Inscription</h2>
        <form action="../Controller/UserController.php?action=register" method="POST">
            <input type="text" name="username" placeholder="Nom complet" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="text" name="country" placeholder="Pays" required>
            <select name="level" required>
                <option value="">-- Choisir un niveau --</option>
                <option value="Débutant">Débutant</option>
                <option value="Intermédiaire">Intermédiaire</option>
                <option value="Avancé">Avancé</option>
            </select>
            <button type="submit">S'inscrire</button>
        </form>
        <div class="toggle">
            <p>Déjà inscrit ? <a onclick="showLogin()">Se connecter</a></p>
        </div>
    </div>

</div>
</body>
</html>