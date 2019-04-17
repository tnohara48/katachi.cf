<!doctype html>
<html lang="ja">

<?php
// 日記入力ダイアログ読み込み
//$bodytag = file_get_contents("ModalDialogBoxDiary.php");
//print $bodytag;


require_once('./common/common.php');

$code         = '';
$member_id    = '0';
$member_name    = '';
$is_staff            =    '';
$badge = "新規";
$updated_at = date("Y-m-d H:i:s");

// クッキーの状態チェック（ログイン状態）
if (isset($_COOKIE["id"]) && !empty($_COOKIE["id"])) {
    $member_id = $_COOKIE["id"];    // ログイン中
}
if (isset($_COOKIE["name"]) && !empty($_COOKIE["name"])) {
    //print($_COOKIE["name"]);
    $member_name = $_COOKIE["name"];    // ログイン中
}
if (isset($_COOKIE['is_staff']) && !empty($_COOKIE['is_staff'])) {
    $is_staff = ($_COOKIE['is_staff'] == "一般利用者")? '一般利用者': 'スタッフ';    // ログイン中
}

// 質問ダイアログ読み込み
/*
$bodytag = file_get_contents("ModalDialogBoxQA.php");
print $bodytag;
*/

function create_table_members($code, $member_id, $member_name)
{
    try {
        $dsn        =        'mysql:dbname=membersapp;host=localhost;charset=utf8';
        $user       =   get_userid();
        $password   =   get_password();
        $dbh=new PDO($dsn, $user, $password);

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql='SELECT * FROM diary_members WHERE member_id=?';
        $stmt=$dbh->prepare($sql);
        $data[] = $member_id;
        $stmt->execute($data);

        $dbh=null;

        if ($member_id == 0 || $member_name == "") {
            // 検索対象のユーザーIDまたはユーザーネームが指定されていない
            print('<div><p style="color:tomato">ログインしてください。</p></div>');
            return;
        }

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
        while (true) {
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec==false) {
                break;
            }
            $code = $rec['code'];
            print '<tr onclick="disp_modal(\'' . $code . '\',\'' . $member_id . '\',\'' . $member_name . '\')";>';
            print '<th scope="row">' . h($rec['code']) . '</th>';
            print '<td>' . h($rec['member_name']) . '</td>';
            print '<td>' . h($rec['subject1']) . '</td>';
            print '<td>' . h($rec['subject2']) . '</td>';
            print '<td>' . h($rec['subject5']) . '</td>';
            print '<td>' . h($rec['created_at']) . '</td>';
            print '</tr>';
        }
        print '<tr onclick="disp_modal(\'' . '' . '\',\'' . $member_id . '\',\'' . $member_name . '\')";>';
        print '<th scope="row">' . "" . '</th>';
        print '<td>' . "" . '</td>';
        print '<td>' . "" . '</td>';
        print '<td><b>' . "新規投稿" . '</b></td>';
        print '<td>' . "" . '</td>';
        print '<td>' . ""  . '</td>';
        print '</tr>';

        print '</tbody></table>';
    }    // end of try
    catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。<br />';
        exit();
    }
}


