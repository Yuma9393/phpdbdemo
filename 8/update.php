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
        header("HTTP/1.1 500 Internal Server Error");
        echo $e->getMessage;
    }
}

?>