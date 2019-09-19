<?php
include('./connect_sql.php');
session_start();

	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$pdo = connect();
		
		$sql = "SELECT * FROM user where login_id = :login_id and password = :password ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':login_id',$_POST["login_id"],PDO::PARAM_STR);
		$stmt->bindValue(':password',$_POST["password"],PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();
		$num = $stmt->rowCount();
		if($num == 1){
			$_SESSION['id'] = $result['id'];
			$_SESSION['admin'] = $result['admin'];
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php");
			exit;
		}elseif($num == 0)
		{
			$_SESSION['login_error'] = "ログインIDまたはパスワードが間違っています。";
			$_SESSION['login_id'] = $_POST['login_id'];
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
			exit;			
		}
		
	}	

?>

