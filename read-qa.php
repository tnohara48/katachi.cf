<?php
header( 'Content-type: text/plain; charset= UTF-8' );

require_once( './common/common.php' );

try {
  $dsn = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user = get_db_userid();
  $password = get_db_password();
  $dbh = new PDO( $dsn, $user, $password );
} catch ( PDOException $e ) {
  print( 'Error:' . $e->getMessage() );
  die();
}
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA= 'membersapp' AND TABLE_NAME= 'qa_history'";
$stmt = $dbh->query( $sql );
if ( !$stmt ) {
  echo $dbh->errorInfo();
  exit();
}
$elements = array();
$i = 0;
while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ) {
  //echo $row["COLUMN_NAME"];
  $elements[ $i ] = $row[ "COLUMN_NAME" ];
  $i++;
}
$dbh = null;
if ( $_POST[ 'code_qa' ] == "" ) {
  $str = "";
  $i = 0;
  while ( isset( $elements[ $i ] ) ) {
    $str = $str . $elements[ $i ] . "<AND>" . "<AND>";
    //$elements[] = $row["COLUMN_NAME"];
    $i++;
  }
  echo $str;
  return;
} else {
  $dsn = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user = get_db_userid();
  $password = get_db_password();
  $dbh = new PDO( $dsn, $user, $password );
  $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  $sql = 'SELECT * FROM qa_history WHERE code_qa=' . $_POST[ 'code_qa' ];
  $stmt = $dbh->prepare( $sql );
  $stmt->execute();
  $dbh = null;
  $rec = $stmt->fetch( PDO::FETCH_ASSOC );
  $str = "";
  $i = 0;
  while ( isset( $elements[ $i ] ) && $elements[ $i ] ) {
    $str = $str . ( $elements[ $i ] . "<AND>" . h( $rec[ $elements[ $i ] ] ) . "<AND>" );
    $i++;
  }
  echo $str;
  return;
}