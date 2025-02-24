<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳圖案機制
 * 3.取得圖檔資源
 * 4.進行圖形處理
 *   ->圖形縮放
 *   ->圖形加邊框
 *   ->圖形驗證碼
 * 5.輸出檔案
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文字檔案匯入</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 class="header">圖形處理練習</h1>
<!---建立檔案上傳機制--->
<div class="container">
    <form action="?" method="post" enctype="multipart/form-data">
        <div>
            <label for="file">圖檔:</label>
            <input type="file" name="file" id="file">
        </div>
        <div>
            <input class='btn btn-primary' type="submit" value="上傳">
        </div>
    </form>
</div>
<!----縮放圖形----->
<h2 class="text-center">縮放圖形</h2>
<?php
if(!empty($_FILES['file']['tmp_name'])){
    move_uploaded_file($_FILES['file']['tmp_name'],"./images/{$_FILES['file']['name']}");
    $filename = "./images/{$_FILES['file']['name']}";

    $src=imagecreatefromjpeg($filename);
    $src_info=getimagesize($filename);
    //print_r($src_info);
    $scale_small=0.5;
    $scale_big=1.5;
    $dst_small_width=$src_info[0]*$scale_small;
    $dst_small_height=$src_info[1]*$scale_small;

    $dst_small=imagecreatetruecolor($dst_small_width,$dst_small_height);
    imagecopyresampled($dst_small,$src,0,0,0,0,$dst_small_width,$dst_small_height,$src_info[0],$src_info[1]);

    imagejpeg($dst_small,"./images/small_{$_FILES['file']['name']}");
}

?>

<div class="d-flex">
    <div>
        <h3 class="text-center">原圖</h3>
        <img src="<?=$filename;?>" alt="">
    </div>
    <div>
        <h3 class="text-center">縮小</h3>
        <img src="<?="./images/small_{$_FILES['file']['name']}";?>" alt="">
    </div>
    <div>
        <h3 class="text-center">放大</h3>
    </div>
</div>

<!----圖形加邊框----->


<!----產生圖形驗證碼----->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>