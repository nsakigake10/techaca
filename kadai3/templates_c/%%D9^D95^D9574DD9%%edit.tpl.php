<?php /* Smarty version 2.6.25-dev, created on 2016-06-19 04:04:23
         compiled from edit.tpl */ ?>
<html>
<head>
    <title>編集場面</title></head>
    <body>
    <form method="POST" action="edit-smarty.php">
    <textarea name="edited_userID" cols="30" rows="1"><?php echo $this->_tpl_vars['userID']; ?>

            </textarea><br />
    <textarea name="edited_message" cols="30" rows="5"><?php echo $this->_tpl_vars['message']; ?>

    </textarea><br />
    <input type="hidden" name="edit_num" value="<?php echo $this->_tpl_vars['edit_num']; ?>
" />
    <input type="submit"  value="編集完了" />
    </form>





</body>
</html>