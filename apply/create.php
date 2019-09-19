<?php
session_start();
$name = "";
$login_id = "";
$misspassword = "";
$missid = "";
$missname = "";
	if(!empty($_SESSION))
	{
		if(!empty($_SESSION['name'])){
			$name = $_SESSION["name"];
		}
		if(!empty($_SESSION['login_id'])){
		$login_id = $_SESSION["login_id"];
		}
		if(!empty($_SESSION["missname"])){
			$missname = $_SESSION["missname"];
		}
		if(!empty($_SESSION["misspassword"])){
			$misspassword = $_SESSION["misspassword"];
		}
		if(!empty($_SESSION["missid"])){
			$missid = $_SESSION["missid"];
		}
		unset($_SESSION['name']);
		unset($_SESSION['login_id']);
		unset($_SESSION['missid']);
		unset($_SESSION['missname']);
		unset($_SESSION['misspassword']);
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="stylesheet" href="../style.css">
	<style>
		.error{
			text-align: center;
			color: #C24338;
		}
		input.form{
			width: 90%;
			
		}
		#result_success{
			margin-top: 3px;
			color: #3A9804;
		}
		#result_error{
			margin-top: 3px;
			color: #C24338;
		}
	</style>
<meta charset="UTF-8">
<title>コメントの表示</title>
</head>
<body>
<div id="form">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<p class="form-title">新規登録</p>
<p class="error">
<?php
	if(!empty($missname)){ 
		echo $missname . "<br />";
	} 
?>
</p>
<p class="error">
<?php
	if(!empty($misspassword)){ 
		echo $misspassword . "<br />";
	} 
?>
</p>
<p class="error">
<?php if(!empty($missid)){
		echo $missid . "<br />";
	}
?>
</p>


<form action="create_user.php" method="POST">
	<p>名前</p>
	<p class="login_id"><input type="text" name="name" class="form" value="<?php echo $name?>"></p>
	<p>ログインID</p>
	<p class="login_id"><input id="id_number" type="text" name="login_id" class="form" value="<?php echo $login_id?>"></p>
	<div id="result_success"></div>
	<div id="result_error"></div>
	<p>パスワード</p>
	<p class="login_id"><input type="password" name="password" class="form" value=""></p>
	<p>確認用のパスワード</p>
	<p class="pass"><input type="password" name="repassword" class="form" value=""></p>
	<p class="submit"><input type="submit" value="登録"></p>
</form>


<a href=../login.php>ログイン画面に戻る</a>
</div>

<script type="text/javascript" src="./login.js"></script>

</body>
</html>































