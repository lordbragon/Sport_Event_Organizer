<div id="menu">
	<ul>
		<li><a href="index.php">nowe zdjęcie</a></li>
		<li><a href="galeria.php">galeria zdjęć</a></li>
		<?php
		if (isSet($_SESSION['zapamietane']))
		{
			echo '<li><a href="zapamietane.php">zapamiętane</a></li>';
		}
		
		if (isSet($_SESSION['zalogowany']))
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
		if (isSet($_SESSION['zalogowany']))
		{
			echo '<p style="color:white" >Zalogowany jako ' . $_SESSION['logged_login'].'</p>';
		}
		else
		{
			echo '<p style="color:red">Nie jesteś zalogowany.</p>';
		}
		?>
	</p>
</div>