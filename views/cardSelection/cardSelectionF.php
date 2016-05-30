<?php

	//Wenn Session username bereits gesetzt ist wird direkt umgeleitet
	session_start(); 
	if(!isset($_SESSION['username']))
		header("location:index.php"); // Re-direct to index.php

		include_once('views/header.php');
		
		
?>


<table>
		<tr>
			<td class="auswahl">
				 <h4>vendeur</h4>
				<form action="index.php?site=formularVerkauf&language=f" method="post">
	      				<input name="typ" type="hidden" value="601">
	   				<input type="image" src="resource/template/vorlagen/Verkauf/VK_franz_Verkauf_VS_voll.jpg" height="170px">
				</form>
				</form>
			</td>
			<td class="auswahl">
				<h4>vendeur - emplacement changement</h4>
				<form action="index.php?site=formularVerkaufSpringer&language=f" method="post">
	      				<input name="typ" type="hidden" value="3">
	   				<input type="image" src="resource/template/vorlagen/Springer/VK_franz_Springer_VS_voll.jpg" height="170px">
				</form>
			</td>
			<td class="auswahl">
				<h4>cuisines/bains/renovation</h4>
				<form action="index.php?site=formularKueBa&language=f" method="post">
	      				<input name="typ" type="hidden" value="5">
	   				<input type="image" src="resource/template/vorlagen/KueBa/VK_franz_KueBa_VS_voll.jpg" height="170px">
				</form>
			</td>
		</tr>
		<tr>
			<td class="auswahl">
				<h4>transformation / construction neuve</h4>
				<form action="index.php?site=formularEigenheim&language=f" method="post">
	      				<input name="typ" type="hidden" value="2">
	   				<input type="image" src="resource/template/vorlagen/Umbau_Neubau/VK_franz_Umbau_Neubau_VS_voll.jpg" height="170px">
				</form>
			</td>
			<td class="auswahl">
				 <h4>monteurs</h4>
				<form action="index.php?site=formularMonteur&language=f" method="post">
	      				<input name="typ" type="hidden" value="601">
	   				<input type="image" src="resource/template/vorlagen/Monteur/VK_franz_Monteur_VS_voll.jpg" height="170px">
				</form>
				</form>
			</td>
			<td class="auswahl">
				<h4>administration</h4>
				<form action="index.php?site=formularAdmin&language=f" method="post">
	      				<input name="typ" type="hidden" value="1">
	   				<input type="image" src="resource/template/vorlagen/Administration/VK_franz_Administration_VS_voll.jpg" height="170px">
				</form>
			</td>
		</tr>
	</table>