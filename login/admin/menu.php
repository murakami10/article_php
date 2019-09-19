<?php
session_start();
if($_SESSION['admin'] != 1){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login.php");
	exit;
}
?>

<html lang="ja">
<head>
<style>
	body{
		background-color: #000;
	}
	p{
		color: #FFF;
		text-align: center;
		font-size: 30px;
	}
	a{
		color: #FFF;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<meta charset="UTF-8">
<title>ADMIN</title>
</head>
<body>
<p>YOU ARE ADMIN</p>
<div id="change">
<p><a id="world" href="./delete.php">CHANGE THE WORLD</a></p>
</div>
<p><a href="../display.php">Board</a></p>
<p><a href="../../login.php">Logout</a></p>


<script>
	$(function() {
		$('#change').hover(function() {
			$("body").css('background', '#fff');
			$("#world").css('color','#F00');
		}, function(){
			$("body").css('background', '#000');
			$("#world").css('color','#fff');
		});
	});
</script>

</body>
</html>
