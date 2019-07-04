<?php
require('function.php');

if ($_GET['id'] && $_SESSION['id']) {
	$id = $_GET['id'];
	//編集前の情報を取得
	$dbh = dbConnect();
	$sql = 'SELECT user_id, title, content FROM posts WHERE id = :id';
	$data = array(':id' => $id);
	$stmt = queryPost($dbh, $sql, $data);

	//編集時に現在登録されている値を表示するためとユーザーチェックのために取得
	$post = $stmt->fetch();
	if ($_POST) {
		if (empty($_POST['title']) || empty($_POST['content'])) {
			$message[] = 'タイトルもしくは本文が入力されていません';
		}
		if ($_SESSION['id'] !== $post['user_id']) {
			$message[] = 'あなたの投稿ではありません';
		}
		if (empty($message)) {
			//情報を変数に代入
			$title = $_POST['title'];
			$content = $_POST['content'];

			//情報を更新
			$dbh = dbConnect();
			$sql = 'UPDATE posts SET title = :title, content = :content WHERE id = :id';
			$data = array(':title' => $title, ':content' => $content, ':id' => $id);
			$stmt = queryPost($dbh, $sql, $data);

			//更新できたら投稿一覧にリダイレクト
			header('Location: post_list.php');
		}
	}
} else {
	//get送信されていないもしくはログイン中でなければ投稿一覧にリダイレクト
	header('Location: post_list.php');
}
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>編集</title>
</head>
<body>
<h1>編集</h1>
<?php
if ($message) {
	foreach ($message as $err_message) {
		echo $err_message . '<br>';
	}
}
?>
<form action='' method='post'>
<label for='title'>タイトル：</label><br>
<input type='text' name='title' id='title' size='50' value='<?php echo $post['title']; ?>'><br>

<label for='content'>本　　文：</label><br>
<textarea name='content' id='content' rows='5' cols='50'><?php echo $post['content']; ?></textarea><br>
<input type='submit' value='編集 '>
</form>
<a href='post_list.php'>投稿一覧に戻る</a>
</body>
</html>
