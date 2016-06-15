<html>
<head>
    <title>編集場面</title></head>
    <body>
    <form method="POST" action="http://localhost:8888/kadai3/smarty_test/edit-smarty.php">
    <textarea name="edit_userID" cols="30" rows="1">{$userID}
            </textarea><br />
    <textarea name="edit_message" cols="30" rows="5">{$message}
    </textarea><br />
    <input type="hidden" name="edit_num" value="{$edit_num}" />
    <input type="submit"  value="編集完了" />
    </form>


/**
* Created by PhpStorm.
* User: nagashimakaito
* Date: 2016/05/20
* Time: 13:17
*/


</body>
</html>
