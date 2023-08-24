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

function GetData(string $tblname, string $where = "", string $join = "", $alias = "", $group = "", $order = "", $having = "")
{
    $rtn = "";
    $pdo = GetConnect();
    empty($alias) ? $alias = "*" : "";
    !empty($where) ? $where = "where " . $where : "";
    !empty($group) ? $group = "group by " . $group : "";
    !empty($order) ? $order = "order by " . $order : "";
    !empty($having) ? $having = "having " . $having : "";
    $sql = "select $alias from $tblname $join where $where $group $having $order";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rtn = $stmt->fetch();
    return $rtn;
}

function GetListAll(string $tblname, string $where = "", string $join = "", $alias = "", $group = "", $order = "", $having = "")
{
    $rtn = "";
    $pdo = GetConnect();
    empty($alias) ? $alias = "*" : "";
    !empty($where) ? $where = "where " . $where : "";
    !empty($group) ? $group = "group by " . $group : "";
    !empty($order) ? $order = "order by " . $order : "";
    !empty($having) ? $having = "having " . $having : "";
    $sql = "select $alias from $tblname $join where $where $group $having $order";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rtn = $stmt->fetchAll();
    return $rtn;
}

function GetCount(string $tblname, string $where = "", string $join = "")
{
    $rtn = 0;
    !empty($where) ? $where = "where " . $where : "";
    $pdo = GetConnect();
    $sql = "select count(*) from {$tblname} {$join} {$where}";
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

function DbUpdate(string $tblname, array $arr, string $where = "")
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
    !empty($where) ? $where = "where " . $where : "";
    $sql = "update $tblname set $setColumn $where";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

function DbDelete(string $tblname, string $where = "")
{
    $pdo = GetConnect();
    !empty($where) ? $where = "where " . $where : "";
    $sql = "delete from $tblname $where";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
