<?php
require '../pg_pdodb.php';

$html = "";
// POST値があれば更新
if (isset($_POST['no']) && isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['birthday'])) {
    try {
        $conn = db_connect();
        $sql = 'update student set name=?,mail=?,birthday=to_date(?,\'yyyy/mm/dd\') where no = ?';
        $prepare = $conn->prepare($sql);
        $prepare->bindValue(1, $_POST['name']);
        $prepare->bindValue(2, $_POST['mail']);
        $prepare->bindValue(3, $_POST['birthday']);    
        $prepare->bindValue(4, $_POST['no']);
        $prepare->execute();
        $count=$prepare->rowCount();
    } catch( PDOException $e ) {
        $html =  "更新できませんでした。（" . $e->getMessage() . "）";
    }
    
    if ($count > 0) {
        $html = '更新されました。';
    }
} else {
    // 更新対象データの取得
    if (isset($_GET['no'])) {
        try {
            $conn = db_connect();
            $sql = 'select * from student where no = ?';
            $prepare = $conn->prepare($sql);
            $prepare->bindValue(1, $_GET['no']);
            $prepare->execute();
            $count=$prepare->rowCount();
            $student = $prepare->fetch(PDO::FETCH_ASSOC);
        } catch( PDOException $e ) {
            $html =  "更新対象のデータがありません。（" . $e->getMessage() . "）";
        }    
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./update.php" method="post">
        ID：<input type="text" name="no" value="<?=$student['no'] ?>" readonly /><br>
        氏名：<input type="text" name="name" value="<?=$student['name'] ?>" required /><br>
        メールアドレス：<input type="email" name="mail" value="<?=$student['mail'] ?>" required/><br>
        生年月日：<input type="date" name="birthday" value="<?=$student['birthday'] ?>" required/><br>
        <input type="submit" value="更新" />
    </form>
    <?=$html ?>
    <br>
    <a href="./index.php">一覧に戻る</a>
</body>
</html>

