<?php
header('Content-type: text/plain; charset= UTF-8');
/*
**      member_entry.php
*/
?>
 <?php

  require_once('./common/common.php');

  $existing_name = "";
  $member_id =  "";
  $member_name =  "";
  $is_staff =  "";

  $dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'shop_tnohara';
  $dbh=new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql='SELECT id,name,password,is_staff,login_status FROM users';
  $sql = $sql . " WHERE name='" . $_POST['name'] . "'";
  $stmt=$dbh->prepare($sql);
  $stmt->execute();

  $dbh=null;

  while(true)
  {
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    if($rec==false)
    {
      break;
    }
    $password = md5(md5($_POST['password']));
    if ($rec['name'] == $_POST['name'] && $rec['password'] == $password) {
      $existing_name = h($rec['name']);
      $member_id = h($rec['id']);
      $member_name = h($rec['name']);
      $is_staff  = h($rec['is_staff']);
      break;
    }
  }

  if ($_POST['process'] == "@login") {
  	if ($member_id != "" && $member_name != "") {
      echo $member_id . '<AND>' . $member_name. '<AND>' . $is_staff;
  	} else {
      $str = "お名前か暗証番号が間違っています。<br>再度、入力してください。";
      $result = nl2br($str);
      echo $result;
  	}
  } else {
    if ($member_id != "") {
      $str = "その名前は既に登録されています。ログインしてください。" . $member_name . " 様";
      $result = nl2br($str);
      echo $result;
    }

    $name = h($_POST['name']);
    $password = md5(md5($_POST['password']));
    $is_staff = h($_POST['is_staff']);
  	/* データベース接続処理 */
    $dsn = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
    $user       = 'root';
    $dbpassword = 'shop_tnohara';
  	$dbh			=	new PDO($dsn,$user,$dbpassword);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  	$sql	=	'LOCK TABLES users WRITE';
  	$stmt	=	$dbh->prepare($sql);
  	$stmt->execute();

  	/* データ挿入 */
  	$sql='INSERT INTO users (
      id,
  		name,
  		password,
      is_staff
      )
  		VALUES (?,?,?,?)';

  	$stmt=$dbh->prepare($sql);
  	$data=array();
  	$data[] = "";
  	$data[] = $name;
  	$data[] = $password;
  	$data[] = $is_staff;

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

    if ($lastmembercode != 0) {
      echo $lastmembercode . '<AND>' . $name . '<AND>' . $is_staff;
    } else {
      $str = "申し訳ございません。お名前の登録に失敗しました。" . $name . "様";
      $result = nl2br($str);
      echo $result;
    }
  }

?>
