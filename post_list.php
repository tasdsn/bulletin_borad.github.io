<?php
require('function.php');

//データベースから投稿を取得
$dbh = dbConnect();
$sql = 'SELECT p.id, p.user_id, u.name, p.title, p.content, p.create_date FROM posts p JOIN users u ON p.user_id = u.id WHERE delete_flg = false';
$data = array();
$stmt = queryPost($dbh, $sql, $data);
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'> <title>投稿一覧</title>
</head>
<body>
<h1>投稿一覧</h1>
<a href='new_post.php'>新規投稿</a>
<table border='1'>
<?php foreach ($posts as $post): ?>
<tr>
<th>投稿ID</th>
<td><?php echo $post['id']; ?></td>
</tr>
<tr>
<th>投稿者名</th>
<td>
<a href="mypage.php?user_id=<?php echo $post['user_id']; ?>"><?php echo $post['name']; ?></a></td>
</td>
</tr>
<tr>
<th>タイトル
<?php if ($_SESSION && $_SESSION['id'] === $post['user_id']): ?>
	<a href="edit.php?id=<?php echo $post['id']; ?>">編集</a>
	<a href="delete.php?id=<?php echo $post['id']; ?>">削除</a>
<?php endif; ?>
</th>
<td><?php echo $post['title']; ?></td>
</tr>
<tr>
<th>本文</th>
<td><?php echo $post['content']; ?></td>
</tr>
<tr>
<th>記入年月日時分</th>
<td><?php echo $post['create_date']; ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php if ($_SESSION): ?>
	<a href='logout.php'>ログアウト画面へ</a>
<?php else: ?>
	<a href='login.php'>ログイン画面へ</a>
	<a href='signup.php'>新規登録画面へ</a>
<?php endif; ?>
</body>
</html>
