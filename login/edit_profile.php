<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');

$pdo = connect();
$sql ="select * from user where id = :id";
$stmt= $pdo->prepare($sql);
$stmt->bindValue(':id', $_SESSION["id"], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch();				

$introduction = "";

if(!empty($_SESSION['introduction']))
{
	$introduction = $_SESSION['introduction'];
	$introduction_error = "自己紹介は300文字以下にしてください";
	unset($_SESSION['introduction']);
}else
{
	$introduction = $result["introduction"];
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
</style>
<meta charset="UTF-8">
<title>自己紹介編集</title>

</head>
<body>
<?php include('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title">自己紹介</h1>

<?php
if(!empty($introduction_error))
{
?>
	<p class="error"><?= $introduction_error ?>
<?php
}
				
?>
	<form action="./complete_profile.php" method="post">
		<p><textarea name="introduction"class="area" rows="4"><?= $introduction?></textarea></p>
		<p class="submit"><input type="submit" value="投稿"></p>
	</form>
<p><a href="./mypage.php?number=<?= $_SESSION["id"]?>">My profile</a></p>
<p><a href="./article.php">記事一覧に戻る</a></p>
</div>
</div>
<?php include('footer.php')?>
</body>
</html>
