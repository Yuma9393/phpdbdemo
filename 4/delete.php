<?php
require '../pg_pdodb.php';

$html = "";
// GET値をチェック
if (isset($_GET['no'])) {
    try {
        $conn = db_connect();
        $sql = 'delete from student where no = ?';
        $prepare = $conn->prepare($sql);
        $prepare->bindValue(1, $_GET['no']);
        $prepare->execute();
        $count=$prepare->rowCount();
    } catch( PDOException $e ) {
        $html =  "削除できませんでした。（" . $e->getMessage() . "）";
    }
    
    if ($count > 0) {
        $html = '削除されました。';
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
    <?=$html ?>
    <br>
    <a href="./index.php">一覧に戻る</a>
</body>
</html>

