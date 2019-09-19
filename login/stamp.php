<?php
function stamp($string)
{
	$pattern = '/:[a-zA-Z0-9]*:/';
	$str_replace = h($string);
	if(preg_match_all($pattern, $str_replace, $matches, PREG_OFFSET_CAPTURE))
	{
		$pdo = connect();
		foreach($matches[0] as $value)
		{
			$stamp_name = $value[0];
			$sql = "select * from stamp where stamp_name = :stamp_name";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':stamp_name', $stamp_name, PDO::PARAM_STR);
			$stmt->execute();
			
			$count_sql = $stmt->rowCount();
			if($count_sql == 1)
			{
				$row = $stmt->fetch();
				$image = '<img class="stamp" src="../stamp/'.h($row["stamp_image"]).'">';
				$match = '/' . $value[0] . '/';				
				$str_replace = preg_replace($match, $image, $str_replace, 1);
			}
		}
	}

	return $str_replace;
}
?>
