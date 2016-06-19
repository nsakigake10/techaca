<?php

session_start();

require_once($_SERVER["DOCUMENT_ROOT"]."/kadai3/smarty_test/MySmarty.class.php");

//新しく作ったMySmartyインスタンスの作成
$smarty = new MySmarty();

try{

    $dsn = 'mysql:dbname=kadai3;host=127.0.0.1';
    $user = 'root';
    $password = 'K/ai1104';

    $dbh = new PDO($dsn, $user, $password);

    //編集ボタンが押された時の処理
    if(isset($_POST["edit_func"])) {

        //対象となる投稿の番号を得る
        $edit_num = $_POST["edit_func"]; 
        //該当する投稿をデータベースから引っ張ってくる
        $sql = "select userID,message from post where ID= ?";
        $stmt = $dbh->prepare($sql);
        $flag = $stmt->execute(array($edit_num));


        //編集フォームの表示内容をtplのフォームに表示するためsmarty化
        if($result = $stmt->fetch(PDO::FETCH_ASSOC)){ //fetchで実行結果の取得

            $smarty->assign('userID',$result['userID']);
            $smarty->assign('message',$result['message']);
            $smarty->assign('edit_num',$edit_num);

        }

    }

    //編集後の本文の更新を行う
    if(isset($_POST['edited_message'])){
            
        //編集された投稿の番号・編集後の内容をedit.tplから受け取る    
        $edit_num = $_POST["edit_num"];
        $new_message = $_POST['edited_message'];
        
        //データの更新
        $sql = "update post set message= ? where ID= ?";
        $stmt = $dbh->prepare($sql);
        $flag = $stmt->execute(array($new_message,$edit_num));

    }

    //編集後のuserIDの更新を行う
    if(isset($_POST['edited_userID'])){

        //編集された投稿の番号・編集後の内容をedit.tplから受け取る    
        $edit_num = $_POST["edit_num"];
        $new_userID = $_POST['edited_userID'];

        //データの更新
        $sql = "update post set userID= ? where ID= ?";
        $stmt = $dbh->prepare($sql);
        $flag = $stmt->execute(array($new_userID,$edit_num));

    }
    
    //掲示板に戻る
    if(isset($_POST['edited_userID'])||(isset($_POST['edited_message']))){
        $login_url = 'board-smarty.php';
        header("Location: {$login_url}");
        exit;
    }


    //削除ボタンが押された時の処理
    if(isset($_POST["delete_func"])) {

        $delete_num = $_POST["delete_func"];//対象となる投稿の番号を得る

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



