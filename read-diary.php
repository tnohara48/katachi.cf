<?php
  header('Content-type: text/plain; charset= UTF-8');

  if ($_POST['code'] == "") {
    
    $str = "";
    $str .= '<AND>';  // 0
    $str .= '<AND>';  // 1
    $str .= '<AND>';  // 2
    $str .= '<AND>';  // 3
    $str .= '<AND>';  // 4
    $str .= '<AND>';  // 5
    $str .= '<AND>';  // 6
    $str .= '<AND>';  // 7
    $str .= '<AND>';  // 8
    $str .= '<AND>';  // 9
    $str .= date( "Y-m-d H:i:s" ) . '<AND>';  // 10
    $str .= 'NEW';   // 11
    echo $str;
    return;
  }

  require_once('./common/common.php');

  $dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user = get_db_userid();
  $password = get_db_password();
  $dbh=new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $sql  ='SELECT * FROM diary_members WHERE code=' . $_POST['code'];
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $dbh=null;

  $rec  = $stmt->fetch(PDO::FETCH_ASSOC);

  $str = "";
  $str .= (h($rec['code']) . '<AND>');      // 0
  $str .= (h($rec['member_id']) . '<AND>'); // 1
  $str .= (h($rec['member_name']) . '<AND>');  // 2
  $str .= (h($rec['subject1']) . '<AND>');  // 3
  $str .= (h($rec['subject2']) . '<AND>');  // 4
  $str .= (h($rec['subject3']) . '<AND>');  // 5
  $str .= (h($rec['subject4']) . '<AND>');  // 6
  $str .= (h($rec['subject5']) . '<AND>');  // 7
  $str .= (h($rec['subject6']) . '<AND>');  // 8
  $str .= (h($rec['subject7']) . '<AND>');  // 9
  $str .= (h($rec['created_at']) . '<AND>');// 10
  $str .=  'UPDATE';                        // 11

  echo $str;

?>
