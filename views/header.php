<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	header("Content-Type: text/html; charset=iso-8859-1");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/> 		
		 <link href="../style/style.css" rel="stylesheet" type="text/css" />
		 <script src="http://code.jquery.com/jquery-latest.js"></script>
		<title>E-Druck Visitenkarten</title>
	</head>
	<body>
		<a href="http://www.edruck.ch" target="_blanc">
			<img style="border-style:none;" src="resource/logo/logo_mit_e-druck.png" class="headerLogo" />
		</a>
		<a href="http://fust.ch" target="_blanc">
			<img style="border-style:none;"  src="resource/logo/logo_fust.png" class="headerLogo" />
		</a>
	<?php 
		if(isset($_SESSION['username']))
		{ 
			echo '<a href="views/logout.php">';
			echo '<img class="logoutIMG" src="resource/button/button_logout.png" />';
			echo '</a>';
		}
 	?>
	<hr noshade />
	<div class="content" >

		
