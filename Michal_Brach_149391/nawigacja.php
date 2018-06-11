<div id="nawigacja">
	<ul>
		<li><a href="index.php">nowe zdjęcie</a></li>
		<li><a href="galeria.php">galeria zdjęć</a></li>
		<?php
		if (isSet($_SESSION['zapamietane']))
		{
			echo '<li><a href="zapamietane.php">zapamiętane</a></li>';
		}
		
		if (isSet($_SESSION['logged']))
		{
			echo '<li><a href="wyloguj.php">wyloguj się</a></li>';
		}
		else
		{
			echo '<li><a href="logowanie.php">zaloguj się</a></li>';
		}
		?>
	</ul>
	<div id="clear"></div>
	<p id="zalogowany">
		<?php
		if (isSet($_SESSION['logged']))
		{
			echo 'Zalogowany jako ' . $_SESSION['logged_login'];
		}
		else
		{
			echo 'Nie jesteś zalogowany.';
		}
		?>
	</p>
</div>