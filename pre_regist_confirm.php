<?php
session_start();

//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_POST['token'] != $_SESSION['token']){
	echo "不正アクセスの可能性あり";
	exit();
}
//DB接続
try {
$dsn=データベース;
$user=ユーザー;
$password=パスワード;
$pdo = new PDO($dsn,$user,$password);
}catch (PDOException $e) {
exit('データベースに接続できませんでした。' . $e->getMessage());
}
if(empty($_POST)) {
	header("Location: pre_registrate.php");
	exit();
}else{
	//POSTされたデータを変数に入れる
	$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
	//メール入力判定
	if ($mail == ''){
		$errors['mail'] = "メールが入力されていません。";
	}else{
		if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
			$errors['mail_check'] = "メールアドレスの形式が正しくありません。";
	}
  }
}

if (count($errors) === 0){
	$urltoken = hash('sha256',uniqid(rand(),1));
	$url = "http://naotobass.php.xdomain.jp/registrate.php"."?urltoken=".$urltoken;

	try{
		//例外処理
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $pdo->prepare("INSERT INTO pre_registration (urltoken,mail,date) VALUES (:urltoken,:mail,now() )");
		$statement->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
		$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
		$statement->execute();

		//データベース接続切断
		$pdo = null;

		}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}
	//メールの宛先
	$mailTo = $mail;
 
	//Return-Pathに指定するメールアドレス
	//$returnMail = 'web@sample.com';
 
	$name = "練習時間管理サービス";
	//$mail = 'web@sample.com';
	$subject = "会員登録用URLのお知らせ";
$body = <<< EOM
24時間以内に下記のURLからご登録下さい。
{$url}
EOM;

	mb_language('ja');
	mb_internal_encoding('UTF-8');

	//Fromヘッダーを作成
	$header = 'From: ' . mb_encode_mimeheader($name);

	if (mb_send_mail($mailTo, $subject, $body, $header)) {
	
	 	//セッション変数を全て解除
		$_SESSION = array();
	
		//クッキーの削除
		if (isset($_COOKIE["PHPSESSID"])) {
			setcookie("PHPSESSID", '', time() - 1800, '/');
		}
	
 		//セッションを破棄する
 		session_destroy();
 	
 		$message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";
 	
	 } else {
		$errors['mail_error'] = "メールの送信に失敗しました。";
	}	
}
 
?>

<!DOCTYPE html>
<html>
<head>
<title>メール確認画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>メール確認画面</h1>
 
<?php if (count($errors) === 0): ?>
 
<p><?=$message?></p>
 
<p>↓このURLが記載されたメールが届きます。</p>
<a href="<?=$url?>"><?=$url?></a>
 
<?php elseif(count($errors) > 0): ?>
 
<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>
 
<input type="button" value="戻る" onClick="history.back()">
 
<?php endif; ?>