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
	$data = post_foreach($_POST);
	$errors = validation($data);

	if(empty($errors))
	{
		$pdo = connect();
		$sql = "update user set introduction = ? where id = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $_POST["introduction"]);
		$stmt->bindValue(2, $_SESSION['id']);
		$stmt->execute();
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/mypage.php?number=".$_SESSION["id"]);
		exit;
	}else
	{
		foreach($errors as $key => $value)
		{
			$_SESSION[$key] = $value; 
		}
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/edit_profile.php");
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

if(mb_strlen($data["introduction"]) > 300)
{
	$errors["introduction"] = $data["introduction"];
}

return $errors;
}
?>



