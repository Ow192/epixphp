<?php
session_start();

define("SITE_URL", "http://127.0.0.1/blokepix/block/public/index.php");
//header('Location: www.ya.ru'); - ne otpravit na ya
//header('Location: http://www.ya.ru'); - otpravit na ya

if (!empty($a)){echo "1";}
echo"</br>";
echo $f=ceil(8/5);


echo"</br>";
$asd="qwer";
echo $asd;
echo"</br>";
$e=password_hash($asd,PASSWORD_DEFAULT);
echo $e;
$f="qwer";
echo"</br>";
echo password_hash($f,PASSWORD_DEFAULT);
echo"</br>";
var_dump(password_verify($f,$e));
echo"</br>";


$ddd= date_create('1099-24-5');
echo date('j.n.Y H:i:s');
echo date_format($ddd, 'Y-m-d H:i:s');


?>