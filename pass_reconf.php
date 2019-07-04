<?php
require('function.php');
if ($_POST) {
	$mail = $_POST['mail'];
	if (empty($mail)) {
		$message[] = 'メールアドレスが入力されていません。';
	}
	if (!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $mail)) {
		$message[] = 'メールアドレスの形式にして下さい。';
	}

	$dbh = dbConnect();
	$sql = 'SELECT id FROM users WHERE mail = :mail';
	$data = array(':mail' => $mail);

	$stmt = queryPost($dbh, $sql, $data);
	$is_mail = $stmt->fetch();
	$id = $is_mail['id'];
	if ($is_mail) {
		//ハッシュ処理の計算コストを指定
		$options = array('cost' => 10);
		//ランダムなパスワードを生成
		$pass = (uniqid(mt_rand(), true));
		//ハッシュか方式にPASSWORD_DEFAULTを指定し、パスワードをハッシュ化する。
		$hash = password_hash($pass, PASSWORD_DEFAULT, $options);
		//30分後の時間を取得
		$limit = strtotime("1800 second");

		//データをインサート
		$dbh = dbConnect();
		$sql = 'UPDATE users SET hash_pass = :hash_pass, limit_time = :limit_time WHERE id = :id';
		$data = array(':hash_pass' => $hash, ':limit_time' => $limit, ':id' => $id);

		$stmt = queryPost($dbh, $sql, $data);
		$hash_pass = $stmt->fetch();
		//メールを送信
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");

		$to = "$mail";
		$subject = 'パスワード再発行URL送付';
		$content = "下記のURLをクリックしてパスワードを再設定して下さい。\nパスワード再発行URL↓\n\nhttps://procir-study.site/tada/bulletin_board/pass_new.php?hash=" . $hash .  "";
		$headers = 'From: from@hoge.co.jp' . '\r\n';

		mb_send_mail($to, $subject, $content, $headers);

	}

}
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>パスワード再設定申請画面</title>
</head>
<body>
<h1>パスワード再設定画面</h1>
<form action='' method='post'>
<label id='mail'>メールアドレスを入力してください</label><br>
<input type='text' name='mail' for='mail'>
<input type='submit' value='送信'>
</form>
<p>
<?php if ($_POST): ?>
	<?php if ($message): ?>
	<?php echo $message[0]; ?>
	<?php else: ?>
	<?php echo '再発行URLを送信しました'; ?>
	<?php endif; ?>
<?php endif; ?>
</p>
<a href='login.php'>ログイン画面に戻る</a>
</body>
</html>
