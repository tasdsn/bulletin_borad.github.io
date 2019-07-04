<?php
require('function.php');

if ($_POST) {
	if (empty($_POST['name']) || empty($_POST['mail']) || empty($_POST['pass']) || empty($_POST['pass_re'])) {
		$message[] = '空欄があります';
	}
	//送られてきた値を変数に代入
	$name = $_POST['name'];
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];
	$pass_re = $_POST['pass_re'];

	//メールアドレスの重複チェック
	$dbh = dbConnect();
	$sql = 'SELECT mail FROM users WHERE mail = :mail';
	$data = array(':mail' => $mail);
	$stmt = queryPost($dbh, $sql, $data);
	$result = $stmt->fetch();

	if ($result) {
		$message[] = 'そのメールアドレスはすでに登録されています。';
	}
	if ($pass !== $pass_re) {
		$message[] = 'パスワードとパスワード再入力が違います';
	}

	if (empty($message)) {
		//ユーザー登録処理
		$dbh = dbConnect();
		$sql = 'INSERT INTO users (name, mail, pass) VALUES (:name, :mail, :pass)';
		$data = array(':name' => $name, ':mail' => $mail, ':pass' => $pass);
		$stmt = queryPost($dbh, $sql, $data);

		//メンバーがいればメンバーのidとnameをセッションに保存
		$user = getuser($mail, $pass);
		if ($user['user'] !== null) {
			$_SESSION['id'] = $user['user'];
		}
		header('Location: post_list.php');
	}
}
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>ユーザー登録</title>
</head>
<body>
<h1>ユーザー登録</h1>
<?php
if ($message) {
	foreach ($message as $err_message) {
		echo $err_message . '<br>';
	}
}
?>
<form action='' method='post'>
<label for='name'>名前：</label>
<input type='text' name='name' id='name'><br>
<label for='mail'>メールアドレス：</label>
<input type='text' name='mail' id='mail'><br>
<label for='pass'>パスワード：</label>
<input type='password' name='pass' id='pass'><br>
<label for='pass_re'>パスワード（再入力）：</label>
<input type='password' name='pass_re' id='pass_re'><br>
<input type='submit' value='登録'>
</form>
<a href='login.php'>ログインはこちら</a><br>
<a href='post_list.php'>投稿一覧はこちら</a>
</body>
</html>
