function create_daiary_list_table($code, $member_id, $member_name) {

  if ($member_id == 0 || $member_name == "") {
    return '<div><p style="color:tomato">ログインしてください。</p></div>';
  }

  $temp_html = "";
  try {
    $dsn      = 'mysql:dbname=membersapp;host=localhost;charset=utf8';
    $user     = get_db_userid();
    $password = get_db_password();

    $dbh = new PDO($dsn, $user, $password);

    $dbh - > setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM diary_members WHERE member_id=?';
    $stmt = $dbh - > prepare($sql);
    $data[] = $member_id;
    $stmt - > execute($data);

    $dbh = null;

    $temp_html .= '<table class="table table-hover">';
    $temp_html .= '
      <thead> <thead class = "thead-light" >
        <tr>
          <th scope = "col" > # </th>
          <th scope = "col" > お名前 </th>
          <th scope = "col" > 本日の課題内容 </th>
          <th scope = "col" > 本日の課題で難しかったこと、 できたこと < /th>
          <th scope = "col" > スタッフへの連絡 < /th>
          <th scope = "col" > 登録日時 < /th>
        </tr>
      </thead>
      <tbody> ';
    while (true) {
      $rec = $stmt - > fetch(PDO::FETCH_ASSOC);
      if ($rec == false) {
        break;
      }
      $code = $rec['code'];
      $temp_html .= (
        '<tr onclick="disp_modal(\''.$code.
        '\',\''.$member_id.
        '\',\''.$member_name.
        '\')";>'
      );
      $temp_html .= (
        '<th scope="row">'.h($rec['code']).
        '</th>'
      );
      $temp_html .= (
        '<td>'.h($rec['member_name']).
        '</td>'
      );
      $temp_html .= (
        '<td>'.h($rec['subject1']).
        '</td>'
      );
      $temp_html .= (
        '<td>'.h($rec['subject2']).
        '</td>'
      );
      $temp_html .= (
        '<td>'.h($rec['subject5']).
        '</td>'
      );
      $temp_html .= (
        '<td>'.h($rec['created_at']).
        '</td>'
      );
      $temp_html .= '</tr>';
    }
    $temp_html .= (
      '<tr onclick="disp_modal(\''.
      ''.
      '\',\''.$member_id.
      '\',\''.$member_name.
      '\')";>'
    );
    $temp_html .= (
      '<th scope="row">'.
      "".
      '</th>'
    );
    $temp_html .= (
      '<td>'.
      "".
      '</td>'
    );
    $temp_html .= (
      '<td>'.
      "".
      '</td>'
    );
    $temp_html .= (
      '<td><b>'.
      "新規投稿".
      '</b></td>'
    );
    $temp_html .= (
      '<td>'.
      "".
      '</td>'
    );
    $temp_html .=
      ('<td>'.
      "".
      '</td>'
    );
    $temp_html .= '</tr>';

    $temp_html .= '</tbody></table>';
  } // end of try
  catch (Exception $e) {
    $temp_html .= (
      'ただいま障害により大変ご迷惑をお掛けしております。<br />'.' '.$e
    );
  }

  return $temp_html;
}

function disp_modal(code,member_id,member_name) {
  $("#code_m").val(code);
  $("#disp_id_m").val(member_id,);
  $("#disp_name_m").val(member_name);
  $("#ModalDialogBoxDiary").modal("show");
}
