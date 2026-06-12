<div style="max-width: 650px; margin: 0 auto; background: white; padding: 35px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
    <h3 style="margin-top: 0; color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 10px; font-size: 22px;">Créer un nouvel article</h3>
    
    <form method="POST" action="index.php?action=add_article" style="display: flex; flex-direction: column; gap: 18px; margin-top: 20px;">
        <div>
            <label style="display:block; font-weight:600; margin-bottom:6px; font-size:14px;">Titre de l'actualité *</label>
            <input type="text" name="title" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;">
        </div>
        <div>
            <label style="display:block; font-weight:600; margin-bottom:6px; font-size:14px;">Sous-titre / Accroche</label>
            <input type="text" name="subtitle" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;">
        </div>
        <div>
            <label style="display:block; font-weight:600; margin-bottom:6px; font-size:14px;">URL d'une image d'illustration</label>
            <input type="url" name="image" placeholder="https://exemple.com/image.jpg" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;">
        </div>
        <div>
            <label style="display:block; font-weight:600; margin-bottom:6px; font-size:14px;">Légende descriptive de l'image</label>
            <input type="text" name="caption" placeholder="Crédit photo, description..." style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;">
        </div>
        <div>
            <label style="display:block; font-weight:600; margin-bottom:6px; font-size:14px;">Corps du texte *</label>
            <textarea name="content" rows="7" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box; font-family:inherit; font-size:14.5px;"></textarea>
        </div>
        
        <div style="display:flex; gap:12px; margin-top:10px;">
            <button type="submit" class="btn btn-success" style="padding: 12px 24px; background-color: #28a745; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Enregistrer et Publier</button>
            <a href="index.php?action=actualites" style="padding: 12px 24px; background: #333; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; text-align:center;">Annuler</a>
        </div>
    </form>
</div>