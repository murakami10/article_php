<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');

	if($_SERVER['REQUEST_METHOD'] === "POST")
	{
		$id = "";
		$id = $_SESSION["id"];

		$pdo = connect();

		$sql ="select * from user where id = :id and password = :password";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id',$id,PDO::PARAM_INT);
		$stmt->bindValue(':password',$_POST["password"],PDO::PARAM_STR);
		$stmt->execute();
		
		$num = $stmt->rowCount();
		if($num == 1)
		{
			$sql = "delete from user where id = :id";
			$stmt_user_del = $pdo->prepare($sql);
			$stmt_user_del->bindValue(':id',$id,PDO::PARAM_INT);
			$stmt_user_del->execute();

			$sql = "delete from comment where user_id = :id";
			$stmt_comment_del = $pdo->prepare($sql);
			$stmt_comment_del->bindValue(':id',$id,PDO::PARAM_INT);
			$stmt_comment_del->execute();

			unset($_SESSION["id"]);

			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php#dele");
			exit;
			
		}else
		{
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/delete_account.php#pass");
		}

	}
?>
