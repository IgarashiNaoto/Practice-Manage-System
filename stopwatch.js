$(function () {
  var sec = 0;
  var min = 0;
  var hour = 0;

  var timer;

  // スタート
  $('#start').click(function() {
    // 00:00:00から開始
    sec = 0;
    min = 0;
    hour = 0;
    $('#clock').html('00:00:00');
    timer = setInterval(countup, 1000);

    $(this).attr('disabled', 'disabled');
    $('#stop,#reset').removeAttr('disabled');    
  });

  // ストップ
  $('#stop').click(function() {
    // 一時停止
    clearInterval(timer);
   //時間取得
    var time = $('#clock').html();
    //value書き換え
    $('#time').val(time);

    $(this).attr('disabled', 'disabled');
    $('#restart').removeAttr('disabled');
  });

  // リスタート
  $('#restart').click(function() {
    // 一時停止から再開
    timer = setInterval(countup, 1000);

    $(this).attr('disabled', 'disabled');
    $('#stop').removeAttr('disabled');
  });

  // リセット
  $('#reset').click(function() {
    // 初期状態
    sec = 0;
    min = 0;
    hour = 0;
    $('#clock').html('00:00:00');
    clearInterval(timer);

    $('#stop,#restart,#reset').attr('disabled', 'disabled');
    $('#start').removeAttr('disabled');
  });

 /**
  * カウントアップ
  */
  function countup()
  {
    sec += 1;

    if (sec > 59) {
      sec = 0;
      min += 1;
    }

    if (min > 59) {
      min = 0;
      hour += 1;
    }

    // 0埋め
    sec_number = ('0' + sec).slice(-2);
    min_number = ('0' + min).slice(-2);
    hour_number = ('0' + hour).slice(-2);

    $('#clock').html(hour_number + ':' +  min_number + ':' + sec_number);
  }
});