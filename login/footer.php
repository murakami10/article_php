<footer>
<?php 
	if($_SESSION["admin"] == 1){
?>
		<a style="color:#F00; font-size: 30px;" href="./admin/menu.php">管理者権限</a><br>
<?php
	}
?>
<a class="logout" href="./add_stamp.php">スタンプを追加する</a><br>
<a class="logout" href="./change_account.php">アカウント情報を変更する</a><br>
<a class="logout"href="../login.php">ログアウトする</a>
</footer>
