<?php
  header('Content-type: text/plain; charset= UTF-8');

  require_once('./common/common.php');
  try {
    $dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
    $user = get_db_userid();
    $password = get_db_password();
    $dbh=new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $sql  ='SELECT * FROM users';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh=null;

    print '<label>利用者を選択してください</label>';
    print '<select class="form-control" name="users_select" id="users_select" onchange="users_select_changed()">';
    while(true)
    {
      $rec=$stmt->fetch(PDO::FETCH_ASSOC);
      if($rec==false)
      {
        break;
      }
      print '<option value="' . $rec['name'] . '">' . $rec['name'] . '</option>';
    }

  } catch (Exception $e) {
    console.log("error!!!" . $e);
    
  }
  print '</select>';    
?>
