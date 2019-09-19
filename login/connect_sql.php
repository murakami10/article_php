<?php
function connect()
{
	$dsn = 'mysql:dbname=board;host=localhost';
	$user = 'root';
	$password = '0000';

	try{
		$pdo = new PDO($dsn, $user, $password);
		return $pdo;
	}catch (PDOException $e) {
		exit('データベース接続失敗'.$e->getMessage());
	}
	
}
	
?>
