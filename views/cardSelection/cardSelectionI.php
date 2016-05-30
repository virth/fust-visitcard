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
				 <h4>venditore</h4>
				<form action="index.php?site=formularVerkauf&language=i" method="post">
	      				<input name="typ" type="hidden" value="601">
	   				<input type="image" src="resource/template/vorlagen/Verkauf/VK_ital_Verkauf_VS_voll.jpg" height="170px">
				</form>
				</form>
			</td>
			<td class="auswahl">
				<h4>venditore - 2 filiali</h4>
				<form action="index.php?site=formularVerkaufSpringer&language=i" method="post">
	      				<input name="typ" type="hidden" value="3">
	   				<input type="image" src="resource/template/vorlagen/Springer/VK_ital_Springer_VS_voll.jpg" height="170px">
				</form>
			</td>
			<td class="auswahl">
				<h4>cucine/bagni/rinnovi</h4>
				<form action="index.php?site=formularKueBa&language=i" method="post">
	      				<input name="typ" type="hidden" value="5">
	   				<input type="image" src="resource/template/vorlagen/KueBa/VK_ital_KueBa_VS_voll.jpg" height="170px">
				</form>
			</td>
		</tr>
		<tr>
			<td class="auswahl">
				<h4>ristrutturazioni e costruzione della propria casa</h4>
				<form action="index.php?site=formularEigenheim&language=i" method="post">
	      				<input name="typ" type="hidden" value="2">
	   				<input type="image" src="resource/template/vorlagen/Umbau_Neubau/VK_ital_Umbau_Neubau_VS_voll.jpg" height="170px">
				</form>
			</td>
			<td class="auswahl">
				 <h4>montatore</h4>
				<form action="index.php?site=formularMonteur&language=i" method="post">
	      				<input name="typ" type="hidden" value="601">
	   				<input type="image" src="resource/template/vorlagen/Monteur/VK_ital_Monteur_VS_voll.jpg" height="170px">
				</form>
				</form>
			</td>
			<td class="auswahl">
				<h4>administrazione</h4>
				<form action="index.php?site=formularAdmin&language=i" method="post">
	      				<input name="typ" type="hidden" value="1">
	   				<input type="image" src="resource/template/vorlagen/Administration/VK_ital_Administration_VS_voll.jpg" height="170px">
				</form>
			</td>
		</tr>
	</table>