<?php
session_start();
if($_SESSION['admin'] != 1){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login.php");
	exit;
}
include('./connect_sql.php');

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$pdo = connect();
	$sql = "update comment set content = ? where comment_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1,$_POST["content"]);
	$stmt->bindValue(2,$_POST["id"]);
	$stmt->execute();
	header("Location: http://" . $_SERVER["HTTP_HOST"] . "/php/login/admin/delete.php");
	exit;
}else
{
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login/admin/delete.php");
	exit;
}

?>


















