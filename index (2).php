<?php

require_once('./common/common.php');

$code = '';
$member_id = '';
$member_name = '';
$badge = "新規";
$updated_at = date("Y-m-d H:i:s");


function create_table_members() {

	require_once('./common/common.php');

	try
	{
		$member_id = "";
		$member_name = "";
		if (isset($_COOKIE["id"]) && !empty($_COOKIE["id"])) {
			$member_id = $_COOKIE["id"];
		} else {
			print ('<div><p style="color:tomato">ログインしてください。</p></div>');
			return;
		}
		if (isset($_COOKIE["name"]) && !empty($_COOKIE["name"])) {
			$member_name = $_COOKIE["name"];
		} else {
			print ('<div><p style="color:tomato">ログインしてください。</p></div>');
			return;
		}

		$dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
		$user			=	get_userid();
		$password	=	get_password();
		$dbh=new PDO($dsn,$user,$password);

		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='SELECT * FROM diary_members WHERE member_id=?';
    $stmt=$dbh->prepare($sql);
    $data[] = $member_id;
		$stmt->execute($data);

		$dbh=null;

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
		while(true) {

			$rec=$stmt->fetch(PDO::FETCH_ASSOC);
			if($rec==false)
			{
				break;
			}
		  //print '<tr onclick="window.location=\'diary.php?code=' . h($rec['code']) . '&member_id=' . h($rec['member_id']) . '&member_name=' . h($rec['member_name']) . '\'";>';
		  print '<tr onclick="disp_modal(' . $rec['code'] . ')";>';
			print '<th scope="row">' . h($rec['code']) . '</th>';
		  print '<td>' . h($rec['member_name']) . '</td>';
		  print '<td>' . h($rec['subject1']) . '</td>';
		  print '<td>' . h($rec['subject2']) . '</td>';
		  print '<td>' . h($rec['subject5']) . '</td>';
		  print '<td>' . h($rec['created_at']) . '</td>';
	    print '</tr>';
		}
    print '<tr onclick="new_modal(' . $rec['member_id'] . ')";>';
    print '<th scope="row">' . "" . '</th>';
    print '<td>' . "" . '</td>';
    print '<td>' . "" . '</td>';
    print '<td><b>' . "新規投稿" . '</b></td>';
    print '<td>' . "" . '</td>';
    print '<td>' . ""  . '</td>';
    print '</tr>';

		print '</tbody></table>';

	}	// end of try
	catch(Exception $e)
	{
    print 'ただいま障害により大変ご迷惑をお掛けしております。<br />';
  	exit();
  }
}
?>

