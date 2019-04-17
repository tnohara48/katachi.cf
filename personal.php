<?php
/*
**  personal.php  日報入力
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

  <title>個人情報入力</title>

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
        <h1>自己紹介を入力する</h1>
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
          <label for="exampleFormControlInput0">生年月日</label>
            <div class="row">
                <div class="col-sm-3">
                    <div>
                        <select class="form-control" name="date_of_birth_era" id="date_of_birth_era">
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <select class="form-control" name="date_of_birth_year" id="date_of_birth_year">
                        </select>
                        <span class="input-group-addon">年</span>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <select class="form-control" name="date_of_birth_month" id="date_of_birth_month">
                        </select>
                        <span class="input-group-addon">月</span>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <select id="date_of_birth_day" name="date_of_birth_day" class="form-control" >
                        </select>
                        <span class="input-group-addon">日</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput0">趣味</label>
          <input type="email" class="form-control" id="exampleFormControlInput0" placeholder="読書、音楽、など">
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput0">休日の過ごし方</label>
          <input type="email" class="form-control" id="exampleFormControlInput0" placeholder="読書、音楽、など">
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput0">その他</label>
          <input type="email" class="form-control" id="exampleFormControlInput0" placeholder="読書、音楽、など">
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

  <script src="./js/wareki.js"></script>

</body>
</html>
