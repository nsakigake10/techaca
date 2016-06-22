<?php

    session_start();

    require_once("MySmarty.class.php");
    require_once("db_connect.class.php");


    //新しく作ったMySmartyインスタンスの作成
    $smarty = new MySmarty();
    //データベースのインスタンス作成
    $dbh = new db_connect();
    //エラーメッセージ初期化    
    $error_message = '';



    //ログインされたユーザーのidを記憶  login画面からデータ受け取る
    if (isset($_SESSION["login_ID"])) { 
        //投稿者は好きに投稿時のユーザー名、本文を決められるので
        //ユーザー固有のIDで投稿を管理
        $member_ID = $_SESSION["login_ID"]; 
        
    }


    
    
    //データを投稿するときの処理
    //ユーザー名・メッセージともに送信された時     
    if ((isset($_POST['post_name'])) && (isset($_POST['message']))) {

        $name = ($_POST['post_name']);
        $message = ($_POST['message']);
        

        //ユーザー・本文ともに入力されてなければエラー表示
        if ($name == NULL || $message == NULL) {
            $error_message = '投稿者名と本文を正しく入力してください。';
        } else {
            //データの追加処理。
            $sql = "insert into post (userID,message,postdate,memberID) values (?, ?, ?, ?)";
            //投稿時間をtime関数で得て、date関数で適切な形に整形
            $time = time();
            $post_time = date("YmdHis", $time);
            //データの追加を行う
            $dbh->pdo_update($sql,array($name, $message, $post_time, $member_ID));
            
        }
    }


    //投稿され本文の表示処理
    //postにある全データを表示する
    $sql = 'select userID, message,ID, memberID from post';
    $list = $dbh->pdo_show($sql);///取り出されたすべてのデータが入っている

    
    //foreachで実行結果をすべて取り出す
    //初回時は$lisrが空なので処理をスキップ
    if($list != null){       
        foreach ($list as $result) {


            //結果を取り出し変数に格納する
            $user_ID = $result['userID'];
            $posted_message = $result['message']; 
            $member_posted_ID = $result['memberID'];

            $posted_message = nl2br($posted_message); //表示時に改行処理を行う
        
            //ログインしたユーザーが過去に投稿した内容は編集・消去のボタンを表示するが他ユーザーは何も表示しない
            //取り出した投稿のIDを取り出し編集・消去時に適切な投稿に処理が行われるようにする
            $edit_ID = $result['ID'];
        
            $data[] = array('name'=>$user_ID, 'message'=>$posted_message, 'edit_ID'=>$edit_ID, 'member_ID'=>$member_ID, 'member_posted_ID'=>$member_posted_ID);
        }
        //配列をテンプレートに渡す
        $smarty->assign('data', $data);
    }
    
    if ($error_message) {
        print '<font color="red">' . $error_message . '</font>';
    }


$smarty->display('board.tpl');

/*

create table memeber(
    -> ID varchar(20),
    -> 名前 varchar(20),
    -> パスワード varchar(20),
    -> 登録日 timestamp);
    

     テーブル定義
    create table post(
    -> ID int auto_increment,
    -> ユーザーID varchar(20),
    -> primary key(ID),
    -> 本文 mediumblob,
    -> 投稿日 timestamp);

*/
?>
