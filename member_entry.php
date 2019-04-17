<?php
header( 'Content-type: text/plain; charset= UTF-8' );
/*
 **      member_entry.php
 */
require_once( './common/common.php' );

try {
  /* データベース接続処理 */
  $dsn = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user = get_db_userid();
  $password = get_db_password();
  $dbh = new PDO( $dsn, $user, $password );
  $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

  $sql = 'LOCK TABLES users WRITE';
  $stmt = $dbh->prepare( $sql );
  $stmt->execute();

  /* データ挿入 */
  $sql = 'INSERT INTO users (
        id,
        name,
        password,
        is_staff
      )
      VALUES (?,?,?,?)';

  $stmt = $dbh->prepare( $sql );
  $data = array();
  $data[] = "";
  $data[] = h( $_POST[ 'member_name' ] );
  $data[] = md5( md5( $_POST[ 'password' ] ) );
  $data[] = h( $_POST[ 'is_staff' ] );

  $stmt->execute( $data );

  $sql = 'SELECT LAST_INSERT_ID()';
  $stmt = $dbh->prepare( $sql );
  $stmt->execute();
  $rec = $stmt->fetch( PDO::FETCH_ASSOC );
  $lastmembercode = $rec[ 'LAST_INSERT_ID()' ];

  $sql = 'UNLOCK TABLES';
  $stmt = $dbh->prepare( $sql );
  $stmt->execute();

  $dbh = null;

  if ( $lastmembercode != 0 ) {
    echo "" . $lastmembercode;
  } else {
    echo '0';
  } 

}  catch(Exception $e) {
  echo $e;
}
?>