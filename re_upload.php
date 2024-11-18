<?php
/**
 * 1.建立表單
 * 2.建立處理檔案程式
 * 3.搬移檔案
 * 4.顯示檔案列表
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案上傳</title>
    <link rel="stylesheet" href="style.css">
    <style>
        form{
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
 <h1 class="header">編輯資料</h1>
 <!----建立你的表單及設定編碼----->

 <?php
include_once "function.php";
$id=$_GET['id'];
$row=find('imgs',$id);
//dd($row);
?>
<form action="update_img.php" method="post" enctype="multipart/form-data">
<img src="files/<?=$row['filename'];?>" style="width:200px">
<input type="file" name="filename" id="file">
<input type="text" name="desc" value="<?=$row['desc'];?>">
<input type="hidden" name="id" value="<?=$id;?>">
<input type="submit" value="上傳">

</form>




<!----建立一個連結來查看上傳後的圖檔---->  


</body>
</html>