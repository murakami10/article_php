<?php

session_start();
if($_SESSION['admin'] != 1){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login.php");
	exit;
}
include("./connect_sql.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
$pdo = connect();

$sql = "delete from comment where comment_id = ?";
$stmt_comment_dele = $pdo->prepare("$sql");
$stmt_comment_dele->bindValue(1,$_POST["id"]);
$stmt_comment_dele->execute();

	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login/admin/delete.php");
	exit;
}else{
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login/admin/delete.php");
	exit;
}


?>
