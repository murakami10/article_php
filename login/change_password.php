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
<meta charset="UTF-8">
<title>passwordの変更</title>
</head>
<body>
<?php include('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title">パスワードの変更</h1>
<?php
	if(!empty($_SESSION['not_match_password']))
	{
?>
		<div class="alert">
			<p><?= $_SESSION['not_match_password']?></p>
		</div>
<?php
		unset($_SESSION['not_match_password']);
	}

	if(!empty($_SESSION['now_password']))
	{
?>
		<div class="alert">
			<p><?= $_SESSION['now_password']?></p>
		</div>
<?php
		unset($_SESSION['now_password']);
	}
?>
	<form action="./complete_change_password.php" method="post">
		<p>現在のパスワード</p>
		<p class="pass"><input type="password" name="now_password" value=""></p>
		<p>新しいパスワード</p>
		<p class="pass"><input type="password" name="next_password" value=""></p>
		<p>確認用のパスワード</p>
		<p class="pass"><input type="password" name="re_password" value=""></p>
		<p class="submit"><input type="submit" value="変更"></p>
	</form>

<p><a href="./article.php">記事一覧に戻る</a></p>
</div>
</div>
<?php include('footer.php')?>
</body>
</html>
