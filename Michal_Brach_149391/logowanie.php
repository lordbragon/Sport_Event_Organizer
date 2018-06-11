<?php
session_start();
$informacja = '';
if (isSet($_SESSION['zalogowany'])) 
{
	header('Location: index.php');
}

$uzytkownicy = simplexml_load_file('uzytkownicy.xml');
if (isSet($_POST['login'])) 
{
	foreach ($uzytkownicy as $uzytkownik)
	{
		if ($uzytkownik->login == $_POST['login'] && $uzytkownik->password == md5($_POST['haslo'])) 
		{
			$_SESSION['zalogowany'] = (string) $uzytkownik->id;
			$_SESSION['logged_login'] = (string) $uzytkownik->login;
			header('Location: index.php');
		}
	}
	
	$informacja = 'złe dane logowania.';
}
if (isSet($_POST['login_rejestracja'])) 
{
	$nowy = $uzytkownicy->addChild('user');
	$nowy->addChild('login', $_POST['login_rejestracja']);
	$nowy->addChild('password', md5($_POST['haslo_rejestracja']));
	$nowy->addChild('id', uniqid());
	$uzytkownicy->asXML('uzytkownicy.xml');
	
	$informacja = 'zostałeś zarejestrowany.';
}
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
			<h1>Zaloguj się</h1>
			<?php include('menu.php'); ?>
			<h2>Logowanie</h2>
			<form action="logowanie.php" method="post">
				<fieldset>
					<legend>Zaloguj się na swoje konto</legend>
					<label>
						Login:
						<br />
						<input type="text" name="login" />
					</label>
					<label>
						Hasło:
						<br />
						<input type="password" name="haslo" />
					</label>
					<input type="submit" value="loguj" />
					<?php
					echo "<br />$informacja";
					?>
				</fieldset>
			</form>
			<h2>Rejestracja</h2>
			<form action="logowanie.php" method="post">
				<fieldset>
					<legend>Załóż nowe konto</legend>
					<label>
						Login:
						<br />
						<input type="text" name="login_rejestracja" />
					</label>
					<label>
						Hasło:
						<br />
						<input type="text" name="haslo_rejestracja" />
					</label>
					<input type="submit" value="rejestruj" />
					<?php
					echo "<br />$informacja";
					?>
				</fieldset>
			</form>
		</div>
	</body>
</html>