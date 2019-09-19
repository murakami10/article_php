<?php

session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
include('./connect_sql.php');
include('./paging.php');
include('./h.php');

	$search = "";
	$pdo = connect();

	if(isset($_GET['search']) && ($_GET['search'] != ""))
	{
		$search = $_GET['search'];
		$csql = "select *from user inner join article on user.id = article.made_by where article_content like :search";
		$stmt_count = $pdo->prepare($csql);
		$stmt_count->bindValue(":search",'%'. $search .'%');
	}else
	{
		$csql = "select * from user inner join article on user.id = article.made_by";
		$stmt_count = $pdo->prepare($csql);
	}
	
	$stmt_count->execute();
	$count_sql = ceil(($stmt_count->rowCount())/10);

	if(isset($_GET['search']) && ($_GET['search'] != "") && isset($_GET['page']) && ($_GET['page'] > 0) && ($_GET['page'] <= $count_sql))
	{
		$search = $_GET['search'];
		$sql = 'select article_id,article_title,article_content,article_time,made_by from article where article_content like :search order by article_id desc limit 10 offset :page';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':search','%'.$search.'%');
		$ofset = ($_GET['page'] -1) * 10;
		$stmt->bindValue(':page',$ofset,PDO::PARAM_INT);
	}
	elseif(isset($_GET['search']) && $_GET['search'] != "")
	{
		$search = $_GET['search'];
		$sql = 'select article_id,article_title,article_content,article_time,made_by from article where article_content like :search order by article_id desc limit 10 offset 0';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':search','%'.$search.'%');
	}elseif( (isset($_GET['page'])) && ($_GET['page'] > 0)&& ($_GET['page'] <= $count_sql)){
		$sql = "select * from article order by article_id desc limit 10 offset :page";
		$stmt = $pdo->prepare($sql);
		$ofset = ($_GET['page'] -1) * 10;
		$stmt->bindValue(":page",$ofset,PDO::PARAM_INT);
	}else{
		$sql = "select article_id,article_title,article_content,article_time,made_by from article order by article_id desc limit 10 offset 0";
		$stmt = $pdo->prepare($sql);
	}
		$stmt->execute();
		$num = $stmt->rowCount();
		$result = $stmt->fetchAll();	
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./style.css">
<style>
	.form-title{
		border: none;
	}
	footer{
		margin-top: 60px
	}
	.name{
		width: 20%;
	}
	.content{
		word-break: break-all;
		width: 66%;
	}
	.edit{
		width: 7%;
	}
	.delete{
		width: 7%;
	}
	#add{
		color: #fff;
	}
	#form{
		width:90%;
		margin: 60px auto;
		margin-bottom: 0;
		padding: 30px;
		border:1px solid #555;
		text-align: start;
		background-color: #CCFFFF;
	}
	#msg{
		margin: 3px;
		font-size: 30px;
		padding-bottom: 10px;
		color: #3A9804;

	}
	#btn{
		text-align: center;
	}
	table tbody tr:hover{
			background-color: #FFCCFF;
	}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="move_article.js"></script>

<meta charset="UTF-8">
<title>記事一覧</title>
</head>
<body>
<?php include('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title">記事一覧</h1>
<div id="msg">
<p id="name_fade">名前を変更しました</p>
<p id="pass_fade">パスワードを変更しました</p>
<p id="dele_fade">記事を削除しました</p>
<p id="edit_fade">記事を編集しました</p>
<p id="add_fade">追加しました</p>
</div>
<script type="text/javascript" src="./hash.js"></script>
<form action="" method="get">
	検索したい内容: <input type="text" name="search" value="<?php if(isset($_GET["search"])) echo $_GET["search"]; ?>">
	<button type="submit">検索</button>
</form>
<?php
	if(isset($_GET['search']))
	{
?>
<form action="" method="get">
	<div  id="btn">
	<button type"submit">検索条件をクリア</button>
	</div>
</form>
<?php
	}

	if($num != 0){
?>
<table>
			<thead><tr><th class="name">題名</th><th class="content">内容</th><th class="edit">内容を編集</th><th class="delete">削除</th</tr> </thead>
<?php 
			foreach ($result as $row) 
			{
?>
				<tbody>
				<tr>
				<td class="name" onclick="move_article('<?= $row["article_id"]?>')">
					<?= h($row['article_title'])?>
				</td>
				<td class="content" onclick="move_article('<?= $row["article_id"]?>')">
					<?= h($row['article_content'])?>
				</td>
				<td class="edit">
<?php
					$time = (string) $row['article_time'];
					$day = date("Y/m/d　G時i分s秒", $time);
					$now = strtotime("-1 hour");
					if(($_SESSION['id'] == $row['made_by'] && $now < $time) || $_SESSION["admin"] == 1)
					{
?>
						<form action="./edit_article.php" method="get">
							<input type="hidden" name="article_id" value="<?= h($row['article_id'])?>">
							<input type="submit" value="編集">
						</form>
<?php
			
						if($_SESSION["admin"] == 1)
						{
?>
							<form action="./admin/delete.php" method="post">
								<input type="hidden" name="id" value="<?= $row["made_by"] ?>">
								<input type="submit" value="アカウントの詳細">
							</form>
<?php
						}
			

					}
?>
				</td>
				<td class="delete">	
<?php					
					if(($_SESSION['id'] == $row['made_by']) || $_SESSION["admin"] == 1){
?>
					<form action="./delete_article.php" method="post">
						<input type="hidden" name="article_id" value="<?= $row['article_id']?>">
						<input type="hidden" name="ids" value="<?= $row['made_by']?>">
						<input type="submit" value="削除">
					</form>
<?php
					}
?>
				</td>
				</tr>
				</tbody>
<?php
			}
	}else
	{
?>
	<p>記事は一つもありません</p>
<?php
	}
?>
	
</table>


<?php
	$limit = $count_sql;
	$page = empty($_GET["page"]) ? 1 : $_GET["page"];
	paging($limit, $page,$search);
?>
</div>
<a id="add" href="./add_article.php">記事を追加する</a><br>
</div>
<?php include('footer.php')?>
<?php $pdo = null; ?>
</div>
</body>
</html>
