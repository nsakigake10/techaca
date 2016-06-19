<html>
<head>
    <title>新規登録画面</title>
</head>
<body>



<form action= "new_registar-smarty.php" method="POST">

    新規登録者<br />
    ID       :<input type="text" name="new_user_id" value="" /><br />
    ユーザ名  ：<input type="text" name="new_user_name" value="" /><br />
    パスワード：<input type="password" name="new_password" value"" /><br />
    <input type="submit" name="registar" value="登録" /><br />

</form>

<form action= "login-smarty.php" >

	<input type="submit" value="戻る" />

</form>

</body>
</html>