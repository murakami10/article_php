<?php

session_start();
if($_SESSION['admin'] != 1){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login.php");
	exit;
}
include('./connect_sql.php');
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
	.button {
	display: inline-block;
	border-radius: 50%;
	font-size: 18pt;
	background: rgba(0, 0, 102, 0.77);
	color: #ffffff; 
	line-height: 1em;      
	transition: .3s;        
	box-shadow: 6px 6px 3px #666666;
	border: 2px solid rgba(0, 0, 102, 0.77);  
	}
	.button:hover {
		box-shadow: none;      
		color: rgba(0, 0, 102, 0.77);   
		background: #ffffff; 
	}
	a{
		color: #FFF;
	}
</style>
<meta charset="UTF-8">
<title>DELETE</title>
</head>
<body>
<p>NAME CHANGE</p>
<?php
if($_SERVER["REQUEST_METHOD"] === "POST")
{
	$pdo = connect();

	$sql = "select * from comment where comment_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1,$_POST["id"]);
	$stmt->execute();
	$result = $stmt->fetch();

?>
<form action="./comp_comment.php" method="post">
	<p><textarea name="content" rows="4" cols="40"><?= $result["content"]?></textarea></p>
	<input type="hidden" name="id" value="<?= $result["comment_id"]?>">
	<p><input type="submit" class="button" value="change"></p>
</form>

<?php
}

?>
<p><a href="./delete.php">Back</a></p>
<p><a href="./menu.php">Admin</a></p>
<p><a href="../display.php">Board</a></p>
<p><a href="../../login.php">Logout</a></p>
</body>
</html>





