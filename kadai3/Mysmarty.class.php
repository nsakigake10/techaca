<?php
	//Smartyクラスを呼び出す
	require( dirname( __FILE__ ).'/libs/Smarty.class.php' );

	//smartyクラスを継承したMySmartyクラスを作成する
	class MySmarty extends Smarty {

		public $dbh;
		//コンストラクタ
		function MySmarty(){	

			//Smartyで使用する４つのパスを上書き
			$this->template_dir = dirname( __FILE__ ).'/templates'; //テンプレートファイル
			$this->compile_dir  = dirname( __FILE__ ).'/templates_c'; //コンパイル結果格納
			$this->cache_dir = dirname(__FILE__) . "/cache";
			$this->config_dir = dirname(__FILE__) . "/config";
	

			//Smartyクラスのコンストトラクタの呼び出し
			$this->Smarty();
			
			
		}
}