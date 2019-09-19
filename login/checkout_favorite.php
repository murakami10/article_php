<?php
include('./connect_sql.php');
$id = $_POST["id"];
$article_id = $_POST["article_id"];

$pdo = connect();
$sql = "select favorite_id from favorite where favorite_user_id = :favorite_user_id and favorite_article_id = :favorite_article_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':favorite_user_id', $id, PDO::PARAM_INT);
$stmt->bindValue(':favorite_article_id', $article_id, PDO::PARAM_INT);
$stmt->execute();
$count_sql = $stmt->rowCount();

if($count_sql == 1)
{
	$sql = "delete from favorite where favorite_article_id = :favorite_article_id and favorite_user_id = :favorite_user_id";
	$stmt_insert = $pdo->prepare($sql);
	$stmt_insert->bindValue(':favorite_article_id',$article_id,PDO::PARAM_INT);
	$stmt_insert->bindValue(':favorite_user_id',$id,PDO::PARAM_INT);
	$stmt_insert->execute();
	$flag = 1;
}
?>
