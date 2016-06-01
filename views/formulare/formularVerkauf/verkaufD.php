<?php

session_start(); 
if(!isset($_SESSION['username']))
	header("location:index.php"); // Re-direct to index.php


require('pdfGenerator/pdfgenerator.php');
$pdfGenerator = new pdfGenerator();
$message = "";
$anz = "";
$filialnr= "";
$name = "";	
$vorname = "";
$function1 ="";
$function2 ="";
$sparte ="";
$street = "";
$zip = "";
$mail ="";
$mailEnding = "@fust.ch";
$mobile ="";
$phone = "";
$fax ="";
$freierTag = "";	
$Errmessage = "";

if (isset($_POST['filialnr']))
	$filialnr = $pdfGenerator->customspecialchars(trim($_POST['filialnr']));
if (isset($_POST['vorname']))
	$vorname = $pdfGenerator->customspecialchars(trim($_POST['vorname']));
if (isset($_POST['name']))
	$name = $pdfGenerator->customspecialchars(trim($_POST['name']));
if (isset($_POST['function1'])) 
	$function1 = $pdfGenerator->customspecialchars(trim($_POST['function1']));
if (isset($_POST['function2'])) 
	$function2 = $pdfGenerator->customspecialchars(trim($_POST['function2']));
if (isset($_POST['sparte'])) 
	$sparte = $pdfGenerator->customspecialchars(trim($_POST['sparte']));
if (isset($_POST['street']))
	$street = $pdfGenerator->customspecialchars(trim($_POST['street']));
if (isset($_POST['zip'])) 
	$zip = $pdfGenerator->customspecialchars(trim($_POST['zip']));
if (isset($_POST['mail'])) 
{
	$mail = $pdfGenerator->customspecialchars(trim($_POST['mail']));
	if (strpos($mail,'@') != false)
	$Errmessage =	 "<script type='text/javascript'>alert ('Email muss ohne @fust.ch eingegeben werden.');</script>";
}
if (isset($_POST['phone']))
{
	$phone = $pdfGenerator->customspecialchars(trim($_POST['phone']));
	$array = str_split($phone);
	if (count($array) < 13)
		$Errmessage = "<span class='red' style=\"font-size:10px;\">Die Telefonnummer ist im falschen Format. Bitte formatieren Sie die Telefonnummer wie folgt: 071 123 45 78</span>";
	else
		if ($array[3] != " " || $array[7] != " " || $array[10] != " ")
			$Errmessage = "<span class='red' style=\"font-size:10px;\">Die Telefonnummer ist im falschen Format. Bitte formatieren Sie die Telefonnummer wie folgt: 071 123 45 78</span>";
}
	
	
if (isset($_POST['fax']))
	$fax = $pdfGenerator->customspecialchars(trim($_POST['fax']));		
if (isset($_POST['freierTag']))
	$freierTag = $pdfGenerator->customspecialchars(trim($_POST['freierTag']));		
if (isset($_POST['anz']))
	$anz = $pdfGenerator->customspecialchars(trim($_POST['anz']));




if (isset($_POST['order']) && $Errmessage == "")
{
	$freierWochentag = "";
	if ($freierTag != "")
		$freierWochentag = "Freier Wochentag: ".$freierTag;
	$filename = $filename = $pdfGenerator->generatePdf("verkauf", "D", array($vorname.' '.$name, $function1.' '.$sparte, $function2, 'Dipl.Ing.Fust AG ', $street, $zip, $mail.'@fust.ch', 'Telefon '.$phone.' · Fax '.$fax, $freierWochentag), $filialnr, $anz);
	$message = 'Besten Dank für Ihre Bestellung! <br /> <a href="vcards/'.urlencode($filename).'" target="_blank">PDF ansehen<br />  <a href="index.php?site=cardSelection&language=d">Neue Visitenkarte erstellen</a>';
}


include_once('views/header.php');

?>	
		<script LANGUAGE="JavaScript">
