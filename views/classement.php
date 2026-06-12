<h2 style="border-left: 4px solid #111; padding-left: 12px; margin-bottom: 25px;">Classement Championnat - LaLiga</h2>

<div style="overflow-x: auto; background: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14.5px;">
        <thead>
            <tr style="background-color: #111; color: white;">
                <th style="padding: 15px 12px; width: 50px;">Pos</th>
                <th style="padding: 15px 12px;">Équipe</th>
                <th style="padding: 15px 12px; text-align: center;">MJ</th>
                <th style="padding: 15px 12px; text-align: center;">G</th>
                <th style="padding: 15px 12px; text-align: center;">N</th>
                <th style="padding: 15px 12px; text-align: center;">P</th>
                <th style="padding: 15px 12px; text-align: center;">BP</th>
                <th style="padding: 15px 12px; text-align: center;">BC</th>
                <th style="padding: 15px 12px; text-align: center;">Diff</th>
                <th style="padding: 15px 12px; text-align: center; background-color: #222;">Pts</th>
            </tr>
        </thead>
        <tbody id="api-ranking-table">
            <tr>
                <td colspan="10" style="padding: 30px; text-align: center; color: #777;">
                    ⚽ Chargement du classement en cours...
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Utilisation de fetch pour interroger l'API locale
    fetch('api/classement.json')
        .then(response => {
            if (!response.ok) {
                throw new Error("Fichier de classement introuvable.");
            }
            return response.json();
        })
        .then(result => {
            const container = document.getElementById('api-ranking-table');
            container.innerHTML = ''; 

            if (result.data && result.data.length > 0) {
                result.data.forEach(teamData => {
                    const tr = document.createElement('tr');
                    tr.style.borderBottom = '1px solid #f0f0f0';
                    
                    // Surlignage discret du top 4 qualificatif
                    if (teamData.position <= 4) {
                        tr.style.borderLeft = '3px solid #007bff';
                        tr.style.backgroundColor = '#f7faff';
                    }

                    let diffColor = '#333';
                    let diffPrefix = '';
                    if (teamData.goalDifference > 0) { diffColor = '#28a745'; diffPrefix = '+'; }
                    else if (teamData.goalDifference < 0) { diffColor = '#dc3545'; }

                    tr.innerHTML = `
                        <td style="padding: 14px 12px; font-weight: bold; color: #555;">${teamData.position}</td>
                        <td style="padding: 14px 12px; display: flex; align-items: center; gap: 12px; font-weight: 600;">
                            <img src="${teamData.teamImageUrl}" alt="${teamData.team}" style="width: 24px; height: 24px; object-fit: contain;" onerror="this.style.display='none'">
                            <span>${teamData.team}</span>
                        </td>
                        <td style="padding: 14px 12px; text-align: center; color: #555;">${teamData.played}</td>
                        <td style="padding: 14px 12px; text-align: center;">${teamData.won}</td>
                        <td style="padding: 14px 12px; text-align: center;">${teamData.drawn}</td>
                        <td style="padding: 14px 12px; text-align: center;">${teamData.lost}</td>
                        <td style="padding: 14px 12px; text-align: center; color: #777;">${teamData.goalsFor}</td>
                        <td style="padding: 14px 12px; text-align: center; color: #777;">${teamData.goalsAgainst}</td>
                        <td style="padding: 14px 12px; text-align: center; font-weight: 600; color: ${diffColor};">${diffPrefix}${teamData.goalDifference}</td>
                        <td style="padding: 14px 12px; text-align: center; font-weight: bold; color: #000; background-color: #fafafa;">${teamData.points}</td>
                    `;
                    container.appendChild(tr);
                });
            } else {
                container.innerHTML = '<tr><td colspan="10" style="padding:30px; text-align:center;">Aucune donnée disponible.</td></tr>';
            }
        })
        .catch(err => {
            console.error(err);
            document.getElementById('api-ranking-table').innerHTML = 
                '<tr><td colspan="10" style="padding:30px; text-align:center; color:#dc3545; font-weight:bold;">⚠️ Impossible de charger le classement.</td></tr>';
        });
});
</script>