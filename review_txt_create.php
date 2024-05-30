<?php
//  var_dump($_GET);
//  exit();

$name=$_GET["name"];
$number=$_GET["number"];
$title=$_GET["title"];
$message=$_GET["message"];
$today=$_GET["today"];

$write_data="{$name}|{$number}|{$title}|{$message}|{$today}\n";

$file=fopen("./data/review.text","a");

flock($file,LOCK_EX);
fwrite($file,$write_data);
flock($file,LOCK_UN);
fclose($file);
header("Location:./main.php");
exit();