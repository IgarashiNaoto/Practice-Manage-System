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
//自分のユーザー名を取得
$sql ="SELECT*FROM registration where id ='$userid'";
$result = $pdo ->query($sql);
foreach($result as $row){
	$mail_from = $row['username'];
	$sent = $row['username'];
}


//相手のユーザー名を取得
$searchname = $_SESSION['searchname'];
$sql ="SELECT*FROM registration where username = '$searchname'";
$results = $pdo ->query($sql);
foreach($results as $rows){
	$mail_to = $rows['username'];
	$receive = $rows['username'];
}


//chatテーブルにデータを入力
if(!empty($_POST['comment'])){
$sql = $pdo ->prepare("INSERT INTO post_box(mail_from,mail_to,comment,day) VALUES(:mail_from,:mail_to,:comment,:day)");
$sql -> bindParam(':mail_from',$mail_from,PDO::PARAM_STR);
$sql -> bindParam(':mail_to',$mail_to,PDO::PARAM_STR);
$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
$sql -> bindParam(':day',$day,PDO::PARAM_STR);
	$comment = htmlspecialchars($_POST['comment']);
	$day = date('Y.m.d,H:i');
$sql -> execute();
}else{
	echo "コメントが入力されていません";
}
//receive_box
if(!empty($_POST['comment'])){
$sql = $pdo ->prepare("INSERT INTO receive_box(comment,day,receive_from,receive) VALUES(:comment,:day,:receive_from,:receive)");
$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
$sql -> bindParam(':day',$day,PDO::PARAM_STR);
$sql -> bindParam(':receive_from',$receive_from,PDO::PARAM_STR);
$sql -> bindParam(':receive',$receive,PDO::PARAM_STR);
	$receive_from = $sent;
	$comment = htmlspecialchars($_POST['comment']);
	$day = date('Y.m.d,H:i');
$sql -> execute();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>チャット</title>
	<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
</head>
<body>
	<h1>チャット相手:<?php echo $mail_to; ?></h1>
	<form action="chat.php" method="post">
		<textarea name="comment" cols=40 rows=4 ></textarea>
		<input type="submit" value="送信">
	</form>
	<p><a href="my_page.php">マイページに戻る</a></p>
	<?php
	//ajaxデータ取得
	$array_date = $_POST('date');
	$array_from = $_POST('from');
	$array_comment = $_POST('comment');
	//データ取得
	$sql = "SELECT*FROM post_box where mail_from='$mail_from' and mail_to='$mail_to'";
	$stmt = $pdo -> query($sql);
	foreach($stmt as $line){
		if($array_from=$line['mail_to']){
			echo $array_dat;
			echo $array_from;
			echo $array_comment;
		}
	//if($mail_from==$line['mail_from']&&$mail_to==$line['mail_to']){
		echo $line['day'];
		echo '<br>';
		echo $line['mail_from'];
		echo ":";
		echo $line['comment'];
		echo '<hr>';
	}
 }

 echo response;

/*$sql ="delete from post_box";
$statement = $pdo -> query($sql);
$sql ="delete from receive_box";
$statements = $pdo -> query($sql);*/
?>

</body>
</html>