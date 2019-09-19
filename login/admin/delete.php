<?php
session_start();
if($_SESSION['admin'] != 1){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login.php");
	exit;
}
include("./connect_sql.php");
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
<p>DELETE</p>
<?php
	$pdo = connect();
	
	$sql ="select * from user";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	if($_SERVER["REQUEST_METHOD"]==="POST")
	{
		$sql = "select * from user where id = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1,$_POST["id"]);
		$stmt->execute();
	}else{
		$sql ="select * from user";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	}
	$all = $stmt->fetchAll();
?>
<table border=1 align="center">
	<tr><th><p>name</p></th><th><p>change name</p></th><th><p>delete account</p></th><th><p>refer comment</p></th></td>
<?php
	foreach($all as $row){
?>
	<tr>
		<td><p><?php echo $row["name"]?></p></td>
		<td>
			<form action="./change_name.php" method="post">
				<input type="hidden" value="<?php echo $row["id"]?>" name="id">
				<p><input class="button" type="submit" value="name"></p>
			</form>
		</td>
		<td>
			<form action="./dele_comp.php" method="post" onsubmit="return submitdel('<?= $row["name"]?>')">
				<input type="hidden" value="<?php echo $row["id"]?>" name="id">
				<p><input class="button" type="submit" value="dele"></p>
			</form>
		</td>
		<td>
			<form action="./comment.php" method="post">
				<input type="hidden" value="<?php echo $row["id"]?>" name="id">
				<input type="hidden" value="<?php echo $row["name"]?>" name="name">
				<p><input class="button" type="submit" value="comment"></p>
			</form>
		</td>
	</tr>

<?php
	}
	
?>
</table>

<script>
	function submitdel(name){
		var flag = confirm("Really delete " + name + "?");
		return flag;
	}
</script>
<p><a href="./menu.php">Admin</a></p>
<p><a href="../article.php">Article</a></p>
<p><a href="../display.php">Board</a></p>
<p><a href="../../login.php">Logout</a></p>
</body>
</html>







