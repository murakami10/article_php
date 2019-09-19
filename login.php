<?php
session_start();
	if(!empty($_SESSION["id"])){
		unset($_SESSION["id"]);
	}
	if(!empty($_SESSION["admin"])){
		unset($_SESSION["admin"]);
	}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
<style>
	#msg{
		margin-top: 3px;
		color: #3A9804;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<meta charset="UTF-8">
<title>ログイン</title>
</head>
<body>


<?php
	$login_id = "";
	if($_SERVER["REQUEST_METHOD"]==='POST'){
		$login_id = $_POST["login_id"];
	}
?>
<div id="form">

<p class="form-title">Login</p>

<div id="in">
<p id="msg">登録が完了しました</p>
</div>
<p id="error">アカウントが削除されました</p>
<script>
	if(location.hash=="#dele"){
		$("#error").fadeIn()
	}else{
		$("#error").hide();
	}

	if(window.performance.navigation.type == 1){
		var url = location.protocol + "//" + location.host + location.pathname;
		location.href = url;
	}
	
	if(location.hash=="#message"){
		$("#in").fadeIn()
	}else{
		$("#in").hide();
	}
</script>


<?php
	if(!empty($_SESSION['login_error'])){
?>

		<p id="error">
			<?php echo $_SESSION['login_error'] ?>
		</p>

<?php
		unset($_SESSION['login_error']);
	}
	if(!empty($_SESSION['login_id'])){
		$login_id = $_SESSION['login_id'];
		unset($_SESSION['login_id']);
	}
?>

<form action="./login/admin_login.php" method="post">
	<p id="login_id">Login ID</p>	
	<p class="mail">
	<input type="text" name="login_id" value="<?php echo $login_id ?>">
	</p>
	<p>Password</p>
	<p class="pass">
	<input type="password" name="password" value="" >
	</p>
	<p class="submit">
	<input type="submit" value="ログイン">
	</p>
</form>
<a href="./apply/create.php">アカウントをお持ちでない方はこちら</a>
</div>
<footer class="footer">

</footer>



</body>
</html>
