<?php
// header('Content-type: text/plain; charset= UTF-8');
/*
**      update-diary.php
*/
  try {

    require_once('./common/common.php');

    /* データベース接続処理 */
    $dsn  =       'mysql:dbname=membersapp;host=localhost;charset=utf8';
    $user =       'root';
    $dbpassword = 'shop_tnohara';
    $dbh			  =	new PDO($dsn,$user,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $sql	=	'LOCK TABLES qa_history WRITE';
    $stmt	=	$dbh->prepare($sql);
    $stmt->execute();

    $postdata  = $_POST['postdata'];
    $name_list = explode(",", $postdata);

    $sql = 'INSERT INTO qa_history';
    $val = 'VALUES';
    $upd = 'on duplicate key update';
    $sql = $sql . ' (';
    $val = $val . ' (';
    $upd = $upd . ' ';
   	$data = array();

    $i = 0;
    while ($name_list[$i] != null) {
    	$elem_val = explode(":", $name_list[$i]);
    	$index = $elem_val[0];
    	$title = $elem_val[1];

      $sql = $sql . $index;
      $val = $val . '?';
      $upd = $upd . $index . '="' . $_POST[$index] . '"';
      $data[] = $_POST[$index];
      $i ++;
      if ($name_list[$i] != null) {
        $sql = $sql . ',';
        $val = $val . ',';
        $upd = $upd . ',';
      } else {
        $sql = $sql . ') ';
        $val = $val . ') ';
        $upd = $upd . '';
        break;
      }
  	}

    $sql = $sql . $val . $upd;

     /* データ挿入 */
     $stmt=$dbh->prepare($sql);

   	 $stmt->execute($data);

   	 $sql = 'SELECT LAST_INSERT_ID()';
   	 $stmt = $dbh->prepare($sql);
   	 $stmt->execute();
   	 $rec=$stmt->fetch(PDO::FETCH_ASSOC);
   	 $lastmembercode = $rec['LAST_INSERT_ID()'];

   	 $sql = 'UNLOCK TABLES';
   	 $stmt = $dbh->prepare($sql);
   	 $stmt->execute();

   	  $dbh=null;

//    echo $lastmembercode;

      header('Location:index.php');

      return;
    }
    catch (Exception $e)  {
      echo "DB ERROR!!" . $e;
      exit();
    }

?>
