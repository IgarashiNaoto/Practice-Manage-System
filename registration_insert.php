<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_POST['token'] != $_SESSION['token']){
	echo "不正アクセスの可能性あり";
	exit();
}
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
 
//DB接続
try {
$dsn = 'mysql:dbname=naotobass_db;host=mysql1.php.xdomain.ne.jp;charset=utf8';
$user = 'naotobass_db';
$password ='kiyomori11';
$pdo = new PDO($dsn,$user,$password);
}catch (PDOException $e) {
exit('データベースに接続できませんでした。' . $e->getMessage());
}
//エラーメッセージの初期化
$errors = array();
 
if(empty($_POST)) {
	header("Location: registration_mail_form.php");
	exit();
}

$mail = $_SESSION['mail'];
$username = $_SESSION['account'];


//メールの宛先
	$mailTo = $mail;
	$urltoken = hash('sha256',uniqid(rand(),1));
	$url = "http://tt-712.99sv-coco.com/rogin.php"."?urltoken=".$urltoken;

 
	//Return-Pathに指定するメールアドレス
	//$returnMail = 'web@sample.com';
 
	$name = "練習時間管理サービス";
	//$mail = 'web@sample.com';
	$subject = "会員登録完了のお知らせ";
	$body = <<< EOM
	以下のURLからログインできます。
	{$url}
EOM;

	mb_language('ja');
	mb_internal_encoding('UTF-8');

	//Fromヘッダーを作成
	$header = 'From: ' . mb_encode_mimeheader($name);

		if (mb_send_mail($mailTo, $subject, $body, $header)) {
			 		echo '登録完了メールをお送りしました。<br/>';
			 	}else{
			 		echo '送信に失敗しました';
			 	}

//パスワードのハッシュ化
$password_hash = $_SESSION['password'];
 
 //ここでデータベースに登録する
try{
	//例外処理を投げる（スロー）ようにする
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//トランザクション開始
	$pdo->beginTransaction();
	
	//memberテーブルに本登録する
	$statement = $pdo->prepare("INSERT INTO registration (username,mail,password) VALUES (:account,:mail,:password_hash)");
	//プレースホルダへ実際の値を設定する
	$statement->bindValue(':account', $username, PDO::PARAM_STR);
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
	$statement->execute();
		
	//pre_memberのflagを1にする
	$statement = $pdo->prepare("UPDATE pre_registration SET flag=1 WHERE mail=(:mail)");
	//プレースホルダへ実際の値を設定する
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->execute();
	
	// トランザクション完了（コミット）
	$pdo->commit();
		
	//データベース接続切断
	$pdo = null;

	//セッション変数を全て解除
	$_SESSION = array();

	//セッションクッキーの削除・sessionidとの関係を探れ。つまりはじめのsesssionidを名前でやる
	if (isset($_COOKIE["PHPSESSID"])) {
    		setcookie("PHPSESSID", '', time() - 1800, '/');
	}
	

 	//セッションを破棄する
 	session_destroy();
 	
}catch (PDOException $e){
	//トランザクション取り消し（ロールバック）
	$pdo->rollBack();
	$errors['error'] = "もう一度やりなおして下さい。";
	print('Error:'.$e->getMessage());
}
 
?>

<!DOCTYPE html>
<html>
<head>
<title>会員登録完了画面</title>
<meta charset="utf-8">
</head>
<body>
 
<?php if (count($errors) === 0): ?>
<h1>会員登録完了画面</h1>
 
<p>登録完了いたしました。ログイン画面からどうぞ。</p>
<p><a href="rogin.php">ログイン画面</a></p>
 
<?php elseif(count($errors) > 0): ?>
 
<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>
 
<?php endif; ?>
 
</body>
</html>