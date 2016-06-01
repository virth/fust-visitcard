<?php
	session_start(); 
	if(!isset($_SESSION['username']))
		header("location:index.php"); // Re-direct to index.php



	require('pdfGenerator/pdfgenerator.php');
	$pdfGenerator = new pdfGenerator();

	$anz = "";
	$message = "";
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
                	$Errmessage =	 "<script type='text/javascript'>alert ('E-mail doit étre entré sans @fust.ch');</script>";
	}
	if (isset($_POST['phone']))
	{
		$phone = $pdfGenerator->customspecialchars(trim($_POST['phone']));
	    $array = str_split($phone);
		if (count($array) < 13)
			$Errmessage = "<span class='red' style=\"font-size:10px;\">Le né de téléphone néa pas le format correct. Veuillez le corriger comme suit: 071 123 45 78</span>";
		else
			if ($array[3] != " " || $array[7] != " " || $array[10] != " ")
				$Errmessage = "<span class='red' style=\"font-size:10px;\">Le né de téléphone néa pas le format correct. Veuillez le corriger comme suit: 071 123 45 78</span>";
	}

	if (isset($_POST['fax']))
		$fax = $pdfGenerator->customspecialchars(trim($_POST['fax']));		
	if (isset($_POST['freierTag']))
		$freierTag = $pdfGenerator->customspecialchars(trim($_POST['freierTag']));		
	if (isset($_POST['anz']))
		$anz = $pdfGenerator->customspecialchars(trim($_POST['anz']));

	if (isset($_POST['order']))
	{
		$freierWochentag = "";
		if ($freierTag != "")
			$freierWochentag = "jour congé: ".$freierTag;
		$filename = $pdfGenerator->generatePdf("verkauf", "F", array($vorname.' '.$name, $function1.' '.$sparte, $function2, 'Ing. dipl. Fust SA ', $street, $zip, $mail.'@fust.ch', 'Téléphone '.$phone.' · Fax '.$fax, $freierWochentag), $filialnr, $anz);
		$message = 'Merci pour votre commandation <br /> <a href="vcards/'.urlencode($filename).'" target="_blank">Visionner PDF<br />  <a href="index.php?site=cardSelection&language=f">Commander nouvelle carte de visite</a>';
	}


	include_once('views/header.php');

?>	

