<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');
include('./post_foreach');

	if($_SERVER['REQUEST_METHOD'] === "POST")
	{
		$id = "";
		$id = $_SESSION["id"];

		$pdo = connect();

		$sql = "select * from user where id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result['password'] == $_POST['now_password'])
		{
			$errors = array();	
			$data = post_foreach($_POST);
			$errors = validation($data);
			if(empty($errors))
			{
				$sql = "update user set password = :password where id = :id";
				$stmt_update = $pdo->prepare($sql);
				$stmt_update->bindValue(':password',$_POST['next_password'],PDO::PARAM_STR);
				$stmt_update->bindValue(':id',$_SESSION['id'],PDO::PARAM_STR);
				$stmt_update->execute();
				header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php#pass");
				exit;
			}else
			{
				foreach($errors as $key=>$value)
				{
					$_SESSION[$key] = $value;
				}
				header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/change_password.php");
				exit;
			}
		}else
		{
			$_SESSION['now_password'] = "現在のパスワードが正しくありません";
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/change_password.php");
			exit;
		}
	}

function validation($data){
	$errors = array();

	if($data['next_password'] != $data['re_password']){
		$errors['not_match_password'] = "新しく入力したパスワードと確認用のパスワードが一致しません";
	}elseif(mb_strlen($data['next_password']) == 0)
	{
		$erros['not_match_password'] = "please fill in password";
	}
	return $errors;
}

