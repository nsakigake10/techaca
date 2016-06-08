<?php

require( dirname( __FILE__ ).'/libs/Smarty.class.php' );

$smarty = new Smarty();

$smarty->template_dir = dirname( __FILE__ ).'/templates'; //テンプレートファイル
$smarty->compile_dir  = dirname( __FILE__ ).'/templates_c'; //コンパイル結果格納
$smarty->cache_dir = dirname(__FILE__) . "/cache";
$smarty->config_dir = dirname(__FILE__) . "/config";


if(isset($_POST['fail'])){
    $login_url = 'http://localhost:8888/kadai3/smarty_test/new_registar-smarty.php';
    header("Location: {$login_url}");
    exit;
}

$smarty->display('registar_fail.tpl');

?>



/**
* Created by PhpStorm.
* User: nagashimakaito
* Date: 2016/05/20
* Time: 12:53
*/