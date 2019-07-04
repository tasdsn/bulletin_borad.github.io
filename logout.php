<?php
//セッション開始
session_start();

//全てのセッション変数を削除するために、array()で上書き
$_SESSION = array();

//クッキーの削除(クライアント側にはクッキーに残るため）
//クッキーを昔の時間にすることで削除する
if (isset($_COOKIE['id'])) {
	setcookie('id', '', time() - 100);
}
//セッションを削除
session_destroy();

?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>ログアウト画面</title>
</head>
<body>
<h1>ログアウトしました</h1>
<a href='login.php'>ログイン画面に戻る</a>
</body>
</html>
