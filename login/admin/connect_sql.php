<?php
function connect()
{
	$dsn = 'mysql:dbname=board;host=localhost';
	$user = 'root';
	$password = '0000';

	try{
		$pdo = new PDO($dsn, $user, $password,[
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_EMULATE_PREPARES => false,
	]);
		return $pdo;
	}catch (PDOException $e) {
		exit('データベース接続失敗'.$e->getMessage());
	}
	
}
	
?>
