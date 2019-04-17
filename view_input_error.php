<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>入力フォーム</title>
</head>
<body>
    <h1>入力フォーム</h1>
    <div>
        <?php print($msg); ?>
        <form method="post" action= "check.php">
		<table border="2">
            <tr>
                <td>名前</td><td><input type ="text" name="name" value="<?php print($name) ?>" />
                </td>
            </tr>
            <tr>
                <td>住所</td><td><input type ="text" name="adress" value="<?php print($adress) ?>" />
                </td>
            </tr>
            <tr>
                <td>電話番号</td><td><input type ="text" name="phone" value="<?php print($phone) ?>" />
                </td>
            </tr>
            <tr>
                <td>性別</td>
                <td>
                	<input type ="radio" name="gender" value="男" <?php if ($gender == "男") {print("checked");} ?> />男&nbsp;
                	<input type ="radio" name="gender" value="女" <?php if ($gender == "女") {print("checked");} ?> />女
                </td>
            </tr>
              <tr>
              <td>趣味</td>
                <td>
                  <?php
                    // 選択されているチェックボックスの選択肢を選択状態にする
                    function checked_favorite($favorite, $value) {
                      for ($i = 0; $i < count($favorite); ++ $i) {
                        if ($favorite[$i] == $value) {
                          return true;
                        }
                      }
                      return false;
                    }
                  ?>
                  <input type ="checkbox" name="favorite[]" value="読書" <?php if (checked_favorite($favorite, "読書" ) == true) { print('checked'); } ?> />読書&nbsp;
                  <input type ="checkbox" name="favorite[]" value="ドライブ" <?php if (checked_favorite($favorite, "ドライブ" ) == true) { print('checked'); } ?> />ドライブ&nbsp;
                  <input type ="checkbox" name="favorite[]" value="映画" <?php if (checked_favorite($favorite, "映画" ) == true) { print('checked'); } ?> />映画&nbsp;
                  <input type ="checkbox" name="favorite[]" value="音楽" <?php if (checked_favorite($favorite, "音楽" ) == true) { print('checked'); } ?> />音楽&nbsp;
                </td>
              </tr>
              <tr>
                <td>携帯キャリア</td>
                <td>
                	<select name="carrier">
                		<option value="docomo" <?php if ($carrier == "docomo") { print('selected'); } ?> >docomo</option>
                 		<option value="au" <?php if ($carrier == "au") { print('selected'); } ?> >au</option>
                 		<option value="softbank" <?php if ($carrier == "softbank") { print('selected'); } ?> >softbank</option>
                	</select>
                </td>
            </tr>
        </table>
        	<input type="submit" value="送信" />
          <input type="button" onclick="history.back()" value="戻る" />
		</form>

    </div>
</body>
</html>
