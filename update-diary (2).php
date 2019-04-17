<?php
  header('Content-type: text/plain; charset= UTF-8');
/*
**      member-entry.php
*/
?>
 <?php

 try {
   require_once('./common/common.php');

 	/* データベース接続処理 */
   $dsn  =       'mysql:dbname=membersapp;host=localhost;charset=utf8';
   $user =       'root';
   $dbpassword = 'shop_tnohara';
 	 $dbh			  =	new PDO($dsn,$user,$dbpassword);
 	 $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   $sql	=	'LOCK TABLES diary_members WRITE';
 	 $stmt	=	$dbh->prepare($sql);
 	 $stmt->execute();

   //exit();
 	 /* データ挿入 */
 	 $sql='INSERT into diary_members (
 			code,
      member_id,
      member_name,
 			subject1,
 			subject2,
 			subject3,
 			subject4,
 			subject5,
 			subject6,
 			subject7,
 			updated_at)
 			VALUES (?,?,?,?,?,?,?,?,?,?,?)
 			on duplicate key update ' .
 			'code="'       . $_POST['code'] . '", ' .
 			'member_id="'       . $_POST['member_id'] . '", ' .
 			'member_name="'       . $_POST['member_name'] . '", ' .
 			'subject1="'       . $_POST['subject1'] . '", ' .
 			'subject2="'       . $_POST['subject2'] . '", ' .
 			'subject3="'       . $_POST['subject3'] . '", ' .
 			'subject4="'       . $_POST['subject4'] . '", ' .
 			'subject5="'       . $_POST['subject5'] . '", ' .
      'subject6="'       . $_POST['subject6'][0] . '", ' .
      'subject7="'       . $_POST['subject7'] . '", ' .
 			'updated_at="'       . $_POST['updated_at'] . '"';
 	$stmt=$dbh->prepare($sql);
 	$data=array();
 	$data[]=$_POST['code'];
 	$data[]=$_POST['member_id'];
 	$data[]=$_POST['member_name'];
  $data[]=$_POST['subject1'];
  $data[]=$_POST['subject2'];
  $data[]=$_POST['subject3'];
  $data[]=$_POST['subject4'];
  $data[]=$_POST['subject5'];
  $data[]=$_POST['subject6'][0];
  $data[]=$_POST['subject7'];
  $data[]=$_POST['updated_at'];

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

  echo "SUCCESS";
}
catch (Exception $e)  {
   print "DB ERROR!!";
   exit();
}

?>
