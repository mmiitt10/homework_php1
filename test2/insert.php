<?php
session_start();
require_once('funcs.php');

//1. POSTデータ取得
$con_category   = $_POST['con_category'];
$con_input_name  = $_POST['con_input_name'];
$con_title  = $_POST['con_title'];
$con_detail = $_POST['con_detail'];
$con_url    = $_POST['con_url']; 

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare(
    'INSERT INTO contents(u_id,con_id,con_category,con_input_name,con_title,con_detail,con_url,con_indate)
    VALUES(:u_id,null,:con_category,:con_input_name,:con_title,:con_detail,:con_url,sysdate());
    ');
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt->bindValue(':con_category', $con_category, PDO::PARAM_STR);
$stmt->bindValue(':con_input_name', $con_input_name, PDO::PARAM_STR);
$stmt->bindValue(':con_title', $con_title, PDO::PARAM_STR);
$stmt->bindValue(':con_detail', $con_detail, PDO::PARAM_STR);
$stmt->bindValue(':con_url', $con_url, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    header('Location:index.php');
}

?>
