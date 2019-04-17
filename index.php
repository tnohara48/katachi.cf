<?php

require_once( './common/common.php' );

$code = '';
$login = 'NO';
$member_id = '不明';
$member_name = 'ゲスト';
$is_staff = '不明';
$badge = "新規";
$updated_at = date( "Y-m-d H:i:s" );

// 現在ログイン中？
function is_logined_now() {
  return ( isset( $_COOKIE[ "login" ] ) && !empty( $_COOKIE[ "login" ] ) && $_COOKIE[ "login" ] == "YES" );
}

// 現在ログインしているのはスタッフか？
function is_staff() {
  if ( is_logined_now() ) {
    return ( isset( $_COOKIE[ "is_staff" ] ) && !empty( $_COOKIE[ "is_staff" ] ) && $_COOKIE[ "is_staff" ] == 'スタッフ' );
  }
}

// クッキーの状態チェック（ログイン状態しているか？）
if ( is_logined_now() ) {
  $login = 'YES';
  if ( isset( $_COOKIE[ "member_id" ] ) && !empty( $_COOKIE[ "member_id" ] ) ) {
    $member_id = $_COOKIE[ "member_id" ]; // ログイン中
  }
  if ( isset( $_COOKIE[ "member_name" ] ) && !empty( $_COOKIE[ "member_name" ] ) ) {
    //print($_COOKIE["name"]);
    $member_name = $_COOKIE[ "member_name" ]; // ログイン中
  }
  if ( isset( $_COOKIE[ 'is_staff' ] ) && !empty( $_COOKIE[ 'is_staff' ] ) ) {
    $is_staff = ( $_COOKIE[ 'is_staff' ] == "一般利用者" ) ? '一般利用者' : 'スタッフ'; // ログイン中
  }
}
// 現在ログインしているメンバーＩＤを返す
function get_member_id() {
  if ( isset( $_COOKIE[ "member_id" ] ) && !empty( $_COOKIE[ "member_id" ] ) ) {
    return $_COOKIE[ "member_id" ];
  }
  return 0;
}
// 現在ログインしているメンバー名を返す
function get_member_name() {
  if ( isset( $_COOKIE[ "member_name" ] ) && !empty( $_COOKIE[ "member_name" ] ) ) {
    return $_COOKIE[ "member_name" ];
  }
  return '';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>らいとぽー</title>

  <link rel="shortcut icon" href="img/american-sign-language-interpreting-solid.png">

  <!-- Tabs Bootstrap4 -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

  <!-- デートピッカー -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">


  <!--<link rel="stylesheet" href="css/styles.css" >-->
  <link rel="stylesheet" href="css/katachi-style.css">


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

</head>

<body class=" text-secondary">
  <!-- 日記入力　Modal -->
  <?= file_get_contents("ModalDialogBoxDiary.php"); /*日記入力　Modalダイアログ読み込み*/ ?>

  <!-- 質問入力　Modal -->
  <?= file_get_contents("ModalDialogBoxQA.php");    /*質問ダイアログ読み込み*/ ?>

  <!-- ログイン情報入力　Modal -->
  <?= file_get_contents("loginModal.php");          /*ログインダイアログ読み込み*/  ?>

  <!-- 都道府県選択したら連動して市区郡が出てくるアレ -->
  <?php require_once( 'pref_city.php' );            /* 都道府県一覧データ */                             ?>
  <?= file_get_contents("select_pref_city.php");    /*都道府県選択したら連動して市区郡が出てくるアレ*/   ?>

  <div class="container ">
    <div class="row ">
      <div class="col-sm-1 ">
      </div>
      <div class="col-sm-10 ">
      </div>
      <div class="col-sm-1 ">
      </div>
    </div>
    <div class="row ">
      <div class="col-sm-1 ">
      </div>
      <div class="col-sm-10 ">
        <p class="h6 ml-2 mt-3 mb-3">
          <small><i class="fas fa-american-sign-language-interpreting"></i> 就労移行支援事業所 らいとぽー</small>
        </p>
        <p class="katachi_main_title align-middle">
          <span class="h3 ml-2 font-weight-bold">「本日の学び」</span><span class="h5">&lt;電子版&gt;</span>
        </p>
      </div>
      <div class="col-sm-1 "><br>
      </div>
    </div>
    <div class="row ">
      <div class="col-sm-1 ">
      </div>
      <div class="col-sm-10 ">
      </div>
      <div class="col-sm-1 ">
      </div>
    </div>

    <!--◆◆◆ ログインボタン表示-->
    <div class="row">
      <div class="col-sm-1 ">
      </div>

      <div class="col-sm-4 text-left align-bottom pl-4">
        ようこそ、
        <span>
          <?= $member_name ?>
        </span> 様
        <small> (<?= $member_id ?>)</small>
      </div>
      <div class="col-sm-6 text-right">
        <p class="h6  align-items-start">
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#loginModal" data-whatever="<?=( is_logined_now()) ? '@logout' : '@login'; ?>">
            <?= (is_logined_now()) ? "ログアウト" : "ログイン<small>/新規</small>"; ?>
          </button>
        
        </p>
      </div>
    </div>

    <!--◆◆◆ タブウインドウの表示 -->
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-10">
        <div id="tabs">
          <!--<ul class="nav nav-tabs center nav-fill second">-->
          <ul class="nav nav-tabs flex-column flex-sm-row">
            <li class="nav-item  border-white">
              <a href="#tab-top" class="flex-sm-fill nav-link text-secondary " data-toggle="tab"><i class="fas fa-home"></i> HOME</a>
            </li>
            <li class="nav-item border-white">
              <a href="#tab-diary" class="flex-sm-fill nav-link text-secondary" data-toggle="tab"><i class="fas fa-user-graduate"></i> 本日の学び</a>
            </li>
            <li class="nav-item border-white">
              <a href="#tab-qa" class="flex-sm-fill nav-link text-secondary" data-toggle="tab"><i class="fas fa-question"></i> 質問と回答</a>
            </li>
            <li class="nav-item border-white">
              <a href="#tab-proc" class="flex-sm-fill nav-link text-secondary" data-toggle="tab"><i class="fas fa-file"></i> 各種手続</a>
            </li>
            <li class="nav-item border-white">
              <a href="#tab-archive" class="flex-sm-fill nav-link text-secondary" data-toggle="tab"><i class="fas fa-archive"></i> 参考資料</a>
            </li>
            <li class="nav-item border-white">
              <a href="#tab-setting" class="flex-sm-fill nav-link text-secondary" data-toggle="tab"><i class="fas fa-cog"></i> 設定</a>
            </li>
            <li class="nav-item border-white">
              <a href="#tab-help" class="flex-sm-fill nav-link text-secondary" data-toggle="tab"><i class="fas fa-info-circle"></i> </a>
            </li>
            <li class="nav-item border-white">
              <a href="#tab-staff" class="flex-sm-fill nav-link text-secondary" data-toggle="tab" <?=is_staff() ? "" : "hidden" ?>><i class="fas fa-user-shield"></i> スタッフ用</a>
            </li>
          </ul>
          <script type="text/javascript">
            $( function () {
              $( "#tabs" ).tabs();
              if ( is_logined_now() ) {
                if ( $.cookie( "openTag" ) ) {
                  //一旦すべての active を外す
                  $( 'a[data-toggle="tab"]' ).removeClass( 'active' );
                  $( 'a[href="#' + $.cookie( "openTag" ) + '"]' ).addClass( 'active' );
                  $( 'a[href="#' + $.cookie( "openTag" ) + '"]' ).click();
                  $( 'a[href="#' + $.cookie( "openTag" ) + '"]' ).parent().click();
                }
                $( 'a[data-toggle="tab"]' ).on( 'shown.bs.tab', function ( e ) {
                  var tabName = e.target.href;
                  var items = tabName.split( "#" );
                  //クッキーに選択されたタブを記憶
                  $.cookie( "openTag", items[ 1 ], {
                    expires: 700
                  } );
                } );
              }
            } );
          </script>

          <div class="tab-content align-text-top">
            <div id="tab-top" class="tab-pane show fade" class="tab-pane p-4 border-left border-bottom border-right">
              <p>
                <div class="row">
                  <div class="col-sm-10 align-top">
                    <img src="img/newredhikari.gif" hight="4px" alt="new(.git from webworkkit(c) http://webworkkit.minibird.jp/sonota/icon/icon3.html)">ニュース<small>(2019.4.11)</small>
                  </div>
                  <div class="col-sm-2">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-10 align-top">
                    <div class="card">
                      <div class="card-body">
                        <p class="card-text">4月5日、近くの靭公園にお花見に行ってきました。</p>
                        <img class="card-img-top" src="img/20190405_121147_small.jpg" alt="靭公園の桜" width="width: 18rem;" height="auto">
                      </div>
                      
                    </div>
                  </div>
                  <div class="col-sm-2">
                  </div>
                </div>
              </p>
            </div>
            <div id="tab-diary" class="tab-pane fade show " class="tab-pane p-4 border-left border-bottom border-right">
              <div id="result_dialy_table"></div>
              <div class="row">
                <div class="col-sm-12">
                  <script>
                    draw_table_dialy();
                  </script>
                  <?php
                  //create_table_members( $code, $member_id, $member_name );
                  ?>
                </div>
              </div>
            </div>
            <div id="tab-qa" class="tab-pane">
              <div id="result_qa_table"></div>
              <div class="row">
                <div class="col-sm-12">
                  <script>
                    draw_table_qa();
                  </script>
                  <?php
                  //create_tab_qa( $code, $member_id, $member_name );
                  ?>
                </div>
              </div>
            </div>
            <div id="tab-setting" class="tab-pane fade show p-4">
              <p>
                <form name="form_settings">
                  <div class="form-group">
                    <label for="exampleInputPassword1">ニックネーム(任意)</label>
                    <div class="form-row align-items-center pl-1">
                      <input type="text" class="form-control-sm" id="nickname" placeholder="ニックネーム">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">お誕生日(任意)</label>
                    <div class="form-row align-items-center pl-1">
                      <div class="form-group row">
                        <div class="col-auto"><a id="birth_year"></a> </div>
                        <div class="col-auto"><a id="birth_month"></a> </div>
                        <div class="col-auto"><a id="birth_day"></a> </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">お住まい(任意)</label>
                    <div class="form-row align-items-center pl-1">
                      <div class="form-group row">
                        <div class="col-auto">
                          <select class="custom-select" name="s1" id="s1">
                            <?php
                            foreach ( $areas as $i => $area ) {
                              ?>
                            <option value="<?php echo $i;?>">
                              <?php echo $area; ?>
                            </option>
                            <?php 
                          } 
                          ?>
                          </select>
                        </div>
                        <div class="col-auto">
                          <select class="custom-select" name="s2" id="s2">
                            <option value="" selected>市区郡を選択</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group mt-3">
                    <label for="exampleInputPassword1">学習分野</label>
                    <div class="form-row align-items-center pl-1">
                      <div class="form-inline">
                        <label class="checkbox-inline"><input type="checkbox"> Java</label>
                        <label class="checkbox-inline"><input type="checkbox"> Web系(HTML,PHP,CSS,Javascript...)</label>
                        <label class="checkbox-inline"><input type="checkbox"> Python</label>
                        <label class="checkbox-inline"><input type="checkbox"> C言語</label>
                        <label class="checkbox-inline"><input type="checkbox"> デザイン(Web,印刷...)</label>
                        <label class="checkbox-inline"><input type="checkbox"> その他</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group mt-3">
                    <label for="exampleInputPassword1">目標とする職種</label>
                    <div class="form-row align-items-center pl-1">
                      <div class="form-inline">
                        <label class="checkbox-inline"><input type="checkbox"> プログラマー(正社員)</label>
                        <label class="checkbox-inline"><input type="checkbox"> プログラマー(契約/派遣)</label>
                        <label class="checkbox-inline"><input type="checkbox"> プログラマー(アルバイト/パート)</label>
                        <label class="checkbox-inline"><input type="checkbox"> プログラマー(フリー/自営)</label>
                        <label class="checkbox-inline"><input type="checkbox"> デザイナー</label>
                        <label class="checkbox-inline"><input type="checkbox"> 起業</label>
                        <label class="checkbox-inline"><input type="checkbox"> その他</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group mt-4">
                    <label for="exampleInputPassword1">パスワード(任意)</label>
                    <div class="form-row align-items-center pl-1">
                      <input type="password" class="form-control-sm" id="examplePassword" placeholder="パスワード">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">メールアドレス(任意)</label>
                    <div class="form-row align-items-center pl-1">
                      <input type="email" class="form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="メールアドレス">
                    </div>
                    <small id="emailHelp" class="form-text text-muted ml-1">当事業所内でのご連絡に用います。ほかの目的に使用することはございません。</small>
                  </div>
                  <div class="form-check">
<!--                    <div class="form-row align-items-center pl-3">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">確認しました</label>
                    </div>
-->
                  </div>
                  <div class="form-row align-items-center mt-4 pl-1">
                    <button type="submit" class="btn btn-primary">保存</button>
                  </div>
                </form>
              </p>
            </div>
            <div id="tab-resume" class="tab-pane p-4">
              <p>
                <!--<iframe src="https://hkbaom-my.sharepoint.com/personal/dt0823_my365_site/_layouts/15/Doc.aspx?sourcedoc={69b351ef-3a82-40f1-b152-d87a4b3a85a9}&amp;action=embedview&amp;wdStartOn=1" width="100%" height="1980px" frameborder="0"></iframe>-->
              </p>
            </div>
            <div id="tab-archive" class="tab-pane p-4">
              <p>
                <div class="div_title_small">アーカイブ・参考資料</div>
                <div>
                  <p class="pl-3"><i class="fas fa-film"></i> (ビデオ)Eclipseでコードをワンタッチで整形する方法</p>
                  <iframe  class="pl-3" max-width:100%; width="100%" height="400px" src="https://www.youtube-nocookie.com/embed/LmtHWs_LMbE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
              </p>
            </div>
            <div id="tab-help" class="tab-pane p-4">
              <p>
                <div class="div_title_small">ヘルプ</div>
                <div>
                  <p class="pl-3 mb-4">
                    最初にログインボタンでログインしてください。新規の方はお名前と暗証番号で登録できます。
                  </p>
                </div>
                <div class="div_title_small">このサイトについて</div>
                <div>
                  <p class="pl-3 mb-4">
                    このサイトは、「《プログラマー養成特化型》 就労移行支援事業所 らいとぽー」の 利用者様専用 コミュニケーションサイトです。
                  </p>
                </div>
                <div class="div_title_small">「《プログラマー養成特化型》 就労移行支援事業所 らいとぽー」について</div>
                <div>
                  <p class="pl-3 mb-4">
                    初級のプログラミング技術の習得をサポートすることにより、プログラマーをはじめとするIT関連職を育成し、各企業様への就労を支援する事業所です。<br>
                    <a data-toggle="collapse" href="#answer1" class="text-info">
                     就労移行支援事業所とは？
                    </a>
                    <div class="collapse p-3 ml-3 mr-3 bg-info" id="answer1">
                     一般企業への就職を望む６５歳未満の身体・知的・精神障害者らを対象に、職場探しや就職の準備を支援する。障害者総合支援法に基づき、自治体が指定する。利用料はかからないことが多く、期限は２年間。県内には１５カ所ある。(2019-01-28 朝日新聞 朝刊 香川全県・１地方)
                      <br>
                      <a href="https://works.litalico.jp/syuro_shien/" target="_blank">就労移行支援事業所</a>
                    </div>
                  </p>
                </div>
                <div>
                  <p class="p-4">
                    <img src="img/photo0000-1768.jpg" width="63%" height="auto" alt="大阪 中之島の夜景">
                  </p>
                </div>
              </p>
            </div>
            <div id="tab-proc" class="tab-pane p-4">
              <p>
                <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                      <a class="text-body" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fas fa-subway"></i> 交通費申請 
                      </a>
                    </div>
                    <!-- /.card-header -->
                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="card-body">
                        <div>
                          <form name="form_trafic_fee">
                            <div class="form-group">
                              <label for="exampleInputPassword1">自宅最寄駅：</label>
                              <div class="form-row align-items-center">
                                <input type="text" class="form-control-sm" id="trafic_fee_from_line" placeholder="例)JR京都">&nbsp;線
                                <input type="text" class="form-control-sm" id="trafic_fee_from_station" placeholder="例)京橋">&nbsp;駅
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">定期代：</label>
                              <div class="form-row align-items-center">
                                <input type="text" class="form-control-sm" id="trafic_fee_pass" placeholder="定期代"> 円
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">その他運賃（切符代）：</label>
                              <div class="form-row align-items-center">
                                <input type="text" class="form-control-sm" id="trafic_fee_others" placeholder="その他運賃（切符代"> 円
                              </div>
                            </div>
                            <div class="form-row align-items-center mt-4">
                              <button type="submit" class="btn btn-primary">申請する</button>
                            </div>
                          </form>
                        </div>
                        <div>
                          <small> ・利用する鉄道（バス）会社名や路線名・発着駅名、乗り換え駅名・所要時間・運賃（定期代）</small>
                        </div>
                      </div>
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                  <div class="card">
                    <div class="card-header" role="tab" id="headingTwo">
                      <a class="collapsed text-body" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-graduation-cap"></i> 受験補助申請 
                      </a>
                    
                    </div>
                    <!-- /.card-header -->
                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                      <div class="card-body">
                        <div>
                          <form name="form_settings">
                            <div class="form-group">
                              <label for="exampleInputPassword1">試験名/資格名：</label>
                              <div class="form-row align-items-center">
                                <input type="text" class="form-control-sm" id="exam_name" placeholder="例)オラクル認定JAVA試験">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">受験料：</label>
                              <div class="form-row align-items-center">
                                <input type="text" class="form-control-sm" id="exam_fee" placeholder="受験料"> 円
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">諸費用：</label>
                              <div class="form-row align-items-center">
                                <input type="text" class="form-control-sm" id="exam_fee_others" placeholder="諸費用"> 円
                              </div>
                            </div>
                            <div class="form-row align-items-center mt-4">
                              <button type="submit" class="btn btn-primary">申請する</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                  <div class="card">
                    <div class="card-header" role="tab" id="headingThree">
                      <a class="collapsed text-body" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseThree">
                        <i class="fas fa-book-open"></i> 書籍購入申請 
                      </a>
                    
                    </div>
                    <!-- /.card-header -->
                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                      <div class="card-body">
                        <div>
                          <form name="form_settings">
                            <div class="form-group">
                              <label for="exampleInputPassword1">希望する書籍名：</label>
                              <div class="form-row align-items-center">
                                <input type="text" class="form-control-sm" id="book_name" placeholder="例)３ステップJava">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">出版社/発行者：</label>
                              <div class="form-row align-items-center">
                                <input type="text" class="form-control-sm" id="book_company" placeholder="出版社/発行者"> 円
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">価格：</label>
                              <div class="form-row align-items-center">
                                <input type="text" class="form-control-sm" id="book_price" placeholder="価格"> 円
                              </div>
                            </div>
                            <div class="form-row align-items-center mt-4">
                              <button type="submit" class="btn btn-primary">申請する</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                  <div class="card">
                    <div class="card-header" role="tab" id="headingFive">
                      <a class="collapsed text-body" data-toggle="collapse" href="#collapseFive" role="button" aria-expanded="false" aria-controls="collapseFive">
                        <i class="fas fa-envelope-square"></i> 面談予約
                      </a>
                    </div>
                    <!-- /.card-header -->
                    <div id="collapseFive" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                      <div class="card-body">
                        <p>
                          <div class="row">
                            <div class="col-sm-12">
                              <p>
                                <table id="table-meeting">
                                  <thead>
                                    <tr>
                                      <th scope="col" colspan="7" style="border: 0">１．ご希望の日にちを選択してください。</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td scope="col" colspan="7" style="border: 0">2019年4月 </td>
                                    </tr>
                                    <tr>
                                      <th scope="col" style="color:red;background-color:#CCC;border-color:#FFF">日</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">月</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">火</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">水</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">木</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">金</th>
                                      <th scope="col" style="color:blue;background-color:#CCC;border-color:#FFF">土</th>
                                    </tr>
                                    <?php 
                                      //指定日の曜日を取得する
                                      $date = date('w', mktime(0, 0, 0, 4, 1, 2019));
                                      $last_day = date("t", mktime(0, 0, 0, 5, 2019));

                                      $reservation_date_meeting = 0;
                                      $temp = 1;
                                      for ($i=0; $i<5;++$i) {
                                        print '<tr>';
                                        for ($j=0; $j<7;++$j) {
                                          if ($i==0 && $j<$date) {
                                            print '<td id="td1'.$i.$j.'" style="background-color:#eee;border-color:#FFF"></td>';
                                            continue;
                                          }
                                          if ( $temp >= 1 && $temp <= $last_day ){
                                            print '<td id="td1'.$i.$j.'" onclick="register(this,' . $temp . ',4,2019)">'.$temp.'</td>';
                                          }
                                          else {
                                            print '<td id="td1'.$i.$j.'" style="background-color:#eee;border-color:#FFF"></td>';
                                          }
                                          $temp++;
                                       }
                                        print "</tr>";

                                      }
                                      ?>
                                    <tr>
                                      <td scope="col" colspan="7" style="border: 0">2019年5月 </td>
                                    </tr>
                                    <tr>
                                      <th scope="col" style="color:red;background-color:#CCC;border-color:#FFF">日</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">月</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">火</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">水</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">木</th>
                                      <th scope="col" style="background-color:#CCC;border-color:#FFF">金</th>
                                      <th scope="col" style="color:blue;background-color:#CCC;border-color:#FFF">土</th>
                                    </tr>
                                    <?php 
                                      //指定日の曜日を取得する
                                      $date = date('w', mktime(0, 0, 0, 5, 1, 2019));
                                      $last_day = date("t", mktime(0, 0, 0, 6, 2019));

                                      $reservation_date_meeting = 0;
                                      $temp = 1;
                                      for ($i=0; $i<5;++$i) {
                                        print '<tr>';
                                        for ($j=0; $j<7;++$j) {
                                          if ($i==0 && $j<$date) {
                                            print '<td id="td2'.$i.$j.'" style="background-color:#eee;border-color:#FFF"></td>';
                                            continue;
                                          }
                                          if ( $temp >= 1 && $temp <= $last_day ){
                                            print '<td id="td2'.$i.$j.'" onclick="register(this,' . $temp . ',5,2019)">'.$temp.'</td>';
                                          }
                                          else {
                                            print '<td id="td2'.$i.$j.'" style="background-color:#eee;border-color:#FFF"></td>';
                                          }
                                          $temp++;
                                       }
                                        print "</tr>";

                                      }
                                      ?>


                                  </tbody>
                                </table>

                              </p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-12">
                              <p>
                                <table id="table-meeting-hour">
                                  <thead>
                                    <tr>
                                      <th scope="col" colspan="7" style="border: 0">２．ご希望の時間を選択してください。</th>
                                    </tr>
                                    <tr>
                                      <td scope="col" style="border: 0">予約可能時間</td>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td style="background-color:#CCC;border-color:#CCC">
                                        <div id="reservation_date_meeting"></div>
                                      </td>
                                    </tr>
                                    <?php 
                                      $h = 600;
                                      for ($i=0; $i<10;++$i) {
                                        $str = "" . floor ($h/60) . ":" . ((($h%60)==0)?"00":"30");
                                        $str .= " -- ";
                                        $h += 30;
                                        $str .= "" . floor ($h/60) . ":" . ((($h%60)==0)?"00":"30");
                                        print '<tr>';
                                        print '<td id="td_hour' . $i . '"onclick="register_hour(this)" value="' . $str . '">';
                                        print $str;
                                        print '</td>';
                                        print "</tr>";
                                      }
                                      ?>
                                  </tbody>
                                </table>
                              </p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-12">
                              <p>
                                <table id="table-meeting-confirm">
                                  <thead>
                                    <tr>
                                      <th scope="col" colspan="7" style="border: 0">３．確認</th>
                                    </tr>
                                    <tr>
                                      <td scope="col" style="border: 0">以下の内容で予約します。よろしいですか？</td>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td class="p-4">
                                        <form>
                                          <div class="form-group">
                                            <div class="form-row align-items-center">
                                              <input type=text class="form-control-sm" id="reservation_date_meeting_fixed" value="" disabled>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <div class="form-row align-items-center">
                                              <input type=text class="form-control-sm" id="reservation_time_meeting_fixed" value="" disabled>
                                            </div>
                                          </div>
                                          <div class="form-row align-items-center mt-4">
                                            <button type="submit" class="btn btn-primary">予約する</button>
                                          </div>
                                        </form>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </p>
                            </div>
                          </div>
                          <script>
                            //document.getElementById( "table-meeting-hour" ).style.visibility = "hidden";
                            //document.getElementById( "table-meeting-confirm" ).style.visibility = "hidden";
                            document.getElementById( "table-meeting-hour" ).style.display = "none";
                            document.getElementById( "table-meeting-confirm" ).style.display = "none";

                            function register( obj, day, month, year ) {

                              for ( var i = 0; i < 5; ++i ) {
                                for ( var j = 0; j < 7; ++j ) {
                                  var temp = j + i * 7 + 1;
                                  if ( document.getElementById( 'td1' + i + j ).innerHTML != "" ) {
                                    document.getElementById( 'td1' + i + j ).style.backgroundColor = "white";
                                  }
                                  if ( document.getElementById( 'td2' + i + j ).innerHTML != "" ) {
                                    document.getElementById( 'td2' + i + j ).style.backgroundColor = "white";
                                  }
                                }
                              }

                              if ( obj.style.backgroundColor == "pink" ) {
                                obj.style.backgroundColor = "white";
                                document.getElementById( "table-meeting-hour" ).style.visibility = "hidden";
                              } else {
                                obj.style.backgroundColor = "pink";
                                if ( day != null ) {
                                  document.getElementById( "reservation_date_meeting" ).innerHTML = "" + year + "年" + month + "月" + day + "日";
                                  document.getElementById( 'reservation_date_meeting_fixed' ).value = "" + year + "年" + month + "月" + day + "日";
                                }
                                document.getElementById( "table-meeting-hour" ).style.display = "block";
                                document.getElementById( "table-meeting-hour" ).style.visibility = "visible";
                              }
                            }
                            // 時間の選択
                            function register_hour( obj ) {
                              for ( var i = 0; i < 10; ++i ) {
                                document.getElementById( 'td_hour' + i ).style.backgroundColor = "white";
                              }
                              if ( obj.style.backgroundColor == "pink" ) {
                                obj.style.backgroundColor = "white";
                              } else {
                                obj.style.backgroundColor = "pink";
                                document.getElementById( 'reservation_date_meeting_fixed' ).value = document.getElementById( 'reservation_date_meeting_fixed' ).value;
                                document.getElementById( 'reservation_time_meeting_fixed' ).value = obj.innerHTML;
                              }
                              document.getElementById( "table-meeting-confirm" ).style.display = "block";
                              document.getElementById( "table-meeting-confirm" ).style.visibility = "visible";
                            }
                          </script>
                        </p>
                      </div>
                    </div>
                  </div>  
                  <div class="card">
                    <div class="card-header" role="tab" id="headingFour">
                      <a class="collapsed text-body" data-toggle="collapse" href="#collapseFour" role="button" aria-expanded="false" aria-controls="collapseFour">
                        <i class="fas fa-envelope-square"></i> 連絡 
                      </a>
                    </div>
                    <!-- /.card-header -->
                    <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                      <div class="card-body">              
                        <div>
                          <form name="form_settings">
                            <div class="form-group">
                              <div class="form-row align-items-center">
                                <textarea name="communication_mail" rows="4" cols="40">ここに連絡内容を記入してください。</textarea>
                              </div>
                            </div>
                            <div class="form-row align-items-center mt-4">
                              <button type="submit" class="btn btn-primary">送信する</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /#accordion -->
              </p>
            </div>
          </div>

          <div id="tab-staff" class="tab-pane">
            <!-- スタッフ専用 -->
            <!--<div class="col-sm-10" style="background-color:yellow;padding:6px;margin:10px;">-->
            <div class="col-sm-10">
              <div id="build_user_list_selection"></div>
              <!--<span>検索する利用者を指定してください。<input type="text" name="search_name" id="search_name" width"30"></span>
                <button class="btn btn-primary" id="btn_search">検索</button>-->
              <p>
                <div id="result_diary_table"></div>
              </p>
            </div>
            <div class="col-sm-2">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-1">
    </div>
  </div>
  <div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10 text-center">
      <footer>
      <small>Copyright 2018 Office Right Paw, OSAKA JAPAN</small>
      </footer>
    </div>
    <div class="col-sm-1">
    </div>
  </div>
  </div>

  <!--「本日の学び」一覧テーブル出力-->
  <script type="text/javascript">
    $( function () {
      // Ajax button click
      $( '#btn_search' ).on( 'click', function () {
        $.ajax( {
            url: './create-diary-list.php',
            type: 'POST',
            data: {
              'member_name': $( '#search_name' ).val()
            }
          } )
          // Ajaxリクエストが成功した時発動
          .done( ( data ) => {
            $( '#result_diary_table' ).html( data );
          } )
          // Ajaxリクエストが失敗した時発動
          .fail( ( data ) => {
            $( '.result' ).html( data );
            console.log( data );
          } )
          // Ajaxリクエストが成功・失敗どちらでも発動
          .always( ( data ) => {

          } );
      } )
    } );
  </script>


  <script>
    $( function () {

      $( "#tabs" ).tabs();

      $( "#tabs" ).bind( "tabsactivate", function ( event, ui ) {
        //alert("tabsactivate");
        // クリックされたタブのインデックス
        // インデックスは 0 から始まるので + 1
        var i = ui.newTab.index() + 1;
        if ( i == 1 ) {
          // 日報一覧
          //location.reload(); // 親画面をリロード
        } else if ( i == 3 ) {
          // 質問一覧
          //location.reload(); // 親画面をリロード
        } else if ( i == 4 ) {
          // 質問一覧
          //location.reload(); // 親画面をリロード
        }

      } );
    } );
  </script>

  <script>
    $.ajax( {
        url: './build_user_list_selection.php',
        type: 'POST',
        data: {
          'member_name': ""
        }
      } )
      // Ajaxリクエストが成功した時発動
      .done( ( data ) => {
        $( '#build_user_list_selection' ).html( data );
      } )
      // Ajaxリクエストが失敗した時発動
      .fail( ( data ) => {
        $( '.result' ).html( data );
        console.log( data );
      } )
      // Ajaxリクエストが成功・失敗どちらでも発動
      .always( ( data ) => {

      } );
  </script>
  <script>
    // 利用者の選択後、その利用者に関する情報を表示する
    function users_select_changed() {

      var member_name = $( '#users_select' ).val();

      $.ajax( {
          url: './create-diary-list.php',
          type: 'POST',
          data: {
            'member_name': member_name
          }
        } )
        // Ajaxリクエストが成功した時発動
        .done( ( data ) => {
          $( '#result_diary_table' ).html( data );
        } )
        // Ajaxリクエストが失敗した時発動
        .fail( ( data ) => {
          $( '.result' ).html( data );
          console.log( data );
        } )
        // Ajaxリクエストが成功・失敗どちらでも発動
        .always( ( data ) => {

        } );
    }
  </script>
  <script>
    window.onload = function getDate() {
      var yyyy, mm, dd, today
      today = new Date();
      yyyy = today.getFullYear();
      mm = today.getMonth() + 1;
      dd = today.getDate();

      //年
      $Year = "<select class='form-control-sm custom-select'>";
      for ( var i = 1945; i <= 2019; i++ ) {
        if ( i == yyyy ) {
          $Year += "<option value=\"" + i + "\" selected >" + i + "年" + "</option>";
        } else {
          $Year += "<option value=\"" + i + "\" >" + i + "年" + "</option>";
        }
      }
      $Year += "</select>";
      document.getElementById( "birth_year" ).innerHTML = $Year;

      //月
      $Month = "<select class='form-control-sm custom-select' >";
      for ( var i = 1; i <= 12; i++ ) {
        if ( i == mm ) {
          $Month += "<option value=\"" + i + "\" selected >" + i + "月" + "</option>";
        } else {
          $Month += "<option value=\"" + i + "\" >" + i + "月" + "</option>";
        }
      }
      $Month += "</select>";
      document.getElementById( "birth_month" ).innerHTML = $Month;

      //日付
      $Day = "<select class='form-control-sm custom-select' >";
      for ( var i = 1; i <= 31; i++ ) {
        if ( i == dd ) {
          $Day += "<option value=\"" + i + "\" selected >" + i + "日" + "</option>";
        } else {
          $Day += "<option value=\"" + i + "\" >" + i + "日" + "</option>";
        }
      }
      $Day += "</select>";
      document.getElementById( "birth_day" ).innerHTML = $Day;
    }
  </script>


  <script>
    // HTMLロード完了時、大阪府を選択、市区の一覧をセットアップ
    $( function () {
      document.getElementById( "s1" ).options[ 27 ].selected = true;
      setupList2();
    } );
  </script>

  <?php

  ?>
</body>
</html>