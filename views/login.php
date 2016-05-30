<?php
	//Wenn Session username bereits gesetzt ist wird direkt umgeleitet
	header('P3P: CP="CAO PSA OUR"');
	session_start();
	if (isset($_SESSION['username']))
	{
		header("location:index.php?site=languageSelection");
	}
	$message="";
	$username="";
	$md5_password="";
	
	//Post request Login
	if (isset($_POST['name']))
	{
		$username=$_POST['name'];

		if (isset($_POST['pw']))
			$md5_password=md5($_POST['pw']);
		else
			$md5_password="";

		if($username=="fust" and $md5_password==md5("fust"))
		{
			$_SESSION["username"] = $username;
			header("location:/index.php?site=languageSelection");
		}
		else if($username=="admin" and $md5_password==md5("offset1"))
		{
			//header("location:admin.php");   --> Falls Admin Bereich erwünscht 
		}
		else
			$message="--- Incorrect Username or Password ---";
	}
    else
		$username= "";
	
	
	include_once 'header.php';

?>


	<form action="index.php" method="post">
	<?php print($message); ?>
	<table border="0" cellpadding="0" cellspacing="8"
		style="color: #ffffff;">
		<tr>
			<td align="right">Login:</td>
			<td><input name="name" type="text" size="30" maxlength="30"
				value=<?php echo $username; ?>></td>
		</tr>
		<tr>
			<td align="right">Passwort:</td>
			<td><input name="pw" type="password" size="30" maxlength="40"></td>
		</tr>
		<tr>
			<td style="padding-top: 30;"><input type="submit" name="submit" value=" Login "></td>
		</tr>
	</table>
	</form>
	</div>
	</body>
</html>


<?php include_once 'footer.php'; ?>