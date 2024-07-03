<?php
require '../pg_pdodb.php';

$html = "";
// POST値をチェック
if (isset($_POST['no']) && isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['birthday'])) {
    try {
        $conn = db_connect();
        $sql = 'insert into student (no,name,mail,birthday) values (?,?,?,to_date(?,\'yyyy/mm/dd\'))';
        $prepare = $conn->prepare($sql);
        $prepare->bindValue(1, $_POST['no']);
        $prepare->bindValue(2, $_POST['name']);
        $prepare->bindValue(3, $_POST['mail']);
        $prepare->bindValue(4, $_POST['birthday']);    
        $prepare->execute();
        $count=$prepare->rowCount();
    } catch( PDOException $e ) {
        $html =  "登録できませんでした。（" . $e->getMessage() . "）";
    }
    
    if ($count > 0) {
        $html = '登録されました。';
    }}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./add.php" method="post">
        ID：<input type="number" name="no" required/><br>
        氏名：<input type="text" name="name" required/><br>
        メールアドレス：<input type="email" name="mail" required/><br>
        生年月日：<input type="date" name="birthday" required/><br>
        <input type="submit" value="登録" />
    </form>
    <?=$html ?>
    <br>
    <a href="./index.php">一覧に戻る</a>
</body>
</html>

