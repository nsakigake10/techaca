<?php

session_start();

require_once($_SERVER["DOCUMENT_ROOT"]."/kadai3/smarty_test/MySmarty.class.php");

//新しく作ったMySmartyインスタンスの作成
$smarty = new MySmarty();



try {
    $dsn = 'mysql:dbname=kadai3;host=127.0.0.1';
    $user = 'root';
    $password = 'K/ai1104';

    $dbh = new PDO($dsn, $user, $password);

    if ($dbh == null) {
        print('接続に失敗しました。<br>');
    }

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
        $usr_stmt = $dbh->prepare($usr_sql);                        //文の準備
        $usr_flag = $usr_stmt->execute(array($user_name));          //データの内容を補足


        //hitしたユーザーネームに対応するパスワードを取り出す
        //ログインしたユーザーのIDも取得

        if (($result = $usr_stmt->fetch(PDO::FETCH_ASSOC))) {
            $hit_password = $result['password'];
            $_SESSION["loginID"] = $result['ID'];//ログインした人のIDをboardに引き継ぐ
        }

        //user_nameがデータベースにない時の処理
        if (!$usr_flag) {

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

            $error_message = 'ユーザー名またはパスワードが異なります。';
        
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
}catch (PDOException $e) {

    echo "エラー:" . $e->getMessage(); //メッセージ表示

}

$smarty->display('login.tpl');

?>