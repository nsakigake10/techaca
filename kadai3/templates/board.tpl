<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>掲示板2</title></head>

<body>

<form method="POST" action="board-smarty.php">
    ユーザー名：<br />
    <textarea name="post_name" cols="30" rows="1"></textarea><br />
    本文：<br />
    <textarea name="message" cols="30" rows="5"></textarea><br />
    <br />



    <input type="submit" value="投稿する" />
</form>

<form action="login-smarty.php">
    <input type="submit" value="ログアウト" />
</form>

 
    

<!--データの連想配列をsectionを用いて表す-->


{section name=output loop=$data}
<p>
user: {$data[output].name}<br/>
message <br/> {$data[output].message}<br/>

<!--ログインした人のIDと過去の投稿を行った人のIDが等しい時、二つのボタンを表示 -->
<!--ーこの時、投稿した内容のデータ番号をformタグで飛ばす -->
{if $data[output].member_ID == $data[output].member_posted_ID}
<form action="edit-smarty.php" method="POST"><input type="hidden" name="edit_func" value={$data[output].edit_ID} /><button>編集する</button></form>

<form action="edit-smarty.php" method="POST"><input type="hidden" name="delete_func" value={$data[output].edit_ID} /><button>消去</button></form>
{/if}


{/section}




</body>
</html>
