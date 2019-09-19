<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') 
{		
		if(($_SESSION['id'] == $_POST['ids']) || $_SESSION["admin"] == 1)
		{
			$pdo = connect();
			$sql = "DELETE FROM comment WHERE comment_id = :comment_id";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':comment_id',$_POST['comment_id'],PDO::PARAM_INT);
			$stmt->execute();
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/display.php#dele");
		 	exit;
		}
}else
{
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php");
	exit;
}

?>
