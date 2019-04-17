<?php
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>入力フォーム</title>
</head>
<body>
    <h1>入力フォーム</h1>
    <div>
        <form method="post" action= "check.php">
		<table border="2">
            <tr>
                <td>名前</td><td><input type ="text" name="name" value="" />
                </td>
            </tr>
            <tr>
                <td>住所</td><td><input type ="text" name="adress" value="" />
                </td>
            </tr>
            <tr>
                <td>電話番号</td><td><input type ="text" name="phone" value="" />
                </td>
            </tr>
            <tr>
                <td>性別</td>
                <td>
                	<input type ="radio" name="gender" value="男" />男&nbsp;
                	<input type ="radio" name="gender" value="女" />女
                </td>
            </tr>
             <tr>
                <td>趣味</td>
                <td>
                  <input type="hidden" name="favorite[]"  value="" >
                	<input type ="checkbox" name="favorite[]" value="読書" />読書&nbsp;
                  <input type="hidden" name="favorite[]"  value="" >
                	<input type ="checkbox" name="favorite[]" value="ドライブ" />ドライブ&nbsp;
                  <input type="hidden" name="favorite[]"  value="" >
                  <input type ="checkbox" name="favorite[]" value="映画" />映画&nbsp;
                  <input type="hidden" name="favorite[]"  value="" >
                  <input type ="checkbox" name="favorite[]" value="音楽" />音楽&nbsp;
                </td>
            </tr>
             <tr>
                <td>携帯キャリア</td>
                <td>
                	<select name="carrier">
                		<option value="docomo">docomo</option>
                 		<option value="au">au</option>
                 		<option value="softbank">softbank</option>
                	</select>
                </td>
            </tr>
        </table>
        	<input type="submit" value="送信" />
		</form>

    </div>
</body>
</html>
