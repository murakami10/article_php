<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');
include('./post_foreach.php');
include('./h.php');

$name = "";

		if($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$errors = array();
			$data = post_foreach($_POST);
			$errors = validation($data, $_FILES['file_upload']['size']);
			if(empty($errors))
			{
				$pdo = connect();
				$sql = "select stamp_name from stamp where stamp_name = :stamp_name";
				$stmt_stamp = $pdo->prepare($sql);
				$stmt_stamp->bindValue(':stamp_name', ':'.$_POST['name'].':', PDO::PARAM_STR);
				$stmt_stamp->execute();
				$count_sql = $stmt_stamp->rowCount();
				if($count_sql == 1)
				{
					$errors['name'] = "そのスタンプの名前はすでに使われています。";
				}else
				{

					$newfilename = "";
					$file = $_FILES['file_upload']['name'];
					$newfilename = date("YmdHis") . "-".$file;
					$upload = "../stamp/" . $newfilename;
					if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload))
					{
						$sql =	'INSERT INTO stamp(stamp_id, stamp_name, stamp_image) VALUES (:stamp_id, :stamp_name, :stamp_image)';
						$stmt= $pdo->prepare($sql);
						$stmt->bindValue(':stamp_id', null, PDO::PARAM_NULL);
						$stmt->bindValue(':stamp_name', ':'.$_POST['name'].':', PDO::PARAM_STR);
						$stmt->bindValue(':stamp_image', $newfilename, PDO::PARAM_STR);
						$stmt->execute();
						header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php#add");
						exit;
					}else
					{
						echo '失敗';
						$newfilename = "";
					}
				}
				$name = $data["name"];
			}else
			{
				$name = $data["name"];
			}
					
		}

function validation($data,$file_size)
{
	$errors = array();
	$pattern = '/[^a-z0-9_]+/';

	if(preg_match($pattern, $data["name"]))
	{
		$errors["name"] = "半角英数字、アンダーバーのみでスタンプの名前をつけてください";
	}
	else
	{
		if(mb_strlen($data["name"]) > 20)
		{
			$errors["name"] = "スタンプの名前はは20文字以下にしてください";
		}elseif(mb_strlen($data["name"]) == 0)
		{
			$errors["name"] = "スタンプ名を入力してください";
		}
	}

	if($file_size === 0)
	{
		$errors["image"] = "画像を選んでください";
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
	#result_success{
		margin-top: 3px;
		color: #3A9804;
	}
	#result_error{
		margin-top: 3px;
		color: #C24338;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="./search_stamp.js"></script>
<meta charset="UTF-8">
<title>スタンプ追加</title>
</head>
<body>
<?php include_once('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title">新しいスタンプの追加</h1>

<?php
	if(!empty($errors["name"]))
	{
?>
		<p class="error"><?= $errors["name"] ?></p>
<?php
	}
?>
<?php
	if(!empty($errors["image"]))
	{
?>
		<p class="error"><?= $errors["image"] ?></p>
<?php
	}
?>
	<form action="" method="post" enctype="multipart/form-data">
		<p>スタンプの名前</p>
		<p>(英数字とアンダーバーのみで決めてください)</p>
		<p class="mail"><input id="stamp_name" type="text" name="name" value="<?= h($name)?>"></p>		
		<div id="result_success"></div>
		<div id="result_error"></div>
		<input type="file" name="file_upload">
		<p class="submit"><input type="submit" value="追加"></p>
	</form>

<a href="./article.php">記事一覧にもどる</a>
</div>
</div>
<?php include('footer.php')?>
</body>
</html>
