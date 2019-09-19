<?php
include('./connect_sql.php');
$id = $_POST['id'];

$pdo = connect();
$sql = "SELECT * from user where login_id = ?";
$stmt = $pdo->prepare($sql);
if($id == ""){
	$flag = -1;
}
else
{
	$stmt->bindValue(1,$id);
	$stmt->execute();
	$num = $stmt->rowCount();


	if($num >= 1)
	{
		$flag = 1;
	}else{
		$flag = 0;
	}
}


header('Content-type: application/json');
echo json_encode($flag, JSON_UNESCAPED_UNICODE);

?>
