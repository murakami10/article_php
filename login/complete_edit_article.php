<?php
session_start();
if(empty($_SESSION['id']))
{
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "../login.php");
	exit;
}
include('./connect_sql.php');
include('./post_foreach.php');


	if($_SERVER["REQUEST_METHOD"] === "POST")
	{
		if($_POST["made_by"] == $_SESSION["id"] || $_SESSION["admin"] == 1)
		{
			$errors = array();
			$data = post_foreach($_POST);
			$errors = validation($data);

			if(empty($errors))
			{
				$pdo = connect();
				$sql = "update article set article_title = :article_title,article_content = :article_content where article_id = :article_id";
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(':article_title', $_POST["article_title"],PDO::PARAM_STR);
				$stmt->bindValue(':article_content', $_POST["article_content"],PDO::PARAM_STR);
				$stmt->bindValue(':article_id', $_POST["article_id"], PDO::PARAM_INT);
				$stmt->execute();
				header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php#edit");
				exit;
			}else
			{
				foreach($errors as $key=>$value)
				{
					$_SESSION[$key] = $value;
				}
				$_SESSION["article_title"] = $_POST["article_title"];
				$_SESSION["article_content"] = $_POST["article_content"];
				header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/edit_article.php?article_id=" . $_POST["article_id"]);
				exit;
			}
		}else
		{
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php");
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
		if(mb_strlen($data["article_title"]) > 30)
		{
			$errors["article"] = "題名は30文字以下にしてください";
		}elseif(mb_strlen($data["article_title"]) == 0)
		{
			$errors["article"] = "題名を入力してください";
		}
	
		if(mb_strlen($data["article_content"]) > 300)
		{
			$errors["content"] = "本文は300文字以下にしてください";
		}elseif(mb_strlen($data["article_content"]) == 0)
		{
			$errors["content"] = "本文を入力してください";
		}
		
		return $errors;
	}
?>
