<?php
session_start();
if(empty($_SESSION['id'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ".php");
exit;
}
if(empty($_SESSION['article'])){
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/article.php");
exit;
}
$article_id = $_SESSION['article'];
include('./connect_sql.php');
include('./paging.php');
include('./h.php');
include('./stamp.php');


	$search = "";
	$pdo = connect();

	$sql = "select * from article where article_id = :article_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':article_id', $article_id, PDO::PARAM_INT);
	$stmt->execute();
	$title_content = $stmt->fetch();

	if(isset($_GET['search']) && ($_GET['search'] != ""))
	{
		$search = $_GET['search'];
		$csql = "select *from user inner join comment on user.id = comment.user_id where com_article_id = :com_article_id and content like :search";
		$stmt_count = $pdo->prepare($csql);
		$stmt_count->bindValue(":search",'%'. $search .'%');
	}else
	{
		$csql = "select * from user inner join comment on user.id = comment.user_id where com_article_id = :com_article_id";
		$stmt_count = $pdo->prepare($csql);
	}

	$stmt_count->bindValue(':com_article_id',$article_id,PDO::PARAM_INT);
	$stmt_count->execute();
	$count_sql = ceil(($stmt_count->rowCount())/10);

	if(isset($_GET['search']) && ($_GET['search'] != "") && isset($_GET['page']) && ($_GET['page'] > 0) && ($_GET['page'] <= $count_sql))
	{
		$search = $_GET['search'];
		$sql = 'select id,name,content,time,comment_id from user inner join comment on user.id = comment.user_id where com_article_id = :com_article_id and content like :search order by comment_id desc limit 10 offset :page';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':search','%'.$search.'%');
		$ofset = ($_GET['page'] -1) * 10;
		$stmt->bindValue(':page',$ofset,PDO::PARAM_INT);
	}
	elseif(isset($_GET['search']) && $_GET['search'] != "")
	{
		$search = $_GET['search'];
		$sql = 'select id,name,content,time,comment_id from user inner join comment on user.id = comment.user_id where com_article_id = :com_article_id and content like :search order by comment_id desc limit 10 offset 0';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':search','%'.$search.'%');
	}elseif( (isset($_GET['page'])) && ($_GET['page'] > 0)&& ($_GET['page'] <= $count_sql)){
		$sql = "select id,name,content,time,comment_id from user inner join comment on user.id = comment.user_id where com_article_id = :com_article_id order by comment_id desc limit 10 offset :page";
		$stmt = $pdo->prepare($sql);
		$ofset = ($_GET['page'] -1) * 10;
		$stmt->bindValue(":page",$ofset,PDO::PARAM_INT);
	}else{
		$sql = 'select id,name,content,time,comment_id from user inner join comment on user.id = comment.user_id where com_article_id = :com_article_id order by comment_id desc limit 10 offset 0';
		$stmt = $pdo->prepare($sql);
	}

	$check_flag = check_favorite();
	$stmt->bindValue(':com_article_id',$article_id,PDO::PARAM_INT);
	$stmt->execute();
	$num = $stmt->rowCount();
	$result = $stmt->fetchAll();

