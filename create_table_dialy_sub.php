<?php
function create_tab_dialy_sub( $code, $member_id, $member_name ) {
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

    $sql = 'SELECT * FROM diary_members WHERE member_id=?';
    $stmt = $dbh->prepare( $sql );
    $data[] = $member_id;
    $stmt->execute( $data );

    $dbh = null;
    
    print '<div>登録済みの学習の記録を確認編集する場合は下記の各行をクリックしてください。<br>新規に学習の記録を書く場合は「新規投稿」を押してください。</div>';

    print '<table class="table table-hover " id="create_table_members">';
    print '<thead>
			<thead class="thead-light">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">お名前</th>
		      <th scope="col">本日の課題内容</th>
		      <th scope="col">本日の課題で難しかったこと、できたこと</th>
		      <th scope="col">スタッフへの連絡</th>
		      <th scope="col">登録日時</th>
		    </tr>
		  </thead>
		  <tbody>';
    while ( true ) {
      $rec = $stmt->fetch( PDO::FETCH_ASSOC );
      if ( $rec == false ) {
        break;
      }
      $code = $rec[ 'code' ];
      print '<tr onclick="disp_input_diary_modal(\'' . $code . '\')";>';
      print '<td>' . h( $rec[ 'code' ] ) . '</td>';
      print '<td>' . h( $rec[ 'member_name' ] ) . '</td>';
      print '<td>' . h( $rec[ 'subject1' ] ) . '</td>';
      print '<td>' . h( $rec[ 'subject2' ] ) . '</td>';
      print '<td>' . h( $rec[ 'subject5' ] ) . '</td>';
      print '<td>' . h( $rec[ 'created_at' ] ) . '</td>';
      print '</tr>';
    }
    print '<tr onclick="disp_input_diary_modal(\'\')";>';
    print '<td>' . "" . '</td>';
    print '<td>' . "" . '</td>';
    print '<td>' . "" . '</td>';
    print '<td><b>' . "新規投稿" . '</b></td>';
    print '<td>' . "" . '</td>';
    print '<td>' . "" . '</td>';
    print '</tr>';

    print '</tbody></table>';
  } // end of try
  catch ( Exception $e ) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。<br />' . $e;
    exit();
  }
}

?>