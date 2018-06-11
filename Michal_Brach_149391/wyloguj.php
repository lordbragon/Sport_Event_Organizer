<?php
session_start();
if (!isSet($_SESSION['zalogowany'])) 
{
	header('Location: index.php');
}
unset($_SESSION['zalogowany']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
	<head>
		<title>Moja galeria</title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="css.css" />
	</head>
	<body>
		<div id="strona">
			<h1>Galeria Zdjęć</h1>
			<?php include('menu.php'); ?>
			<h2>Wylogowany</h2>
		</div>
	</body>
</html>