<?php
require '../pg_pdodb.php';

$conn = db_connect();
$sql = 'select * from student order by no';
$prepare = $conn->prepare($sql);
$prepare->execute();
$count=$prepare->rowCount();
$students = $prepare->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($students, JSON_UNESCAPED_UNICODE);

?>