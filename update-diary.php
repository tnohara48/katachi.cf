<?php
header( 'Content-type: text/plain; charset= UTF-8' );
/*
 **      update-diary.php
 */
/*
echo $_POST[ 'subject1' ];

echo $_POST[ 'subject5' ];
exit();
*/
try {
  require_once( './common/common.php' );

  /* データベース接続処理 */
  $dsn = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user = get_db_userid();
  $password = get_db_password();
  $dbh = new PDO( $dsn, $user, $password );
  $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  $sql = 'LOCK TABLES diary_members WRITE';
  $stmt = $dbh->prepare( $sql );
  $stmt->execute();

  //exit();
  /* データ挿入 */
  $sql = 'INSERT into diary_members (
 			code,
      member_id,
      member_name,
 			subject1,
 			subject2,
 			subject3,
 			subject4,
 			subject5,
 			subject6,
 			subject7)
 			VALUES (?,?,?,?,?,?,?,?,?,?)
 			on duplicate key update ' .
  'code="' . $_POST[ 'code' ] . '", ' .
  'member_id="' . $_POST[ 'member_id' ] . '", ' .
  'member_name="' . $_POST[ 'member_name' ] . '", ' .
  'subject1="' . $_POST[ 'subject1' ] . '", ' .
  'subject2="' . $_POST[ 'subject2' ] . '", ' .
  'subject3="' . $_POST[ 'subject3' ] . '", ' .
  'subject4="' . $_POST[ 'subject4' ] . '", ' .
  'subject5="' . $_POST[ 'subject5' ] . '", ' .
  'subject6="' . $_POST[ 'subject6' ] . '", ' .
  'subject7="' . $_POST[ 'subject7' ] . '"';
  $stmt = $dbh->prepare( $sql );
  $data = array();
  $data[] = $_POST[ 'code' ];
  $data[] = $_POST[ 'member_id' ];
  $data[] = $_POST[ 'member_name' ];
  $data[] = $_POST[ 'subject1' ];
  $data[] = $_POST[ 'subject2' ];
  $data[] = $_POST[ 'subject3' ];
  $data[] = $_POST[ 'subject4' ];
  $data[] = $_POST[ 'subject5' ];
  $data[] = $_POST[ 'subject6' ];
  $data[] = $_POST[ 'subject7' ];

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

  echo "SUCCESS";
} catch ( Exception $e ) {
  print "DB ERROR!!!!!";
  exit();
}

?>