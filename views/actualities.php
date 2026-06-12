<h2 style="border-left: 4px solid #111; padding-left: 12px; margin-bottom: 30px;">Fil des Actualités</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px;">
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <article style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <?php if ($article->getImage()): ?>
                        <img src="<?= htmlspecialchars($article->getImage()) ?>" style="width: 100%; height: 210px; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 100%; height: 210px; background: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #777;">Pas d'illustration</div>
                    <?php endif; ?>
                    
                    <div style="padding: 20px;">
                        <h3 style="margin: 0 0 8px 0; font-size: 20px; color: #111;"><?= htmlspecialchars($article->getTitle()) ?></h3>
                        <?php if ($article->getSubtitle()): ?>
                            <h4 style="margin: 0 0 15px 0; color: #666; font-size: 14px; font-weight: normal; font-style: italic;"><?= htmlspecialchars($article->getSubtitle()) ?></h4>
                        <?php endif; ?>
                        <p style="font-size: 14.5px; line-height: 1.6; color: #444; white-space: pre-line;"><?= htmlspecialchars($article->getContent()) ?></p>
                        <?php if ($article->getCaption()): ?>
                            <p style="font-size: 12px; color: #888; font-style: italic; margin-top: 15px; border-left: 2px solid #ccc; padding-left: 6px;">ℹ️ <?= htmlspecialchars($article->getCaption()) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div style="padding: 15px 20px; background: #fafafa; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 11px; color: #777;">
                        Par <strong><?= htmlspecialchars($article->getAuthorName() ?? 'Anonyme') ?></strong><br>
                        Le <?= date('d/m/Y à H:i', strtotime($article->getPublishDate())) ?>
                    </span>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 1): ?>
                        <div style="display: flex; gap: 8px;">
                            <a href="index.php?action=edit_article&id=<?= $article->getIdPosts() ?>" style="background:#007bff; color:white; padding:4px 8px; border-radius:4px; text-decoration:none; font-size:12px; font-weight:bold;">Modifier</a>
                            <a href="index.php?action=delete_article&id=<?= $article->getIdPosts() ?>" style="background:#dc3545; color:white; padding:4px 8px; border-radius:4px; text-decoration:none; font-size:12px; font-weight:bold;" onclick="return confirm('Supprimer cet article ?');">Supprimer</a>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="grid-column: 1/-1; text-align: center; color: #666; padding: 40px; background: white; border-radius: 8px;">Aucun article publié pour le moment.</p>
    <?php endif; ?>
</div>