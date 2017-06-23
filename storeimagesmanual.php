<?php

//header('content-type: application/json; charset=utf-8');
//header("access-control-allow-origin: http://localhost:8100");

$msg = '';
$image = 'instagram.jpeg';
$img = file_get_contents($image);
$con = mysqli_connect('localhost','root','root','maneapp') or die('Unable To connect');
$sql = "insert into feed (picture) values(?)";
$stmt = mysqli_prepare($con,$sql);
mysqli_stmt_bind_param($stmt, "s",$img);
mysqli_stmt_execute($stmt);
$check = mysqli_stmt_affected_rows($stmt);
if($check==1){
$msg = 'Image Successfullly Uploaded';
}else{
$msg = 'Error uploading image';
}
mysqli_close($con);

?>