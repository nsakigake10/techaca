<html>
<head>
    <title>編集場面</title></head>
    <body>
    <form method="POST" action="edit-smarty.php">
    <textarea name="edited_userID" cols="30" rows="1">{$userID}
            </textarea><br />
    <textarea name="edited_message" cols="30" rows="5">{$message}
    </textarea><br />
    <input type="hidden" name="edit_num" value="{$edit_num}" />
    <input type="submit"  value="編集完了" />
    </form>





</body>
</html>
