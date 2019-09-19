<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');
include('./h.php');

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$pdo = connect();

	$sql = "select * from user where id = ?";
	$stmt= $pdo->prepare($sql);
	$stmt->bindValue(1, $_GET["number"], PDO::PARAM_INT);
	$stmt->execute();
		
	$num = $stmt->rowCount();
	if($num == 0)
	{
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/mypage.php?number=" . $_SESSION["id"]);
	}
	$result = $stmt->fetch();

	if($_SESSION['id'] == $_GET['number'])
	{
		$sql = "select article_id, article_title, article_content, favorite_user_id from article inner join favorite on article.article_id = favorite.favorite_article_id where favorite_user_id = :favorite_user_id";
		$stmt_favorite = $pdo->prepare($sql);
		$stmt_favorite->bindValue(':favorite_user_id',$_SESSION['id'],PDO::PARAM_INT);
		$stmt_favorite->execute();
		$rows = $stmt_favorite->fetchAll();
		$count_favorite = $stmt_favorite->rowCount();
	}				
}else
{
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "./article.php");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./style.css">
<style>
	.area{
		width: 98%;
	}
	.not_break{
		word-break: break-all;
	}
	.name{
		width: 30%;
	}
	.content{
		word-break: break-all;
		width: 70%;
	}
	#favorite{
		margin-right: -30px;
		margin-left: -30px;
		background-color:#FFCC99;
	}
	
</style>
<script type="text/javascript" src="move_article.js"></script>
<meta charset="UTF-8">
<title>page</title>

</head>
<body>
<?php include('header.php')?>
<div class="wrapper">
<div id="form">

<h1 class="form-title">
<?php
	echo $result["name"];
?>
</h1>
		<p>自己紹介</p>
		<p class="not_break"><?= h($result["introduction"])?></p>
<br>
<?php 
if($_SESSION["id"] == $_GET["number"]){

if($count_favorite != 0)
{
?>
<div id="favorite">
<p>お気に入りにした記事</p>
<table>
<thead><tr><th class="name">題名</th><th class="content">内容</th></thead>
<tbody>
<?php 
			foreach ($rows as $row) 
			{
?>
			<tr>
				<td class="name" onclick="move_article('<?= $row["article_id"]?>')">
					<?= h($row['article_title'])?>

				</td>
				<td class="content" onclick="move_article('<?= $row["article_id"]?>')"s>
					<?= h($row['article_content'])?>

				</td>
			<tr>
<?php
			}
?>
</tbody>
</table>
</div>
<?
}
?>
<p><a href="./edit_profile.php">自己紹介を編集する</a></p>
<?php
}
?>

<p><a href="./article.php">記事一覧に戻る</a></p>
</div>
</div>
<?php include('footer.php')?>
</body>
</html>
