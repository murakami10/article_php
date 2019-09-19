<?php
include('./connect_sql.php');
$name = $_POST['name'];

$pdo = connect();
$sql = "SELECT stamp_name from stamp where stamp_name = :stamp_name";
$stmt = $pdo->prepare($sql);
if($name == "")
{
	$flag = -1;
}
else
{
	$stmt->bindValue(':stamp_name',':'.$name.':');
	$stmt->execute();
	$num = $stmt->rowCount();


	if($num >= 1)
	{
		$flag = 1;
	}else
	{
		$flag = 0;
	}
}


header('Content-type: application/json');
echo json_encode($flag, JSON_UNESCAPED_UNICODE);

?>
