<?php
  header('Content-type: text/plain; charset= UTF-8');

  $bodytag = file_get_contents("ModalDialogBoxQABody.php");

  if ($_POST['code'] == "") {

    $bodytag = str_replace("%code%", 'value=""', $bodytag);
    $bodytag = str_replace("%member_id%", 'value=""', $bodytag);
    $bodytag = str_replace("%member_name%", 'value=""', $bodytag);

    $bodytag = str_replace("%category%", 'value=""', $bodytag);
    $bodytag = str_replace("%title%", 'value=""', $bodytag);
    $bodytag = str_replace("%question%", 'value=""', $bodytag);
    $bodytag = str_replace("%answerer%", 'value=""', $bodytag);
  } else {

    require_once('./common/common.php');

    $dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
    $user     = 'root';
    $password = 'shop_tnohara';
    $dbh=new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $sql  ='SELECT * FROM qa_history WHERE code=' . $_POST['code'];
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh=null;

    $rec  = $stmt->fetch(PDO::FETCH_ASSOC);

    $bodytag = str_replace("%code%", 'value="' . h($rec['code'] . '" disabled', $bodytag);
    $bodytag = str_replace("%member_id%", 'value="' . h($rec['member_id'] . '" disabled', $bodytag);
    $bodytag = str_replace("%member_name%", 'value="' . h($rec['member_name'] . '" disabled', $bodytag);

    $bodytag = str_replace("%category%", 'value="' . h($rec['category'] . '" disabled', $bodytag);
    $bodytag = str_replace("%title%", 'value="' . h($rec['title'] . '" disabled', $bodytag);
    $bodytag = str_replace("%question%", 'value="' . h($rec['question'] . '" disabled', $bodytag);
    $bodytag = str_replace("%answerer%", 'value="' . h($rec['answerer'] . '" disabled', $bodytag);
  }

  echo $bodytag;

?>
