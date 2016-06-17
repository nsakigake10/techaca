<?php

require( dirname( __FILE__ ).'/libs/Smarty.class.php' );

$smarty = new Smarty();

$smarty->template_dir = dirname( __FILE__ ).'/templates'; //テンプレートファイル
$smarty->compile_dir  = dirname( __FILE__ ).'/templates_c'; //コンパイル結果格納
$smarty->cache_dir = dirname(__FILE__) . "/cache";
$smarty->config_dir = dirname(__FILE__) . "/config";


session_start();

try{
    $dsn = 'mysql:dbname=kadai3;host=127.0.0.1';
    $user = 'root';
    $password = 'K/ai1104';

    $dbh = new PDO($dsn, $user, $password);

   
    //編集後の本文の更新を行う
    if(isset($_POST['edit_message'])){

        $new_message = $_POST['edit_message'];
        $sql = "update post set message= ? where ID= ?";
        $stmt = $dbh->prepare($sql);
        $flag = $stmt->execute(array($new_message,$edit_num));

    }

    //編集後のuserIDの更新を行う
    if(isset($_POST['edit_userID'])){

        $new_userID = $_POST['edit_userID'];
        $sql = "update post set userID= ? where ID= ?";
        $stmt = $dbh->prepare($sql);
        $flag = $stmt->execute(array($new_userID,$edit_num));

    }

    //掲示板に戻る
    if(isset($_POST['edit_userID'])||(isset($_POST['edit_message']))){
        $login_url = 'board-smarty.php';
        header("Location: {$login_url}");
        exit;
    }

    //編集ボタンが押された時の処理
    if(isset($_POST["editnum"])) {

        //対象となる投稿の番号を得る
        $edit_num = $_POST["editnum"]; 
        //該当する投稿をデータベースから引っ張ってくる
        $sql = "select userID,message from post where ID= ?";
        $stmt = $dbh->prepare($sql);
        $flag = $stmt->execute(array($edit_num));

        //編集フォームの表示内容をsmarty化
        if($result = $stmt->fetch(PDO::FETCH_ASSOC)){ //fetchで実行結果の取得

            $smarty->assign('userID',$result['userID']);
            $smarty->assign('message',$result['message']);
            $smarty->assign('edit_num',$edit_num);

        }

    }

    //削除ボタンが押された時の処理
    if(isset($_POST["deletenum"])) {

        $delete_num = $_POST["deletenum"];//対象となる投稿の番号を得る

        //削除
        $sql = "delete from post where ID= ?";
        $stmt = $dbh->prepare($sql);
        $flag = $stmt->execute(array($delete_num));

        $login_url = 'board-smarty.php';
        header("Location: {$login_url}");
        exit();

    }
}catch (PDOException $e) {

    echo "エラー:" . $e->getMessage(); //メッセージ表示

}
$smarty->display('edit.tpl');
?>
/**
* Created by PhpStorm.
* User: nagashimakaito
* Date: 2016/05/20
* Time: 13:17
*/



