<div style="max-width: 400px; margin: 60px auto; background: white; padding: 35px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
    <h3 style="margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid #e50914; padding-bottom: 10px; font-size: 22px;">Espace Administration</h3>
    
    <?php if (!empty($error)): ?>
        <div style="color: #d9534f; background-color: #fdf7f7; border: 1px solid #d9534f; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; font-weight: 500;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=login" style="display: flex; flex-direction: column; gap: 20px;">
        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px;">Nom d'utilisateur</label>
            <input type="text" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
        </div>
        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px;">Mot de passe</label>
            <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 15px;">S'authentifier</button>
    </form>
</div>