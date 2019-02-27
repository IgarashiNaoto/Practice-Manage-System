<?php
// セッション開始
session_start();
// セッション変数を全て削除
$_SESSION = array();
// セッションクッキーを削除
if (isset($_COOKIE["PHPSESSID"])) {
  setcookie("PHPSESSID", '', time() - 1800, '/');
}
// セッションの登録データを削除
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>ログアウト</title>
</head>
<body>
	<p>ログアウトしました</p>
	<p><a href="rogin.php">ログイン画面に戻る</p>
</body>
</html>