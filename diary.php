<?php
/*
**  diary.php  日報入力
*/
/*
session_start();
session_regenerate_id(true);
*/
require_once('./common/common.php');

$member_id = "";
$member_name = "";
$disp_title = "日記入力";
$badge = "新規";
$updated_at = date("Y-m-d H:i:s");

/*
if (isset($_SESSION['member_login'])==false) {
  // ログインしていません
} else {
  // ログインしています
  if (!empty($_SESSION)) {
    if (isset($_SESSION['member_name']) && is_string($_SESSION['member_name']) && $_SESSION['member_name'] != "") {
      $member_name = h($_SESSION['member_name']);
    }
  }
}
*/
//print $_GET['code'] . " " . $_GET['member_id'] . " " . $_GET['member_name'];
$code = '';
$member_id = '';
$member_name = '';

if (isset($_GET) || isset($_POST)) {
    if (isset($_GET['code']) || isset($_POST['code'])) {
        if (!empty($_POST['code']) && is_string($_POST['code'])) {
            $code = $_POST['code'];
            $member_id = $_POST['member_id'];
            $member_name = $_POST['member_name'];
            $disp_title = "日記の修正";
            $badge = "修正中";
        } elseif (!empty($_GET['code']) && is_string($_GET['code'])) {
            $code = $_GET['code'];
            $member_id = $_GET['member_id'];
            $member_name = $_GET['member_name'];
            $disp_title = "日記の確認";
            $badge = "既存";
        } else {
            $code = $_GET['code'];
            $member_id = $_GET['member_id'];
            $member_name = $_GET['member_name'];
            $disp_title = "日記の新規作成";
            $badge = "新規";
        }

        if ($code != 0) {
            try {
                $dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
                $user=get_userid();
                $password=get_password();
                $dbh=new PDO($dsn, $user, $password);

                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql='SELECT * FROM diary_members WHERE code=?';
                $stmt=$dbh->prepare($sql);
                $data[]=$code;

                $stmt->execute($data);

                $dbh=null;

                $rec=$stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec['code'] != "") {
                    $code = $rec['code'];
                }
                if ($rec['member_id'] != "") {
                    $member_id = $rec['member_id'];
                }
                if ($rec['member_name'] != "") {
                    $member_name = $rec['member_name'];
                }
                if ($rec['updated_at'] != "") {
                    $updated_at = $rec['updated_at'];
                }
            }	// end of try
            catch (Exception $e) {
                print "ただいま障害により大変ご迷惑をお掛けしております。<br />";
                exit();
            }
        }
    }

    $disp_title = "日記の新規作成";
    $subtitle = $_GET['member_name'] . " さんが " . "作成中です。";
    if ($badge == "既存") {
        $subtitle = $member_name . " さんが<br> " . date_format(date_create($updated_at), 'Y日m月d日H時i分s秒') . " に書いた日記";
    } elseif ($badge == "修正中") {
        $subtitle = $member_name . " さんが " . " 修正中";
    }
} else {
    $disp_title = "日記の新規作成";
    $subtitle = $member_name . " さんが " . "作成中です。";
}

?>

