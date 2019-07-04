<?php
require('function.php');
$user_id = $_POST['user_id'];

if ($_POST) {
	var_dump($user_id);
	$id = $_SESSION['id'];
	$a_word = $_POST['a_word'];
	$exetension = substr($_FILES['image']['name'], strpos($_FILES['image']['name'], '.') + 1);
	//ファイルへのアップロードがあればimageディレクトリに移動
	if ($exetension == 'jpg' || $exetension == 'jpeg' || $exetension == 'png') {
		$upload_file = (uniqid(mt_rand(), true)) . '.' . $exetension;
		$tmp_file = $_FILES['image']['tmp_name'];
		$display_file = 'image/' . $upload_file;

		//画像をサーバーのディレクトリに移動
		move_uploaded_file($tmp_file, $display_file);
		//情報を更新
		$dbh = dbConnect();
		$sql = 'UPDATE users SET image = :image, image_name = :image_name WHERE id = :id';
		$data = array(':image' => $display_file, ':image_name' => $upload_file, ':id' => $id);
		$stmt = queryPost($dbh, $sql, $data);
	}
	//情報を更新
	$dbh = dbConnect();
	$sql = 'UPDATE users SET a_word = :a_word WHERE id = :id';
	$data = array(':a_word' => $a_word, ':id' => $id);
	$stmt = queryPost($dbh, $sql, $data);
}
var_dump($user_id);
header("Location: mypage.php?user_id=" . $user_id . "");
?>
