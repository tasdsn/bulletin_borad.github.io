<?php
require('function.php');

if ($_POST) {
	if (empty($_POST['mail']) || empty($_POST['pass'])) {
		$user = ['message' => '空欄があります'];
	} else {
		$mail = $_POST['mail'];
		$pass = $_POST['pass'];
		$user = getuser($mail, $pass);

		if ($user['user'] !== null) {
			$_SESSION['id'] = $user['user'];
			header('Location: post_list.php');
		}
	}
}

?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>ログイン画面</title>
</head>
<body>
<?php if ($_GET): ?>
<?php echo $_GET['message']; ?>
<?php endif; ?>
<!-- セッションが空の時表示 -->
<?php if (empty($_SESSION)): ?>
	<h1>ログイン</h1>
	<?php if ($user): ?>
	<?php echo $user['message']; ?>
	<?php endif; ?>
	<form action='' method='post'>
	<label for='mail'>メールアドレス</label>
	<p><input type='text' name='mail' id='mail'></p>
	<label for='pass'>パスワード</label>
	<p><input type='password' name='pass' id='pass'></p>
	<input type='submit' value='送信'>
	</form>
<?php endif; ?>
<a href='post_list.php'>投稿一覧に戻る</a>
<a href='signup.php'>新規登録はこちら</a><br>
<a href='pass_reconf.php'>パスワードを忘れた方はこちら</a>
</body>
</html>
