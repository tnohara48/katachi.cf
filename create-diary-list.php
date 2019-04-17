<?php
/*
 **      create-diary-list.php
 */

header( 'Content-type: text/plain; charset= UTF-8' );

require_once( './common/common.php' );

try {
  $dsn = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
  $user = get_db_userid();
  $password = get_db_password();
  $dbh = new PDO( $dsn, $user, $password );

  $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

  $sql = 'SELECT * FROM diary_members WHERE member_name=?';
  $stmt = $dbh->prepare( $sql );
  $data[] = $_POST[ "member_name" ];
  $stmt->execute( $data );

  $dbh = null;

  print '<table class="table table-hover">';
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
    //print '<tr onclick="window.location=\'diary.php?code=' . h($rec['code']) . '&member_id=' . h($rec['member_id']) . '&member_name=' . h($rec['member_name']) . '\'";>';
    //print '<tr onclick="disp_modal(' . $rec['code'] . ')";>';
    //print '<tr onclick="disp_modal(\'' . $rec[ 'code' ] . '\',\'' . h( $rec[ 'member_id' ] ) . '\',\'' . h( $rec[ 'member_name' ] ) . '\')";>';
    print '<tr onclick="disp_input_diary_modal(\'' .$rec[ 'code' ] . '\')";>';
    print '<th scope="row">' . h( $rec[ 'code' ] ) . '</th>';
    print '<td>' . h( $rec[ 'member_name' ] ) . '</td>';
    print '<td>' . h( $rec[ 'subject1' ] ) . '</td>';
    print '<td>' . h( $rec[ 'subject2' ] ) . '</td>';
    print '<td>' . h( $rec[ 'subject5' ] ) . '</td>';
    print '<td>' . h( $rec[ 'created_at' ] ) . '</td>';
    print '</tr>';
  }
  //print '<tr onclick="disp_modal(' . $rec[ 'member_id' ] . ')";>';
  //print '<tr onclick="disp_modal(\'' . '' . '\',\'' . h( $rec[ 'member_id' ] ) . '\',\'' . h( $rec[ 'member_name' ] ) . '\')";>';
  print '<tr onclick="disp_input_diary_modal(\'\')";>';
  print '<th scope="row">' . "" . '</th>';
  print '<td>' . "" . '</td>';
  print '<td>' . "" . '</td>';
  print '<td><b>' . "新規投稿" . '</b></td>';
  print '<td>' . "" . '</td>';
  print '<td>' . "" . '</td>';
  print '</tr>';

  print '</tbody></table>';

} // end of try
catch ( Exception $e ) {
  print 'ただいま障害により大変ご迷惑をお掛けしております。<br />';
  exit();
}


?>