function create_tab_qa($code, $member_id, $member_name)
{
    try {
        //		$member_id = "";
        //		$member_name = "";
        /*
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
*/
        if ($member_id == "") {
            print('<div><p style="color:tomato">ログインしてください。</p></div>');
            return;
        }
        if ($member_name == "") {
            print('<div><p style="color:tomato">ログインしてください。</p></div>');
            return;
        }


        $dsn='mysql:dbname=membersapp;host=localhost;charset=utf8';
        $user            =    get_userid();
        $password    =    get_password();
        $dbh=new PDO($dsn, $user, $password);

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql='SELECT * FROM qa_history WHERE member_id_qa=?';
        $stmt=$dbh->prepare($sql);
        $data[] = $member_id;
        $stmt->execute($data);

        $dbh=null;

        print '質問詳細を見るには各行をクリックしてください。<br>'/* . "code=$code" . " member_id=$member_id" . " member_name=$member_name"*/;

        print '<table class="table table-hover">';
        print '<thead>
			<thead class="thead-light">
		    <tr>
		              <th scope="col">番号</th>
					<th scope="col">題名</th>
					     <th scope="col">質問日時</th>
		      <th scope="col">質問</th>
					<th scope="col">回答日時</th>
		      <th scope="col">回答</th>
		    </tr>
		  </thead>
		  <tbody>';
        while (true) {
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec==false) {
                break;
            }
            //print '<tr onclick="window.location=\'diary.php?code=' . h($rec['code']) . '&member_id=' . h($rec['member_id']) . '&member_name=' . h($rec['member_name']) . '\'";>';
            $code = $rec['code_qa'];

            print '<tr onclick="disp_modal_qa(\'' . $code . '\',\'' .    $member_id . '\',\'' . $member_name . '\')";>';

            //print '<tr onclick="disp_modal_qa(' . $rec['code'] . ',' . $member_id . ',\'' . $member_name . '\')";>';
            print '<th scope="row">' . h($rec['code_qa']) . '</th>';
            print '<td>' . h($rec['title']) . '</td>';
            print '<td>' . h($rec['date_time_q']) . '</td>';
            print '<td>' . h(mb_substr($rec['question'], 0, 15)) . '</td>';
            print '<td>' . h($rec['date_time_a']) . '</td>';
            print '<td>' . h(mb_substr($rec['answer'], 0, 15)) . '</td>';
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
        print '<td>' . ""  . '</td>';
        print '</tr>';
        print '</tbody></table>';

        return;
    }    // end of try
    catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。<br />';
        exit();
    }
}




?>

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
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />


  <link type="text/css" rel="stylesheet"
    href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
  <script type="text/javascript"
    src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript"
    src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
  <script type="text/javascript">
  $(function() {
    $('#tabs').tabs({ heightStyle: 'content' });
  });
  </script>

  <!--AJAX 読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!--	<link rel="stylesheet" href="css/styles.css">-->
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-1">
        　
      </div>
      <div class="col-sm-10">
      </div>
      <div class="col-sm-1">
      </div>
    </div>
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-10">
        <p>
          <small>就労移行支援事業所 未来のかたち</small>
        </p>
        <p style="margin-left:30px">
          <h5 style="color:orange;font-family:'メイリオ';font-weight: bold;">　<b>「本日の学び」- 電子版</b></h5>
        </p>
      </div>
      <div class="col-sm-1">
      </div>
    </div>
    <div class="row">
      <div class="col-sm-1">
        　
      </div>
      <div class="col-sm-10">
      </div>
      <div class="col-sm-1">
      </div>
    </div>

    <!--◆◆◆ ログインボタン表示-->
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-4" style="text-align:left">
        <p style="padding-left:10px">ようこそ、<span id="disp_name">ゲスト</span> 様
					<?php if (isset($_COOKIE['id']) && is_string($_COOKIE['id']) && $_COOKIE['id'] != "") {
    ?>
						<small id="disp_id_span"> (ユーザー番号:<span id="disp_id"></span>)</small></p>
						<?php
} else {
        ?>

					<?php
    }
                    ?>

      </div>
      <div class="col-sm-6" style="text-align:right">
        <p>
          <button type="button" class="btn-xs btn-primary" id="btn_login" data-toggle="modal" data-target="#loginModal" data-whatever="@login">ログイン</button>
        </p>
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
            <a class="navbar-brand" href="#"><h5>マイページ</h5></a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item active">
                <a class="nav-link" href="http://miraino-katachi.co.jp/free/about">事業所について</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="http://miraino-katachi.co.jp/contact">ご連絡</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="nopage.html">ヘルプ</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  関連サイト
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="https://line.me/ja/">公式LINE</a>
                  <a class="dropdown-item" href="https://twitter.com/">ツイッター</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="nopage.html">ご注意</a>
                </div>
              </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
          </div>
        </nav>
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
          <ul  class="nav nav-tabs center">
            <li><a href="#tabs-1" data-toggle="tab">「本日の学び」</a></li>
            <li><a href="#tabs-2" data-toggle="tab">「自己紹介」</a></li>
            <li><a href="#tabs-3" data-toggle="tab">「質問・回答」</a></li>
            <li><a href="#tabs-4" data-toggle="tab">「スタッフ用」</a></li>
          </ul>
          <div id="tabs-1">

						<?php if (isset($_COOKIE['is_staff']) && is_string($_COOKIE['is_staff']) && $_COOKIE['is_staff'] != "一般利用者") {
                        ?>
						<?php /*print ("tabs-1=".$member_id);return;*/?>
						<div class="row">
							<div class="col-sm-10"  style="background-color:yellow;padding:6px;margin:10px;">
							<span>検索する利用者を指定してください。(スタッフ専用)　<input type="text" name="search_name" id="search_name" width"30"></span>
							<!--<button type="button" class="btn btn-success" id="btn_srch" data-toggle="modal" data-target="#srchModal" data-whatever="@search_name">ログイン</button>-->
							<button class="btn btn-primary" id="btn_search" >検索</button>
							</div>
							<div class="col-sm-1">
				      </div>
							<div class="col-sm-1">
				      </div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div id="result_diary_table"></div>
							</div>
						</div>
						<?php
                    } else {
                        ?>
						<div class="row">
							<div class="col-sm-12">

								<script>
								/*
									var str = document.cookie;
									var st = str.indexOf('name');
									console.log("st = ["+st+"]");
									console.log(str.slice(st+5));
									str = str.slice(st+5);
									ed = str.indexOf(';');
									console.log("ed = ["+ed+"]");
									str = str.substring(0, ed);
									console.log(str);
									$.ajax({
										url:'./create-diary-list.php',
										type:'POST',
										data:{
											'member_name':str
										}
									})
									// Ajaxリクエストが成功した時発動
									.done( (data) => {
										alert(data);
											$('#result_diary_table').html(data);
											return;
									})
									// Ajaxリクエストが失敗した時発動
									.fail( (data) => {
										$('#result_diary_table').html(data);
										console.log(data);
									})
									// Ajaxリクエストが成功・失敗どちらでも発動
									.always( (data) => {
//										$('#result_diary_table').html(data);

									});
									*/
								</script>

								<?php
                                    create_table_members($code, $member_id, $member_name); ?>
							</div>
						</div>

						<?php
                    }
                        ?>
          </div>
          <div id="tabs-2">
            <p><span style="color:tomato">Sorry, this page is under constraction.(工事中)</span>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
          </div>
          <div id="tabs-3"  class="active">
            <div id="result_qa_table"></div>

						<?php
            /*
                            if (isset($_COOKIE["id"]) && !empty($_COOKIE["id"])) {
                                $member_id = $_COOKIE["id"];
                            }
                            if (isset($_COOKIE["name"]) && !empty($_COOKIE["name"])) {
                                $member_name = $_COOKIE["name"];
                            }

                            create_tab_qa($code, $member_id, $member_name);
              */
                        ?>
