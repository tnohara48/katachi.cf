<?php
/*
**  diary.php  日報入力
*/

require_once('./common/common.php');

$code = '';
$member_id = '';
$member_name = '';
/*
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
*/

if(isset($_POST['subject1'])) {
  print "POSTED!!";

  try {

    require_once('./common/common.php');

  	$post=sanitize($_POST);

  	$code	    =	$post['code'];
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
  	$dbh			=	new PDO($dsn,$user,$dbpassword);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql	=	'LOCK TABLES diary_members WRITE';
  	$stmt	=	$dbh->prepare($sql);
  	$stmt->execute();

  	/* データ挿入 */
  	$sql='INSERT into diary_members (
  			code,
  			subject1,
  			subject2,
  			subject3,
  			subject4,
  			subject5,
  			subject6,
  			subject7)
  			VALUES (?,?,?,?,?,?,?,?)
  			on duplicate key update ' .
  			'code="' . $code . '", ' .
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

  	header('Location:diary.php');
  	exit();
  }
  catch (Exception $e)  {
    print "DB ERROR!!";
    exit();
  }




}

function create_table_members() {

	require_once('./common/common.php');

	try
	{
		if (!empty($_GET)) {
		  if (isset($_GET['member_id']) && is_string($_GET['member_id'])) {
				$member_id = $_GET['member_id'];
			}
		  if (isset($_GET['member_name']) && is_string($_GET['member_name'])) {
				$member_name = $_GET['member_name'];
			}
		}

		$dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
		$user=get_userid();
		$password=get_password();
		$dbh=new PDO($dsn,$user,$password);

		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='SELECT * FROM diary_members WHERE member_id=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$member_id;

		$stmt->execute($data);

		$dbh=null;

		print '<table class="table table-hover">';
		print '<thead>
			<thead class="thead-light">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">名前</th>
		      <th scope="col">今日やったこと</th>
		      <th scope="col">問題と感じたこと</th>
		      <th scope="col">スタッフへの連絡</th>
		      <th scope="col">登録日時</th>
		    </tr>
		  </thead>
		  <tbody>';
		while(true) {

			$rec=$stmt->fetch(PDO::FETCH_ASSOC);
			if($rec==false)
			{
				break;
			}
		  print '<tr onclick="window.location=\'diary.php?code=' . h($rec['code']) . '&member_id=' . h($rec['member_id']) . '&member_name=' . h($rec['member_name']) . '\'";>';
			print '<th scope="row">' . h($rec['code']) . '</th>';
		  print '<td>' . h($rec['member_name']) . '</td>';
		  print '<td>' . h($rec['subject1']) . '</td>';
		  print '<td>' . h($rec['subject2']) . '</td>';
		  print '<td>' . h($rec['subject5']) . '</td>';
		  print '<td>' . h($rec['created_at']) . '</td>';
	    print '</tr>';
		}
    print '<tr onclick="window.location=\'diary.php?member_name=' . $member_name . '&member_id=' . $member_id . '&code=0' . '\'";>';
    print '<th scope="row">' . "" . '</th>';
    print '<td>' . "" . '</td>';
    print '<td>' . "" . '</td>';
    print '<td><b>' . "新規投稿" . '</b></td>';
    print '<td>' . "" . '</td>';
    print '<td>' . ""  . '</td>';
    print '</tr>';

		print '</tbody></table>';

	}	// end of try
	catch(Exception $e)
	{
    print 'ただいま障害により大変ご迷惑をお掛けしております。<br />';
  	exit();
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

  <title>日記一覧</title>

  <style>
    body {
      position: relative;
    }
  </style>

</head>

<body>

<div class="container">
  <div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
      <p><h2><span id="disp_name">ゲスト</span> さんの日記一覧</h2> <small><span id="disp_id"></span></small></p>
    </div>
    <div class="col-sm-1">
    </div>
  </div>
  <div class="row">
  </div>
  <div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
      <?php create_table_members(); ?>
    </div>
    <div class="col-sm-1">
    </div>
  </div>
  <div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
    <a href="index.php"><button type="button" class="btn btn-secondary btn-sm" id="btn_cancel" data-dismiss="modal">戻る</button></p></a>
    </div>
    <div class="col-sm-1">
    </div>
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

  <script>
    var result = document.cookie.indexOf('name');
    if(result !== -1) {
      console.log(document.cookie);
      var r = document.cookie.split(';');
      r.forEach(function(value) {
        //cookie名と値に分ける
        var content = value.split('=');
        if (content[0] == "id") {
          console.log( content[1] );
          $('#disp_id').text(content[1]);
        }
        if (content[0].indexOf('name')>=0) {
          console.log( content[1] );
          $('#disp_name').text(content[1] );
        }
      })
      console.log('存在します');
    }
    else {
      console.log('存在しません！');
    }
  </script>

</body>
</html>
