<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');
include('./post_foreach.php');

$content = "";

	if($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		$errors = array();
		$data = post_foreach($_POST);
		$errors = validation($data);

		if(empty($errors))
		{
			$pdo = connect();
			$stmt= $pdo->prepare('INSERT INTO comment(comment_id, com_article_id, user_id, content, time) VALUES (:comment_id, :com_article_id, :user_id, :content, :time)');
			$stmt->bindValue(':comment_id', null, PDO::PARAM_NULL);
			$stmt->bindValue(':com_article_id', $_SESSION['article'], PDO::PARAM_INT);
			$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
			$stmt->bindValue(':content', $_POST['content'], PDO::PARAM_STR);
			$stmt->bindValue(':time', (int)$_SERVER['REQUEST_TIME'], PDO::PARAM_INT);
			$stmt->execute();
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/display.php#add");
			exit;
		}else
		{
			$content = $data["content"];
		}
	}
function validation($data)
{
	$errors = array();
	if(mb_strlen($data["content"]) > 300)
	{
		$errors["content"] = "本文は300文字以下にしてください";
	}elseif(mb_strlen($data["content"]) == 0)
	{
		$errors["content"] = "本文に何か入力してください";
	}

	return $errors;

}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./style.css">
<style>
	.area{
		width: 98%;
	}
</style>
<meta charset="UTF-8">
<title>コメント投稿</title>

</head>
<body>
<?php include('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title">コメント投稿</h1>

<?php
	if(!empty($errors["content"]))
	{
?>
		<p class="error"><?= $errors["content"]?></p>
<?php
	}
?>

	<form action="" method="post">
		<p>本文</p>
		<p><textarea name="content"class="area" rows="4"><?= $content?></textarea></p>
		<p class="submit"><input type="submit" value="投稿"></p>
	</form>

<a href="./display.php">コメント一覧に戻る</a>
</div>
</div>
<?php include('footer.php')?>
</body>
</html>
