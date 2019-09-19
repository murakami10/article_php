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
				$sql = "DELETE FROM article WHERE article_id = :article_id";
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(':article_id',$_POST['article_id'],PDO::PARAM_INT);
				$stmt->execute();

				$sql = "delete from comment where com_article_id = :com_article_id";
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(':com_article_id', $_POST["article_id"],PDO::PARAM_INT);
				$stmt->execute();

				header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php#dele");
			 	exit;
			}
	}else
	{
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php");
		exit;
	}

?>
