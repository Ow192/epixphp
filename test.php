<?php
session_start();
$a='def';
$g=5;
switch($a){
    case "1":
    $g=3;
        break;
}

define("SITE_URL", "http://127.0.0.1/blokepix/block/public/index.php");
//header('Location: www.ya.ru'); - ne otpravit na ya
//header('Location: http://www.ya.ru'); - otpravit na ya

if (!isset($_SESSION['token'])){$_SESSION['token']="";}
if (!empty($a)){echo "1";}
echo"</br>";
echo $f=ceil(8/5);
//$pdo=new PDO("mysql:host=127.0.0.1; dbname=epixphp; charset=utf8","root","");
//$log1="qw12";
//$pas1=md5($log1);
//
//$log2="admin";
//$pas2=md5($log2);
//
//$log3="asd123";
//$pas3=md5($log3);
//
//$log4="user100500";
//$pas4=md5($log4);
//
//$log5="ololo";
//$pas5=md5($log5);
//
//$selec1=$pdo->query("INsert INTO users(login, password) value ($log1 and $pas1)");



?>