<?php
require('function.php');
if (empty($_SESSION)) {
	header('Location: signup.php');
}else {
	if ($_POST) {
		if (empty($_POST['title']) || empty($_POST['content'])) {
			$message[]	= '空欄があります';
		}
		if (empty($message)) {
			//送られてきた値を変数に代入
			$title = $_POST['title'];
			$content = $_POST['content'];

			$id = $_SESSION['id'];
			//投稿処理
			$dbh = dbConnect();
			$sql = 'INSERT INTO posts (title, content, user_id, create_date) VALUES (:title, :content, :user_id, :create_date)';
			$data = array(':title' => $title, ':content' => $content, ':user_id' => $id, ':create_date' => date('Y-m-d H:i:s'));
			$stmt = queryPost($dbh, $sql, $data);

			header('Location: post_list.php');
		}
	}
}
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>新規投稿</title>
</head>
<body>
<h1>新規投稿</h1>
<?php if ($message): ?>
<?php echo $message[0]; ?>
<?php endif; ?>
<form action='' method='post'>
<label for='title'>タイトル：</label>
<input type='text' name='title' id='title'><br>

<label for='content'>本文：</label>
<textarea name='content' id='content'></textarea>
<input type='submit' value='投稿'>
</form>
<a href='post_list.php'>投稿一覧に戻る</a>
</body>
</html>
