<?php
require('function.php');
$user_information = '';
//投稿した人のuser_idを取得
if ($_GET) {
	$user_id = $_GET['user_id'];
}
//マイページに表示する値を取得
$dbh = dbConnect();
$sql = 'SELECT * FROM users WHERE id = :id';
$data = array(':id' => $user_id);
$stmt = queryPost($dbh, $sql, $data);

//それぞれの値を取得
$user_information = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>マイページ</title>
</head>
<body>
<h1>マイページ</h1>
<p>
<?php if(empty($user_information['image_name'])): ?>
	ユーザー画像未登録
<?php else: ?>
	<img src="<?php echo $user_information['image']; ?>" width='300px' height='200px'>
<?php endif; ?>
</p>
<p>
ユーザーネーム:
<?php echo $user_information['name']; ?>
</p>
<p>
メールアドレス:
<?php echo $user_information['mail']; ?>
</p>
<p>
一言コメント:
<?php echo $user_information['a_word']; ?>
</p>
<?php if ($_SESSION && $_SESSION['id'] == $user_id): ?>
<a href="mypage_edit.php?user_id=<?php echo $user_id; ?>">マイページ編集はこちら</a><br>
<?php endif; ?>
<a href='post_list.php'>投稿一覧こちら</a>
</body>
</html>