<!doctype html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--<link rel="stylesheet" href="http://resources/demos/style.css">-->

  <title>ホームページ</title>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!--AJAX 読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-10">
        <p>
          <h5>就労移行支援事業所 未来のかたち</h5>
        </p>
        <p>
          <h3>ユーザーホームページ</h3>
        </p>
      </div>
      <div class="col-sm-1">
      </div>
    </div>

    <!--◆◆◆ ログインボタン表示-->
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-4">
        <p>ようこそ、<span id="disp_name">ゲスト</span> 様 <small> (ユーザー番号:<span id="disp_id" invisible></span>)</small></p>
      </div>
      <div class="col-sm-6" style="text-align:right">
        <p>
          <button type="button" class="btn btn-success" id="btn_login" data-toggle="modal" data-target="#exampleModal" data-whatever="@login">ログイン</button>
          <!--<button type="button" class="btn btn-success" id="btn_logout" data-toggle="modal" data-target="#exampleModal" data-whatever="@logout">ログアウト</button>-->
          <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="@new_entry">新規登録</button>
        </p>
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="form_1" action="member-entry.php" method="post"  return false>
                <div class="result" style="color:red;font-weight:bold;"></div>

                <div id="info"></div>
                <div class="form-group">
                <input type="hidden" class="form-control" name="process" id="process" value="@login">
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">お名前を入力してください。</label>
                  <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="form-group">
                  <label for="message-text" class="col-form-label">暗証番号を入力してください。（４桁の数字）</label>
                  <input type="text" class="form-control" name="password" id="password">
                </div>
                <div class="form-group">
                <p><button type="button" class="btn btn-primary" name="entry" id="btn_entry">登録</button>
                <button type="button" class="btn btn-secondary btn-sm" id="btn_cancel" data-dismiss="modal">取消</button></p>
                </div>
              </form>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--◆◆◆ ナビゲーションの表示 -->
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-10">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#">マイページ</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item active">
                <a class="nav-link" href="#">事業所について<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">ご連絡</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#">ヘルプ</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  関連サイト
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">ツイッター</a>
                  <a class="dropdown-item" href="#">公式LINE</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">注意書き</a>
                </div>
              </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
          </div>
        </nav>
      </div>
      <div class="col-sm-1">
      </div>
    </div>

    <!--◆◆◆ モーダルの表示 -->
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-10">
        <div class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Modal body text goes here.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-1">
      </div>
    </div>

    <!--◆◆◆ タブウインドウの表示 -->
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-10">
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">「本日の学び」</a></li>
            <li><a href="#tabs-2">「自己紹介」</a></li>
            <li><a href="#tabs-3">「質問・回答」</a></li>
          </ul>
          <div id="tabs-1">
            <div class="row">
              <div class="col-sm-12">
                <?php create_table_members(); ?>
              </div>
            </div>
          </div>
          <div id="tabs-2">
            <p><span style="color:tomato">T.B.D.(工事中)</span>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
          </div>
          <div id="tabs-3">
            <p><span style="color:tomato">T.B.D.(工事中)</span>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
            <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-1">
    </div>
  </div>

    <!--◆◆◆ フォームの表示 -->
    <!--
    <form>
      <div class="form-group">
        <label for="exampleFormControlInput1">Email address</label>
        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect1">Example select</label>
        <select class="form-control" id="exampleFormControlSelect1">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect2">Example multiple select</label>
        <select multiple class="form-control" id="exampleFormControlSelect2">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Example textarea</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
    </form>
  -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- CDN にて読み込み-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- <script src="jquery-ui/jquery-ui.js"></script> -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!--
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <script>
    $('#exampleModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      if (recipient == "@login"){
        modal.find('.modal-title').text('ログイン')
        modal.find('#btn_entry').text('ログイン');
      }
      else if (recipient == "@logout"){
        modal.find('.modal-title').text('ログアウト')
        modal.find('#btn_entry').text('ログアウト');
      }
      else {
        console.log(recipient);
        modal.find('.modal-title').text('新規登録')
        modal.find('#btn_entry').text('登録');
      }
      //modal.find('.modal-title').text('New message to ' + recipient)
      modal.find('#process').val(recipient);
    })
  </script>

  <script type="text/javascript">
    function replaceAll( strBuffer , strBefore , strAfter ){
      return strBuffer.split(strBefore).join(strAfter);
    }
    var id,name;
      $(function(){
          // Ajax button click
          $('#btn_entry').on('click',function(){
            if ($('#btn_entry').text()=="ログアウト") {

              document.cookie = 'id="' + id + '"; ' + 'max-age=' + '0' + ';';
              document.cookie = 'name="' + name + '"; ' + 'max-age=' + '0' + ';';

              $('#disp_id').text("");
              $('#disp_name').text("ゲスト");
              $('#btn_login').text("ログイン");
              $('#btn_login').data('whatever', "@login");
              //$('#menu_diary').disabled = true;
              //var target = document.getElementById("menu_diary");
              //target.href = '#';
              $('#exampleModal').modal('hide');

              return;
            }
            else if ($('#btn_entry').text()=="ログイン"　|| $('#btn_entry').text()=="登録") {
              $.ajax({
                url:'./member-entry.php',
                type:'POST',
                data:{
                  'process':$('#process').val(),
                  'name':$('#name').val(),
                  'password':$('#password').val()
                }
              })
              // Ajaxリクエストが成功した時発動
              .done( (data) => {
//                console.log(data);
                if ( data.indexOf("お名前か暗証番号が間違っています") != -1 ||
                  data.indexOf('その名前は既に登録されています') != -1 ||
                  data.indexOf('お名前の登録に失敗しました') != -1
                ) {
                  $('.result').html(data);
                }
                else{
                  var result = data.split('<AND>');
                  id = replaceAll( result[0].trim() , "\"" , "" );
                  name = replaceAll( result[1].trim() , "\"" , "" );
                  $('#disp_id').text(id);
                  $('#disp_name').text(name);
                  $('#btn_login').text("ログアウト");
                  $('#btn_login').data('whatever', "@logout");
                  //$('#menu_diary').disabled = false;
                  //var target = document.getElementById("menu_diary");
                  //target.href = 'diary_list.php?member_id=' + id + '&member_name=' + name;
                  console.log("ログイン処理：COOKIEが存在するか？＝"+document.cookie.indexOf('name'));
                  document.cookie = 'id=' + id + '; ' + 'max-age=' + "max-age=" + 60*60*24 + ';';
                  document.cookie = 'name=' + name + '; ' + 'max-age=' + "max-age=" + 60*60*24 + ';';
                  $('#exampleModal').modal('hide');
                }
              })
            // Ajaxリクエストが失敗した時発動
            .fail( (data) => {
              $('.result').html(data);
              console.log(data);
            })
            // Ajaxリクエストが成功・失敗どちらでも発動
            .always( (data) => {

            });
          }
        });
      });

  </script>
  <script>
    var result = document.cookie.indexOf('name');
    if(result !== -1) {
      var r = document.cookie.split(';');
			console.log('存在します。ログアウトします．．．');
      r.forEach(function(value) {
        //cookie名と値に分ける
        var content = value.split('=');
        if (content[0] == "id") {
          console.log( content[1] );
          $('#disp_id').text(content[1]);
        }
        if (content[0].indexOf('name')>=0) {
          console.log( content[1] );
          $('#disp_name').text(content[1] );
        }
      })
      $('#btn_login').text("ログアウト");
      $('#btn_login').data('whatever', "@logout");
      //$('#menu_diary').disabled = false;
      //var target = document.getElementById("menu_diary");
      //target.href = 'diary_list.php?member_id=' + $('#disp_id').text() + '&member_name=' + $('#disp_name').text();
      //console.log(document.cookie.indexOf(target.href));
    }
    else {
      $member_id = "";
      $member_name = "";
      console.log('存在しません！');
    }
  </script>

  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>


  <!-- 日記入力　Modal -->
  <div class="modal fade" id="ModalDone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe2" aria-hidden="true">
    <div class="modal-dialog　modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">本日の学び</h5>
          <span id="disp_id_m" invisible></span>
          <span id="disp_name_m" invisible></span>
          <button type="button" id="btn_close_m" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10">
              <form method="post">
                <div class="form-group">
                  <label for="display-date">● 登録した日時、または前回保存した日時</label>
                  <input type="text" name="date" class="form-control" id="display-date" placeholder="<?=$updated_at?>" disabled value=<?=$updated_at?> >
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput0">● 本日の課題内容</label>
                  <input type="text" name="subject1" id="subject1" class="form-control" <?=($badge=="既存")?"disabled":""?> id="exampleFormControlInput0" placeholder="作業や読んだ本の名前など．．．" value="<?=isset($rec['subject1'])?h($rec['subject1']):''?>">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea0">● 本日の課題で難しかったこと、できたこと</label>
                  <textarea class="form-control" name="subject2" <?=($badge=="既存")?"disabled":""?> id="subject2" rows="3" value="<?=isset($rec['subject2'])?h($rec['subject2']):''?>"><?=isset($rec['subject2'])?h($rec['subject2']):''?></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea0">● 気づいたこと、感じたこと</label>
                  <textarea class="form-control" name="subject3" <?=($badge=="既存")?"disabled":""?> id="subject3" rows="3" value="<?=isset($rec['subject3'])?h($rec['subject3']):''?>"><?=isset($rec['subject3'])?h($rec['subject3']):''?></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">● そう感じた自分ついて言えること</label>
                  <textarea class="form-control" name="subject4" <?=($badge=="既存")?"disabled":""?> id="subject4" rows="3" value="<?=isset($rec['subject4'])?h($rec['subject4']):''?>"><?=isset($rec['subject4'])?h($rec['subject4']):''?></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">● スタッフへの連絡</label>
                  <select class="form-control" name="subject5" <?=($badge=="既存")?"disabled":""?> id="subject5">
                    <option value="相談したい" <?=isset($rec)?is_selected($rec['subject5'],"相談したい"):''?>>相談したい</option>
                    <option value="つぎの課題が欲しい" <?=isset($rec)?is_selected($rec['subject5'],"つぎの課題が欲しい"):''?>>つぎの課題が欲しい</option>
                    <option value="やったことを報告したい" <?=isset($rec)?is_selected($rec['subject5'],"やったことを報告したい"):''?>>やったことを報告したい</option>
                    <option value="やり方を相談したい" <?=isset($rec)?is_selected($rec['subject5'],"やり方を相談したい"):''?>>やり方を相談したい</option>
                    <option value="その他" <?=isset($rec)?is_selected($rec['subject5'],"その他"):''?>>その他</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect2">● やりたいこと</label>
                  <select multiple class="form-control" name="subject6" <?=($badge=="既存")?"disabled":""?> id="subject6">
                    <option value="本" <?=isset($rec)?is_selected($rec['subject6'],"本"):''?>>本</option>
                    <option value="ビデオ" <?=isset($rec)?is_selected($rec['subject6'],"ビデオ"):''?>>ビデオ</option>
                    <option value="テレビ" <?=isset($rec)?is_selected($rec['subject6'],"テレビ"):''?>>テレビ</option>
                    <option value="ラジオ" <?=isset($rec)?is_selected($rec['subject6'],"ラジオ"):''?>>ラジオ</option>
                    <option value="インターネット" <?=isset($rec)?is_selected($rec['subject6'],"インターネット"):''?>>インターネット</option>
                  </select>
                </div>
                <div class="form-group">
                  <input type="hidden" name="subject7" id="subject7" value="<?=$badge?>">
                  <input type="hidden" name="code" id="code" value="<?=(isset($rec)?h($rec['code']):$code)?>">
                  <input type="hidden" name="member_id" id="member_id" value="<?=(isset($rec)?h($rec['member_id']):$member_id)?>">
                  <input type="hidden" name="member_name" id="member_name" value="<?=(isset($rec)?h($rec['member_name']):$member_name)?>">
                </div>
                <div class="form-group">
                  <p>
                    <button type="submit" class="btn btn-primary" name="entry" id="btn_entry_m"><?=($badge=="既存"||$badge=="修正中")?"修正する":"保存する"?> </button>
                    <button type="submit" class="btn btn-secondary btn-sm" id="btn_cancel_m">戻る</button>
                  </p>
                </div>
              </form>
            </div>
            <div class="col-sm-1">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function replaceAll( strBuffer , strBefore , strAfter ){
      return strBuffer.split(strBefore).join(strAfter);
    }
    var id,name;
      $(function(){
          // Ajax button click
          $('#btn_entry').on('click',function(){
            if ($('#btn_entry').text()=="ログアウト") {

              document.cookie = 'id="' + id + '"; ' + 'max-age=' + '0' + ';';
              document.cookie = 'name="' + name + '"; ' + 'max-age=' + '0' + ';';

              $('#disp_id').text("");
              $('#disp_name').text("ゲスト");
              $('#btn_login').text("ログイン");
              $('#btn_login').data('whatever', "@login");
              //$('#menu_diary').disabled = true;
              //var target = document.getElementById("menu_diary");
              //target.href = '#';
              $('#exampleModal').modal('hide');

              return;
            }
            else if ($('#btn_entry').text()=="ログイン"　|| $('#btn_entry').text()=="登録") {
              $.ajax({
                url:'./member-entry.php',
                type:'POST',
                data:{
                  'process':$('#process').val(),
                  'name':$('#name').val(),
                  'password':$('#password').val()
                }
              })
              // Ajaxリクエストが成功した時発動
              .done( (data) => {
//                console.log(data);
                if ( data.indexOf("お名前か暗証番号が間違っています") != -1 ||
                  data.indexOf('その名前は既に登録されています') != -1 ||
                  data.indexOf('お名前の登録に失敗しました') != -1
                ) {
                  $('.result').html(data);
                }
                else{
                  var result = data.split('<AND>');
                  id = replaceAll( result[0].trim() , "\"" , "" );
                  name = replaceAll( result[1].trim() , "\"" , "" );
                  $('#disp_id').text(id);
                  $('#disp_name').text(name);
                  $('#btn_login').text("ログアウト");
                  $('#btn_login').data('whatever', "@logout");
                  //$('#menu_diary').disabled = false;
                  //var target = document.getElementById("menu_diary");
                  //target.href = 'diary_list.php?member_id=' + id + '&member_name=' + name;
                  console.log(document.cookie.indexOf('name'));
                  document.cookie = 'id=' + id + '; ' + 'max-age=' + "max-age=" + 60*60*24 + ';';
                  document.cookie = 'name=' + name + '; ' + 'max-age=' + "max-age=" + 60*60*24 + ';';
                  $('#exampleModal').modal('hide');
									location.reload();
                }
              })
            // Ajaxリクエストが失敗した時発動
            .fail( (data) => {
              $('.result').html(data);
              console.log(data);
            })
            // Ajaxリクエストが成功・失敗どちらでも発動
            .always( (data) => {

            });
          }
        });
      });

  </script>
  <script>
  function disp_modal(item_id) {
		$("#code").val(item_id);
    $("#disp_id_m").val(item_id);
    $("#ModalDone").modal("show");
  }

  $(function(){
    $('#btn_close_m').on('click',function(){
      console.log("CLOSE");
      $('#ModalDone').modal('hide');
    })
  });
  $(function(){
    $('#btn_cancel_m').on('click',function(){
      console.log("CANCEL");
      $('#ModalDone').modal('hide');
    })
  });

  $(function(){
    $('#btn_entry_m').on('click',function(){
			//alert("code=["+$('#code').val() + "]\n");
			//alert("subject5=["+$('#subject5').val() + "]\n");
			//alert("subject6=["+$('#subject6').val() + "]\n");
      $.ajax({
        url:'./update-diary.php',
        type:'POST',
        data:{
          'code': $('#code').val(),
          'member_id': $('#disp_id_m').val(),
          'member_name':$('#disp_name_m').val(),
          'subject1':$('#subject1').val(),
          'subject2':$('#subject2').val(),
          'subject3':$('#subject3').val(),
          'subject4':$('#subject4').val(),
          'subject5':$('#subject5').val(),
          'subject6':$('#subject6').val(),
          'subject7':$('#subject7').val(),
          'updated_at':$('#display-date').val()
        }
      })
      // Ajaxリクエストが成功した時発動
      .done( (data) => {
        console.log("done["+data+"]");
				//alert("subject6=["+$('#subject6').val() + "]\n");
        $('#ModalDone').modal('hide');
      })
      // Ajaxリクエストが失敗した時発動
      .fail( (data) => {
				console.log("fail["+data+"]");
				//alert("subject6=["+$('#subject6').val() + "]\n");
        $('.result').html(data);
      })
      // Ajaxリクエストが成功・失敗どちらでも発動
      .always( (data) => {
				console.log("always["+data+"]");
				//alert("subject6=["+$('#subject6').val() + "]\n");

      });

      $('#ModalDone').modal('hide');

    })
  });

  $('#ModalDone').on('show.bs.modal', function (event) {
    console.log("[["+$('#disp_id_m').val()+"]]");
    $.ajax({
      url:'./read-diary.php',
      type:'POST',
      data:{
        'code':$('#code').val()
      }
    })
    // Ajaxリクエストが成功した時発動
    .done( (data) => {
      console.log("["+data+"]");
      console.log($('#code').val());
      var result = data.split('<AND>');
      $('#code').val(replaceAll( result[0].trim() , "\"" , "" ));
      $('#disp_id_m').val(replaceAll( result[1].trim() , "\"" , "" ));
      $('#disp_name_m').val(replaceAll( result[2].trim() , "\"" , "" ));
      $('#subject1').val(result[3].trim());
      $('#subject2').val(result[4].trim());
      $('#subject3').val(result[5].trim());
      $('#subject4').val(result[6].trim());
      $('#subject5').val(result[7].trim());
      $('#subject6').val(result[8].trim());
      $('#subject7').val(result[9].trim());
      $('#display-date').val(result[10].trim());
    })
    // Ajaxリクエストが失敗した時発動
    .fail( (data) => {
      $('.result').html(data);
      console.log(data);
    })
    // Ajaxリクエストが成功・失敗どちらでも発動
    .always( (data) => {

    });
  })
</script>
<!-- Modal　ここまで -->

</body>

</html>
