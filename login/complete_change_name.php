<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');
include('./post_foreach.php');


$complete = "";

	if($_SERVER['REQUEST_METHOD'] === "POST")
	{
		$errors = array();

		$data = post_foreach($_POST);
		$errors = validation($data);

		$pdo = connect();
		if(empty($errors))
		{
			$sql = "UPDATE user SET name = :name where id = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':name',$_POST['name']);
			$stmt->bindValue(':id',$_SESSION['id']);
			$stmt->execute();
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php#name");
			exit;
		}else
		{
			$_SESSION["error_name"] = $errors["name"];
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/change_name.php");	
		}
	}else{
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php");
		exit;
	}

function validation($data)
{
	$errors = array();
	if(mb_strlen($data["name"]) > 20)
	{
		$errors["name"] = "名前は20文字以下にしてください";
	}elseif(mb_strlen($data["name"]) == 0)
	{
		$errors["name"] = "名前を入力してください";
	}

	return $errors;
}
?>


