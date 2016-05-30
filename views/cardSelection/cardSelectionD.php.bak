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
				 <h4>Verkauf</h4>
				<form action="index.php?site=formularVerkauf&language=d" method="post">
	      				<input name="typ" type="hidden" value="601">
	   				<input type="image" src="resource/template/vorlagen/Verkauf/VK_dt_Verkauf_VS_voll.jpg" height="170px">
				</form>
				</form>
			</td>
			<td class="auswahl">
				<h4>Verkauf Springer</h4>
				<form action="index.php?site=formularVerkaufSpringer&language=d" method="post">
	      				<input name="typ" type="hidden" value="3">
	   				<input type="image" src="resource/template/vorlagen/Springer/VK_dt_Springer_VS_voll.jpg" height="170px">
				</form>
			</td>
			
			<td class="auswahl">
				<h4>K&uuml;chen und Badezimmer</h4>
				<form action="index.php?site=formularKueBa&language=d" method="post">
	      				<input name="typ" type="hidden" value="5">
	   				<input type="image" src="resource/template/vorlagen/KueBa/VK_dt_KueBa_VS_voll.jpg" height="170px">
				</form>
			</td>
			</tr>
			<tr>
			<td class="auswahl">
				<h4>Eigenheim-Umbau/-Neubau</h4>
				<form action="index.php?site=formularEigenheim&language=d" method="post">
	      				<input name="typ" type="hidden" value="2">
	   				<input type="image" src="resource/template/vorlagen/Umbau_Neubau/VK_dt_Umbau_Neubau_VS_voll.jpg" height="170px">
				</form>
			</td>
			<td class="auswahl">
				 <h4>Monteur</h4>
				<form action="index.php?site=formularMonteur&language=d" method="post">
	      				<input name="typ" type="hidden" value="601">
	   				<input type="image" src="resource/template/vorlagen/Monteur/VK_dt_Monteur_VS_voll.jpg" height="170px">
				</form>
			</td>
		
		
			
			<td class="auswahl">
				<h4>Administration</h4>
				<form action="index.php?site=formularAdmin&language=d" method="post">
	      				<input name="typ" type="hidden" value="1">
	   				<input type="image" src="resource/template/vorlagen/Administration/VK_dt_Administration_VS_voll.jpg" height="170px">
				</form>
			</td>
		</tr>
	</table>