<!--
						  <div class="container">
								<div class="row">
									<div class="col-sm-8 control-label">
										<p><h4>質問をします。</h4></p>
									</div>
									<div class="col-sm-4">
									</div>
								</div>
					      <div class="row">
					        <div class="col-sm-9">
					          <form method="post" action="mail.php" class="form-horizontal">
					            <div class="form-group">
					              <label for="input-name" class="col-sm-4 control-label">お名前</label>
					              <div class="col-sm-8">
					                <input name="お名前" type="text" class="form-control " id="input-name" placeholder="お名前" required="required">
					              </div>
					            </div>
					            <div class="form-group">
					              <label for="input-mail" class="col-sm-4 control-label">メールアドレス</label>
					              <div class="col-sm-8">
					                <input name="Email" type="email" class="form-control" id="input-mail" placeholder="メールアドレス" required="required">
					              </div>
					            </div>
					            <div class="form-group">
					              <label class="col-sm-4 control-label">ご用件</label>
					              <div class="col-sm-8">
					                <select name="ご用件" class="form-control">
					                  <option value="">選択してください</option>
					                  <option value="ご質問・お問い合わせ">ご質問・お問い合わせ</option>
					                  <option value="ご意見・ご感想">ご意見・ご感想</option>
					                </select>
					              </div>
					            </div>
					            <div class="form-group">
					              <label class="col-sm-4 control-label">お問い合わせ内容</label>
					              <div class="col-sm-8">
					                <textarea name="お問い合わせ内容" class="form-control" rows="5" required="required"></textarea>
					              </div>
					            </div>
					            <div class="form-group">
					              <div class="col-sm-offset-2 col-sm-10">
					                <button type="submit" class="btn btn-default">送信</button>
					              </div>
					            </div>
					          </form>
					        </div>
					      </div>
					    </div>
						-->
						<!-- /container -->
						<!--
					  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
					  <script src="bootstrap/js/bootstrap.min.js"></script>
					-->
					</div>
          <div id="tabs-4">
            <p><span style="color:tomato">Sorry, this page is under constraction.(工事中)</span>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
            <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
          </div>
        </div>
      </div>
			<div class="col-sm-1">
			</div>
    </div>
    <div class="row">
      <div class="col-sm-1">
			</div>
      <div class="col-sm-10 text-right" >
        <br>
        <small>んぱんぱ.しーえふ</small>&copy;
			</div>
      <div class="col-sm-1">
			</div>
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

    <!-- 日記入力　Modal -->
    <div class="modal fade" id="ModalDialogBoxDiary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe2" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabe2">本日の学び</h5>
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
                    <input type="text" name="date" class="form-control" id="display-date" placeholder="<?=$updated_at?>" disabled value="<?=$updated_at?>" >
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
                      <option value="相談したい" <?=isset($rec)?is_selected($rec['subject5'], "相談したい"):''?>>相談したい</option>
                      <option value="つぎの課題が欲しい" <?=isset($rec)?is_selected($rec['subject5'], "つぎの課題が欲しい"):''?>>つぎの課題が欲しい</option>
                      <option value="やったことを報告したい" <?=isset($rec)?is_selected($rec['subject5'], "やったことを報告したい"):''?>>やったことを報告したい</option>
                      <option value="やり方を相談したい" <?=isset($rec)?is_selected($rec['subject5'], "やり方を相談したい"):''?>>やり方を相談したい</option>
                      <option value="その他" <?=isset($rec)?is_selected($rec['subject5'], "その他"):''?>>その他</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect2">● やりたいこと</label>
                    <select multiple class="form-control" name="subject6" <?=($badge=="既存")?"disabled":""?> id="subject6">
                      <option value="本" <?=isset($rec)?is_selected($rec['subject6'], "本"):''?>>本</option>
                      <option value="ビデオ" <?=isset($rec)?is_selected($rec['subject6'], "ビデオ"):''?>>ビデオ</option>
                      <option value="テレビ" <?=isset($rec)?is_selected($rec['subject6'], "テレビ"):''?>>テレビ</option>
                      <option value="ラジオ" <?=isset($rec)?is_selected($rec['subject6'], "ラジオ"):''?>>ラジオ</option>
                      <option value="インターネット" <?=isset($rec)?is_selected($rec['subject6'], "インターネット"):''?>>インターネット</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="hidden" name="subject7" id="subject7" value="<?=$badge?>">
                    <input type="hidden" name="code_m" id="code_m" value="<?=(isset($rec)?h($rec['code']):$code)?>">
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
  <!--
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
          </div>
  -->
        </div>
      </div>
    </div>

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


