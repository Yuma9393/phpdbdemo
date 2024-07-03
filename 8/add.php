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
        header("HTTP/1.1 500 Internal Server Error");
        echo $e->getMessage;
    }
}

?>