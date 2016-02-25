<?php
session_start();

require '../func.php';
require '../vendor/autoloader.php';

define("HomeUrl", "http://127.0.0.1/blokepix/block/public/index.php");
// constanta url home
$userids=123;


echo "<br>";
echo "<br>";

if (!isset($_POST['mesagewindow'])){$_POST['mesagewindow']=null;}
if (!isset($_POST['token'])){$_POST['token']=null;}
if (!isset($_SESSION['token'])){$_SESSION['token']=null;}

try{
$pdo=new PDO("mysql:host=127.0.0.1; dbname=epixphp; charset=utf8","root","");
} catch (Exception $e){
    file_put_contents("log.txt", $e.date("HH,DD"),FILE_APPEND | LOCK_EX);
    echo "<h1>Ошибка 503: Сервис временно не доступен.</h1>";
    exit();
}

    switch ((int)$_COOKIE ['style']){
        case 1:
            $style= 'black';
            break;
        case 2:
            $style='red';
            break;
        default:
            $style="default";
            setcookie("style",$style);
            break;
}

//    proverka 1 ect' li, 2 ne isseklo vreme? v if
//      izvlekaem idpolzov derehod v home

//$_COOKIE['uniq'] - уникальный id пароль для каждого пользователя.
//if (!isset($_COOKIE['uniq'])){
$action= empty($_GET["action"]) ? "login" : $_GET["action"];
//if (isset($action)){
//
//    $action = "login";
//} else{
//    $action = "login";
//}

switch ($action) {

    case 'login':
        if (!isset($_POST['login'])){$_POST['login']=null;}
        if (!isset($_POST['password'])){$_POST['password']=null;}
        $erorlogin=" ";
        if ((($_SESSION['token'])==($_POST['token']))&&(formcheck($_POST['login'])==false)&&(formcheck($_POST['password'])==false))
        {
            echo $erorlogin;
            $_POST['login'] = htmlentities($_POST['login']);
            $_POST['password'] = htmlentities($_POST['password']);
            $selec4 = $pdo->prepare("SELECT id FROM users WHERE login=:login AND password=:password");
            $selec4->execute([
                ':login'=>$_POST['login'],
                ':password'=>$_POST['password'],
            ]);
            $userid=$selec4->fetchall(PDO::FETCH_ASSOC);

            if (!isset($userid["0"]["id"])){
                $erorlogin="Неправильный логин или пароль.";
            } else{
                $_SESSION["id"]=$userid["0"]["id"];
                header('Location:' . sprintf('%s?action=home', HomeUrl));
            }
        }

        echo templates('templates/autoriz.php', [
            'style' => $style,
            'token' => newtoken(),
            'homeurl'=>HomeUrl,
            'error'=> $erorlogin,
        ]);
        break;

    case 'profile':
s        echo templates('templates/profile.php', [
            'style' => $style,
            'userid'=>$userid,
            'homeurl'=>HomeUrl,
        ]);
        break;

    default:
        if (($_SESSION['token']==$_POST["token"])&&(formcheck($_POST['mesagewindow'])==false))
        {
            $_POST['mesagewindow'] = htmlentities($_POST['mesagewindow']);
            $selec2 = $pdo->prepare("INSERT into mesage set date=now(), mes=:mess,userid=:uses");
            $selec2->execute([
                ':mess'=>$_POST["mesagewindow"],
                ':uses'=>$_SESSION["id"],
            ]);
        }

        $starts= (int)0;
        $kols=(int)7;
        $ses=(int) $_SESSION["id"];
        $selec3=$pdo->query("SELECT mesage.mes, mesage.userid, mesage.date FROM mesage where mesage.userid=$ses order by mesage.date DESC Limit $starts,$kols");

        $mesages = $selec3->fetchAll(PDO::FETCH_ASSOC);

        echo templates('templates/home.php', [
             'token' => newtoken(),
             'style' => $style,
             'mesage'=>$mesages,
            'homeurl'=>HomeUrl,
        ]);
        break;
}
