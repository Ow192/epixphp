<?php
session_start();

require '../config/config.php';
require '../func.php';
require '../vendor/autoloader.php';

if (!isset($_POST['mesagewindow'])){$_POST['mesagewindow']="";}
if (!isset($_POST['token'])){$_POST['token']="";}
if (!isset($_SESSION['token'])){$_SESSION['token']="";}
if (!isset($_POST['quit'])){$_POST['quit']=false;}
if (!isset($_POST['style'])){$_POST['style']="";}

$pdo=connect(['host'=>BD_MAIN_HOST,'dbname'=> BD_MAIN_NAME,'user'=>BD_MAIN_LOGIN,'password'=>BD_MAIN_PASSWORD]);

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

if (isset($_SESSION["id"])){
$action= empty($_GET["action"]) ? "home" : $_GET["action"];
}else{
    $action="login";
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
switch ($action) {

    case 'login':
        if (!isset($_POST['login'])){$_POST['login']="";}
        if (!isset($_POST['password'])){$_POST['password']="";}
        if (!isset($_POST['action'])){$_POST['action']="";}
        $erorlogin=" ";
        $tokenscheck=tokencheck();

        if (($tokenscheck==true)&&(formcheck($_POST['action'])==false)&&(formcheck($_POST['login'])==false)&&
            (formcheck($_POST['password'])==false)&&(formcheck($_POST['action'])==false)&&($_POST['action']=="Registration")){
        $selec12=$pdo->prepare("SELECT login FROM users where login=:logins");
        $selec12->execute([
        'logins'=> $_POST['login'],
            ]);
         $logincheck=$selec12->fetch(PDO::FETCH_ASSOC);
        if (isset($logincheck["login"])){  $erorlogin="Такой логин уже используется"; }
            else{
        $selec5=$pdo->prepare("INSERT INTO users SET login=:lo, password=:pa");
        $selec5->execute([
            ':lo'=>$_POST['login'],
            ':pa'=>password_hash($_POST['password'], PASSWORD_DEFAULT),
        ]);}
        }

        if (($tokenscheck==true)&&(formcheck($_POST['login'])==false)&&(formcheck($_POST['password'])==false) && ($_POST['action']=="Login"))
        {
            echo $erorlogin;
            $_POST['login'] = htmlentities($_POST['login']);
            $_POST['password'] = htmlentities($_POST['password']);
            $selec4 = $pdo->prepare("SELECT id, password FROM users WHERE login=:login");
            $selec4->execute([
                ':login'=>$_POST['login'],
            ]);
            $userid=$selec4->fetchall(PDO::FETCH_ASSOC);

            if (!isset($userid["0"]["id"])){
                $erorlogin="Неправильный логин или пароль";
            } elseif (password_verify($_POST['password'],$userid["0"]["password"])){
                    $_SESSION["id"]=$userid["0"]["id"];
                    header('Location:' . sprintf('%s?action=home', HomeUrl));
                }
            else {
                $erorlogin="Неправильный пароль.";
            }
            }

        echo templates('templates/autoriz.php', [
            'style' => $style,
            'token' => newtoken(),
            'homeurl'=>HomeUrl,
            'error'=> $erorlogin,
        ]);
        break;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'search':
        exits($_POST["quit"]);
        $tokenscheck=tokencheck();
        $searching="";
        $_POST["Searchtags"]=htmlentities($_POST["Searchtags"]);// имя тега
        if (($tokenscheck==true)&&(formcheck($_POST["Searchtags"])==false)){
            $selec7 = $pdo->prepare("SELECT mesage.mes, mesage.date, mesage.userid, tags.tag FROM mesage inner join tagmessageid
            on tagmessageid.messageid=mesage.id inner join tags on tagmessageid.tagid=tags.id WHERE mesage.userid=:users and tags.tag=:tags");
            $selec7->execute([
                ':users'=>$_SESSION["id"],
                ':tags'=>$_POST["Searchtags"],
            ]);
            $searching=$selec7->fetchall(PDO::FETCH_ASSOC);
         }

        echo templates('templates/searchtag.php', [
            'style' => $style,
            'token' => newtoken(),
            'homeurl'=>HomeUrl,
            'ishim'=>$_POST["Searchtags"],
            'searching'=>$searching,
        ]);

        break;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

            if (!isset($_POST['tagswindow'])){$_POST['tagswindow']="";}
            if (formcheck($_POST['tagswindow'])==false){
                $resultsting=htmlentities($_POST['tagswindow']);
                $resultsting=trim($resultsting," ");
                $resultsting=trim($resultsting,".");
                $resultsting=trim($resultsting,"\r");
                $resultsting=trim($resultsting,"\n");
                $resultsting=trim($resultsting,"\r");
                $resultsting=trim($resultsting," ");
                $resultarray=explode(", ", $resultsting);

                for ($k=0; $k<count($resultarray);$k++){
                $selec8=$pdo->prepare("SELECT tag FROM tags WHERE tag=:tagi");
                $selec8->execute([
                    ':tagi'=> $resultarray[$k],
                    ]);
                $tagcheck= $selec8->fetchAll(PDO::FETCH_ASSOC);

                if (!isset($tagcheck["0"])){
                    $selec9=$pdo->prepare("INSERT INTO tags SET tag=:tagi");
                    $selec9->execute([
                        ':tagi'=> $resultarray[$k],
                    ]);
                  }
                }

                $selec11=$pdo->prepare("SELECT id FROM mesage where mes=:message And userid=:uses");
                $selec11->execute([
                    ':message'=> $_POST["mesagewindow"],
                    ':uses'=>$_SESSION["id"],
                ]);
                $idmessage=$selec11->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i<count($resultarray);$i++){

                    $selec11=$pdo->prepare("SELECT id FROM tags where tag=:tagi");
                    $selec11->execute([
                        ':tagi'=>$resultarray[$i],
                    ]);
                    $idtagi=$selec11->fetchAll(PDO::FETCH_ASSOC);

                     $selec10=$pdo->prepare("INSERT INTO tagmessageid SET tagid=:tag, messageid=:mesageid");
                     $selec10->execute([
                    ':tag'=> $idtagi[0]["id"],
                    ':mesageid'=> $idmessage[0]["id"],
                     ]);
                }
            }
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

        if ((!isset($_SESSION['allmessage']))or (!empty($_POST['delete'])) or (!empty($_POST['mesagewindow']))){
            $selec6=$pdo->prepare("SELECT mesage.id FROM mesage where mesage.userid=:ids");
            $selec6->execute([
                'ids'=>$_SESSION["id"],
            ]);
            $mesages = $selec6->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['allmessage']=count($mesages);
        }

        if ((! isset($_SESSION["countmessage"]))or($_POST["countmessage"]!=2)){
        $_SESSION["countmessage"]=$_POST["countmessage"]; //нужное колчество собщений на странице
        }

        $countstraniz= ceil($_SESSION['allmessage']/$_SESSION["countmessage"]);
        $starts= (int)$_SESSION["countmessage"]*$_POST["page"]-$_SESSION["countmessage"];
        $kols=(int)$_SESSION["countmessage"];

        $selec3=$pdo->prepare("SELECT mesage.mes, mesage.userid, mesage.date, mesage.id FROM mesage where mesage.userid=:ids order by mesage.date DESC Limit $starts,$kols");
        $selec3->execute([
            'ids'=>$_SESSION["id"],
        ]);

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
