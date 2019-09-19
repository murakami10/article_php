<?php

session_start();
if($_SESSION['admin'] != 1){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login.php");
	exit;
}
include("./connect_sql.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
$pdo = connect();

$sql = "update user set name = ? where id = ?";
$stmt_user = $pdo->prepare($sql);
$stmt_user->bindValue(1,$_POST["name"]);
$stmt_user->bindValue(2,$_POST["id"]);
$stmt_user->execute();

	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login/admin/delete.php");
	exit;
}else{
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login/admin/delete.php");
	exit;
}


?>
