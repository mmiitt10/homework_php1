<?php
// 共通準備
session_start();
require_once('funcs.php');

//1.  DB接続
$pdo = db_conn();

//２．データ取得SQL作成
// ログインしていない場合は表示できない
if(!isset($_SESSION["u_id"])) {
    header('Location:login.php');
    exit("User is not logged in.");
}

$con_id=$_GET['con_id'];

// 会員情報を抽出
$stmt1 = $pdo->prepare("SELECT * FROM useradmin WHERE u_id = :u_id");
$stmt1->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt1->execute();
$results1 = $stmt1->fetchAll();
$row1=$results1[0];

// プロフィール情報を抽出
$stmt2 = $pdo->prepare("SELECT * FROM profile WHERE u_id = :u_id");
$stmt2->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt2->execute();
$results2 = $stmt2->fetchAll();
$row2= $results2[0];

// コンテンツ情報を抽出
$stmt3 = $pdo->prepare("SELECT * FROM contents WHERE con_id = :con_id");
$stmt3->bindValue(':con_id', $con_id, PDO::PARAM_INT);
$stmt3->execute();
$results3 = $stmt3->fetchAll();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>コンテンツ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <a class="navbar-brand" href="mypage_select.php">マイページ</a>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <p>ようこそ<?php echo h($_SESSION['u_name'])?>さん。登録した内容を書き換えてください</p>
    <form method="post" action="insert.php">
        <label>コンテンツのカテゴリ<input type="text" name="con_category" value=<?= $row3["con_category"]?>></label><br>
        <label>コンテンツ名<input type="text" name="con_input_name" value=<?= $row3["con_input_name"]?>></label><br>
        <label>タイトル<input type="text" name="con_title" value=<?= $row3["con_title"]?>></label><br>
        <label>内容<input type="text" name="con_detail" value=<?= $row3["con_detail"]?>></label><br>
        <label>コンテンツのURL<input type="text" name="con_url" value=<?= $row3["con_url"]?>></label><br>
        <label><input type="hidden" name="con_id" value=<?= $row3["con_id"]?>></label><br>
        <button type="submit" class="btn btn-primary">送信</button>
    </form>
    <!-- Main[End] -->
</body>

</html>
