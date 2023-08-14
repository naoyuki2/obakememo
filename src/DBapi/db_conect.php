<?php //データベース接続用ファイル
$host = 'localhost';
$dbname = '	test';
$username = 'test';
$password = 'test1111';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
