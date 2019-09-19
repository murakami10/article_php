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
<title>COMMENT</title>
</head>
<body>
<p>COMMENT</p>
<?php
	$pdo = connect();
	
	$sql ="select * from user inner join comment on user.id = comment.user_id where id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1,$_POST["id"]);
	$stmt->execute();

	$all = $stmt->fetchAll();
?>
<p><?php echo $_POST["name"]?></p>
<table border=1 align="center">
	<tr><th><p>comment</p></th><th><p>change comment</p></th><th><p>delete comment</p></th></td>
<?php
	foreach($all as $row){
?>
	<tr>
		<td>
			<p><?php echo $row["content"]?></p>
		</td>
		<td>
			<form action="./change_comment.php" method="post">
				<input type="hidden" value="<?php echo $row["comment_id"]?>" name="id">
				<p><input class="button" type="submit" value="change"></p>
			</form>
		</td>
		<td>
			<form action="./dele_comment.php" method="post">
				<input type="hidden" value="<?php echo $row["comment_id"]?>" name="id">
				<p><input class="button" type="submit" value="dele"></p>
			</form>
		</td>
	</tr>

<?php
	}
	
?>
</table>
<p><a href="./delete.php">Back</a></p>
<p><a href="./menu.php">Admin</a></p>
<p><a href="../display.php">Board</a></p>
<p><a href="../../login.php">Logout</a></p>
</body>
</html>

