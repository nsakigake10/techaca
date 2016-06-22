<?php

session_start();

require_once("MySmarty.class.php");
require_once("db_connect.class.php");

//新しく作ったMySmartyインスタンスの作成
$smarty = new MySmarty();
//データベースのインスタンス作成
$dbh = new db_connect();


    if (isset($_POST['user_name'])) {
        $user_name = ($_POST['user_name']);
    }


    if (isset($_POST['user_password'])) {
        $user_password = $_POST['user_password'];
    }


    // エラーメッセージを格納する変数を初期化
    $error_message = "";
    //ログインされたuserIDに対応するパスワードを保持する変数の宣言
    $hit_password = '';
    // ログインボタンが押されたかを判定
    // 初めてのアクセスでは認証は行わずエラーメッセージは表示しないように
    if (isset($_POST["login"])) {


        // データベース内のmemberテーブルのnameカラムから入力されたユーザーネームが存在するか確認
        $usr_sql = "select ID,password from member where name= ?";  //sql文
        $data = $dbh->pdo_fetch($usr_sql,array($user_name));        //実行結果が格納される


        //hitしたユーザーネームに対応するパスワードを取り出す
        //ログインしたユーザーのIDも取得

        if ($data) {
            $hit_password = $data['password'];
            $_SESSION["login_ID"] = $data['ID'];//ログインした人のIDをboardに引き継ぐ
        }

        //user_nameがデータベースにない時の処理
        if (!$data) {

            $error_message = 'ユーザー名が存在しません。';

        } 
        //ユーザー名の入力が不完全のとき
        else if (($user_password == NULL) || ($user_name == NULL)) {

            $error_message = 'ユーザー名とパスワード両方入力してください';

        } 
        //正常にユーザー名、パスワードが見つかれば
        else if ($hit_password == $user_password) { 

            // 管理者専用画面へリダイレクト
            $login_url = 'board-smarty.php';
            header("Location: {$login_url}");
            exit;
        } 
        else {

            $error_message = 'パスワードが異なります。';
        
        }

    }


    //新規登録画面に移動
    if (isset($_POST["new_registar"])) {
        $login_url = 'new_registar-smarty.php';
        header("Location: {$login_url}");
        exit;
    }

    //エラーメッセージの表示
    if ($error_message) {
        print '<font color="red">' . $error_message . '</font>';
    }


$smarty->display('login.tpl');

?>