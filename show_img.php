<?php
include_once "function.php";
$id=$_GET['id'];
$row=find('imgs',$id);

$row['sh']=($row['sh']+1)%2;

save('imgs',$row);

header("location:manage.php");

/* if($row['sh']==1){
    $row['sh']=0;
}else{
    $row['sh']=1;
}
save('imgs',$row); */