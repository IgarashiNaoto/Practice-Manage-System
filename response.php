<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>返信</title>
	<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
</head>
<body>
<script>
	$(function(){
		setInterval(function(){
			$.ajax({
				url: "chat.php",
				type: "POST",
				dataTYpe: "json",
				data: $content,
			}),done(function(data){
				alert('更新しました');
			}),fail(function(){
		    alert('error');
			});
		});
	})
</script>
</body>
</html>
<?php
//DB接続
$dsn = 'mysql:dbname=tt_712_99sv_coco_com;host=localhost';
$user = 'tt-712.99sv-coco';
$password ='t3A2GXxV';
$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_WARNING));


	$sql = "SELECT*FROM receive_box";
	$stmts = $pdo -> query($sql);
	foreach($stmts as $lines){
		$content = array(
			"date" => $lines['day'],
			"from" =>$lines['receive_from'],
			"comment" => $lines['comment']
			);
		//echo $content['date'];
		}
		header('content-type: application/json; charset=utf-8');
		echo json_encode($content);

?>
