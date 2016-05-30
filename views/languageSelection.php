<?php 
	//Wenn Session username bereits gesetzt ist wird direkt umgeleitet
	session_start(); 
	if(!isset($_SESSION['username']))
	{
		header("location:index.php"); // Re-direct to index.php
	}
	include_once 'views/header.php';	
?>
	
	<p>Bitte w&auml;hlen Sie die gewünschte Sprache.</p>
	<p>Choisissez la langue désirée pour les commandes on-line, s.v.p.</p>
	<p>Sceglie la lingua desiderata per le ordinazioni on-line, per favore.</p>
	<br />
	<ul>
		<li class="view-sprachAuswahl-link"><a href="index.php?site=cardSelection&language=d">Deutsch</a></li>
		<li class="view-sprachAuswahl-link"><a href="index.php?site=cardSelection&language=f">Français</a></li>
		<li class="view-sprachAuswahl-link"><a href="index.php?site=cardSelection&language=i">Italiano</a></li>	
	</ul>
	