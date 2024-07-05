<?php
require '../pg_pdodb.php';

$html = "";
// POST値をチェック
if (isset($_POST['name'])) {
    try {
        $conn = db_connect();
        $name = $_POST['name'];
        $sql = 'select * from student where name like ?';
        $prepare = $conn->prepare($sql); 
        $prepare->execute("%$name%");
        $count=$prepare->rowCount();
    }
    catch( PDOException $e ) {
        header("HTTP/1.1 500 Internal Server Error");
        echo $e->getMessage;
    }
}
?>