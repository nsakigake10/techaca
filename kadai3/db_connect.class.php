<?php



class db_connect{

	public $dbh;//どの関数でも使えるようパブリック宣言
        
    function __construct(){

        //コンストラクタでデータベースと接続    
        try {
                //クラス内の変数を用いるので、thisを用いる
                $this->dbh = new PDO('mysql:dbname=kadai3;host=127.0.0.1', 'root','K/ai1104',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
        
            } catch (PDOException $e) {
        
                echo "エラー:" . $e->getMessage(); //メッセージ表示

            }

    }


    //$sql MySqlへのsql文を表す
    //$content $sqlの引数を表す


    //sql文を実行し、結果を取り出す必要がある関数  
    //ただし、取り出すデータは一個  

	function pdo_fetch($sql,$content){
   

        $stmt = $this->dbh->prepare($sql); //sql文を先に実施する
        $flag = $stmt->execute($content);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);//結果を取り出す

        //$flagがfalseならエラー

        if(!$flag){
            exit('Error');
        }
   
        return $data;

    }


    //sql文を実行しデータを複数取り出す関数
    ///ただし、引数は一個

    function pdo_show($sql){


        $stmt = $this->dbh->prepare($sql); //sql文を先に実施する
        $flag = $stmt->execute();
    
        //flagがfalseならエラー

        if(!$flag){
            exit('Error');
        }


        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){//結果を取り出す
   			
   			$data[] = $result;//複数個のデータがあるので配列に保存

   		}


        return $data;///配列を返す

    }



    //sql文を実行しデータを複数取り出す関数
    //ただし、引数は二個

    function pdo_edit($sql,$content){
    

        $stmt = $this->dbh->prepare($sql); //sql文を先に実施する
        $flag = $stmt->execute($content);
    

        //$flagがfalseならエラー

        if(!$flag){
            exit('Error');
        }


        if($result = $stmt->fetch(PDO::FETCH_ASSOC)){//結果を取り出す
            
            $data[] = $result;

        }

        return $data;//配列を返す 
    }


    //データの更新を行う
    //実行結果の内容が不必要な場合  

    function pdo_update($sql,$content){
        $stmt = $this->dbh->prepare($sql); //sql文を先に実施する
        $flag = $stmt->execute($content);
        
        //$flagがfalseならエラー

        if(!$flag){
            exit('Error');
        }

        return null;
    }



}