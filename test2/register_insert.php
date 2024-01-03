
<?php
//1. POSTデータ取得
// index.phpから送信される情報を取得・格納
$u_name=$_POST["u_name"];
$u_mail=$_POST["u_mail"];
$u_pass=$_POST["u_pass"];

//2. DB接続します
db_conn();

//３．データ登録SQL作成

// フォームに入力された文字をそのままSQLに突っ込むと、問題がある場合がある。それを防ぐため、情報を仮の箱に一度入れたうえで（バインド関数）、それをSQLとする

// 1. SQL文を用意
$stmt = $pdo->prepare("
  INSERT INTO 
    profile(u_id,u_name,u_mail,u_pass,life_flg,u_indate)
  VALUES
    (NULL,:u_name,:u_mail,:u_pass,1,sysdate())
    ");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':u_name', $u_name, PDO::PARAM_STR);
$stmt->bindValue(':u_mail', $u_mail, PDO::PARAM_STR);
$stmt->bindValue(':u_pass', $u_pass, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location:login.php");
}

?>
