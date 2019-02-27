<?php
//セッションスタート
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
if(isset($_POST['time'])){
$sql = $pdo ->prepare("INSERT INTO stopwatch(date,time,userid) VALUES(:date,:time,:userid)");
$sql -> bindParam(':date',$date,PDO::PARAM_STR);
$sql -> bindParam(':time',$time,PDO::PARAM_STR);
$sql -> bindParam(':userid',$userid,PDO::PARAM_STR);

	$date = date('Y.m.d');
	$time =	 htmlspecialchars($_POST['time']);
$sql -> execute();
//内容
$sql ="SELECT*FROM stopwatch where userid ='$userid' order by id";
$result = $pdo ->query($sql);
foreach($result as $rows){
	echo $rows['date'];
	echo ",";
	echo $rows['time']; 
	echo '<br>';
}
}
//削除
/*$sql ="delete from";
$statement = $pdo -> query($sql);
$sql ="ALTER TABLE stopwatch AUTO_INCREMENT = 1";
$outcome =$pdo ->query($sql);*/
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>計測</title>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="stopwatch.js"></script>
	<link rel="stylesheet" href="stopwatch.css">
</head>
<body>
	<div class="header">
		<h1>Practice Manage Service</h1><br>
	</div>
	<div class="timebox">
		<div class="stopwatch">
			<div id="clock">00:00:00</div>
			<form action="stopwatch.php" method="post">
			<input type="button" name="start" id="start" value="Start">
			<input type="button" name="stop" id="stop" value="Stop" disabled>
			<input type="button" name="restart" id="restart" value="Restart" disabled>
			<input type="button" name="reset" id="reset" value="Reset" disabled>
			<input type="hidden" name="time" id="time" value="">
			<input type="submit" value="save">
			</form>
		</div>
	</div>
<p><a href="my_page.php">マイページに戻る</a></p>
</body>
</html>