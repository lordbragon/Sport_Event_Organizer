<?php
session_start();

if (isSet($_POST['zapamietaj'])) 
{
	if (!empty($_POST['zapamietaj'])) 
	{
		if (isSet($_SESSION['zapamietane']))
		{
			$_SESSION['zapamietane'] = explode(",",$_SESSION['zapamietane']);//stringa na array
			$_SESSION['zapamietane'] = implode(',', array_merge($_SESSION['zapamietane'], $_POST['zapamietaj']));//laczymy tablice i convert na stringa
		}
		else
		{
			$_SESSION['zapamietane'] = implode(',', $_POST['zapamietaj']);
		}
	}
}
?>