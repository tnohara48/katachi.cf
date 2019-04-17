<?php
/*
**      get_member_entry.php
*/

  header('Content-type: text/plain; charset= UTF-8');

  require_once('./common/common.php');

  $member_id =  "";
  $member_name =  "";

  $dsn      = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user     = get_db_userid();
  $password = get_db_password();
  $dbh      = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql='SELECT id,name,password,is_staff,login_status FROM users';
  $sql = $sql . " WHERE name='" . $_POST['member_name'] . "'";
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
    if ($rec['name'] == $_POST['member_name']) {
      $member_id      = h($rec['id']);
      $member_name    = h($rec['name']);
      $is_staff       = h($rec['is_staff']);
      break;
    }
  }
  if ($member_id != "" && $member_name != "" && $is_staff != "") {
    echo $member_id . '<AND>' . $member_name. '<AND>' . $is_staff;
  } else {
    echo '<NOENTRY>';
  }

?>