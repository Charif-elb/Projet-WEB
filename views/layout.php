<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actu La Liga</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4; }
        
        /* --- HEADER (Barre noire) --- */
        header { 
            background: #000; 
            padding: 20px 50px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            flex-wrap: wrap; 
            gap: 20px;
        }

        /* --- LOGO --- */
        .logo { font-size: 24px; font-weight: bold; color: #fff; text-decoration: none; }
        .logo span { color: #ff0000; }

        /* --- MENU CENTRAL --- */
        .nav-links { display: flex; gap: 30px; }
        .nav-links a { 
            color: #fff; 
            text-decoration: none; 
            font-weight: bold; 
            transition: color 0.3s ease; 
        }
        .nav-links a:hover { color: #ff0000; }

        /* --- BOUTONS À DROITE --- */
        .auth-btns { display: flex; gap: 15px; align-items: center; }
        .auth-btns a, .auth-btns button { 
            background-color: #ff0000; 
            color: #ffffff; 
            text-decoration: none; 
            padding: 10px 20px; 
            border: none;
            border-radius: 5px; 
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: inherit;
        }
        .auth-btns a:hover, .auth-btns button:hover { background-color: #cc0000; }

        /* --- CONTENEUR PRINCIPAL --- */
        .container { padding: 40px 50px; max-width: 1200px; margin: 0 auto; box-sizing: border-box; }

        /* --- STYLE DES FENÊTRES MODALES --- */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); }
        .modal-content { 
            background-color: white; 
            margin: 15% auto; 
            padding: 30px; 
            border-radius: 8px; 
            width: 90%; 
            max-width: 320px; 
            text-align: center; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); 
            box-sizing: border-box;
        }
        .modal-content input { width: 100%; margin-bottom: 15px; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .modal-content button[type="submit"] { width: 100%; padding: 10px; background: #ff0000; color: white; border: none; cursor: pointer; font-weight: bold; border-radius: 5px; transition: 0.3s; }
        .modal-content button[type="submit"]:hover { background: #cc0000; }
        .close-btn { margin-top: 15px; background: none; border: 1px solid #ccc; padding: 8px; width: 100%; cursor: pointer; border-radius: 5px; }

        /* --- RESPONSIVE SMARTPHONE --- */
        @media (max-width: 768px) {
            header { flex-direction: column; text-align: center; padding: 20px; }
            .nav-links { flex-direction: column; gap: 15px; }
            .auth-btns { flex-direction: column; width: 100%; }
            .auth-btns button, .auth-btns a { width: 100%; }
            .container { padding: 20px; }
        }
    </style>
</head>
<body>

    <header>
        <a href="index.php" class="logo">La<span>Liga</span></a>
        <div class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="index.php?action=actu">Actualités</a>
            <a href="index.php?action=classement">Classement</a>
        </div>
        <div class="auth-btns">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span style="color: white; margin-right: 10px;">Bonjour, <?= htmlspecialchars($_SESSION['user_pseudo'] ?? 'Utilisateur') ?></span>
                <a href="index.php?action=logout">Déconnexion</a>
            <?php else: ?>
                <button onclick="document.getElementById('loginModal').style.display='block'">Connexion</button>
                <button onclick="document.getElementById('registerModal').style.display='block'">Inscription</button>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">
        <?php echo $content; ?>
    </div>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <h3 style="margin-top:0;">Connexion</h3>
            <form action="index.php?action=login" method="POST">
                <input type="text" name="pseudo" placeholder="Votre Pseudo" required>
                <input type="password" name="password" placeholder="Votre Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
            <button class="close-btn" onclick="document.getElementById('loginModal').style.display='none'">Fermer</button>
        </div>
    </div>

    <div id="registerModal" class="modal">
        <div class="modal-content">
            <h3 style="margin-top:0;">Inscription</h3>
            <form action="index.php?action=register" method="POST">
                <input type="text" name="pseudo" placeholder="Votre Pseudo" required>
                <input type="password" name="password" placeholder="Votre Mot de passe" required>
                <button type="submit">S'inscrire</button>
            </form>
            <button class="close-btn" onclick="document.getElementById('registerModal').style.display='none'">Fermer</button>
        </div>
    </div>

</body>
</html>