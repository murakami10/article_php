<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');
include('./post_foreach.php');
include('./h.php');

$content = "";
$article = "";

		if($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$errors = array();
			$data = post_foreach($_POST);
			$errors = validation($data);
			if(empty($errors))
			{
				$newfilename = "";
				if(!empty($_FILES['file_upload']))
				{
					$file = $_FILES['file_upload']['name'];
					$newfilename = date("YmdHis") . "-".$file;
					$upload = "../image/" . $newfilename;
					if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload))
					{
						//echo '成功';
					}else
					{
						//echo '失敗';
						$newfilename = "";
					}
				}
				$pdo = connect();
				$stmt= $pdo->prepare('INSERT INTO article(article_id, article_title, article_content, made_by, article_time, image) VALUES (:article_id, :article_title, :article_content, :made_by, :article_time, :image)');
				$stmt->bindValue(':article_id', null, PDO::PARAM_NULL);
				$stmt->bindValue(':article_title', $_POST['article'], PDO::PARAM_STR);
				$stmt->bindValue(':article_content', $_POST['content'], PDO::PARAM_STR);
				$stmt->bindValue(':article_time', (int)$_SERVER['REQUEST_TIME'], PDO::PARAM_INT);
				$stmt->bindValue(':made_by', $_SESSION['id'], PDO::PARAM_INT);
				$stmt->bindValue(':image', $newfilename, PDO::PARAM_STR);
				$stmt->execute();
				header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php#add");
				exit;
			}else
			{
				$article = $data["article"];
				$content = $data["content"];
			}
					
		}

function validation($data)
{
	$errors = array();
	if(mb_strlen($data["article"]) > 30)
	{
		$errors["article"] = "題名は30文字以下にしてください";
	}elseif(mb_strlen($data["article"]) == 0)
	{
		$errors["article"] = "題名を入力してください";
	}

	if(mb_strlen($data["content"]) > 300)
	{
		$errors["content"] = "本文は300文字以下にしてください";
	}elseif(mb_strlen($data["content"]) == 0)
	{
		$errors["content"] = "本文を入力してください";
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
<title>記事投稿</title>

</head>
<body>
<?php include_once('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title">新規記事</h1>

<?php
	if(!empty($errors["article"]))
	{
?>
		<p class="error"><?= $errors["article"] ?></p>
<?php
	}
?>
		
<?php
	if(!empty($errors["content"]))
	{
?>
		<p class="error"><?= $errors["content"] ?></p>
<?php
	}
?>


	<form action="" method="post" enctype="multipart/form-data">
		<p>題名</p>
		<p class="mail"><input type="text" name="article" value="<?= h($article)?>"></p>
		<p>本文</p>
		<p><textarea name="content"class="area" rows="4"><?= h($content)?></textarea></p>
		<input type="file" name="file_upload">
		<p class="submit"><input type="submit" value="投稿"></p>
	</form>

<a href="./article.php">記事一覧にもどる</a>
</div>
</div>
<?php include('footer.php')?>
</body>
</html>
