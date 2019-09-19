
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./style.css">
<meta charset="UTF-8">
<title>コメントの表示</title>
</head>
<body>
<?php
$checks = array();
$errors = array();
	if($_SERVER["REQUEST_METHOD"]==="POST"){
		try{
			$dsn = 'mysql:dbname=board;host=localhost';
			$user = 'root';
			$password = '0000';

			$pdo = new PDO($dsn, $user, $password);

			$sql = "select * from user where login_id = ?";

			$stmt_slt = $pdo->prepare($sql);
	
			$stmt_slt->bindValue(1,$_POST["login_id"]);
			$stmt_slt->execute();

			foreach($_POST as $key => $value){
				$checks[$key] = $value;
			}
			$checks["num"] = $stmt_slt->rowCount();

			$errors = validation($checks);

			if(empty($errors)){
				$sql = "INSERT INTO user(id, login_id, name, password, admin, introduction) VALUES (:id, :login_id, :name, :password, :admin, :introduction)";
				$stmt_in = $pdo->prepare($sql);
				$stmt_in->bindValue(':id', null, PDO::PARAM_NULL);
				$stmt_in->bindValue(':login_id', $_POST["login_id"], PDO::PARAM_STR);
				if($_POST["name"] == ""){
					$name = "名無し";
				}else{
					$name = $_POST['name'];
				}
				$stmt_in->bindValue(':name', $name,PDO::PARAM_STR);
				$stmt_in->bindValue(':password', $_POST["password"],PDO::PARAM_STR);
				$stmt_in->bindValue(':admin',0,PDO::PARAM_INT);
				$stmt_in->bindValue(':introduction','',PDO::PARAM_STR);
				$stmt_in->execute();
				$_SESSION["create"] = 1;
				header("Location: http://" . $_SERVER['HTTP_HOST'] . "/php/login.php#message");
			}else{
				foreach($errors as $key=>$value){
					$_SESSION[$key] = $value;
				}
				$_SESSION["name"] = $_POST["name"];
				$_SESSION["login_id"] = $_POST["login_id"];
				header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/create.php");
				exit;
			}

		}catch(PDOException  $e){
			exit('データベース接続失敗'.$e->getMessage());
		}
	}else{
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/create.php");
		exit;
	}

function validation($data){

	$error = array();
	if(strlen($data["name"])>30){
		$error["missname"] = "名前は30文字以内にしてください";
		echo "name error";
	}

	if($data["password"] != $data["repassword"]){
		$error["misspassword"] = "入力したパスワードと確認用のパスワードが違います";
	}elseif(strlen($data["password"]) == 0){
		$error["misspassword"] = "パスワードを入力してください";
	}
	if($data["num"] != 0){
		$error["missid"] = "そのログインIDはすでに使われています。";
	}elseif(strlen($data["login_id"]) == 0){
		$error["missid"] = "ログインIDを入力してください";
	}
	return $error;

}
?>

</body>
</html>




