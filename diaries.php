<?php
session_start();
$userid = $_SESSION['userid'];
//DB接続
try {
$dsn=データベース;
$user=ユーザー;
$password=パスワード;
$pdo = new PDO($dsn,$user,$password);
}catch (PDOException $e) {
exit('データベースに接続できませんでした。' . $e->getMessage());
}
//日誌データ取得
$sql = "SELECT*FROM diary where userid ='$userid' order by id desc ";
$stmt = $pdo -> query($sql);
foreach ($stmt as $row){
	echo $row['date'];
	echo '<br>';
	echo $row['diary'];
	echo '<hr>';
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>日記一覧</title>
</head>
<body>
	<p><a href="my_page.php">マイページに戻る</a></p>
</body>
</html>