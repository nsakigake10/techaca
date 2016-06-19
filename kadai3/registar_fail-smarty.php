<?php



require_once($_SERVER["DOCUMENT_ROOT"]."/kadai3/smarty_test/MySmarty.class.php");

//新しく作ったMySmartyインスタンスの作成
$smarty = new MySmarty();

$smarty->display('registar_fail.tpl');

?>



