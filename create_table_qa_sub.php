<?php
function create_tab_qa_sub( $code, $member_id, $member_name ) {
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

    print '<div>登録済みの質問詳細を確認する場合は各行をクリックしてください。<br>新しい質問を登録する場合は「新しい質問をする」を押してください。</div>' /* . "code=$code" . " member_id=$member_id" . " member_name=$member_name"*/ ;

    print '<table class="table table-hover">';
    print '<thead><thead class="thead-light"><tr><th scope="col">番号</th><th scope="col">題名</th><th scope="col">質問日時</th><th scope="col">質問</th><th scope="col">回答日時</th><th scope="col">回答</th></tr></thead><tbody>';
    while ( true ) {
      $rec = $stmt->fetch( PDO::FETCH_ASSOC );
      if ( $rec == false ) {
        break;
      }
      $code = $rec[ 'code_qa' ];

      print '<tr onclick="disp_modal_qa(\'' . $code . '\',\'' . $member_id . '\',\'' . $member_name . '\')";>';

      print '<th scope="row">' . h( $rec[ 'code_qa' ] ) . '</th>';
      print '<td>' . h( $rec[ 'title' ] ) . '</td>';
      print '<td>' . h( $rec[ 'date_time_q' ] ) . '</td>';
      print '<td>' . h( mb_substr( $rec[ 'question' ], 0, 15 ) ) . '</td>';
      print '<td>' . h( $rec[ 'date_time_a' ] ) . '</td>';
      print '<td>' . h( mb_substr( $rec[ 'answer' ], 0, 15 ) ) . '</td>';
      print '</tr>';
    }
    print '<tr onclick="disp_modal_qa(\'' . '' . '\',\'' . $member_id . '\',\'' . $member_name . '\')";>';
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