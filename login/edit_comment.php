<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');
$content = "";
$content_error = "";

	if($_SERVER["REQUEST_METHOD"] === "GET")
	{
		$pdo = connect();

		$sql = "select * from comment where comment_id = :comment_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':comment_id',$_GET["comment_id"],PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		if($_SESSION["id"] == $result["user_id"])
		{
			//echo "id == login_id";
		}else
		{
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/display.php");
			exit;
		}

	}else
	{
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/display.php");
		exit;
	}
if(isset($_SESSION["content"]))
{
	$content = $_SESSION["content"];
	unset($_SESSION["content"]);
}else
{
	$content = $result["content"];
}

if(isset($_SESSION["content_error"]))
{
	$content_error = $_SESSION["content_error"];
	unset($_SESSION["content_error"]);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./style.css">
<style>
	#form{
		width: 50%;
	}
	.area{
		width: 98%;
	}
</style>
<meta charset="UTF-8">
<title>コメントの表示</title>
</head>
<body>
<?php include('header.php')?>
<div id="form">
<h1 class="form-title">編集</h1>
<?php
	if($content_error != "")
	{
?>
		<p class="error"><?=$content_error?></p>
<?php
	}
?>

	<form action="complete_edit_comment.php" method="post">
		<p>内容</p>
		<p><textarea class="area" rows="4" name="content"><?= $content?></textarea></p>
		<input type="hidden" name="comment_id" value="<?= $result["comment_id"]?>">
		<p class="submit"><input type="submit" value="編集"></p>
	</form>
<p><a href="./display.php">戻る</a></p>

</div>
<?php include('footer.php')?>
</body>
</html>
