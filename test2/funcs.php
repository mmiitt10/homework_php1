<?php
function db_conn(){
    try {
        $pdo = new PDO('mysql:dbname=test_profile;charset=utf8;host=localhost','root',"");
        return $pdo;
      } catch (PDOException $e) {
        exit('DBConnectError:'.$e->getMessage());
      };
}

function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

?>