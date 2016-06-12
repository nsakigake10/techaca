<?php

require( dirname( __FILE__ ).'/libs/Smarty.class.php' );

$smarty = new Smarty();

$smarty->template_dir = dirname( __FILE__ ).'/templates'; //テンプレートファイル
$smarty->compile_dir  = dirname( __FILE__ ).'/templates_c'; //コンパイル結果格納
$smarty->cache_dir = dirname(__FILE__) . "/cache";
$smarty->config_dir = dirname(__FILE__) . "/config";

session_start();

try {
    $dsn = 'mysql:dbname=kadai3;host=127.0.0.1';
    $user = 'root';
    $password = 'K/ai1104';

    $dbh = new PDO($dsn, $user, $password);
    $error_message = '';


    if (isset($_POST["registar"])) {

        if ($dbh == null) {
            $error_message = '接続に失敗しました';
        }

        if (isset($_POST['new_user_id'])) {
            $new_user_id = ($_POST['new_user_id']);
            //idが重複しているか調べるため$new_user_idと同じIDがデータベースに存在しないかを調べる
            $sql = "select * from member where ID=?";
            $stmt = $dbh->prepare($sql);
            $flag = $stmt->execute(array($new_user_id));
        }

        if (isset($_POST['new_user_name'])) {
            $new_user_name = ($_POST['new_user_name']);
        }

        if (isset($_POST['new_password'])) {
            $new_password = ($_POST['new_password']);
        }

        //入力内容が半角英数字以外ならエラー
        if (ctype_alpha($new_password) || ctype_alpha($new_user_name) || (ctype_alpha($new_user_id))) {

            $error_message = '登録情報は半角英数で入力してください'; //半角英数限定

        } 
        //入力でーた空ならエラー
        else if (($new_user_name == NULL) || ($new_password == NULL) || ($new_user_id == NULL)) {

            $error_message = '入力が不完全です。';

        } else if ($stmt->fetch(PDO::FETCH_ASSOC) != NULL) { //実行結果がNULL以外なら新規登録失敗

            $login_url = 'http://localhost:8888/kadai3/smarty_test/registar_fail-smarty.php';
            header("Location: {$login_url}");
            exit;

        } else {
            //データベースに新規登録情報を引き渡し処理を終える
            $sql = "insert into member (ID,name, password,memberdate) values (?, ?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            $time = time();
            $registar_time = date("YmdHis", $time);
            $flag = $stmt->execute(array($new_user_id, $new_user_name, $new_password, $registar_time));

            $login_url = 'http://localhost:8888/kadai3/smarty_test/login-smarty.php';
            header("Location: {$login_url}");
            exit;
        }


    }

    if ($error_message) {
        print '<font color="red">' . $error_message . '</font>';
    }
}catch (PDOException $e) {

    echo "エラー:" . $e->getMessage(); //メッセージ表示

}
$smarty->display('new_registar.tpl');
?>




/**
* Created by PhpStorm.
* User: nagashimakaito
* Date: 2016/05/19
* Time: 12:35
*/