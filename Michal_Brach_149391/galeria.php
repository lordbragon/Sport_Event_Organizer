<?php
require_once("czy_zapamietane.php");
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
			<?php
			include('menu.php');
			
			$images = simplexml_load_file('images.xml');
			
			$stan = 0;
			echo '<form action="galeria.php" method="post">';
			foreach ($images as $obrazek) 
			{
				if (isSet($_SESSION['zapamietane']) && in_array($obrazek->path, explode(',', $_SESSION['zapamietane'])))
				{
					$checked = ' checked="checked"';
				}
				else
				{
					$checked = '';
				}
				
				$html = '<a href="images/wodne/' . $obrazek->path . '" target="_blank"><img src="images/mini/' . $obrazek->path . '" /></a><input type="checkbox" name="zapamietaj[]" value="' . $obrazek->path . '"' . $checked  . ' /> ';
				
				if ($obrazek->public == 'yes') 
				{
					$stan++;
					echo $html;
				}
				else if ($obrazek->public == 'no' && isSet($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == $obrazek->userid) 
				{
					$stan++;
					echo $html;
				}
			}
			if ($stan > 0)
			{
				echo '<br /><br /><input type="submit" value="zapamiętaj wybrane" />';
			}
			echo '</form>';
			
			if ($stan == 0) 
			{
				echo 'brak zdjęć.';
			}
			?>
		</div>
	</body>
</html>