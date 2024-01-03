<?php
session_start();
require_once("funcs.php");
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
                <a class="navbar-brand" href="register.php">会員登録</a>
                <a class="navbar-brand" href="login.php">ログイン</a>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <p>ようこそ<?php echo h($_SESSION['u_name'])?>さん。読んだ書籍や記事などを登録してください</p>
    <form method="post" action="insert.php">
        <label>コンテンツのカテゴリ<input type="text" name="con_category"></label><br>
        <label>コンテンツ名<input type="text" name="con_input_name"></label><br>
        <label>タイトル<input type="text" name="con_title"></label><br>
        <label>内容<input type="text" name="con_detail"></label><br>
        <label>コンテンツのURL<input type="text" name="con_url"></label><br>
        <button type="submit" class="btn btn-primary">送信</button>
    </form>
    <!-- Main[End] -->
</body>

</html>