function check_favorite()
{
	$pdo = connect();
	$sql = "select favorite_id from favorite where favorite_user_id = :favorite_user_id and favorite_article_id = :favorite_article_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':favorite_user_id', $_SESSION['id'], PDO::PARAM_INT);
	$stmt->bindValue(':favorite_article_id', $_SESSION['article'], PDO::PARAM_INT);
	$stmt->execute();
	$count_sql = $stmt->rowCount();
	$flag = $count_sql == 1 ? 1 : 0;
	return $flag;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./style.css">
<style>
	.not_break{
		word-break: break-all;
	}
	#content{
		text-align: center;
	}
	.content{
		word-break: break-all;
	}
	.add{
		color: #fff;
	}
	footer{
		margin-top: 60px
	}
	#form{
			width:90%;
			margin: 60px auto;
			margin-bottom: 0;
			padding: 30px;
			border:1px solid #555;
			text-align: start;
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
	img{
		width: 30%;
	}
	#image{
		text-align: center;
		margin-left: auto;
		margin-right: auto
	}
	.stamp{
		width:30px;
		height:30px;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="move.js"></script>
<script>
$(function(){
	$('#favorite').change(function(){
		var check = $('#favorite').prop('checked');
		var id = <?php echo json_encode($_SESSION["id"])?>;
		var article_id = <?php echo json_encode($article_id);?>;
		if(check)
		{
			$.ajax({
				url:'./check_favorite.php',
				type:'POST',
				datatype: 'json',
				data:{
					'id' : id,
					'article_id' : article_id,
					}
				})
			.done(function(data)
			{
				//console.log(data);
				console.log('成功');
				})

			.fail(function(data)
			{
				console.log('通信失敗');
			});
		}else
		{
			$.ajax({
				url:'./checkout_favorite.php',
				type:'POST',
				datatype: 'json',
				data:{
					'id' : id,
					'article_id' : article_id,
					}
			})
				
			.done(function(data)
			{
				//console.log(data);
				console.log('delete成功');
			})

			.fail(function(data)
			{
				console.log('通信失敗');
			});
		}
	});
});
</script>
<meta charset="UTF-8">
<title>コメントの表示</title>
</head>
<body>
<?php include('header.php')?>
<div class="wrapper">
<div id="form">
<h1 class="form-title"><?= h($title_content['article_title'])?></h1>
<?php
	if($title_content['image'] != "")
	{
?>
<div id="image">
<img src="../image/<?= h($title_content['image'])?>">
</div>
<?php
	}
?>
<p id="content" class="not_break"><strong><?= h($title_content['article_content'])?></strong></p><br><br>

<div id="msg">
<p id="name_fade">名前を変更しました</p>
<p id="pass_fade">パスワードを変更しました</p>
<p id="dele_fade">コメントを削除しました</p>
<p id="edit_fade">コメントを編集しました</p>
<p id="add_fade">コメントを投稿しました</p>
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
?>
<p><input id="favorite" type="checkbox" <?php if($check_flag == 1) echo "checked"?>>この記事をお気に入りにする</p>

<?php
	if($num != 0){
?>
<table>
			<thead><tr><th class="name">名前</th><th class="content">内容</th><th class="edit">内容を編集</th><th class="time">日時</th><th class="delete">削除</th</tr> </thead>
<?php 
			foreach ($result as $row) {
?>
			<tbody>
			<tr>
				<td class="name" onclick="move_url('<?= h($row["id"])?>')">
					<?= h($row['name'])?>

				</td>
				<td class="content" onclick="move_url('<?= $row["id"]?>')"s>
					<?= stamp($row['content'])?>

				</td>
				<td class="edit">
<?php
					$time = (string) $row['time'];
					$day = date("Y/m/d　G時i分s秒", $time);
					$now = strtotime("-1 hour");
					if(($_SESSION['id'] == $row['id'] && $now < $time) || $_SESSION["admin"] == 1){
?>
					<form action="./edit_comment.php" method="get">
						<input type="hidden" name="comment_id" value="<?= $row['comment_id']?>">
						<input type="submit" value="編集">
					</form>
<?php
					if($_SESSION["admin"] == 1)
					{
?>
						<form action="./admin/delete.php" method="post">
							<input type="hidden" name="id" value="<?= $row["id"] ?>">
							<input type="submit" value="アカウントの詳細">
						</form>
<?php
					}

					}
?>
				</td>
				<td class="time" ><?= $day?></td>
				<td class="delete">	
<?php					
					if(($_SESSION['id'] == $row['id']) || $_SESSION["admin"] == 1){
?>
					<form action="./delete_comment.php" method="post">
						<input type="hidden" name="comment_id" value="<?php echo $row['comment_id']?>">
						<input type="hidden" name="ids" value="<?php echo $row['id']?>">
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
	}else{
?>
	<p>コメントは一つもありません</p>
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
<a class="add" href="./add_comment.php">コメントを投稿する</a><br>
</div>
<?php include('footer.php')?>
<?php $pdo = null; ?>
</body>
</html>


