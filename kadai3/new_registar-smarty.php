<?php

session_start();

require_once("MySmarty.class.php");
require_once("db_connect.class.php");

//新しく作ったMySmartyインスタンスの作成
$smarty = new MySmarty();
//データベースのインスタンス作成
$dbh = new db_connect();
//エラーメッセージの初期化
$error_message = '';


    if (isset($_POST["registar"])) {

        if ($dbh == null) {
            $error_message = '接続に失敗しました';
        }

        if (isset($_POST['new_user_id'])) {
            $new_user_id = ($_POST['new_user_id']);
            //idが重複しているか調べるため$new_user_idと同じIDがデータベースに存在しないかを調べる
            $sql = "select * from member where ID=?";
            $data = $dbh->pdo_fetch($sql,array($new_user_id));
        }

        if (isset($_POST['new_user_name'])) {
            $new_user_name = ($_POST['new_user_name']);
        }

        if (isset($_POST['new_password'])) {
            $new_password = ($_POST['new_password']);
        }



        if (($new_user_name == NULL) || ($new_password == NULL) || ($new_user_id == NULL)){//入力でーた空ならエラー

            $error_message = '入力が不完全です。';

        } 
        //入力内容が半角英数字以外ならエラー
        else if (!(ctype_alnum($new_user_name)) || !(ctype_alnum($new_user_id)) || !(ctype_alnum($new_password))){

            $error_message = '登録内容は半角英数字を入力してください';//半角英数限定  

        } else if ($data != NULL) { //実行結果がNULL以外なら新規登録失敗

            $login_url = 'registar_fail-smarty.php';
            header("Location: {$login_url}");
            exit;

        } else {
            //データベースに新規登録情報を引き渡し処理を終える
            $sql = "insert into member (ID,name, password,memberdate) values (?, ?, ?, ?)";
            $time = time();
            $registar_time = date("YmdHis", $time);
            $dbh->pdo_update($sql,array($new_user_id, $new_user_name, $new_password, $registar_time));

            $login_url = 'login-smarty.php';
            header("Location: {$login_url}");
            exit;
        }


    }

    if ($error_message) {
        print '<font color="red">' . $error_message . '</font>';
    }

$smarty->display('new_registar.tpl');
?>
