<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score 67 - L'actu Foot</title>
    <style>
        /* --- RESET & BASE --- */
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f4f4; }

        /* --- HEADER PROFESSIONNEL --- */
        header { background: #000; padding: 0 50px; height: 80px; display: grid; grid-template-columns: auto 1fr auto; align-items: center; border-bottom: 3px solid #e60000; }
        .logo { font-size: 28px; font-weight: 800; color: #fff; text-transform: uppercase; }
        .logo span { color: #e60000; }
        
        .nav-menu { display: flex; gap: 30px; justify-content: center; }
        .nav-menu a { color: #fff; text-decoration: none; font-weight: 600; font-size: 14px; text-transform: uppercase; transition: 0.3s; }
        .nav-menu a:hover { color: #e60000; }

        /* --- HERO SECTION --- */
        .hero { background: #1a1a1a; padding: 50px 20px; text-align: center; color: white; border-bottom: 4px solid #e60000; }
        .hero h1 { margin: 0; font-size: 32px; }

        /* --- CONTENEUR PRINCIPAL --- */
        .main-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }

        /* --- RESPONSIVE (POUR MOBILE) --- */
        @media (max-width: 768px) {
            header { grid-template-columns: 1fr; height: auto; padding: 20px; text-align: center; gap: 20px; }
            .nav-menu { flex-direction: column; gap: 15px; }
            .hero h1 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">SCORE <span>67</span></div>
        
        <nav class="nav-menu">
            <a href="index.php">Accueil</a>
            <a href="index.php?action=actu">Actu</a>
            <a href="index.php?action=classement">Classement</a>
            <a href="index.php?action=register" style="background:#e60000; padding: 5px 10px; border-radius: 4px;">S'inscrire</a>
        </nav>

        <div style="color: #fff; font-size: 14px;">
            <?php if (isset($_SESSION['username'])): ?>
                👤 <?php echo htmlspecialchars($_SESSION['username']); ?>
            <?php endif; ?>
        </div>
    </header>

    <div class="hero">
        <h1>L'ESSENTIEL DU FOOTBALL</h1>
    </div>

    <div class="main-container">
        <?php echo $content ?? ''; ?>
    </div>
</body>
</html>