<!--「本日の学び」一覧テーブル出力-->
<script type="text/javascript">

  $(function(){
      // Ajax button click
      $('#btn_search').on('click',function(){
          $.ajax({
            url:'./create-diary-list.php',
            type:'POST',
            data:{
              'member_name':$('#search_name').val()
            }
          })
          // Ajaxリクエストが成功した時発動
          .done( (data) => {
              $('#result_diary_table').html(data);
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
    });
</script>

<!--タブ切り替え出力-->
<script>
  $( function() {
		//alert("taabs");
    $( "#tabs" ).tabs();

		$("#modalSeach").modal("show");

  } );
</script>


<script>

		function disp_modal_qa(code,member_id,member_name) {
			$('#code_qa').val(code);
			$('#member_id_qa').val(member_id);
			$('#member_name_qa').val(member_name);
			$('#ModalDialogBoxQA').modal("show");
		}

	  $('#ModalDialogBoxQA').on('show.bs.modal', function (event) {
	    // ボタンを取得
	    console.log("[["+$('#code_qa').val()+"]]");
//	    alert("member_id_qa={"+$('#member_id_qa').val()+"}");
	    $.ajax({
	      url:'./read-qa.php',
	      type:'POST',
	      data:{
					'code_qa':$('#code_qa').val(),
	        'member_id_qa':$('#member_id_qa').val(),
	        'member_name_qa':$('#member_name_qa').val()
	      }
	    })
	    // Ajaxリクエストが成功した時発動
	    .done( (data) => {
				console.log("["+data+"]");
				var result = data.split('<AND>');
				i = 0;
				while(result[i]!=null && result[i] != "") {
          if (result[i]!='member_id_qa' && result[i]!='member_name_qa') {
            $('#'+result[i]).val(replaceAll( result[i+1].trim() , "\"" , "" ));
          }
					i += 2;
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
	  })

    $('#ModalDialogBoxQA').on('hidden.bs.modal', function () {
      //alert($('#result_qa_table').html());
    })
	</script>

  <script>
  function disp_modal_search() {
    $("#modalSeach").modal("show");
  }

  function disp_modal(code,member_id,member_name) {
		$("#code_m").val(code);
		$("#disp_id_m").val(member_id,);
    $("#disp_name_m").val(member_name);
    $("#ModalDialogBoxDiary").modal("show");
  }

  $(function(){
    $('#btn_close_m').on('click',function(){
      console.log("CLOSE");
      $('#ModalDialogBoxDiary').modal('hide');
    })
  });
  $(function(){
    $('#btn_cancel_m').on('click',function(){
      console.log("CANCEL");
      $('#ModalDialogBoxDiary').modal('hide');
    })
  });

  $(function(){
    $('#btn_entry_m').on('click',function(){
			//alert("code_m=["+$('#code_m').val() + "]\n");
			//alert("disp_id_m=["+$('#disp_id_m').val() + "]\n");
			//alert("disp_name_m=["+$('#disp_name_m').val() + "]\n");
      $.ajax({
        url:'./update-diary.php',
        type:'POST',
        data:{
          'code': $('#code_m').val(),
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
        //alert("done["+data+"]");
				//alert("subject6=["+$('#subject6').val() + "]\n");
        $('#ModalDialogBoxDiary').modal('hide');
				location.reload();
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

      $('#ModalDialogBoxDiary').modal('hide');

    })
  });

  $('#ModalDialogBoxDiary').on('show.bs.modal', function (event) {
    console.log("[["+$('#disp_id_m').val()+"]]");
    $.ajax({
      url:'./read-diary.php',
      type:'POST',
      data:{
        'code':$('#code_m').val(),
        'member_id':$('#disp_id_m').val()
      }
    })
    // Ajaxリクエストが成功した時発動
    .done( (data) => {
      console.log("["+data+"]");
      console.log($('#code_m').val());
      var result = data.split('<AND>');
      $('#code_m').val(replaceAll( result[0].trim() , "\"" , "" ));
//      $('#disp_id_m').val(replaceAll( result[1].trim() , "\"" , "" ));
//      $('#disp_name_m').val(replaceAll( result[2].trim() , "\"" , "" ));
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

<script>
$(function() {
//  $('#nav-tabs a[href="#tabs-3"]').tab('show');
 });
</script>
<script>
$( "#tabs" ).on( "tabsactivate", function( event, ui ) {
//  alert('Hello '+$('#disp_id').val());

  $.ajax({
    url:'./update_qa_history.php',
    type:'POST',
    data:{
      'db':'membersapp',
      'tbl':'qa_history',
      'member_id_qa':$('#disp_id').val(),
      'member_name_qa':$('#disp_name').val(),
      'postdata':""
    }
  })
  // Ajaxリクエストが成功した時発動
  .done( (data) => {
      $('#result_qa_table').html(data);
  })
  // Ajaxリクエストが失敗した時発動
  .fail( (data) => {
    $('.result').html(data);
    console.log(data);
  })
  // Ajaxリクエストが成功・失敗どちらでも発動
  .always( (data) => {

  });

} );
$(function(){
//    alert('Hello '+$('#disp_id').val());
    $.ajax({
      url:'./update_qa_history.php',
      type:'POST',
      data:{
        'db':'membersapp',
        'tbl':'qa_history',
        'member_id':$('#disp_id').val(),
        'member_name':$('#disp_name').val(),
        'postdata':""
      }
    })
    // Ajaxリクエストが成功した時発動
    .done( (data) => {
        $('#result_qa_table').html(data);
    })
    // Ajaxリクエストが失敗した時発動
    .fail( (data) => {
      $('.result').html(data);
      console.log(data);
    })
    // Ajaxリクエストが成功・失敗どちらでも発動
    .always( (data) => {

    });
});
</script>

<?php
// ログインダイアログ読み込み
$bodytag = file_get_contents("loginModal.php");
print $bodytag;


?>

<!-- Modal　ここまで -->
</body>

</html>
