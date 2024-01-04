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

// 個人情報を抽出
$stmt1 = $pdo->prepare("SELECT * FROM useradmin");
$stmt1->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt1->execute();
$results1 = $stmt1->fetchAll();
$row=$results1[0];

// 登録情報を抽出
$stmt2 = $pdo->prepare("SELECT * FROM contents");
$stmt2->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt2->execute();
$results2 = $stmt2->fetchAll();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>スレッド</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
        .profile, .content {
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 10px;
        }
        .contents {margin-top: 20px;}
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <a class="navbar-brand" href="con_register.php">コンテンツを登録する</a>
            </div>
        </nav>
    </header>
    <main>
        <!-- 個人情報表示 -->
        <div class="profile">
            <h2>プロフィール情報</h2>
            <p>名前: <?php echo h($row['u_name']) ?></p>
        </div>

        <!-- 登録コンテンツ表示 -->
        <div class="contents">
            <h2>登録コンテンツ</h2>
            <?php foreach ($results2 as $row): ?>
                <div class="content">
                    <p>カテゴリ: <?php echo h($row['con_category'])?></p>
                    <p>コンテンツ名: <?php echo h($row['con_input_name']) ?></p>
                    <p>タイトル: <?php echo h($row['con_title']) ?></p>
                    <p>詳細: <?php echo h($row['con_detail']) ?></p>
                    <p>URL: <?php echo h($row['con_url']) ?></p>
                    <!-- その他のコンテンツ情報があればここに追加 -->
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>