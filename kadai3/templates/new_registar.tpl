<html>
<head>
    <title>新規登録画面</title>
</head>
<body>



<form action= "new_registar-smarty.php" method="POST">

    新規登録者<br />
    <table>
    <td>ID       :<input type="text" name="new_user_id" value="" /></td>
    <td>ユーザ名  ：<input type="text" name="new_user_name" value="" /></td>
    <td>パスワード：<input type="password" name="new_password" value"" /></td>
    </table>
    <input type="submit" name="registar" value="登録" /><br />

</form>

<form action= "login-smarty.php" >

	<input type="submit" value="戻る" />

</form>

</body>
</html>