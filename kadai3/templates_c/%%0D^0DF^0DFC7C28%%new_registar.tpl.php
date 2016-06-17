<?php /* Smarty version 2.6.25-dev, created on 2016-06-08 02:31:23
         compiled from new_registar.tpl */ ?>
<html>
<head>
    <title>新規登録画面</title>
</head>
<body>



<form action= "http://localhost:8888/kadai3/smarty_test/new_registar-smarty.php" method="POST">

    新規登録者<br />
    ID       :<input type="text" name="new_user_id" value="" /><br />
    ユーザ名  ：<input type="text" name="new_user_name" value="" /><br />
    パスワード：<input type="password" name="new_password" value"" /><br />
    <input type="submit" name="registar" value="登録" /><br />

</form>

<form action= "http://localhost:8888/kadai3/smarty_test/login-smarty.php" method="POST">

	<input type="submit" value="戻る" />

</form>

</body>
</html>