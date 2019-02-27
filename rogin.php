<?php
session_start();

try {
$dsn=データベース;
$user=ユーザー;
$password=パスワード;
$pdo = new PDO($dsn,$user,$password);
}catch (PDOException $e) {
exit('データベースに接続できませんでした。' . $e->getMessage());
}
//変数定義
$username = htmlspecialchars($_POST['account']);
$pw = htmlspecialchars($_POST['password']);
//データ取得&ログイン
if(!empty($username)&&!empty($pw)){
$sql ="SELECT*FROM registration where username='$username' and password ='$pw'";
$result = $pdo->query($sql);
	foreach($result as $row){
		$name = $row['username'];
		$pass = $row['password'];
		$_SESSION['userid'] = $row['id'];
	}
	if($username==$name&&$pw==$pass){

		header("Location: my_page.php");
	}else{
		echo "ユーザー名またはパスワードが違います";
	}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>ログイン</title>
	<link rel="stylesheet" href="roginform.css">
</head>
<body>
	<div class="header">
		<h1>Practice Manage Service</h1>
	</div>
	<div class="roginbox">
		<div class="box">
	<form method="post">
		<p class="account">ユーザー名:<input type="text" name="account" placeholder="ユーザー名"></p><br>
		<p class="password">パスワード:<input type="text" name="password" placeholder="パスワード"></p><br>
		<input class="button" type="submit" value="ログイン">
	</form>
	</div>
</div>
</body>
</html>