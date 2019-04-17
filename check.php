<?php

$favorite = array();
$msg = "";

// 送信されたパラメータ「から「値を得る。
if( isset( $_POST["name"] ) ) {
  $name = $_POST["name"];
  $name = htmlspecialchars($name);
  if ($name == "") {
    $msg .= "名前が入力されていませんでした。<br>";
  }
}
if( isset( $_POST["adress"] ) ) {
  $adress = $_POST["adress"];
  $adress = htmlspecialchars($adress);
  if ($adress == "") {
    $msg .= "住所が入力されていませんでした。<br>";
  }
}
if( isset( $_POST["phone"] ) ) {
  $phone = $_POST["phone"];
  $phone = htmlspecialchars($phone);
  if ($phone == "") {
    $msg .= "電話番号が入力されていませんでした。<br>";
  }
}
if( isset( $_POST["gender"] ) ) {
  $gender = $_POST["gender"];
} else {
  $msg .= "性別が入力されていませんでした。<br>";
}
if( isset( $_POST["favorite"] ) ) {
  $favorite = $_POST["favorite"];
} else {
  $msg .= "趣味が入力されていませんでした。<br>";
}
if( isset( $_POST["carrier"] ) ) {
  $carrier = $_POST["carrier"];
} else {
  $msg .= "携帯キャリアが入力されていませんでした。<br>";
}
print($msg);

// エラーがあったか同課で表示するHTMLを選択/変更する。
if ($msg == "") {
  include_once("view_disp.php");  // エラーがなかった
}
else{
  include_once("view_input_error.php"); // エラーがあった
}

?>
