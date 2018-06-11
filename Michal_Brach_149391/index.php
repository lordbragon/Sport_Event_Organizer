<?php
session_start();
$informacja = '';
$czy_mini = 0;
if (isSet($_POST['tytul'])) 
{
	$nazwa = $_FILES['zdjecie']['name'];
	$plik = explode('.', $nazwa);
	$rozszerzenie = $plik[count($plik)-1];//tblica ma dwa elementy ale indeks od zera
		
	if (($rozszerzenie == 'jpeg' || $rozszerzenie == 'JPG'|| $rozszerzenie == 'jpg' || $rozszerzenie == 'png' ) && $_FILES['zdjecie']['size'] <= 1048576) 
	{
		if (move_uploaded_file($_FILES['zdjecie']['tmp_name'], 'images/normalne/' . $nazwa)) 
		{
			
			$xml = simplexml_load_file('images.xml');
			$nowy = $xml->addChild('image');
			$nowy->addChild('title', $_POST['tytul']);
			$nowy->addChild('path', $nazwa);
			
			if (isSet($_SESSION['zalogowany']) && isSet($_POST['prywatne'])) 
			{
				$nowy->addChild('public', 'no');
				$nowy->addChild('userid', $_SESSION['zalogowany']);
			}
			else 
			{
				$nowy->addChild('public', 'yes');
			}
			
			$xml->asXML('images.xml');
			
			if ($rozszerzenie == 'png')
			{
				$obrazek = imagecreatefrompng('images/normalne/' . $nazwa);
			}
			else
			{
				$obrazek = imagecreatefromjpeg('images/normalne/' . $nazwa);
			}
			
			$rozmiar = getimagesize('images/normalne/' . $nazwa);
			$nowy = imagecreatetruecolor(200, 100);
			imagecopyresampled($nowy, $obrazek, 0, 0, 0, 0, 200, 100, $rozmiar[0], $rozmiar[1]);
			$kolor = $_POST["kolor"];
			if($kolor == "niebieski"){
				$kolorek=imagecolorallocate($obrazek, 0, 0, 255);
			}
			else if($kolor =="czerwony"){
				$kolorek=imagecolorallocate($obrazek, 255, 0, 0);
			}
			else{
				$kolorek=imagecolorallocate($obrazek, 0, 255, 0);
			}
			imagestring($obrazek, 5, ceil($rozmiar[0]/2), ceil($rozmiar[1]/2), $_POST['wodny'], $kolorek);//ceil przybliza wzwyz
			
			if ($rozszerzenie == 'jpeg' || $rozszerzenie == 'JPG' || $rozszerzenie == 'jpg' ) 
			{
				imagejpeg($nowy, 'images/mini/' . $nazwa);
				imagejpeg($obrazek, 'images/wodne/' . $nazwa);
			}
			else 
			{
				imagepng($nowy, 'images/mini/' . $nazwa);
				imagepng($obrazek, 'images/wodne/' . $nazwa);
			}
			$informacja = "Plik został pomyślnie wysłany.<br/>nazwa: ".$_POST['tytul']."<br/>rozszerzenie: ".$rozszerzenie."<br/>znak wodny: ".$_POST['wodny'] ."<br/>kolor: $kolor <br/>";		
			$czy_mini = 1;
		}
		else
			$informacja = 'Plik nie został wysłany.';
	}
	else 
	{
		if ($rozszerzenie != 'jpeg' && $rozszerzenie != 'jpg' && $rozszerzenie != 'png')
		{
			$zly_format = 1;
		}
		else
		{
			$zly_format = 0;
		}
		if ($_FILES['zdjecie']['size'] > 1048576)
		{
			$zbyt_duzy = 1;
		}
		else
		{
			$zbyt_duzy = 0;
		}
		
		if ($zbyt_duzy && $zly_format)
		{
			$informacja = 'Plik jest za duzy i ma zły format.';
		}
		else if ($zbyt_duzy)
		{
			$informacja = 'Plik jest zbyt duży.';
		}
		else
		{
			$informacja = 'Plik ma złe rozszerzenie.';			
		}
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
			<h1>Dodaj zdjecie</h1>
			<?php
			include('menu.php');
			?>
			<form action="index.php" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Dodaj nowe zdjęcie</legend>
					<label>
						Wybierz plik:
						<br />
						<span>(plik musi być w formacie png lub jpeg, jego wielkość nie może przekraczać 1MB)</span>
						<input type="file" name="zdjecie" />
					</label>
					<label>
						Tytuł zdjęcia:
						<br />
						<input type="text" name="tytul" />
					</label>
					<label>
						Znak wodny:
						<br />
						<input type="text" name="wodny" />
					</label>
					<label>
						Kolor znaku wodnego:
						<br/>
						<input type="radio" name="kolor" value="niebieski" checked="checked"/>niebieski<br/>
						<input type="radio" name="kolor" value="czerwony" />czerwony<br/>
						<input type="radio" name="kolor" value="zielony" />zielony<br/>
					</label>
					<label>
						<?php
						if (isSet($_SESSION['zalogowany'])) 
						{
						?>
						Zdjęcie prywatne:
						<br />
						<input type="checkbox" name="prywatne" />
						<?php
						}
						else 
						{
							echo 'jeżeli jesteś niezalogowany przesłany plik zostanie dodany jako element publicznie dostępny w galerii';
						}
						?>
					</label>
					<input type="submit" value="wyślij" />
					<?php
					echo "<br />$informacja";
					if($czy_mini){
						 echo "<img src='".'images/mini/'.$nazwa."'></img><br /><br />";
					}
					?>
				</fieldset>
			</form>
		</div>
	</body>
</html>