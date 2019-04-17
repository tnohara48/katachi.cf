<?php
header( 'Content-type: text/plain; charset= UTF-8' );

require_once( './common/common.php' );

db_upd_func( $_POST[ 'db' ], $_POST[ 'tbl' ], $_POST[ 'postdata' ] );

//create_tab_qa( "", $_POST[ 'member_id_qa' ], $_POST[ 'member_name_qa' ] );

function db_upd_func( $db, $tbl, $postdata ) {
  if ( $postdata == "" ) {
    return;
  }

  try {

    /* データベース接続処理 */
    $dsn = 'mysql:dbname=' . $db . ';host=localhost;charset=utf8';
    $user = get_db_userid();
    $dbpassword = get_db_password();
    $dbh = new PDO( $dsn, $user, $dbpassword );
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $sql = 'LOCK TABLES ' . $tbl . ' WRITE';
    $stmt = $dbh->prepare( $sql );
    $stmt->execute();

    $name_list = explode( ",", $postdata );

    $sql = 'INSERT INTO ' . $tbl;
    $val = 'VALUES';
    $upd = 'on duplicate key update';
    $sql = $sql . ' (';
    $val = $val . ' (';
    $upd = $upd . ' ';
    $data = array();

    $i = 0;
    while ( $name_list[ $i ] != null ) {
      $elem_val = explode( ":", $name_list[ $i ] );
      $index = $elem_val[ 0 ];
      if ( $index == 'member_id_qa' ) {
        $value = trim( $elem_val[ 1 ], '\'' );
      } else {
        $value = trim( $elem_val[ 1 ], ' ' );
      }

      $sql = $sql . $index;
      $val = $val . '?';
      $upd = $upd . $index . '=' . $value;
      $data[] = trim( $value, '\'' );
      $i++;
      if ( $name_list[ $i ] != null ) {
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
    $stmt = $dbh->prepare( $sql );

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

    //print 'lastmembercode="' . $lastmembercode . '"';
    //exit();
    return $lastmembercode;
  } catch ( Exception $e ) {
    echo "DB ERROR!!" . $e;
    //exit();
    return 0;
  }
}


function create_tab_qa( $code, $member_id, $member_name ) {
  try {
    if ( $member_id == "" ) {
      print( '<div><p style="color:tomato">ログインしてください。</p></div>' );
      return;
    }
    if ( $member_name == "" ) {
      print( '<div><p style="color:tomato">ログインしてください。</p></div>' );
      return;
    }

    $dsn = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
    $user = get_db_userid();
    $password = get_db_password();
    $dbh = new PDO( $dsn, $user, $password );

    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $sql = 'SELECT * FROM qa_history WHERE member_id_qa=?';
    $stmt = $dbh->prepare( $sql );
    $data[] = $member_id;
    $stmt->execute( $data );

    $dbh = null;

    print '質問詳細を見るには各行をクリックしてください。<br>' /* . "code=$code" . " member_id=$member_id" . " member_name=$member_name"*/ ;

    print '<table class="table table-hover">';
    print '<thead><thead class="thead-light"><tr><th scope="col">番号</th><th scope="col">題名</th><th scope="col">質問日時</th><th scope="col">質問</th><th scope="col">回答日時</th><th scope="col">回答</th></tr></thead><tbody>';
    while ( true ) {
      $rec = $stmt->fetch( PDO::FETCH_ASSOC );
      if ( $rec == false ) {
        break;
      }
      //print '<tr onclick="window.location=\'diary.php?code=' . h($rec['code']) . '&member_id=' . h($rec['member_id']) . '&member_name=' . h($rec['member_name']) . '\'";>';
      $code = $rec[ 'code_qa' ];

      print '<tr onclick="disp_modal_qa(\'' . $code . '\',\'' . $member_id . '\',\'' . $member_name . '\')";>';

      //print '<tr onclick="disp_modal_qa(' . $rec['code'] . ',' . $member_id . ',\'' . $member_name . '\')";>';
      print '<th scope="row">' . h( $rec[ 'code_qa' ] ) . '</th>';
      print '<td>' . h( $rec[ 'title' ] ) . '</td>';
      print '<td>' . h( $rec[ 'date_time_q' ] ) . '</td>';
      print '<td>' . h( mb_substr( $rec[ 'question' ], 0, 15 ) ) . '</td>';
      print '<td>' . h( $rec[ 'date_time_a' ] ) . '</td>';
      print '<td>' . h( mb_substr( $rec[ 'answer' ], 0, 15 ) ) . '</td>';
      print '</tr>';
    }
    //print '<tr onclick="disp_modal_qa(' . 0 . ',' . 0 . ',\'' . $member_name . '\')";>';
    print '<tr onclick="disp_modal_qa(\'' . '' . '\',\'' . $member_id . '\',\'' . $member_name . '\')";>';
    //print '<tr onclick="disp_modal_qa(0,' . ',' . $member_id . ',\'' . $member_name . '\')";>';
    print '<th scope="row">' . "" . '</th>';
    print '<td>' . "" . '</td>';
    print '<td>' . "" . '</td>';
    print '<td><b>' . "新しい質問をする" . '</b></td>';
    print '<td>' . "" . '</td>';
    print '<td>' . "" . '</td>';
    print '</tr>';
    print '</tbody></table>';

    return;
  } // end of try
  catch ( Exception $e ) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。<br />';
    return;
  }
}


?>