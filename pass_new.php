<?php
require('function.php');
$dishonesty = array();
if ($_POST) {
	$pass_new = $_POST['pass_new'];
	$pass_new_re = $_POST['pass_new_re'];
	//POSTの空チェック
	if (empty($_POST['pass_new']) || empty($_POST['pass_new_re'])) {
		$message[] = '値が入力されていません';
	//パスワードとパスワード再入力が同じであれば更新
	} elseif ($pass_new !== $pass_new_re) {
		$message[] = 'パスワードとパスワード再入力が違います。';
	} else {
		if ($_GET) {
			$hash = $_GET['hash'];
			$dbh = dbConnect();
			$sql = 'SELECT limit_time FROM users WHERE hash_pass = :hash_pass';
			$data = array(':hash_pass' => $hash);

			$stmt = queryPost($dbh, $sql, $data);
			$is_hash = $stmt->fetch();
			//制限時間を取得
			$limit = $is_hash['limit_time'];
			//現在時刻を取得
			$now = strtotime("now");

			//GET送信してきたパスワードと保存されているパスワードが同じで期限切れでないかを確認
			if ($is_hash && $limit > $now) {
				$dbh = dbConnect();
				$sql = 'UPDATE users SET pass = :pass_new WHERE hash_pass = :hash_pass';
				$data = array(':pass_new' => $pass_new, ':hash_pass' => $hash);
				$stmt =queryPost($dbh, $sql, $data);
				if ($stmt) {
					$message = 'パスワード更新完了';
					header("Location: login.php?message=" . $message . "");
				} else {
					$dishonesty = '不正なアクセスです。再度お試しください。';
					header("Location: error.php?dishonesty=" . $dishonesty . "");
				}
			} else {
				$dishonesty = '不正なアクセスです。再度お試しください。';
				header("Location: error.php?dishonesty=" . $dishonesty . "");
			}
		} else {
			$dishonesty = '不正なアクセスです。再度お試しください。';
			header("Location: error.php?dishonesty=" . $dishonesty . "");
		}
	}
}

?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='utf-8'>
<title>新規パスワード入力画面</title>
</head>
<body>
<h1>新規パスワード入力画面</h1>
<form action='' method='post'>
<label id='pass_new'>新しいパスワードを入力してください</label>
<input type='password' name='pass_new' for='pass_new'><br>
<label id='pass_new_re'>新しいパスワードを再入力してください</label>
<input type='password' name='pass_new_re' for='pass_new_re'><br>
<input type='submit' value='送信'>
</form>
<?php if ($message): ?>
<?php echo $message[0]; ?>
<?php endif; ?>
</body>
</html>
