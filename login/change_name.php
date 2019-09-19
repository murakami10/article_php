<?php
session_start();
if(empty($_SESSION['id'])){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
	exit;
}
include('./connect_sql.php');

$error_name = ""; 
if(isset($_SESSION["error_name"]))
{
	$error_name = $_SESSION["error_name"];
	unset($_SESSION["error_name"]);
}
	$pdo = connect();

	$sql = "select * from user where id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':id',$_SESSION['id']);
	$stmt->execute();
	$result = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./style.css">
<meta charset="UTF-8">
<title>コメントの表示</title>
</head>
<body>
<?php include('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title">名前の変更</h1>
<?php
	if($error_name != "")
	{
?>
		<p class="error"><?= $error_name?></p>
<?php
	}
?>


	<form action="./complete_change_name.php" method="post">
		<p class="mail"><input type="text" name="name" value="<?= $result['name']?>"></p>
		<p class="submit"><input type="submit" value="変更"></p>
	</form>

<p><a href="./article.php">記事一覧に戻る</a></p>
</div>
</div>
<?php include('footer.php')?>
</body>
</html>
