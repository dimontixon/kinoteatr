<?php
	session_start();
	include_once 'layout/header.php';
	//include_once 'layout/menu.php';

	if(isset($_GET["action"]))
		$actionValue = $_GET["action"];
	else
		$actionValue="main";

	$filename =  'views/'.$actionValue.'.php';
	if (file_exists($filename)) {
		include_once $filename;
	}
	else{
		include_once "views/main.php";
	}

 	include_once 'layout/footer.php';
?>
