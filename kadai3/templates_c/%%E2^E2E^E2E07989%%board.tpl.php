<?php /* Smarty version 2.6.25-dev, created on 2016-06-22 08:30:18
         compiled from board.tpl */ ?>
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


<?php unset($this->_sections['output']);
$this->_sections['output']['name'] = 'output';
$this->_sections['output']['loop'] = is_array($_loop=$this->_tpl_vars['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['output']['show'] = true;
$this->_sections['output']['max'] = $this->_sections['output']['loop'];
$this->_sections['output']['step'] = 1;
$this->_sections['output']['start'] = $this->_sections['output']['step'] > 0 ? 0 : $this->_sections['output']['loop']-1;
if ($this->_sections['output']['show']) {
    $this->_sections['output']['total'] = $this->_sections['output']['loop'];
    if ($this->_sections['output']['total'] == 0)
        $this->_sections['output']['show'] = false;
} else
    $this->_sections['output']['total'] = 0;
if ($this->_sections['output']['show']):

            for ($this->_sections['output']['index'] = $this->_sections['output']['start'], $this->_sections['output']['iteration'] = 1;
                 $this->_sections['output']['iteration'] <= $this->_sections['output']['total'];
                 $this->_sections['output']['index'] += $this->_sections['output']['step'], $this->_sections['output']['iteration']++):
$this->_sections['output']['rownum'] = $this->_sections['output']['iteration'];
$this->_sections['output']['index_prev'] = $this->_sections['output']['index'] - $this->_sections['output']['step'];
$this->_sections['output']['index_next'] = $this->_sections['output']['index'] + $this->_sections['output']['step'];
$this->_sections['output']['first']      = ($this->_sections['output']['iteration'] == 1);
$this->_sections['output']['last']       = ($this->_sections['output']['iteration'] == $this->_sections['output']['total']);
?>
<p>
user: <?php echo $this->_tpl_vars['data'][$this->_sections['output']['index']]['name']; ?>
<br/>
message <br/> <?php echo $this->_tpl_vars['data'][$this->_sections['output']['index']]['message']; ?>
<br/>

<!--ログインした人のIDと過去の投稿を行った人のIDが等しい時、二つのボタンを表示 -->
<!--ーこの時、投稿した内容のデータ番号をformタグで飛ばす -->
<?php if ($this->_tpl_vars['data'][$this->_sections['output']['index']]['member_ID'] == $this->_tpl_vars['data'][$this->_sections['output']['index']]['member_posted_ID']): ?>
<form action="edit-smarty.php" method="POST"><input type="hidden" name="edit_func" value=<?php echo $this->_tpl_vars['data'][$this->_sections['output']['index']]['edit_ID']; ?>
 /><button>編集する</button></form>

<form action="edit-smarty.php" method="POST"><input type="hidden" name="delete_func" value=<?php echo $this->_tpl_vars['data'][$this->_sections['output']['index']]['edit_ID']; ?>
 /><button>消去</button></form>
<?php endif; ?>


<?php endfor; endif; ?>




</body>
</html>