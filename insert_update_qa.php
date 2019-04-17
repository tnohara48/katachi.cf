<?php
// header('Content-type: text/plain; charset= UTF-8');
/*
**      insert_update_qa.php
*/

if (empty($_POST) || $_POST['postdata']=="") {
	print '入力が不正です。';
	exit();
}

// チェック関数・データベース登録関数読み込み
include_once('db_ins_upd_func.php');

// 入力項目の項目名羅列の入力値に対する正当性チェック
$errors = post_date_error_check($_POST);
if ($errors != null && $errors != "") {
	// エラー
	print '<!doctype html><html lang="ja"><head></head><body>'. $errors . ' が入力されていないか不正です。<br></body></html>';
	return;
}

// データベースへの反映（INPUT、存在レコードに対してはUPDATE）
$lastcode = db_ins_upd_func('membersapp','qa_history',$_POST);

// INSERT,UPDATE結果のレコード番号によってパラメータ切り替え
/*
if ($lastcode > 0) {
	header('Location:index.php?code=' . $lastcode . '&mode=qa');
} else {
	header('Location:index.php');
}
return;
*/
?>
