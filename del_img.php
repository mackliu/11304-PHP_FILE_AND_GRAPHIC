<?php
include_once "function.php";
$id=$_GET['id'];
$row=find('imgs',$id);
$imgName=$row['filename'];
unlink("./files/$imgName") ;
del("imgs",$id);
//$imgName=find('imgs',$id)['filename'];


header("location:manage.php");