<?php

try{
$access=new pdo("mysql:host=localhost;dbname=monoshop;charset=utf8","root", "");
} catch(Exception $e){
$e->getmessage();
}


?>
