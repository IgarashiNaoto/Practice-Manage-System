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
//情報入力
if(isset($_POST['diary'])){
$sql = $pdo ->prepare("INSERT INTO diary(userid,date,diary) VALUES(:userid,:date,:diary)");
$sql -> bindParam(':userid',$userid,PDO::PARAM_STR);
$sql -> bindParam(':date',$date,PDO::PARAM_STR);
$sql -> bindParam(':diary',$diary,PDO::PARAM_STR);
	$date = date('Y.m.d');
	$diary = htmlspecialchars($_POST['diary']);
$sql -> execute();
}
//内容
/*$sql ='SELECT*FROM diary';
$result = $pdo ->query($sql);
foreach($result as $rows){
	echo $rows['date'];
	echo ",";
	echo $rows['diary']; 
	echo "<br>";
}*/
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>日誌</title>
		<link rel="stylesheet" href="diary.css">
</head>
<body>
	<div class="header">
		<h1>Practice Manage Service</h1>
	</div>
	<div class="diarybox">
		<div class="diary">
		<form action="diary.php" method="post">
		<textarea name="diary" cols=40 rows=4 ></textarea><br>
		<input type="submit" class="button" value="保存">
		</form>
	</div>
	</div>
	<p><a href="my_page.php">マイページに戻る</a></p>
</body>
</html>