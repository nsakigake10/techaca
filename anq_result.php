<?php
session_start();
//


// ログイン済みかどうかの変数チェックを行う
if (!isset($_SESSION["user_name"])) {

// 変数に値がセットされていない場合は不正な処理と判断し、ログイン画面へリダイレクトさせる
    $no_login_url = "http://localhost:8888/kadai3/smarty_test/login-smarty.php";
    header("Location: {$no_login_url}");
    exit;
} else {
    $login_url = "http://localhost:8888/kadai3/smarty_test/board-smarty.php";//これより前に文字の出力禁止
    header("Location: {$login_url}");
    print "ログイン成功";
}
?>