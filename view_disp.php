<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>入力フォーム</title>
</head>
<body>
    <h1>入力フォーム</h1>
    <div>
        <table border="2">
            <tr>
                <td>名前</td><td><?php print( $name ); ?></td>
            </tr>
            <tr>
                <td>住所</td><td><?php print( $adress ); ?></td>
            </tr>
            <tr>
                <td>電話番号</td><td><?php print( $phone ); ?></td>
            </tr>
            <tr>
                <td>性別</td><td><?php print( $gender ); ?></td>
            </tr>
             <tr>
                <td>趣味</td>
                <td>
                <?php foreach ( $favorite as $value ) {
                    print( $value . "&nbsp;" );
                } ?>
                </td>
            </tr>
             <tr>
                <td>携帯キャリア</td>
                <td><?php print( $carrier ); ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