<?php
if (isset($_POST['subject7']) && is_string($_POST['subject7'])) {
    if ($_POST['subject7'] == "新規" || $_POST['subject7'] == "修正中") {
        try {
            require_once('./common/common.php');

            $post=sanitize($_POST);

            $code	    =	$post['code'];
            $member_id=	$post['member_id'];
            $member_name=	$post['member_name'];
            $subject1	=	$post['subject1'];
            $subject2	=	$post['subject2'];
            $subject3	=	$post['subject3'];
            $subject4	=	$post['subject4'];
            $subject5	=	$post['subject5'];
            $subject6	=	$post['subject6'];
            $subject7	=	$post['subject7'];

            /* データベース接続処理 */
            $dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
            $user =       'root';
            $dbpassword = 'shop_tnohara';
            $dbh			=	new PDO($dsn, $user, $dbpassword);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql	=	'LOCK TABLES diary_members WRITE';
            $stmt	=	$dbh->prepare($sql);
            $stmt->execute();

            /* データ挿入 */
            $sql='INSERT into diary_members (
    			code,
          member_id,
          member_name,
    			subject1,
    			subject2,
    			subject3,
    			subject4,
    			subject5,
    			subject6,
    			subject7)
    			VALUES (?,?,?,?,?,?,?,?,?,?)
    			on duplicate key update ' .
                'code="' . $code . '", ' .
                'member_id="' . $member_id . '", ' .
                'member_name="' . $member_name . '", ' .
                'subject1="' . $subject1 . '", ' .
                'subject2="' . $subject2 . '", ' .
                'subject3="' . $subject3 . '", ' .
                'subject4="' . $subject4 . '", ' .
                'subject5="' . $subject5 . '", ' .
                'subject6="' . $subject6 . '", ' .
                'subject7="' . $subject7 . '"';

            $stmt=$dbh->prepare($sql);
            $data=array();
            $data[]=$code;
            $data[]=$member_id;
            $data[]=$member_name;
            $data[]=$subject1;
            $data[]=$subject2;
            $data[]=$subject3;
            $data[]=$subject4;
            $data[]=$subject5;
            $data[]=$subject6;
            $data[]=$subject7;

            $stmt->execute($data);

            $sql='SELECT LAST_INSERT_ID()';
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            $lastmembercode=$rec['LAST_INSERT_ID()'];

            $sql='UNLOCK TABLES';
            $stmt=$dbh->prepare($sql);
            $stmt->execute();

            $dbh=null;

//      print '<script language=javascript>disp_modal();</script>';

            header("Location:diary_list.php?member_id=$member_id&member_name=$member_name");

            exit();
        } catch (Exception $e) {
            print "DB ERROR!!";
            exit();
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

  <title>日記</title>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!--AJAX 読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script>
    function  disp_modal() {
      $("#ModalDone").modal("show");
    }
  </script>

</head>

<body>

<!-- Modal -->
<div class="modal fade" id="ModalDone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">登録完了</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        日記の登録を完了しました。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
      <p>
        <h1 id="disp_title"><?=$disp_title?></h1>
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
      <form method="post">
        <div class="form-group">
          <hr>
          <label id="subtitle"><h5><?=$subtitle?></h5><span class="badge badge-secondary"><?=$badge?></span></label>
        </div>
        <div class="form-group">
          <label for="display-date">日付</label>
          <input type="text" name="date" class="form-control" id="display-date" placeholder="<?=$updated_at?>" disabled value=<?=$updated_at?> >
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput0">今日やったこと</label>
          <input type="text" name="subject1" class="form-control" <?=($badge=="既存")?"disabled":""?> id="exampleFormControlInput0" placeholder="作業や読んだ本の名前など．．．" value="<?=isset($rec['subject1'])?h($rec['subject1']):''?>">
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea0">問題と感じたこと</label>
          <textarea class="form-control" name="subject2" <?=($badge=="既存")?"disabled":""?> id="exampleFormControlTextarea0" rows="3" value="<?=isset($rec['subject2'])?h($rec['subject2']):''?>"><?=isset($rec['subject2'])?h($rec['subject2']):''?></textarea>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea0">なぜそう思ったか</label>
          <textarea class="form-control" name="subject3" <?=($badge=="既存")?"disabled":""?> id="exampleFormControlTextarea0" rows="3" value="<?=isset($rec['subject3'])?h($rec['subject3']):''?>"><?=isset($rec['subject3'])?h($rec['subject3']):''?></textarea>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">今後どうしたいか</label>
          <textarea class="form-control" name="subject4" <?=($badge=="既存")?"disabled":""?> id="exampleFormControlTextarea1" rows="3" value="<?=isset($rec['subject4'])?h($rec['subject4']):''?>"><?=isset($rec['subject4'])?h($rec['subject4']):''?></textarea>
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">スタッフへの連絡</label>
          <select class="form-control" name="subject5" <?=($badge=="既存")?"disabled":""?> id="exampleFormControlSelect1">
            <option value="相談したい" <?=isset($rec)?is_selected($rec['subject5'], "相談したい"):''?>>相談したい</option>
            <option value="つぎの課題が欲しい" <?=isset($rec)?is_selected($rec['subject5'], "つぎの課題が欲しい"):''?>>つぎの課題が欲しい</option>
            <option value="やったことを報告したい" <?=isset($rec)?is_selected($rec['subject5'], "やったことを報告したい"):''?>>やったことを報告したい</option>
            <option value="やり方を相談したい" <?=isset($rec)?is_selected($rec['subject5'], "やり方を相談したい"):''?>>やり方を相談したい</option>
            <option value="その他" <?=isset($rec)?is_selected($rec['subject5'], "その他"):''?>>その他</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect2">やりたいこと</label>
          <select multiple class="form-control" name="subject6" <?=($badge=="既存")?"disabled":""?> id="exampleFormControlSelect2">
            <option value="本" <?=isset($rec)?is_selected($rec['subject6'], "本"):''?>>本</option>
            <option value="ビデオ" <?=isset($rec)?is_selected($rec['subject6'], "ビデオ"):''?>>ビデオ</option>
            <option value="テレビ" <?=isset($rec)?is_selected($rec['subject6'], "テレビ"):''?>>テレビ</option>
            <option value="ラジオ" <?=isset($rec)?is_selected($rec['subject6'], "ラジオ"):''?>>ラジオ</option>
            <option value="インターネット" <?=isset($rec)?is_selected($rec['subject6'], "インターネット"):''?>>インターネット</option>
          </select>
        </div>
        <div class="form-group">
          <input type="hidden" name="subject7" value="<?=$badge?>">
          <input type="hidden" name="code" value="<?=(isset($rec)?h($rec['code']):$code)?>">
          <input type="hidden" name="member_id" value="<?=(isset($rec)?h($rec['member_id']):$member_id)?>">
          <input type="hidden" name="member_name" value="<?=(isset($rec)?h($rec['member_name']):$member_name)?>">
        </div>
        <div class="form-group">
          <p><button type="submit" class="btn btn-primary" name="entry" id="btn_entry"><?=($badge=="既存"||$badge=="修正中")?"修正する":"保存する"?> </button>
          <a href="diary_list.php?member_id=<?=$member_id?>&member_name=<?=$member_name?>"><button type="button" class="btn btn-secondary btn-sm" id="btn_cancel" data-dismiss="modal">戻る</button></p></a>
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
