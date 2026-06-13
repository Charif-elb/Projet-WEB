<?php
// On génère le hash directement sur ton serveur
$mon_mot_de_passe = '123456';
$nouveau_hash = password_hash($mon_mot_de_passe, PASSWORD_DEFAULT);

echo "Copie EXACTEMENT cette ligne : <br><br>";
echo "<strong>" . $nouveau_hash . "</strong>";
echo "<br><br>...et vérifie si ça marche : <br>";

if (password_verify($mon_mot_de_passe, $nouveau_hash)) {
    echo "Succès : Ton serveur a généré un hash valide !";
} else {
    echo "Échec : Il y a un problème avec ta version de PHP.";
}
?>