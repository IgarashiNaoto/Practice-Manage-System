<?php
session_start();
$userid = $_SESSION['userid'];
//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = (uniqid(rand(),1));
$token = $_SESSION['token'];
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
 
//DB接続
try {
$dsn=データベース;
$user=ユーザー;
$password=パスワード;
$pdo = new PDO($dsn,$user,$password);
}catch (PDOException $e) {
exit('データベースに接続できませんでした。' . $e->getMessage());
}
//データ取得
$sql ="SELECT*FROM registration where id ='$userid'";
$result = $pdo ->query($sql);
foreach($result as $rows){
	//echo $rows['username'];
	$name = $rows['username'];
}

//グラフ内容
$sql ="SELECT*FROM stopwatch where userid ='$userid' order by date";
$results = $pdo ->query($sql);
foreach($results as $rows){
  $time[] = $rows['time'];
  $date[] = $rows['date'];
$times = ($rows['time']);
$content = explode(":",$times);
$contents[] = $content[0].".".$content[1];
}

//セッション変数用データ取得
$searchname = htmlspecialchars($_POST['search']);
$sql ="SELECT*FROM registration where username = '$searchname'";
$results = $pdo ->query($sql);
foreach($results as $rows){
	$_SESSION['searchname'] = $rows['username'];
	header("Location: chat.php");
}

//日誌データ取得
$sql = "SELECT*FROM diary where userid ='$userid' order by id desc limit 3";
$stmt = $pdo -> query($sql);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>マイページ</title>
		<link rel="stylesheet" href="my_page.css">
</head>
<body>
	<div class="rogout">
		<h2><a href="rog_out.php">ログアウト</a></h2>
	</div>
	<div class="header">
		<h1>Practice Manage Service</h1>
	</div>
	<div class="youkoso">
		<h1>ようこそ<?php echo $name;?>さん</h1>
	</div>
	<div class="graph">
  			<canvas  id="myLineChart" width=100% height="20px"></canvas>
   			 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
  			<script>
  			var time_array = <?php echo json_encode($contents);?>;
  			var date_array = <?php echo json_encode($date);?>;
  			var ctx = document.getElementById("myLineChart");
  			var myLineChart = new Chart(ctx, {
    			type: 'line',
    			data: {
      			labels: date_array,
      			datasets: [
        			{
          			label: '練習時間',
          			data: time_array,
          			borderColor: "rgba(255,0,0,1)",
          			backgroundColor: "rgba(0,0,0,0)"
        			}
      			],
    			},
  			});
  		</script>
  	</div>
	<h1 class="stopwatch"><a href="stopwatch.php">▶時間測定</a></h1>
	<h1 class="diary"><a href="diary.php">▶日誌記入</a></h1>
	<h1>最新の日誌</h1><hr>
	<?php
		foreach($stmt as $row){
		echo "<strong>".$row['date']."</strong>";
		echo '<br>';
		echo "<strong>".$row['diary']."</strong>";
		echo '<hr>';
		}
	?>
		<h1><a href="diaries.php">▶日誌一覧</a></h1>
	<h1 class="chat">チャット</h1>
		<div class="chatbox">
		<h2 class="search"▶>ユーザー検索</h2>
			<form method="post">
				<input type="search" name="search" placeholder="ユーザー名を入力">
				<input type="submit" value="検索">
			</form>
		</div>
</body>
</html>