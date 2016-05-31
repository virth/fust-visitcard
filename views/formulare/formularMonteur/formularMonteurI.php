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
	$sparte = "";
	$region = "";
	$mail ="@fust.ch";
	$mobile ="";
	$phone = "";
	$fax ="";

	if (isset($_POST['anz']))
		$anz = $pdfGenerator->customspecialchars(trim($_POST['anz']));
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
	if (isset($_POST['region'])) 
		$region = $pdfGenerator->customspecialchars(trim($_POST['region']));
	
	
	if (isset($_POST['order']))
	{
		$filename = $pdfGenerator->generatePdf
		(
			"monteur", 
			"I", 
			array
			(
				$vorname.' '.$name, //0
				$function1.' '.$sparte, // 1
				$function2, //2
				'Region '.$region //3
			), 
			$filialnr, 
			$anz
		);
		$message = 'Grazie per la vostra ordinazione <br /> <a href="vcards/'.urlencode($filename).'" target="_blank">Visionare PDF<br />  <a href="index.php?site=cardSelection&language=i">Ordinare nuova carta da visita</a>';
	}

include_once('views/header.php');

?>	

<script LANGUAGE="JavaScript">
function confirmSubmit()
{
var agree=confirm("Siete sicuri di volere ordinare? Avete controllato ancora bene tutti i testi?");
if (agree)
	return true ;
else
	return false ;
}
</script>

				<h3>montatore</h3>
		
				<form action="index.php?site=formularMonteur&language=i" method="post">
					<table class="formularTabelle">	
						<tr>
						  <td align="right">Numero filiale:</td>
						  <td>
								<input name="filialnr" type="text" size="6" maxlength="10"  value="<?php echo $filialnr; ?>">
								<span class="tabellenKommentar" >
									(per scopi interni é necessario)
								</span>
							</td>
						</tr>
						<tr>
						  <td align="right">Cognome:</td>
						  <td><input name="name" type="text" size="30" maxlength="20" value="<?php echo $name;?>"></td>
						</tr>
						<tr>
						  <td align="right">Nome:</td>
						  <td><input name="vorname" type="text" size="30" maxlength="20" value="<?php echo $vorname;?>"></td>
						</tr>
						<tr>
						  <td align="right">Funzione 1:</td>
						  <td><input name="function1" type="text" size="30" maxlength="35" value="<?php echo $function1;?>"></td>
						</tr>
						<tr>
						  <td align="right">Funzione Zeile 2:</td>
						  <td><input name="function2" type="text" size="30" maxlength="35" value="<?php echo $function2;?>"></td>
						</tr>
						<tr>
						  <td align="right">Ressort:</td>
						  <td><input name="sparte" type="text" size="30" maxlength="17" value="<?php echo $sparte;?>"></td>
						</tr>
						<tr>
						  <td align="right">Region:</td>
						  <td><input name="region" type="text" size="30" maxlength="30" value="<?php echo $region;?>"></td>
						</tr>
						<tr>
							<td style="padding-top:10;">
								<input type="submit" value="veduta" name="preview">
							</td>
						</tr>
						<tr>
							<td style=padding-top:60px;><p>&nbsp;</p></td>
							<td style=padding-top:60px;>
								<hr width="100%" noshade class="view-AllFormular-HorizontalLine" size="5" />
							</td>
						</tr>
						<tr>
							<td align="right">Quantité:</td>
							<td>
								<select name="anz" size="1">
	      							<option>100</option>
									<option>300</option>
								</select>
								<input type="hidden" name="typ" value="<?php echo $typ; ?>">
								<input type="submit" value=" ordine " name="order" onClick="return confirmSubmit()">
							</td>
						</tr>
					</table>
				</form>
				<?php echo $message; ?>
			<div class="vorschaufenster" >
				<img src="resource/template/vorlagen/Monteur/VK_ital_Monteur_leer.jpg" width="400px" />
				<div class="view-formularMonteur-vorschau-name"><?php echo $vorname; echo ' '; echo $name; ?></div>
				<div class="view-formularMonteur-vorschau-function1"><?php echo $function1; echo ' '; echo $sparte; ?></div>
				<div class="view-formularMonteur-vorschau-function2"><?php echo $function2; ?></div>
				<div class="view-formularMonteur-vorschau-region"><?php echo 'Region '; echo $region; ?></div>
			</div>
		</div>
	</body>
</html>


		