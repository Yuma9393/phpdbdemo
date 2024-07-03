<?php
require '../pg_pdodb.php';

try {
    $conn = db_connect();
    $sql = 'select * from student';
    $prepare = $conn->prepare($sql);
    $prepare->execute();
    $count=$prepare->rowCount();
    $students = $prepare->fetchAll(PDO::FETCH_ASSOC);
} catch( PDOException $e ) {
    echo $e->getMessage();
    exit;
}

$html = "";
if ($count > 0) {
    $html .= '<table border="1"><tr><th>番号</th><th>氏名</th><th>メールアドレス</th><th>誕生日</th></tr>';
    foreach($students as $student) {
        $html .= '<tr><td>' . $student["no"] . '</td><td>' . $student["name"] . '</td><td>' . $student["mail"] . '</td><td>' . $student["birthday"] . '</td></tr>';
    }
    $html .= '</table border="1">';
} else {
    $html = "データが存在しません。";
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
    <?=$html ?>
</body>
</html>

