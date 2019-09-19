<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}

if($_SERVER["REQUEST_METHOD"] === "GET")
{
	if(isset($_GET["id"]))
	{
		unset($_SESSION["article"]);
		$_SESSION["article"] = $_GET["id"];
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/display.php");
		exit;
	}else
	{
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php");
		exit;
	}
}else
{
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php");
	exit;
}
?>
