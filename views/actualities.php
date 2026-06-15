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

                <div style="padding: 15px 20px; background: #fff; border-top: 1px solid #eee;">
                    <h4 style="margin: 0 0 12px 0; color: #111; font-size: 14px; font-weight: 600;">💬 Commentaires</h4>

                    <?php if (isset($_SESSION['id_user'])): ?>
                        <form action="index.php?action=add_comment" method="POST" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: flex-start;">
                            <input type="hidden" name="id_post" value="<?= $article->getIdPosts(); ?>"> 
                            <img src="<?= htmlspecialchars($_SESSION['profile_pic'] ?? 'images/default.png'); ?>" 
                                 style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;"
                                 onerror="this.src='images/default.png'">
                            <div style="flex: 1; display: flex; flex-direction: column; gap: 5px;">
                                <textarea name="content" placeholder="Ajouter un commentaire..." required rows="1" 
                                          style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; resize: vertical; font-family: inherit; font-size: 13px;"></textarea>
                                <button type="submit" style="align-self: flex-end; background: #111; color: white; padding: 5px 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 12px;">
                                    Publier
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <p style="font-size: 12px; color: #666; background: #f5f5f5; padding: 8px; border-radius: 6px; margin-bottom: 15px;">
                            🔑 <a href="index.php?action=login" style="color: #111; font-weight: bold; text-decoration: underline;">Connectez-vous</a> pour commenter.
                        </p>
                    <?php endif; ?>

                    <div style="display: flex; flex-direction: column; gap: 10px; max-height: 220px; overflow-y: auto; padding-right: 2px;">
                        <?php
                        try {
                            $comments = articlecontroller::getCommentsByPost($article->getIdPosts());
                            
                            if (!empty($comments)): 
                                foreach ($comments as $comment): ?>
                                    <div style="display: flex; gap: 10px; align-items: flex-start;">
                                        <img src="<?= htmlspecialchars($comment['profile_pic'] ?? 'images/default.png'); ?>" 
                                             style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; background: #eee; border: 1px solid #e0e0e0;"
                                             onerror="this.src='images/default.png'">
                                        <div style="background: #f8f9fa; padding: 8px 12px; border-radius: 8px; flex: 1; border: 1px solid #f0f0f0;">
                                            <strong style="color: #222; font-size: 12.5px;"><?= htmlspecialchars($comment['pseudo']); ?></strong>
                                            <p style="margin: 3px 0 0 0; color: #444; font-size: 13px; line-height: 1.4; white-space: pre-line;"><?= htmlspecialchars($comment['content']); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; 
                            else: ?>
                                <p style="font-size: 12px; color: #999; font-style: italic; text-align: center; margin: 5px 0;">Aucun commentaire.</p>
                            <?php endif; 
                        } catch (Throwable $e) {
                            echo '<div style="color: #dc3545; background: #fde8e8; padding: 10px; font-size: 12px; border-radius: 6px; border: 1px solid #f5c6cb;">⚠️ Erreur SQL/Système : ' . htmlspecialchars($e->getMessage()) . '</div>';
                        }
                        ?>
                    </div>
                </div>
                </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="grid-column: 1/-1; text-align: center; color: #666; padding: 40px; background: white; border-radius: 8px;">Aucun article publié pour le moment.</p>
    <?php endif; ?>
</div>