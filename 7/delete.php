<?php
require '../pg_pdodb.php';

$html = "";
// GET値をチェック
if (isset($_POST['no'])) {
    try {
        $conn = db_connect();
        $sql = 'delete from student where no = ?';
        $prepare = $conn->prepare($sql);
        $prepare->bindValue(1, $_POST['no']);
        $prepare->execute();
        $count=$prepare->rowCount();
    } catch( PDOException $e ) {
        header("HTTP/1.1 500 Internal Server Error");
        echo $e->getMessage;
    }
}
?>

