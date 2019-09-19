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
<title>コメントの表示</title>

</head>
<body>
<?php include('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title">アカウント情報の変更</h1>
<p><a href="./change_name.php">名前を変更する</a></p>
<p><a href="./change_password.php">パスワードを変更する</a></p>
<p><a href="./delete_account.php">アカウントを削除する</a></p>
<p><a href="./article.php">記事一覧に戻る</a></p>
</div>
</div>
<?php include('footer.php')?>
</body>
</html>
