<?php
//データを取得するAPI

require 'db_conect.php';

$query = "SELECT * FROM test";
$stmt = $pdo->query($query);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);
?>
