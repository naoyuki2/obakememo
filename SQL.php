<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$mode = $_POST['mode'];
$func = $_POST['func'];
$jsonStrData = $_POST['args'];
$argsAssoc = json_decode($jsonStrData, true);
$argsValue = array_values($argsAssoc);
try {
    $getData = $func(...$argsValue);
    if ($mode === 'get') {
        $jsonData = json_encode($getData);
        echo $jsonData;
    }
} catch (Exception $err) {
    echo 'データベース接続に失敗しました。';
}


function GetConnect()
{
    $dsn = "mysql:host=localhost;dbname=obakememo";
    $user = 'root';
    $password = '';
    return new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

function GetData(string $tblname, string $expression, string $join)
{
    $rtn = '';
    $pdo = GetConnect();
    $sql = "select task.*,obake.obake_path from $tblname {$join} where $expression";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rtn = $stmt->fetch();
    return $rtn;
}

function GetListAll(string $tblname, string $expression, string $join)
{
    $rtn = '';
    $pdo = GetConnect();
    $sql = "select * from {$tblname} {$join} where $expression";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rtn = $stmt->fetchAll();
    return $rtn;
}

function GetCount(string $tblname, string $expression = "1", string $join = "")
{
    $rtn = 0;
    $pdo = GetConnect();
    $sql = "select count(*) from {$tblname} {$join} where {$expression}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rtnAlias = $stmt->fetch();
    $rtn = $rtnAlias[0];
    return $rtn;
}

function DbInsert(string $tblname, array $arr)
{
    $pdo = GetConnect();
    $insertKey = "";
    $insertValue = "";
    $insertLastKey = end(array_keys($arr));
    $insertLastValue = end($arr);

    foreach ($arr as $key => $value) {
        if ($key === $insertLastKey && $value === $insertLastValue) {
            $insertKey .= $key;
            $insertValue .= "'{$value}'";
            continue;
        }

        $insertKey .= "{$key}, ";
        $insertValue .= "'{$value}', ";
    }

    $sql = "insert into {$tblname}({$insertKey}) values({$insertValue})";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

function DbUpdate(string $tblname, array $arr, string $expression = "1")
{
    $pdo = GetConnect();
    $setColumn = "";
    $updateLastKey = end(array_keys($arr));
    $updateLastValue = end($arr);

    foreach ($arr as $key => $value) {
        if ($key === $updateLastKey && $value === $updateLastValue) {
            $setColumn .= "{$key} = '{$value}'";
            continue;
        }

        $setColumn .= " {$key} = '{$value}',";
    }

    $sql = "update {$tblname} set {$setColumn} where {$expression}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

function DbDelete(string $tblname, string $expression = "1")
{
    $pdo = GetConnect();
    $sql = "delete from {$tblname} where {$expression}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
