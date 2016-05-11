<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>掲示板１</title></head>

<body>

<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
  ユーザー名：<br />
  <input type="text" name="name" size="30" value="" /><br />
  本文：<br />
  <textarea name="message" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" value="投稿する" />
</form>


<!-- テーブル定義
 create table kadai3.board(
    -> user char(20),
    -> text varchar(256));
    -->

<?php

$dsn = 'mysql:dbname=kadai3;host=127.0.0.1';
$user = 'root';
$password = 'K/ai1104';

try{

  if(isset($_POST['name'])){
      $name = ($_POST['name']);
          }    
  if(isset($_POST['message'])){
      $message = ($_POST['message']);
      $message = nl2br($message);//改行処理
          }
  

     print('<br>');


    $dbh = new PDO($dsn, $user, $password);

    print('<br>');

    if ($dbh == null){
        print('接続に失敗しました。<br>');
    }

    $result = $dbh->query('SET NAMES utf8');
    //文字コード指定
    //一回だけ使用するようなメソッドはqueryをつかう

    if (!$result) {
        exit('文字コードを指定できませんでした。');
    }

    $sql = '';

    if((isset($_POST['name']))&&(isset($_POST['message'])) ){
    $sql = "insert into board (name, message) values (?, ?)";
  }
  
    $stmt = $dbh->prepare($sql);

    if((isset($_POST['name']))&&(isset($_POST['message'])) ){

    $flag = $stmt->execute(array("$name", "$message"));

    if (!$flag){
        print('データの追加に失敗しました<br>');
    }
}
    

    $sql = 'select name, message from board';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        print('ユーザー名:');
        print($result['name'].'<br>');
        print('本文:<br>');
        print($result['message'].'<br>');
    }

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;

?>

</body>
</html>

