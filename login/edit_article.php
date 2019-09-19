<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');

if($_SERVER["REQUEST_METHOD"] === "GET")
{
	$pdo =connect();
	$sql = "select * from article where article_id = :article_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':article_id',$_GET["article_id"],PDO::PARAM_INT);
	$stmt->execute();
	$result = $stmt->fetch();

	if($_SESSION['id'] == $result['made_by'] || $_SESSION["admin"] == 1)
	{
		//echo "id == made_by";
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

$article_title = "";
$article_content = "";
$errors = array();

if(isset($_SESSION["article_title"]))
{
	$article_title = $_SESSION["article_title"];
	unset($_SESSION["article_title"]);
}else
{
	$article_title = $result["article_title"];
}
if(isset($_SESSION["article_content"]))
{
	$article_content = $_SESSION["article_content"];
	unset($_SESSION["article_content"]);
}else
{
	$article_content = $result["article_content"];
}
if(!empty($_SESSION["article"]))
{
	$errors["article"] = $_SESSION["article"];
	unset($_SESSION["article"]);
}
if(!empty($_SESSION["content"]))
{
	$errors["content"] = $_SESSION["content"];
	unset($_SESSION["content"]);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./style.css">
<style>
	.error{
		margin-top: 3px;
		color: #C24338;
	}
	#form{
		width: 50%;
	}
	.area{
		width: 98%;
	}
</style>
<meta charset="UTF-8">
<title>記事の編集</title>
</head>
<body>
<?php include('header.php')?>
<div id="form">
<h1 class="form-title">記事編集</h1>
<?php
	if(isset($errors["article"]))
	{
?>
		<p class="error"><?= $errors["article"] ?></p>
<?php
	}
?>
		
<?php
	if(isset($errors["content"]))
	{
?>
		<p class="error"><?= $errors["content"] ?></p>
<?php
	}
?>

	<form action="complete_edit_article.php" method="post">

		<p>題名</p>
		<p class="mail"><input type="text" name="article_title" value="<?= $article_title?>">
		<p>内容</p>
		<p><textarea class="area" rows="4" name="article_content"><?= $article_content?></textarea></p>
		<input type="hidden" name="article_id" value="<?= $result["article_id"]?>">
		<input type="hidden" name="made_by" value="<?= $result["made_by"]?>">
		<p class="submit"><input type="submit" value="編集"></p>
	</form>
<p><a href="./article.php">記事一覧に戻る</a></p>
</div>
<?php include('footer.php')?>
</body>
</html>