<script LANGUAGE="JavaScript">
function confirmSubmit()
{
var agree=confirm("étes-vous sure, que vous voulez comander? Avez vous controllé tous les textes?");
if (agree)
	return true ;
else
	return false ;
}
</script>


				<h3>vendeur</h3>
		
				<form action="index.php?site=formularVerkauf&language=f" method="post">
					<table class="formularTabelle">	
						<tr>
						  <td align="right">Numéro filiale:</td>
						  <td>
								<input name="filialnr" type="text" size="6" maxlength="10" value="<?php echo $filialnr;?>">
								<span class="tabellenKommentar" >
									 (pour usage interne)
								</span>
							</td>
						</tr>
						<tr>
						  <td align="right">Nom:</td>
						  <td><input name="name" type="text" size="30" maxlength="20" value="<?php echo $name;?>"></td>
						</tr>
						<tr>
						  <td align="right">Prénom:</td>
						  <td><input name="vorname" type="text" size="30" maxlength="20" value="<?php echo $vorname;?>"></td>
						</tr>
						<tr>
						  <td align="right">Fonction 1:</td>
						  <td>
							<select name="function1" type="text" size="1" maxlength="35" value="<?php echo $function1;?>">
							<option <?php if ($function1 == "Conseillère de vente")  { echo 'selected'; } ?>>Conseillère de vente</option>
							<option <?php if ($function1 == "Conseiller de vente")  { echo 'selected'; } ?>>Conseiller de vente</option>
							<option <?php if ($function1 == "Chef du département")  { echo 'selected'; } ?>>Chef du département</option>
							<option <?php if ($function1 == "Chef de succursale")  { echo 'selected'; } ?>>Chef de succursale</option>
							<option <?php if ($function1 == "Chef de marché")  { echo 'selected'; } ?>>Chef de marché</option>
							<option <?php if ($function1 == "Chef de vente régional")  { echo 'selected'; } ?>>Chef de vente régional</option>
							<option <?php if ($function1 == "Chef de vente")  { echo 'selected'; } ?>>Chef de vente</option>
							<option <?php if ($function1 == "Technicien PC")  { echo 'selected'; } ?>>Technicien PC</option>
							<option <?php if ($function1 == "Personnes en formation")  { echo 'selected'; } ?>>Personnes en formation</option>
							</select>
						  </td>
						</tr>
						<tr>
						  <td align="right">Fonction 2:</td>
						  <td><input name="function2" type="text" size="30" maxlength="35" value="<?php echo $function2;?>"></td>
						</tr>
						<tr>
						  <td align="right">Ressort:</td>
						   <td>
							<select name="sparte" type="text" size="1" maxlength="36" value="<?php echo $sparte;?>">
								<option <?php if ($sparte == "électroménager")  { echo 'selected'; } ?>>électroménager</option>
								<option <?php if ($sparte == "multimedia")  { echo 'selected'; } ?>>multimedia</option>
								<option <?php if ($sparte == "électroménager/multimedia")  { echo 'selected'; } ?>>électroménager/multimedia</option>
								<option <?php if ($sparte == "photo")  { echo 'selected'; } ?>>photo</option>
							</select>
						  </td>
						</tr>
						<tr>
						  <td align="right">Rue:</td>
						  <td><input name="street" type="text" size="30" maxlength="30" value="<?php echo $street;?>"></td>
						</tr>
						<tr>
						  <td align="right">NAP/lieu:</td>
						  <td><input name="zip" type="text" size="30" maxlength="30" value="<?php echo $zip;?>"></td>
						</tr>
						<tr>
						  <td align="right">E-Mail:</td>
						  <td>
							<input name="mail" type="text" size="30" maxlength="33" value="<?php echo $mail;?>">
							<?php echo $mailEnding; ?>
						</td>
						<tr>
						  <td align="right">Téléphone:</td>
						  <td><input name="phone" type="text" size="30" maxlength="36" value="<?php echo $phone;?>"><?php echo $Errmessage; ?></td>
						</tr>
						<tr>
						  <td align="right">Fax:</td>
						  <td><input name="fax" type="text" size="30" maxlength="36" value="<?php echo $fax;?>"></td>
						</tr>
						
						<tr>
						  <td align="right">jour congé:</td>
						  <td><input name="freierTag" type="text" size="30" maxlength="36" value="<?php echo $freierTag;?>"></td>
						</tr>
						<tr>
							<td style="padding-top:10;">
								<input type="submit" value="vue d'ensemble" name="preview">
							</td>
						</tr>
						<tr>
							<td style=padding-top:60px;><p>&nbsp;</p></td>
							<td style=padding-top:60px;>
								<hr width="100%" noshade class="view-AllFormular-HorizontalLine" size="5" />
							</td>
						</tr>
						<tr>
							<td align="right">Nombre:</td>
							<td>
								<select name="anz" size="1">
									<option>300</option>
									<option>100</option>
								</select>
								<input type="submit" value=" commande " name="order" onClick="return confirmSubmit()" <?php if($Errmessage != "") echo("disabled= 	\"disabled\""); ?>>
							</td>
						</tr>
					</table>
				</form>
				<?php echo $message; ?>
			<div class="vorschaufenster" >
				<img src="resource/template/vorlagen/Verkauf/VK_franz_Verkauf_VS_leer.jpg" width="400px" />
				<div class="view-formularVerkauf-vorschau-name"><?php echo $vorname; echo ' '; echo $name; ?></div>
				<div class="view-formularVerkauf-vorschau-function1"><?php echo $function1; echo ' '; echo $sparte ?></div>
				<div class="view-formularVerkauf-vorschau-function2"><?php echo $function2; ?></div>
				<div class="view-formularVerkauf-vorschau-adressZeile" <?php if((strlen($street) + strlen($zip)) > 32) { echo 'style=font-size:9px;'; } ?>><?php echo 'Ing. dipl. Fust SA <span class="orange">|</span> '; echo $street; echo ' <span class="orange">|</span> '; echo $zip; ?></div>
				<div class="view-formularVerkauf-vorschau-mail"><?php echo $mail; echo $mailEnding; ?></div>
				<div class="view-formularVerkauf-vorschau-nummern"><?php if ($phone != "") { echo ' Téléphone '; echo $phone; } if ($fax != "") {  echo ' · Fax '; echo $fax; } ?></div>
				<div class="view-formularVerkauf-vorschau-freierWochentag"><?php if ($freierTag != "") { echo 'jour congé: '; echo $freierTag; } ?></div>
			</div>
			<div class="vorschaufenster-rueckseite">
				<img src="resource/template/vorlagen/Verkauf/VK_franz_Verkauf_RS.jpg" width="400px" />
			</div>
		</div>
	</body>
</html>



