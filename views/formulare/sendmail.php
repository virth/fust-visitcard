<?php
$objekt_name = $pdfGenerator->customspecialchars(trim($_POST['objekt_name']));
$kontaktaufnahme_betreffend = $pdfGenerator->customspecialchars(trim($_POST['kontaktaufnahme_betreffend']));
$offerte = $pdfGenerator->customspecialchars(trim($_POST['offerte']));
$reparatur = $pdfGenerator->customspecialchars(trim($_POST['reparatur']));
$unterhalt = $pdfGenerator->customspecialchars(trim($_POST['unterhalt']));
$mitteilung = $pdfGenerator->customspecialchars(trim($_POST['mitteilung']));
$objekt_vorname = $pdfGenerator->customspecialchars(trim($_POST['objekt_vorname']));
$objekt_strasse = $pdfGenerator->customspecialchars(trim($_POST['objekt_strasse']));
$objekt_plz = $pdfGenerator->customspecialchars(trim($_POST['objekt_plz']));
$objekt_ort = $pdfGenerator->customspecialchars(trim($_POST['objekt_ort']));
$objekt_telefon = $pdfGenerator->customspecialchars(trim($_POST['objekt_telefon']));
$objekt_email = $pdfGenerator->customspecialchars(trim($_POST['objekt_email']));
$konktakt_name = $pdfGenerator->customspecialchars(trim($_POST['konktakt_name']));
$konktakt_vorname = $pdfGenerator->customspecialchars(trim($_POST['konktakt_vorname']));
$konktakt_strasse = $pdfGenerator->customspecialchars(trim($_POST['konktakt_strasse']));
$konktakt_plz = $pdfGenerator->customspecialchars(trim($_POST['konktakt_plz']));
$konktakt_ort = $pdfGenerator->customspecialchars(trim($_POST['konktakt_ort']));
$konktakt_telefon = $pdfGenerator->customspecialchars(trim($_POST['konktakt_telefon']));
$konktakt_email = $pdfGenerator->customspecialchars(trim($_POST['konktakt_email']));
$rg_objekt = $pdfGenerator->customspecialchars(trim($_POST['rg_objekt']));
$rg_kontaktperson = $pdfGenerator->customspecialchars(trim($_POST['rg_kontaktperson']));

			$absendername = "Website Kontakt";
			$absendermail = "kontaktformular@fatzer-ag.ch";
			$betreff = "Kontaktformular Fatzer";
			$text = "ein test".$objekt_name.$kontakt_ort; 
			mail('wirth.joshua@gmail.com', $betreff, $text, "From: $absendername <$absendermail>");	

?>