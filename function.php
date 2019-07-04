<?php
//データベースに接続する関数
function dbConnect() {
	try {
		$dsn = 'mysql:dbname=procir_tada;host=localhost';
		$user = 'tada';
		$password = 'zT7LW2JH';
		$dbh = new PDO($dsn, $user, $password);
		return $dbh;
	} catch (PDOException $e) {
		echo $e->getMessage();
		die();
	}
}

//メンバーを取得
function getUser($mail, $pass) {
	$dbh = dbConnect();
	$sql_check = 'SELECT id FROM users WHERE mail = :mail AND pass = :pass';
	$stmt = $dbh->prepare($sql_check);
	$stmt->execute(array(':mail' => $mail, ':pass' => $pass));
	$user = $stmt->fetch();
	//メンバーが存在していればnameを返す
	if ($user) {
		return ['user' => $user['id'], 'message' => null];
	} else {
		$message = 'メンバーが存在しません。';
		return ['user' => null, 'message' => $message];
	}
}


//SQLを実行する関数
function queryPost($dbh, $sql, $data) {
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);
	return $stmt;
}


$user = array();
$message = array();

//セッションを開始
session_start();
?>
