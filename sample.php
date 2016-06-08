<?php

require( dirname( __FILE__ ).'/libs/Smarty.class.php' );

$smarty = new Smarty();

$smarty->template_dir = dirname( __FILE__ ).'/templates'; //テンプレートファイル
$smarty->compile_dir  = dirname( __FILE__ ).'/templates_c'; //コンパイル結果格納

$smarty->assign('name', 'ワールド');

$smarty->display('sample.tpl');

?>