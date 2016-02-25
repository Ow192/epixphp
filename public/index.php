<?php
session_start();

require '../func.php';
require '../vendor/autoloader.php';

define("HomeUrl", "http://127.0.0.1/blokepix/block/public/index.php");
// constanta url home

echo "<br>";
echo "<br>";

if (!isset($_POST['mesagewindow'])){$_POST['mesagewindow']="";}
if (!isset($_POST['token'])){$_POST['token']="";}
if (!isset($_SESSION['token'])){$_SESSION['token']="";}
if (!isset($_POST['quit'])){$_POST['quit']=false;}
if (!isset($_POST['style'])){$_POST['style']="";}


try{
$pdo=new PDO("mysql:host=127.0.0.1; dbname=epixphp; charset=utf8","root","");
} catch (Exception $e){
    file_put_contents("log.txt", $e.date("HH,DD"),FILE_APPEND | LOCK_EX);
    echo "<h1>Ошибка 503: Сервис временно не доступен.</h1>";
    exit();
}

if (!isset($_COOKIE ['style'])){ $cookieinit="0"; setcookie("style", $cookieinit);} else {$cookieinit=(int)$_COOKIE['style'];}
if (!empty($_POST['style'])){$cookieinit=(int)$_POST['style'];  setcookie("style",$cookieinit);}

switch ($cookieinit){
        case 1:
            $style= 'black';
            break;
        case 2:
            $style='red';
            break;
        default:
            $style="default";
            break;
            }


//    proverka 1 ect' li, 2 ne isseklo vreme? v if
//      izvlekaem idpolzov derehod v home

//$_COOKIE['uniq'] - уникальный id пароль для каждого пользователя.
if (isset($_SESSION["id"])){
$action= empty($_GET["action"]) ? "home" : $_GET["action"];
}else{
    $action="login";
}

switch ($action) {

    case 'login':
        if (!isset($_POST['login'])){$_POST['login']="";}
        if (!isset($_POST['password'])){$_POST['password']="";}
        if (!isset($_POST['action'])){$_POST['action']="";}
        $erorlogin=" ";
        $tokenscheck=tokencheck();

      //post dohodit. token pravilniy
        if (($tokenscheck==true)&&(formcheck($_POST['action'])==false)&&(formcheck($_POST['login'])==false)&&
            (formcheck($_POST['password'])==false)&&(formcheck($_POST['action']))&&($_POST['action']=="Registration")){
// что не так?
        $selec5=$pdo->prepare("INSERT INTO users SET login=:lo, password=:pa");
        $selec5->execute([
            ':lo'=>$_POST['login'],
            ':pa'=>md5($_POST['password']),
        ]);
        }

        if (($tokenscheck==true)&&(formcheck($_POST['login'])==false)&&(formcheck($_POST['password'])==false) && ($_POST['action']=="Login"))
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
        exits($_POST["quit"]);
        $tokenscheck=tokencheck();

        echo templates('templates/profile.php', [
            'style' => $style,
            'token' => newtoken(),
            'homeurl'=>HomeUrl,
        ]);

        break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    default:

        exits($_POST["quit"]);
        if (!isset($_POST['delete'])){$_POST['delete']="";}
        if (!isset($_POST['countmessage'])){$_POST['countmessage']="2";}
        if (!isset($_POST['page'])){$_POST['page']="1";}
        if (!isset($_POST['mesageEdit'])){$_POST['mesageEdit']="";}
        if (!isset($mesedit)){$mesedit="";}
        $tokenscheck=tokencheck();

        if (($tokenscheck==true)&&(formcheck($_POST['delete'])==false)&&($_POST['action']=="Edit")){
            $mesedit=$_POST['delete'];
            $_SESSION['editmessage']=$mesedit;
            }

        if (($tokenscheck==true)&&(formcheck($_POST['delete'])==false)&&($_POST['action']=="Delete")){
                $selec5=$pdo->prepare("DELETE FROM mesage WHERE id=:ids");
                $selec5->execute([
                    ':ids'=>$_POST['delete'],
                ]);
        }

        if (($tokenscheck==true)&&(formcheck($_POST['mesagewindow'])==false))
        {
            $_POST['mesagewindow'] = htmlentities($_POST['mesagewindow']);
            $selec2 = $pdo->prepare("INSERT into mesage set date=now(), mes=:mess,userid=:uses");
            $selec2->execute([
                ':mess'=>$_POST["mesagewindow"],
                ':uses'=>$_SESSION["id"],
            ]);
        }

        if (($tokenscheck==true)&&(formcheck($_POST['mesageEdit'])==false)&&($_POST["action"])=="Save")
        {
            $_POST['mesageEdit'] = htmlentities($_POST['mesageEdit']);
            $selec2 = $pdo->prepare("UPDATE mesage SET mes=:mess Where id=:userid");
            $selec2->execute([
                ':mess'=>$_POST['mesageEdit'],
                ':userid'=>$_SESSION['editmessage']
            ]);
        }

        $id=(int) $_SESSION["id"];
//тут id

        if ((!isset($_SESSION['allmessage']))or (!empty($_POST['delete'])) or (!empty($_POST['mesagewindow']))){
            $selec6=$pdo->query("SELECT mesage.id FROM mesage where mesage.userid=5");
            $mesages = $selec6->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['allmessage']=count($mesages);
        }
        if ((! isset($_SESSION["countmessage"]))or($_POST["countmessage"]!=2)){
        $_SESSION["countmessage"]=$_POST["countmessage"]; //нудное колчество собщений на странице
        }

        $countstraniz= ceil($_SESSION['allmessage']/$_SESSION["countmessage"]);
        $starts= (int)$_SESSION["countmessage"]*$_POST["page"]-$_SESSION["countmessage"];
        $kols=(int)$_SESSION["countmessage"];


        $selec3=$pdo->query("SELECT mesage.mes, mesage.userid, mesage.date, mesage.id FROM mesage where mesage.userid=5 order by mesage.date DESC Limit $starts,$kols");
// что не так?
        $mesages = $selec3->fetchAll(PDO::FETCH_ASSOC);

        echo templates('templates/home.php', [
             'token' => newtoken(),
             'style' => $style,
             'mesage'=>$mesages,
            'homeurl'=>HomeUrl,
            'messEdit'=>$mesedit,
            'kolstraniz'=>$countstraniz,
        ]);
        break;
}
