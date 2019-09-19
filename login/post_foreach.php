<?php

function post_foreach($post)
{
	$data = array();

	foreach($_POST as $key=>$value)
	{
		$data[$key] = $value;
	}

	return $data;
}

?>
