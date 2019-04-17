<?php
header( 'Content-type: text/plain; charset= UTF-8' );
ini_set('display_errors',1);
/*
 **      exist_the_memberphp.php
 */
try {
  require_once( './common/common.php' );
  $dsn = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user = get_db_userid();
  $password = get_db_password();
  $dbh = new PDO( $dsn, $user, $password );
  $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  $sql = 'SELECT name FROM users';
  $sql = $sql . " WHERE name='" . $_POST[ 'member_name' ] . "'";
  $stmt = $dbh->prepare( $sql );
  $stmt->execute();
  $dbh = null;
  $rec = $stmt->fetch( PDO::FETCH_ASSOC );
  if ( $rec == false ) {
    echo '<NOEXIST>';
  } else {
    echo '<EXIST>';
  }
}
catch (POException $e) {
  print("DB Error!!" . $e);
}
?>