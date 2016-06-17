<?php
session_start();
//


// ログイン済みかどうかの変数チェックを行う
if (!isset($_SESSION["user_name"])) {

	// 変数に値がセットされていない場合は不正な処理と判断し、ログイン画面へリダイレクトさせる
    $no_login_url = "login-smarty.php";
    header("Location: {$no_login_url}");
    exit;
} else {
    $login_url = "board-smarty.php";//これより前に文字の出力禁止
    header("Location: {$login_url}");
    print "ログイン成功";
}
?>