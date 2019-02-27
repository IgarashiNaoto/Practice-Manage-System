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

//仮登録テーブル作成
$sql ="CREATE TABLE pre_registration"
."("
."id INT PRIMARY KEY AUTO_INCREMENT,"
."urltoken VARCHAR(128) NOT NULL,"
."mail VARCHAR(50) NOT NULL,"
."date DATETIME NOT NULL,"
."flag TINYINT(1) NOT NULL DEFAULT 0"
.");";
$stmt = $pdo ->query($sql);

//本登録テーブル作成
$sql ="CREATE TABLE registration"
."("
."id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,"
."username VARCHAR(50) NOT NULL,"
."mail VARCHAR(50) NOT NULL,"
."password VARCHAR(128) NOT NULL,"
."flag TINYINT(1) NOT NULL DEFAULT 1"
.");";
$stmts = $pdo->query($sql);

//時間保存テーブル作成
$sql ="CREATE TABLE stopwatch"
."("
."id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,"
."date DATE NOT NULL,"
."time VARCHAR(50) NOT NULL"
.")";
$statement = $pdo -> query($sql);
$sql = 'ALTER TABLE stopwatch ADD userid INT NOT NULL';
$statements = $pdo -> query($sql);

//日誌rテーブル作成
$sql ="CREATE TABLE diary"
."("
."id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,"
."userid VARCHAR(128) NOT NULL,"
."date DATE NOT NULL,"
."diary text NOT NULL"
.")";
$statment = $pdo -> query($sql);

//post_boxテーブル作成
$sql = "CREATE TABLE post_box"
."("
."id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,"
."mail_from  VARCHAR(100) NOT NULL,"
."name char(32),"
."comment TEXT,"
."mail_to VARCHAR(50) NOT NULL,"
."day datetime"
.");";
$stmt = $pdo -> query($sql);

//カラム削除
/*$sql = 'ALTER TABLE post_box drop column receive_from,drop column receive,drop column reply';
$stmts = $pdo -> query($sql);*/
//テーブル名変更
/*$sql= "ALTER TABLE chat rename to post_box;";
$stmt = $pdo ->query($sql);*/
//カラム追加
/*$sql = 'ALTER TABLE  post_box ADD (reply TEXT NOT NULL)';
$statement = $pdo -> query($sql);*/


//receive_box作成
$sql = "CREATE TABLE receive_box"
."("
."id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,"
."receive_from  VARCHAR(50) NOT NULL,"
."receive char(32),"
."comment TEXT,"
."day datetime"
.");";
$stmt = $pdo -> query($sql);
//テーブル確認
$sql ='SHOW TABLES';
$results = $pdo -> query($sql);
foreach($results as $row){
echo $row[0];
echo '<br>';
}
//内容
$sql ='SELECT*FROM registration';
$result = $pdo ->query($sql);
foreach($result as $rows){
	echo $rows['id'];
	echo $rows['username'];
	/*echo $rows['mail_to'];
	echo $rows['comment']; */ 
	echo '<br>';

}
//テーブル削除
/*$sql ="drop table receive_box";
$res = $pdo -> query($sql);*/
//内容確認
$sql='SHOW CREATE TABLE registration';
$statement= $pdo ->query($sql);
foreach($statement as $line){
	print_r($line);
}

//削除
//$sql ="delete from post_box";
//$statement = $pdo -> query($sql);
/*$sql ="ALTER TABLE diary AUTO_INCREMENT = 1";
$outcomes =$pdo ->query($sql);*/

?>