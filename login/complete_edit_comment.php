<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');
include('./post_foreach.php');


	if($_SERVER["REQUEST_METHOD"] === "POST")
	{
		$pdo = connect();
		$sql = "select * from comment where comment_id = :comment_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':comment_id',$_POST["comment_id"],PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch();

		if($row["user_id"] == $_SESSION['id'] || $_SESSION["admin"] == 1)
		{
			$errors = array();
			$data = post_foreach($_POST);
			$errors = validation($data);

			if(empty($errors))
			{
				$sql = "update comment set content = :content where comment_id = :comment_id";
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(':content',$_POST["content"],PDO::PARAM_STR);
				$stmt->bindValue(':comment_id',$_POST["comment_id"],PDO::PARAM_INT);
				$stmt->execute();
				header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/display.php#edit");
				exit;
			}else
			{
				$_SESSION["content_error"] = $errors["content_error"];
				$_SESSION["content"] = $_POST["content"];
				header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/edit_comment.php?comment_id=" . $_POST["comment_id"]);
				exit;
			}
		}else
		{
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/display.php");
			exit;
		}
	}else
	{
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php");
		exit;
	}

function validation($data)
{
	$errors = array();

	if(mb_strlen($data["content"]) > 300)
	{
		$errors["content_error"] = "本文は300文字以下にしてください";
	}elseif(mb_strlen($data["content"]) == 0)
	{
		$errors["content_error"] = "本文に何か入力してください";
	}
	return $errors;
}
?>

