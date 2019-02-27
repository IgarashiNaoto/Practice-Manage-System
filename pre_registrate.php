<?php
//セッション開始
session_start();
//CSRF対策
$_SESSION['token'] = (uniqid(rand(),1));
$token = $_SESSION['token'];
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

?>
<html>
<head>
	<meta charset="UTF-8">
	<title>仮登録</title>
		<link rel="stylesheet" href="pre_regist.css">

</head>
<body>
	<div class="header">
		<h1>Practice Manage Service</h1>
	</div>
	<h1>メール登録画面</h1>
	<div class="mailbox">
	<form action="pre_regist_confirm.php" method="post">
		<div class="mailform">
		<p class="mail">メールアドレス<input type="text" name="mail"></p>
		<input type="hidden" name="token" value="<?=$token?>">
		<input type="submit" name="登録">
	</form>
</div>
</body>
</html>