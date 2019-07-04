<?php
require('function.php');

if ($_GET['id'] && $_SESSION['id']) {
	$id = $_GET['id'];

	$dbh = dbConnect();
	$sql = 'SELECT user_id FROM posts WHERE id = :id';
	$data = array(':id' => $id);
	$stmt = queryPost($dbh, $sql, $data);
	$post = $stmt->fetch();
	if ($post['user_id'] !== $_SESSION['id']) {
		$message[] = '他人の投稿は削除できません';
	}
	if (empty($message)) {
		//ログインしていれば、送られてきた投稿IDの投稿を削除
		$dbh = dbConnect();
		$sql = 'UPDATE posts SET delete_flg = :delete_flg WHERE id = :id';
		$data = array(':delete_flg' => 1, ':id' => $id);
		$stmt = queryPost($dbh, $sql, $data);

		if ($stmt) {
			$message[] = '削除できました';
		} else {
			$message[] = '削除できませんでした';
		}
	}
} else {
	header('Location: post_list.php');
}

?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>削除</title>
</head>
<body>
<?php if ($message): ?>
<?php echo $message[0]; ?>
<?php endif; ?>
<br>
<a href='post_list.php'>投稿一覧に戻る</a>
</body>
</html>
