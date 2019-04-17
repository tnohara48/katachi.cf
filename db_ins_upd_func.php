<!--
/*
*		db_ins_upd_func.php
*/
-->
<?php

// 入力項目の項目名羅列の入力値に対する正当性チェック
function post_date_error_check($post)
{
    $postdata  = $post['postdata'];
    //print $postdata;
    $name_list = explode(",", $postdata);
    $errors = "";
    $i = 0;
    while ($name_list[$i] != null) {
        $elem_val = explode(":", $name_list[$i]);
        $index = $elem_val[0];
        $title = $elem_val[1];
        if (!is_string($post[$index]) || $post[$index] == '') {
            if ($index != 'code' && $index != 'code_qa') {
                $errors = $errors.'「'.$title.'」';
            }
        }
        $i ++;
    }
    return $errors;
}

function db_ins_upd_func($db, $tbl, $post)
{
    try {
        require_once('./common/common.php');

        /* データベース接続処理 */
        $dsn  =       'mysql:dbname='.$db.';host=localhost;charset=utf8';
        $user =       'root';
        $dbpassword = 'shop_tnohara';
        $dbh              =    new PDO($dsn, $user, $dbpassword);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql    =    'LOCK TABLES '.$tbl.' WRITE';
        $stmt    =    $dbh->prepare($sql);
        $stmt->execute();

        $postdata  = $post['postdata'];
        $name_list = explode(",", $postdata);

        $sql = 'INSERT INTO '.$tbl;
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
            $upd = $upd . $index . '="' . $post[$index] . '"';
            $data[] = $post[$index];
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
        //print $sql;

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

        //print 'lastmembercode="' . $lastmembercode . '"';
        //exit();
        return $lastmembercode;
    } catch (Exception $e) {
        echo "DB ERROR!!" . $e;
        //exit();
        return 0;
    }
}

?>
