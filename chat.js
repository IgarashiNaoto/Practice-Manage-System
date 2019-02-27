$(function(){

	$(document).ready(function(){
    $.PeriodicalUpdater({
    //  オプション設定
        url: 'chat.php',  // 送信リクエストURL
        minTimeout: 5000,    // 送信インターバル(ミリ秒)
        method   :get,        // 'post'/'get'：リクエストメソッド
//      sendData             // 送信データ
//      maxTimeout           // 最長のリクエスト間隔(ミリ秒)
//      multiplier           // リクエスト間隔の変更(2に設定の場合、レスポンス内容に変更がないときは、リクエスト間隔が2倍になっていく)
　		type     :html                 // xml、json、scriptもしくはhtml (jquery.getやjquery.postのdataType)
    },
})