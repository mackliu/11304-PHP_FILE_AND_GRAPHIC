<style>
    table{
        border-collapse:collapse;
        border-spacing:0;
        border:1px solid #ccc;
        margin:10px 0;
    }
    table th,table td{
        border:1px solid #ccc;
        padding:5px;
    }
    .header{
        text-align:center;
    }
</style>

<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳檔案機制
 * 3.取得檔案資源
 * 4.取得檔案內容
 * 5.建立SQL語法
 * 6.寫入資料庫
 * 7.結束檔案
 */

if(!empty($_FILES['file'])){
    move_uploaded_file($_FILES['file']['tmp_name'], "./files/{$_FILES['file']['name']}");
    echo $_FILES['file']['name']."上傳成功";
    getfile("./files/{$_FILES['file']['name']}");
}
function getfile($path){
/*     $file=fopen($path,'r');
    $line=fgets($file);
    $header_cols=explode(",",trim($line));
    echo "<table>";
    echo "<tr class='header'>";
    foreach($header_cols as $hc){
        echo "<th>{$hc}</th>";
    }
    echo "</tr>";

    while($line=fgets($file)){
        $cols=explode(",",trim($line));
        echo "<tr>";
        foreach($cols as $col){
            echo "<td>{$col}</td>";
        }
        echo "</tr>";
    }
    fclose($file);
    echo "</table>"; */

    try {
        // 使用PDO建立資料庫連線
        $conn = new PDO("mysql:host=localhost;dbname=import", 'root', '');
        // 設定PDO錯誤模式為拋出例外
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // 生成6位數字的隨機資料表名稱
        $tableName = 'table_' . mt_rand(100000, 999999); // 6位亂數
        $file=fopen($path,'r');
        $line=fgets($file);
        $header_cols=explode(",",trim($line));
        // 創建資料表的SQL語法
        $sql = "CREATE TABLE $tableName (
            id INT AUTO_INCREMENT PRIMARY KEY,";
            foreach($header_cols as $hc){
                $tmpcols[]="$hc TEXT NOT NULL";
            }
            $sql .= join(",",$tmpcols);
            $sql.=")";
            echo $sql;
        // 執行創建資料表的語句
        $conn->exec($sql);
        echo "資料表 $tableName 建立完成<br>";
  
        $first=false;
        $count=0;
        while($line=fgets($file)){
            $tmp=[];
            $tmp2=[];
            $cols=explode(",",trim($line));
            $sql="INSERT INTO $tableName (`";
            foreach($header_cols as $hc){
                $tmp[]=$hc;
            }
            $sql .= join("`,`",$tmp);
            $sql .="`) values(";
            
            foreach($cols as $col){
                $tmp2[]="'$col'";
            }
            $sql .= join(",",$tmp2);
            
            $sql .=")";

            if($count<=2){
                echo $sql;
                echo "<br>";

            }
            
            $conn->exec($sql);
            $count++;
        }
        echo "資料匯入 $tableName 完成，共匯入 $count 筆資料";
    fclose($file);


    } catch(PDOException $e) {
        echo "Error creating table: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文字檔案匯入</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 class="header">文字檔案匯入練習</h1>
<!---建立檔案上傳機制--->
<form action="?" method="post" enctype="multipart/form-data">
    <label for="file">文字檔:</label><input type="file" name="file" id="file">
    <input type="submit" value="上傳">
</form>


<!----讀出匯入完成的資料----->
<?php 


?>


</body>
</html>