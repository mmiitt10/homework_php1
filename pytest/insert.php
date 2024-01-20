<?php
require_once('funcs.php');
setlocale(LC_CTYPE, "en_US.UTF-8");


//1. POSTデータ取得
$url   = $_POST['url'];

// Pythonスクリプトを実行してタイトルを取得
$title = shell_exec("python \"C:\\xampp\\htdocs\\pytest\\get_title.py\" " . escapeshellarg($url));
$title = mb_convert_encoding($title, 'UTF-8', 'UTF-8');
echo $title;

// //2. DB接続します
// $pdo = db_conn();

// //３．データ登録SQL作成
// $stmt = $pdo->prepare(
//     'INSERT INTO pytest1(id,title)
//     VALUES(null,:title);
//     ');
// $stmt->bindValue(':title', $title, PDO::PARAM_STR);
// $status = $stmt->execute(); //実行

// //４．データ登録処理後
// if ($status == false) {
//     sql_error($stmt);
// } 

?>
