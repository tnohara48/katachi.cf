<?php
  header('Content-type: text/plain; charset= UTF-8');
  require_once('./common/common.php');

  $dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user     = 'root';
  $password = 'shop_tnohara';
  $dbh=new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $sql  ='SELECT * FROM diary_members WHERE code=' . $_POST['code'];
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $dbh=null;

  $rec  = $stmt->fetch(PDO::FETCH_ASSOC);

  $str = "";
  $str .= (h($rec['code']) . '<AND>');
  $str .= (h($rec['member_id']) . '<AND>');
  $str .= (h($rec['member_name']) . '<AND>');
  $str .= (h($rec['subject1']) . '<AND>');
  $str .= (h($rec['subject2']) . '<AND>');
  $str .= (h($rec['subject3']) . '<AND>');
  $str .= (h($rec['subject4']) . '<AND>');
  $str .= (h($rec['subject5']) . '<AND>');
  $str .= (h($rec['subject6']) . '<AND>');
  $str .= (h($rec['subject7']) . '<AND>');
  $str .= (h($rec['updated_at']));

  echo $str;

?>
