<?php
/*
**  diary.php  日報入力
*/

session_start();
session_regenerate_id(true);

require_once('./common/common.php');

$member_name = "";

if(isset($_SESSION['member_login'])==false) {
  // ログインしていません
} else {
  // ログインしています
  if (!empty($_SESSION)) {
    if (isset($_SESSION['member_name']) && is_string($_SESSION['member_name']) && $_SESSION['member_name'] != "") {
      $member_name = h($_SESSION['member_name']);
    }
  }
}
?>
<!doctype html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--<link rel="stylesheet" href="http://resources/demos/style.css">-->

  <title>質問</title>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!--AJAX 読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>

<body>

<div class="container">
  <div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
      <p>
        <h1>質問の入力</h1>
      </p>
    </div>
    <div class="col-sm-2">
    </div>
  </div>
  <div class="row">
  </div>
  <div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
      <form>
        <div class="form-group">
          <?php
          // 年4桁、月日を2桁ゼロ詰めする場合　
          // 2009年01月02日　
          //  date('Y年m月d日');
          ?>
          <label for="display-date">今日の日付</label>
          <input type="text" class="form-control" id="display-date" placeholder="<?=date('Y年m月d日')?>" disabled>
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput0">質問のタイトル</label>
          <input type="email" class="form-control" id="exampleFormControlInput0" placeholder="「３ステップ」について。など">
        </div>

        <!-- ラジオボタン -->
        <div class="form-group">
          <div class="form-row">
            <label for="exampleFormControlInput0">質問の種類</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" checked>
            <label class="custom-control-label" for="customRadioInline1">学習内容</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline2">生活全般</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline2">本事業所について</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline2">その他</label>
          </div>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea0">質問内容</label>
          <textarea class="form-control" id="exampleFormControlTextarea0" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">希望する回答者（都合により指定いただいた先生以外が回答する場合があります）</label>
          <select class="form-control" id="exampleFormControlSelect1">
            <option>(先生を選択してください)</option>
            <option>斎藤先生(プロゼミ、Java、Python、PHP)</option>
            <option>田中先生(プロゼミ、Web)</option>
            <option>大橋先生(プロゼミ、Java、Android、Python、PHP、他)</option>
            <option>関先生(Java、Android、Python、PHP、他)</option>
            <option>山本先生-実践(Java、Android、Python、Web、AI、実践全般、他)</option>
            <option>山本先生(福祉、他)</option>
            <option>諏訪先生(福祉、他)</option>
            <option>土江田先生(英語、福祉、他)</option>
            <option>その他</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect2">使用している本(オプション)</label>
          <select multiple class="form-control" id="exampleFormControlSelect2">
            <option>Java 3ステップ</option>
            <option>オラクルJava試験</option>
            <option>テストプリント</option>
            <option>イラストレーター</option>
            <option>フォトショップ</option>
          </select>
        </div>
        <div class="form-group">
          <p><button type="button" class="btn btn-primary" name="entry" id="btn_entry">質問する</button>
          <button type="button" class="btn btn-secondary btn-sm" id="btn_cancel" data-dismiss="modal">取消</button></p>
        </div>
      </form>
    </div>
    <div class="col-sm-2">
    </div>
  </div>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- CDN にて読み込み-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- <script src="jquery-ui/jquery-ui.js"></script> -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!--
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>
