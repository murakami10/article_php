<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./style.css">
<style>
	#msg{
		margin: 3px;
		font-size: 20px;
		padding-bottom: 10px;
		color: #C24338;

	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<meta charset="UTF-8">
<title>アカウントの削除</title>
</head>
<body>
<?php include('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title">アカウントの削除</h1>
<p id="msg">パスワードが一致しません</p>

<script type="text/javascript" src="./dele_acc.js"></script>

<form action="./complete_delete_account.php" method="post" onsubmit="return submitChk()">
		<p>パスワードを入力してください</p>
		<p class="pass"><input type="password" name="password" value=""></p>
		<p class="submit"><input type="submit" value="アカウントを削除する"></p>
</form>

<p><a href="./article.php">記事一覧に戻る</a></p>

</div>
</div>
<?php include('footer.php')?>
</body>
</html>
