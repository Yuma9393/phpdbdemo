<?php
require '../pg_pdodb.php';

$html = "";
if (isset($_POST['no'])) {
    try {
        $conn = db_connect();
        $sql = 'select * from student where no = ?';
        $prepare = $conn->prepare($sql);
        $prepare->bindValue(1, $_POST['no']);
        $prepare->execute();
        $count=$prepare->rowCount();
        $student = $prepare->fetch(PDO::FETCH_ASSOC);
        echo json_encode($student, JSON_UNESCAPED_UNICODE);
    } catch( PDOException $e ) {
        $html =  "更新対象のデータがありません。（" . $e->getMessage() . "）";
    }    
}