function confirmSubmit()
{
var agree=confirm("Sind Sie sicher dass Sie bestellen möchten? Haben Sie alle Texte nochmals überprüft?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>

				<h3>Verkauf</h3>
		
				<form action="index.php?site=formularVerkauf&language=d" method="post">
					<table class="formularTabelle">	
						<tr>
						  <td align="right">Filial-Nr.:</td>
						  <td>
								<input name="filialnr" type="text" size="6" maxlength="36" value="<?php echo $filialnr;?>">
								<span class="tabellenKommentar" >
									(wird nur für interne Zwecke benötigt)
								</span>
							</td>
						</tr>
						<tr>
						  <td align="right">Name:</td>
						  <td><input name="name" type="text" size="30" maxlength="20" value="<?php echo $name;?>"></td>
						</tr>
						<tr>
						  <td align="right">Vorname:</td>
						  <td><input name="vorname" type="text" size="30" maxlength="20" value="<?php echo $vorname;?>"></td>
						</tr>
						<tr>
						  <td align="right">Funktion Zeile 1:</td>
						  <td>
							<select name="function1" type="text" size="1" maxlength="36" value="<?php echo $function1;?>">
							<option <?php if ($function1 == "Verkaufsberater")  { echo 'selected'; } ?>>Verkaufsberater</option>
							<option <?php if ($function1 == "Verkaufsberaterin")  { echo 'selected'; } ?>>Verkaufsberaterin</option>
							<option <?php if ($function1 == "Abteilungsleiter")  { echo 'selected'; } ?>>Abteilungsleiter</option>
							<option <?php if ($function1 == "Abteilungsleiterin")  { echo 'selected'; } ?>>Abteilungsleiterin</option>
							<option <?php if ($function1 == "Filialleiter")  { echo 'selected'; } ?>>Filialleiter</option>
							<option <?php if ($function1 == "Filialleiterin")  { echo 'selected'; } ?>>Filialleiterin</option>
							<option <?php if ($function1 == "PC-Techniker")  { echo 'selected'; } ?>>PC-Techniker</option>
							<option <?php if ($function1 == "Lernender")  { echo 'selected'; } ?>>Lernender</option>
							<option <?php if ($function1 == "Lernende")  { echo 'selected'; } ?>>Lernende</option>
							</select>
						  </td>
						</tr>
						<tr>
						  <td align="right">Funktion Zeile 2:</td>
						  <td><input name="function2" type="text" size="30" maxlength="35" value="<?php echo $function2;?>"></td>
						</tr>
						<tr>
						  <td align="right">Sparte:</td>
						   <td>
							<select name="sparte" type="text" size="1" maxlength="36" value="<?php echo $sparte;?>">
								<option <?php if ($sparte == "Elektrohaushalt")  { echo 'selected'; } ?>>Elektrohaushalt</option>
								<option <?php if ($sparte == "Multimedia")  { echo 'selected'; } ?>>Multimedia</option>
								<option <?php if ($sparte == "Elektrohaushalt/Multimedia")  { echo 'selected'; } ?>>Elektrohaushalt/Multimedia</option>
								<option <?php if ($sparte == "Foto")  { echo 'selected'; } ?>>Foto</option>
							</select>
						  </td>
						</tr>
						<tr>
						  <td align="right">Strasse:</td>
						  <td><input name="street" type="text" size="30" maxlength="23" value="<?php echo $street;?>"></td>
						</tr>
						<tr>
						  <td align="right">PLZ/Ort:</td>
						  <td><input name="zip" type="text" size="30" maxlength="23" value="<?php echo $zip;?>"></td>
						</tr>
						<tr>
						  <td align="right">E-Mail:</td>
						  <td>
							<input name="mail" type="text" size="30" maxlength="33" value="<?php echo $mail;?>">
							<?php echo $mailEnding; ?>
						</td>
						<tr>
						  <td align="right">Telefon:</td>
						  <td><input name="phone" type="text" size="30" maxlength="36" value="<?php echo $phone;?>"><?php echo $Errmessage; ?></td>
						</tr>
						<tr>
						  <td align="right">Fax:</td>
						  <td><input name="fax" type="text" size="30" maxlength="36" value="<?php echo $fax;?>"></td>
						</tr>
						
						<tr>
						  <td align="right">Freier Wochentag:</td>
						  <td><input name="freierTag" type="text" size="30" maxlength="36" value="<?php echo $freierTag;?>"></td>
						</tr>
						<tr>
							<td style="padding-top:10;">
								<input type="submit" value="Vorschau aktualisieren" name="preview">
							</td>
						</tr>
						<tr>
							<td style=padding-top:60px;><p>&nbsp;</p></td>
							<td style=padding-top:60px;>
								<hr width="100%" noshade class="view-AllFormular-HorizontalLine" size="5" />
							</td>
						</tr>
						<tr>
							<td align="right">Anzahl:</td>
							<td>
								<select name="anz" size="1">
									<option>300</option>
									<option>100</option>
								</select>
								<input type="submit" value=" Bestellen " name="order" onClick="return confirmSubmit()" <?php if($Errmessage != "") echo("disabled= 	\"disabled\""); ?>>
							</td>
						</tr>
					</table>
				</form>
				<?php echo $message; ?>
			<div class="vorschaufenster" >
				<img src="resource/template/vorlagen/Verkauf/VK_dt_Verkauf_VS_leer.jpg" width="400px" />
				<div class="view-formularVerkauf-vorschau-name"><?php echo $vorname; echo ' '; echo $name; ?></div>
				<div class="view-formularVerkauf-vorschau-function1"><?php echo $function1; echo ' '; echo $sparte ?></div>
				<div class="view-formularVerkauf-vorschau-function2"><?php echo $function2; ?></div>
				<div class="view-formularVerkauf-vorschau-adressZeile"><?php echo 'Dipl.Ing.Fust AG <span class="orange">|</span> '; echo $street; echo ' <span class="orange">|</span> '; echo $zip; ?></div>
				<div class="view-formularVerkauf-vorschau-mail"><?php echo $mail; echo $mailEnding; ?></div>
				<div class="view-formularVerkauf-vorschau-nummern"><?php if ($phone != "") { echo ' Telefon '; echo $phone; } if ($fax != "") {  echo ' · Fax '; echo $fax; } ?></div>
				<div class="view-formularVerkauf-vorschau-freierWochentag"><?php if ($freierTag != "") { echo 'Freier Wochentag: '; echo $freierTag; } ?></div>
			</div>
			<div class="vorschaufenster-rueckseite">
				<img src="resource/template/img/Visit_Verkauf_RS_de.jpg" width="400px" />
			</div>
		</div>
	</body>
</html>




	