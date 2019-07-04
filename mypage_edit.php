<?php
require('function.php');
$user_id = $_GET['user_id'];

if (empty($_SESSION['id'])) {
	header('Location: signup.php');
}
//データベースに値が入っている場合はデフォルト値として表示するため取得
$dbh = dbConnect();
$sql = 'SELECT id, image, image_name, a_word FROM users WHERE id = :id';
$data = array(':id' => $_SESSION['id']);
$stmt = queryPost($dbh, $sql, $data);
$user_information = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>マイページ編集画面</title>
</head>
<body>
<h1>マイページ編集</h1>
<form action='update.php' method='post' enctype='multipart/form-data'>
<label for='image'>アップロードしたい画像を選択してください</label><br>
<input type='file' name='image' id='image'><br>
<p>
<?php if(empty($user_information['image_name'])): ?>
	ユーザー画像未登録
<?php else: ?>
	<img src="<?php echo $user_information['image']; ?>" width='300px' height='200px'>
<?php endif; ?>
</p>
<label for='a_word'>一言コメント</label><br>
<textarea name='a_word' id='a_word' rows='5' cols='50'><?php echo $user_information['a_word']; ?></textarea><br>
<input type='hidden' name='user_id' value="<?php echo $user_id; ?>">
<input type='submit' value='編集'>
</form>
<a href='post_list.php'>投稿一覧こちら</a>
</body>
</html>
