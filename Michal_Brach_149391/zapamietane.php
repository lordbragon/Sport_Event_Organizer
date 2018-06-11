<?php
session_start();

if (isSet($_POST['zapomnij'])) 
{
	$nowa = array_diff(explode(',', $_SESSION['zapamietane']), $_POST['zapomnij']);
	if (empty($nowa)) 
	{
		unset($_SESSION['zapamietane']);
		header('Location: galeria.php');
	}
	else
	{
		$_SESSION['zapamietane'] = implode(',', $nowa);
	}
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
			<h1>Zapamiętane Zdjęcia</h1>
			<?php
			include('nawigacja.php');
			
			$images = simplexml_load_file('images.xml');
			
			$stan = 0;
			echo '<form action="zapamietane.php" method="post">';
			$zapamietane = explode(',', $_SESSION['zapamietane']);
			foreach ($images as $obrazek) 
			{
				$html = '<a href="images/wodny/' . $obrazek->path . '" target="_blank"><img src="images/mini/' . $obrazek->path . '" /></a><input type="checkbox" name="zapomnij[]" value="' . $obrazek->path . '" /> ';
				
				if (in_array($obrazek->path, $zapamietane)) 
				{
					if ($obrazek->public == 'yes') 
					{
						$stan++;
						echo $html;
					}
					elseif ($obrazek->public == 'no' && isSet($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == $obrazek->userid) 
					{
						$stan++;
						echo $html;
					}
				}
			}
			echo '<br /><br /><input type="submit" value="zapomnij wybrane" />';
			echo '</form>';
			
			if ($stan == 0) 
			{
				echo 'brak zdjęć.';
			}
			?>
		</div>
	</body>
</html>