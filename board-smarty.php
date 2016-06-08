<?php

require( dirname( __FILE__ ).'/libs/Smarty.class.php' );

$smarty = new Smarty();

$smarty->template_dir = dirname( __FILE__ ).'/templates'; //テンプレートファイル
$smarty->compile_dir  = dirname( __FILE__ ).'/templates_c'; //コンパイル結果格納
$smarty->cache_dir = dirname(__FILE__) . "/cache";
$smarty->config_dir = dirname(__FILE__) . "/config";

session_start();
try {
//データベースの初期設定
    $dsn = 'mysql:dbname=kadai3;host=127.0.0.1';
    $user = 'root';
    $password = 'K/ai1104';
    $error_message = '';


    if (isset($_POST['postname'])) {
        $name = ($_POST['postname']);
    }

    if (isset($_POST['message'])) {
        $message = ($_POST['message']);
        $message = nl2br($message);//改行処理F
    }

    if (isset($_SESSION["loginID"])) { //ログインされたユーザーのidを記憶  login画面から
        $memberID = $_SESSION["loginID"]; //投稿者は透きに投稿時のユーザー名、本文を決められるので
        //ユーザー固有のIDで投稿を管理
    }


    $dbh = new PDO($dsn, $user, $password);


    if ($dbh == null) {
        exit('接続に失敗しました。<br>');
    }

    $result = $dbh->query('SET NAMES utf8');
//文字コード指定
//一回だけ使用するようなメソッドはqueryをつかう

    if (!$result) {
        exit('文字コードを指定できませんでした。');
    }

//データを投稿するときの処理
    if ((isset($_POST['postname'])) && (isset($_POST['message']))) {
        //ユーザー・本文ともに入力されてなければエラー表示
        if ($name == NULL || $message == NULL) {
            $error_message = '投稿者名と本文を正しく入力してください。';
        } else {
            //データの追加処理。
            $sql = "insert into post (userID,message,postdate,memberID) values (?, ?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            //投稿時間をtime関数で得て、date関数で適切な形に整形
            $time = time();
            $post_time = date("YmdHis", $time);
            $flag = $stmt->execute(array($name, $message, $post_time, $memberID));
            //flagが正しく立たなければエラー
            if (!$flag) {
                exit('データの追加に失敗しました<br>');
            }
        }
    }


//投稿され本文の表示処理

    $sql = 'select userID, message,ID, memberID from post';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) { //fetchで実行結果の取得

        //IDとと本文をそれぞれ取り出し、IDをキーとした連想配列にする
        $userID = $result['userID'];
        $posted_message = $result['message'];
        //ログインしたユーザーが過去に投稿した内容は編集・消去のボタンを表示するが他ユーザーは何も表示しない
        $editbutton = '';
        $deletebutton = '';
        //取り出した投稿のIDを取り出し編集・消去時に適切な投稿に処理が行われるようにする
        $edit_id = $result['ID'];
        //データベースにpostされたメッセージの投稿者IDとログインしたユーザーIDが等しい場合
        if ($memberID == $result['memberID']) {
            //取り出したメッセージのIDを送信するフォームを保持する変数作成
            $editbutton = '<form action="http://localhost:8888/kadai3/smarty_test/edit-smarty.php/" method="POST"><input type="hidden" name="editnum" value="' . $edit_id . '" /><button>編集する</button></form>';
            $deletebutton = '<form action="http://localhost:8888/kadai3/smarty_test/edit-smarty.php/" method="POST"><input type="hidden" name="deletenum" value="' . $edit_id . '" /><button>消去</button></form>';

        }
        //ユーザーID、本文、編集・消去ボタンについての内容をどんどん配列にぶっこむ
        $data[] = array('name' => $userID, 'message' => $posted_message, 'edit' => $editbutton, 'delete' => $deletebutton);
    }

//配列をテンプレートに渡す
    $smarty->assign('member', $data);

    if ($error_message) {
        print '<font color="red">' . $error_message . '</font>';
    }

}catch (PDOException $e) {

    echo "エラー:" . $e->getMessage(); //メッセージ表示 

}
$smarty->display('board.tpl');
?>
