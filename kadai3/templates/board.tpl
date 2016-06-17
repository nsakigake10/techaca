<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>掲示板2</title></head>

<body>

<form method="POST" action="board-smarty.php">
    ユーザー名：<br />
    <textarea name="postname" cols="30" rows="1"></textarea><br />
    本文：<br />
    <textarea name="message" cols="30" rows="5"></textarea><br />
    <br />



    <input type="submit" value="投稿する" />
</form>

<form action="login-smarty.php">
    <input type="submit" value="ログアウト" />
</form>

<!-- テーブル定義
 create table memeber(
    -> ID varchar(20),
    -> 名前 varchar(20),
    -> パスワード varchar(20),
    -> 登録日 timestamp);
    -->

<!-- テーブル定義
    create table post(
    -> ID int auto_increment,
    -> ユーザーID varchar(20),
    -> primary key(ID),
    -> 本文 mediumblob,
    -> 投稿日 timestamp);
    

データの連想配列をsectionを用いて表す

-->

{section name=output loop=$member}
<p>
user: {$member[output].name}<br/>
message {$member[output].message}<br/>
{$member[output].edit} {$member[output].delete}<br/>
</p>
{/section}




</body>
</html>
