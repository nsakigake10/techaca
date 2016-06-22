<?php

session_start();

require_once("MySmarty.class.php");
require_once("db_connect.class.php");
//新しく作ったMySmartyインスタンスの作成
$smarty = new MySmarty();
//データベースのインスタンス作成
$dbh = new db_connect();


    //編集ボタンが押された時の処理
    if(isset($_POST["edit_func"])) {

        //対象となる投稿の番号を得る
        $edit_num = $_POST["edit_func"]; 
        //該当する投稿をデータベースから引っ張ってくる
        $sql = "select userID,message from post where ID= ?";
        $list = $dbh->pdo_edit($sql,array($edit_num)); 

        //編集フォームの表示内容をtplのフォームに表示するためsmarty化
        foreach($list as $result){ //fetchで実行結果の取得

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
        $dbh->pdo_update($sql,array($new_message,$edit_num));

    }

    //編集後のuserIDの更新を行う
    if(isset($_POST['edited_userID'])){

        //編集された投稿の番号・編集後の内容をedit.tplから受け取る    
        $edit_num = $_POST["edit_num"];
        $new_userID = $_POST['edited_userID'];

        //データの更新
        $sql = "update post set userID= ? where ID= ?";
        $dbh->pdo_update($sql,array($new_userID,$edit_num));

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
        $dbh->pdo_update($sql,array($delete_num));


        $login_url = 'board-smarty.php';
        header("Location: {$login_url}");
        exit();

    }

$smarty->display('edit.tpl');


?>



