<?php

define("DBNAME","file");

/**
 * 建立資料庫的連線變數
 * @param string $db 資料庫名稱
 * @return object
 */
function pdo($db){
    $dsn="mysql:host=localhost;charset=utf8;dbname=$db";
    $pdo=new PDO($dsn,'root','');
    return $pdo;
}


/***
 * 回傳指定資料表的所有資料
 * @param string $table 資料表名稱
 * @return array
 */
function all($table){
    $pdo=pdo(DBNAME);
    $sql="select * from $table";
    $rows=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

/**
 * 回傳指定資料表的特定ID的單筆資料
 * @param string $table 資料表名稱
 * @param integer $id || array $id 資料表ID
 * @return array
 */
function find($table,$id){
    $sql="select * from $table where ";
    $pdo=$pdo=pdo(DBNAME);

    if(is_array($id)){
        $tmp=[];
        foreach($id as $key => $value){
            //sprintf("`%s`='%s'",$key,$value);
            $tmp[]="`$key`='$value'";
        }
        $sql=$sql.join(" && ",$tmp);
        
    }else{
        $sql=$sql . " `id`='$id'";
    }
    $row=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    
    return $row;
}


/**
 * 刪除指定條件的資料
 * @param string $table 資料表名稱
 * @param array $id 條件(數字或陣列)
 * @return boolean
 */

function del($table ,$id){
    $sql="delete from $table where ";
    $pdo=$pdo=pdo(DBNAME);

    if(is_array($id)){
        $tmp=[];
        foreach($id as $key => $value){
            //sprintf("`%s`='%s'",$key,$value);
            $tmp[]="`$key`='$value'";
        }
        $sql=$sql.join(" && ",$tmp);
        
    }else{
        $sql=$sql . " id='$id'";
    }

     return  $pdo->exec($sql);
    
}

/**
 * 更新指定條件的資料
 * @param string $table 資料表名稱
 * @param array $array 更新的欄位及內容
 * @param array || number $id 條件(數字或陣列)
 * @return boolean
 */

function update($table,$array,$id){
    $sql="update $table set ";
    $pdo=$pdo=pdo(DBNAME);
    $tmp=[];
    foreach($array as $key => $value){
        $tmp[]="`$key`='$value'";
    }
    $sql=$sql . join(",",$tmp);

    if(is_array($id)){
        $tmp=[];
        foreach($id as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        $sql=$sql . " where ".join(" && ",$tmp);

    }else{
        $sql=$sql . " where `id`='$id'";
    }

    return $pdo->exec($sql);


}

/**
 * 新增資料
 * @param string $table 資料表名稱
 * @param string $cols  新增的欄位字串
 * @param string $values 新增的值字串
 * @return boolean
 */

function insert($table,$array){
    $pdo=pdo(DBNAME);
    $sql="insert into $table ";
    $keys=array_keys($array);
    
    $sql=$sql . "(`".join("`,`",$keys)."`) values ('".join("','",$array)."')";
    return $pdo->exec($sql);
}

/**
 * 列出陣列內容
 */
function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

//insert("member",["acc"=>21,
//                 "pw"=>21,
//                 "email"=>"21@gmail.com",
//                 "tel"=>"0933254879"]);
//
//update('member',['email'=>'19@gmail.com'],['acc'=>'19','pw'=>'19']);

?>