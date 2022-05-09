<div>
	<h1>Statistiques</h1>
	<h3>Liste des projets actifs :</h3>
	<div class="table">
		<table>
			<thead>
				<tr>
					<th>Nom</th>
					<th>Code</th>
					<th>Enseignant</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($listeProj as $projet) { ?>
				<tr>
					<td><?=$projet['nomProj']?></td>
					<td><?=$projet['codeApoge']?></td>
					<td><?=$projet['prenomEns']?> <?=$projet['nomEns']?></td>
				</tr>
				<?php } ?>
		</table>
	</div>
	<h3>Nombre de projets par UE suivant l'état du projet :</h3>
	<div class="table">
		<table>
			<thead>
				<tr>
					<th>UE</th>
					<th>Actifs</th>
					<th>En Attente</th>
					<th>Archivés</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($nbProjetsUEParEtat as $nbProjetsUEParEtat) { ?>
				<tr>
					<td><?=$nbProjetsUEParEtat['codeApoge']?></td>
					<td><?=$nbProjetsUEParEtat['Actifs']?></td>
					<td><?=$nbProjetsUEParEtat['Attentes']?></td>
					<td><?=$nbProjetsUEParEtat['Archives']?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<h3>UE acceptant plus de 2 étudiants par équipe :</h3>
	<p>Il y as <strong><?=$nbUEEquipePlusDe2?></strong> UE qui accepte plus de 2 étudiants par équipes.</p>

	<h3>UE présentant le plus de projets :</h3>
	<p>L'ue qui as présenté le plus de projets est <strong><?=$ueProjetPlus['codeApoge']?></strong> avec <strong><?=$ueProjetPlus['c']?></strong> projets.</p>
	
	<h3>Enseignant encadré le plus de projets :</h3>
	<p>L'enseignant qui a encadré le plus de projets est <strong><?=$ensProjetEncadrerPlus["prenomEns"]." ".$ensProjetEncadrerPlus["nomEns"]?></strong> avec <strong><?=$ensProjetEncadrerPlus["c"]?></strong> projets.</p>
	
	<h3>Liste des étudiants qui ont eu la meilleure note dans chaque UE :</h3>
	<div class="table">
		<table>
			<thead>
				<tr>
					<th>EU</th>
					<th>Sigle</th>
					<th>Année</th>
					<th>Semestre</th>
					<th>Projet</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Note</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($listeEtudiantMeilleurNote as $etudiant) { ?>
				<tr>
					<td><?=$etudiant['libelleUE']?></td>
					<td><?=$etudiant['sigle'] ?? "null"?></td>
					<td><?=$etudiant['anneeProj']?></td>
					<td><?=$etudiant['semestreProj']?></td>
					<td><?=$etudiant['nomProj']?></td>
					<td><?=$etudiant['nomEtu']?></td>
					<td><?=$etudiant['prenomEtu']?></td>
					<td><?=$etudiant['note']?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>