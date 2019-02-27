<?php
//DB接続
try {
$dsn=データベース;
$user=ユーザー;
$password=パスワード;
$pdo = new PDO($dsn,$user,$password);
}catch (PDOException $e) {
exit('データベースに接続できませんでした。' . $e->getMessage());
}

//内容
$sql ='SELECT*FROM stopwatch order by id';
$result = $pdo ->query($sql);
foreach($result as $rows){
  $time[] = $rows['time']; 
  $date[] = $rows['date'];
  echo $rows['id'];
  echo $rows['time'];
  echo $rows['date'];
  echo '<br>';
$times = ($rows['time']);
$content = explode(":",$times);
$contents[] = $content[0].".".$content[1];
//echo $contents;
//echo '<br>';
}
//削除
$sql ="delete from stopwatch where id='19'";
$statement = $pdo -> query($sql);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
　<title>グラフ</title> 
</head>
<body>
  <h1>折れ線グラフ</h1>
  <canvas id="myLineChart"></canvas>
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
      /*scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            Max: 24,
            Min: 0,
          }
        }]
      },*/
  });
  </script>
</body>

</html>